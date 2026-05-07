<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingRequest;
use App\Models\Appointment;
use App\Models\AppointmentDocument;
use App\Models\DoctorBusinessHour;
use App\Models\DoctorSpecialityService;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AppointmentController extends Controller
{
    // ── Store Booking ──────────────────────────────────────────────────────
    public function store(BookingRequest $request, $doctorId)
    {
        $patient = auth()->user();
        $doctor  = User::where('role', 'doctor')->findOrFail($doctorId);

        // Prevent double booking
        $slotTaken = Appointment::where('doctor_id', $doctorId)
            ->where('appointment_date', $request->appointment_date)
            ->where('appointment_time', $request->appointment_time)
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();

        if ($slotTaken) {
            return back()
                ->withErrors(['appointment_time' => 'This time slot is already booked. Please choose another.'])
                ->withInput();
        }

        try {
            $appointment = DB::transaction(function () use ($request, $patient, $doctor) {

                // ── Calculate fees ─────────────────────────────────────────
                $serviceIds = $request->service_ids ?? [];
                $services   = DoctorSpecialityService::whereIn('id', $serviceIds)->get();
                $subtotal   = $services->sum('price') ?: 0;
                $bookingFee = 20;
                $tax        = round($subtotal * 0.05, 2);
                $total      = $subtotal + $bookingFee + $tax;

                // ── Generate unique appointment number ─────────────────────
                $year          = now()->year;
                $aptCount      = Appointment::whereYear('created_at', $year)->count() + 1;
                $aptNumber     = 'APT-' . $year . '-' . str_pad($aptCount, 6, '0', STR_PAD_LEFT);
                $invCount      = Invoice::whereYear('created_at', $year)->count() + 1;
                $invoiceNumber = 'INV-' . $year . '-' . str_pad($invCount, 6, '0', STR_PAD_LEFT);

                // ── Create Appointment ─────────────────────────────────────
                $appointment = Appointment::create([
                    'appointment_number' => $aptNumber,
                    'patient_id'         => $patient->id,
                    'doctor_id'          => $doctor->id,
                    'clinic_id'          => $request->appointment_type === 'clinic' ? $request->clinic_id : null,
                    'service_ids'        => $serviceIds,
                    'appointment_type'   => $request->appointment_type,
                    'appointment_date'   => $request->appointment_date,
                    'appointment_time'   => $request->appointment_time,
                    'duration_minutes'   => 30,
                    'consultation_fee'   => $subtotal,
                    'booking_fee'        => $bookingFee,
                    'tax'                => $tax,
                    'discount'           => 0,
                    'total_amount'       => $total,
                    'symptoms'           => $request->symptoms,
                    'reason_for_visit'   => $request->reason_for_visit,
                    'status'             => 'pending',
                    'payment_status'     => 'paid',
                    'invoice_number'     => $invoiceNumber,
                ]);

                // ── Handle document upload ─────────────────────────────────
                if ($request->hasFile('attachment') && $request->file('attachment')->isValid()) {
                    $file = $request->file('attachment');
                    $path = $file->store('appointment_docs', 'public');
                    AppointmentDocument::create([
                        'appointment_id' => $appointment->id,
                        'file_path'      => $path,
                        'file_name'      => $file->getClientOriginalName(),
                        'file_type'      => $file->getMimeType(),
                        'file_size'      => $file->getSize(),
                    ]);
                }

                // ── Mock payment ───────────────────────────────────────────
                $rawCard    = preg_replace('/\s+/', '', $request->card_number);
                $lastFour   = substr($rawCard, -4);
                $transactId = 'TXN-' . strtoupper(Str::random(8));

                Payment::create([
                    'appointment_id' => $appointment->id,
                    'patient_id'     => $patient->id,
                    'doctor_id'      => $doctor->id,
                    'amount'         => $total,
                    'payment_method' => 'credit_card',
                    'transaction_id' => $transactId,
                    'payment_status' => 'paid',
                    'card_last_four' => $lastFour,
                    'paid_at'        => now(),
                ]);

                // ── Generate Invoice ───────────────────────────────────────
                Invoice::create([
                    'appointment_id' => $appointment->id,
                    'invoice_number' => $invoiceNumber,
                    'patient_id'     => $patient->id,
                    'doctor_id'      => $doctor->id,
                    'subtotal'       => $subtotal,
                    'tax'            => $tax,
                    'discount'       => 0,
                    'total'          => $total,
                    'status'         => 'paid',
                    'generated_at'   => now(),
                ]);

                return $appointment;
            });

            return redirect()
                ->route('appointment.success', $appointment->appointment_number)
                ->with('booking_success', true);

        } catch (\Throwable $e) {
            return back()
                ->withErrors(['error' => 'Booking failed. Please try again. (' . $e->getMessage() . ')'])
                ->withInput();
        }
    }

    // ── Booking Success / Confirmation ────────────────────────────────────
    public function success($appointmentNumber)
    {
        $appointment = Appointment::where('appointment_number', $appointmentNumber)
            ->where('patient_id', auth()->id())
            ->with(['doctor', 'patient', 'clinic', 'payment', 'invoice', 'documents'])
            ->firstOrFail();

        $services = DoctorSpecialityService::with('speciality')
            ->whereIn('id', $appointment->service_ids ?? [])
            ->get();

        return view('frontend.booking_success', compact('appointment', 'services'));
    }

    // ── AJAX: Load Available Slots ────────────────────────────────────────
    public function loadSlots(Request $request, $doctorId)
    {
        $request->validate(['date' => 'required|date|after_or_equal:today']);

        $date      = $request->input('date');
        $dayOfWeek = strtolower(Carbon::parse($date)->format('l'));

        $businessHour = DoctorBusinessHour::where('user_id', $doctorId)
            ->where('day_of_week', $dayOfWeek)
            ->where('is_open', true)
            ->first();

        if (!$businessHour || !$businessHour->start_time || !$businessHour->end_time) {
            return response()->json(['slots' => [], 'message' => 'Doctor is not available on this day.']);
        }

        // Already booked times for this doctor on this date
        $bookedTimes = Appointment::where('doctor_id', $doctorId)
            ->where('appointment_date', $date)
            ->whereIn('status', ['pending', 'confirmed'])
            ->pluck('appointment_time')
            ->toArray();

        $slots   = [];
        $current = Carbon::createFromFormat('H:i', $businessHour->start_time);
        $end     = Carbon::createFromFormat('H:i', $businessHour->end_time);

        while ($current->lt($end)) {
            $timeStr = $current->format('H:i');
            $hour    = (int) $current->format('H');

            $slots[] = [
                'time'    => $timeStr,
                'display' => $current->format('h:i A'),
                'booked'  => in_array($timeStr, $bookedTimes),
                'period'  => $hour < 12 ? 'morning' : ($hour < 17 ? 'afternoon' : 'evening'),
            ];

            $current->addMinutes(30);
        }

        return response()->json(['slots' => $slots]);
    }

    // ── Print Invoice ─────────────────────────────────────────────────────
    public function printInvoice($appointmentNumber)
    {
        $appointment = Appointment::where('appointment_number', $appointmentNumber)
            ->where('patient_id', auth()->id())
            ->with(['doctor', 'patient', 'clinic', 'payment', 'invoice'])
            ->firstOrFail();

        $services = DoctorSpecialityService::with('speciality')
            ->whereIn('id', $appointment->service_ids ?? [])
            ->get();

        return view('frontend.invoice_print', compact('appointment', 'services'));
    }
}
