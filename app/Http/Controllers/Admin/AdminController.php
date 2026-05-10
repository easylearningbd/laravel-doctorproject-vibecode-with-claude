<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Invoice;
use App\Models\PaymentRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function AdminDashboard()
    {
        // ── Stat cards ────────────────────────────────────────────
        $doctorCount      = User::where('role', 'doctor')->count();
        $patientCount     = User::where('role', 'patient')->count();
        $appointmentCount = Appointment::count();
        $totalRevenue     = Invoice::where('status', 'paid')->sum('total');

        // ── Top 5 doctors: most earned, with avg review rating ────
        $topDoctors = User::where('role', 'doctor')
            ->select('users.*')
            ->selectSub(
                DB::table('doctor_speciality_services')
                    ->select('specialities.name')
                    ->join('specialities', 'specialities.id', '=', 'doctor_speciality_services.speciality_id')
                    ->whereColumn('doctor_speciality_services.user_id', 'users.id')
                    ->limit(1),
                'primary_speciality'
            )
            ->selectSub(
                DB::table('payment_requests')
                    ->selectRaw('COALESCE(SUM(amount),0)')
                    ->whereColumn('doctor_id', 'users.id')
                    ->where('status', 'approved'),
                'total_earned'
            )
            ->selectSub(
                DB::table('doctor_reviews')
                    ->selectRaw('COALESCE(AVG(rating),0)')
                    ->whereColumn('doctor_id', 'users.id'),
                'avg_rating'
            )
            ->orderByDesc('total_earned')
            ->limit(5)
            ->get();

        // ── Latest 5 patients: most recent join, with last visit & paid ──
        $latestPatients = User::where('role', 'patient')
            ->select('users.*')
            ->selectSub(
                DB::table('appointments')
                    ->selectRaw('MAX(appointment_date)')
                    ->whereColumn('patient_id', 'users.id')
                    ->where('status', 'completed'),
                'last_visit'
            )
            ->selectSub(
                DB::table('invoices')
                    ->selectRaw('COALESCE(SUM(total),0)')
                    ->whereColumn('patient_id', 'users.id')
                    ->where('status', 'paid'),
                'total_paid'
            )
            ->orderByDesc('users.created_at')
            ->limit(5)
            ->get();

        // ── Latest 5 appointments ─────────────────────────────────
        $latestAppointments = Appointment::with([
                'doctor',
                'doctor.specialityServices.speciality',
                'patient',
            ])
            ->orderByDesc('appointment_date')
            ->orderByDesc('appointment_time')
            ->limit(5)
            ->get()
            ->each(function ($apt) {
                $apt->doctor->display_speciality =
                    $apt->doctor->specialization
                    ?: ($apt->doctor->specialityServices->first()?->speciality?->name
                        ?? $apt->doctor->designation
                        ?? '—');
            });

        // ── Monthly revenue chart (last 12 months) ────────────────
        $monthlyRevenue = Invoice::where('status', 'paid')
            ->where('generated_at', '>=', now()->subMonths(11)->startOfMonth())
            ->selectRaw('DATE_FORMAT(generated_at, "%Y-%m") as period, ROUND(SUM(total), 2) as revenue')
            ->groupBy('period')
            ->orderBy('period')
            ->get()
            ->map(fn($r) => ['y' => $r->period, 'a' => (float) $r->revenue]);

        // ── Monthly appointment status chart (last 6 months) ──────
        $months = collect();
        for ($i = 5; $i >= 0; $i--) {
            $months->push(now()->subMonths($i)->format('Y-m'));
        }

        $apptByMonth = Appointment::where('appointment_date', '>=', now()->subMonths(5)->startOfMonth())
            ->selectRaw('DATE_FORMAT(appointment_date, "%Y-%m") as period,
                         SUM(status = "completed") as completed,
                         SUM(status = "cancelled") as cancelled,
                         SUM(status = "confirmed") as confirmed,
                         SUM(status = "pending")   as pending')
            ->groupBy('period')
            ->orderBy('period')
            ->get()
            ->keyBy('period');

        $monthlyAppointments = $months->map(fn($m) => [
            'y'         => $m,
            'completed' => (int) ($apptByMonth[$m]->completed ?? 0),
            'cancelled' => (int) ($apptByMonth[$m]->cancelled ?? 0),
            'confirmed' => (int) ($apptByMonth[$m]->confirmed ?? 0),
            'pending'   => (int) ($apptByMonth[$m]->pending   ?? 0),
        ])->values();

        return view('admin.index', compact(
            'doctorCount', 'patientCount', 'appointmentCount', 'totalRevenue',
            'topDoctors', 'latestPatients', 'latestAppointments',
            'monthlyRevenue', 'monthlyAppointments'
        ));
    }
    // End Method

    public function AdminLogin()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('agent.dashboard');
        }
        return view('admin.login.admin_login');
    }
    // End Method

    public function AdminLoginPost(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('agent.dashboard');
        }

        return back()->withErrors([
            'email' => 'These credentials do not match our records.',
        ])->withInput($request->only('email'));
    }
    // End Method

    public function AdminLogout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('agent.login');
    }
    // End Method


    public function AdminSpcialities(){
        return view('admin.dashboard.spcialities.all_spcialities');
    }
    // End Method

    public function AdminPaymentRequests()
    {
        $requests = PaymentRequest::with('doctor')
            ->orderByRaw("FIELD(status,'pending','approved','cancelled')")
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $pendingCount = PaymentRequest::where('status', 'pending')->count();

        return view('admin.dashboard.payment_requests.all_payment_requests',
            compact('requests', 'pendingCount'));
    }
    // End Method

    public function AdminPaymentRequestAction(Request $request, $id)
    {
        $request->validate([
            'action'     => 'required|in:approved,cancelled',
            'admin_note' => 'nullable|string|max:500',
        ]);

        $pr = PaymentRequest::findOrFail($id);

        if ($pr->status !== 'pending') {
            return back()->with('error', 'This request has already been processed.');
        }

        $pr->update([
            'status'      => $request->action,
            'admin_note'  => $request->admin_note,
            'credited_on' => $request->action === 'approved' ? now()->toDateString() : null,
        ]);

        return back()->with('success',
            $request->action === 'approved' ? 'Payment request approved.' : 'Payment request cancelled.');
    }
    // End Method

    public function AdminReviews()
    {
        $reviews = \App\Models\DoctorReview::with(['patient', 'doctor'])
            ->latest()
            ->paginate(15);

        return view('admin.dashboard.reviews.all_reviews', compact('reviews'));
    }
    // End Method

    public function AdminDeleteReview(Request $request, $id)
    {
        \App\Models\DoctorReview::findOrFail($id)->delete();
        return back()->with('success', 'Review deleted successfully.');
    }
    // End Method


    public function AdminAppointments(Request $request)
    {
        $query = \App\Models\Appointment::with([
            'doctor',
            'doctor.specialityServices.speciality',
            'patient',
        ]);

        // Optional status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $appointments = $query->orderBy('appointment_date', 'desc')
                              ->orderBy('appointment_time', 'desc')
                              ->paginate(15)
                              ->withQueryString();

        // Counts per status for summary cards
        $counts = [
            'total'     => \App\Models\Appointment::count(),
            'pending'   => \App\Models\Appointment::where('status', 'pending')->count(),
            'confirmed' => \App\Models\Appointment::where('status', 'confirmed')->count(),
            'completed' => \App\Models\Appointment::where('status', 'completed')->count(),
            'cancelled' => \App\Models\Appointment::where('status', 'cancelled')->count(),
        ];

        return view('admin.dashboard.appointments.all_appointments',
            compact('appointments', 'counts'));
    }
    // End Method

    public function AllDoctorsAgent()
    {
        $doctors = \App\Models\User::where('role', 'doctor')
            ->select('users.*')
            ->selectSub(
                \Illuminate\Support\Facades\DB::table('doctor_speciality_services')
                    ->select('specialities.name')
                    ->join('specialities', 'specialities.id', '=', 'doctor_speciality_services.speciality_id')
                    ->whereColumn('doctor_speciality_services.user_id', 'users.id')
                    ->orderBy('doctor_speciality_services.id')
                    ->limit(1),
                'primary_speciality'
            )
            ->selectSub(
                \Illuminate\Support\Facades\DB::table('payment_requests')
                    ->selectRaw('COALESCE(SUM(amount), 0)')
                    ->whereColumn('doctor_id', 'users.id')
                    ->where('status', 'approved'),
                'total_earned'
            )
            ->orderBy('users.created_at', 'desc')
            ->paginate(15);

        return view('admin.dashboard.doctors.all_doctors', compact('doctors'));
    }
    // End Method

    public function AllPatientsAgent()
    {
        $patients = \App\Models\User::where('role', 'patient')
            ->select('users.*')
            ->selectSub(
                \Illuminate\Support\Facades\DB::table('appointments')
                    ->selectRaw('MAX(appointment_date)')
                    ->whereColumn('patient_id', 'users.id')
                    ->where('status', 'completed'),
                'last_visit'
            )
            ->selectSub(
                \Illuminate\Support\Facades\DB::table('invoices')
                    ->selectRaw('COALESCE(SUM(total), 0)')
                    ->whereColumn('patient_id', 'users.id')
                    ->where('status', 'paid'),
                'total_paid'
            )
            ->orderBy('users.created_at', 'desc')
            ->paginate(15);

        return view('admin.dashboard.patients.all_patients', compact('patients'));
    }
    // End Method


}
