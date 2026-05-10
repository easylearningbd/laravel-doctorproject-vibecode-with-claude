<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\DoctorBankAccount;
use App\Models\DoctorBusinessHour;
use App\Models\DoctorClinic;
use App\Models\DoctorEducation;
use App\Models\DoctorExperience;
use App\Models\DoctorSpecialityService;
use App\Models\Invoice;
use App\Models\PatientMedicalRecord;
use App\Models\PaymentRequest;
use App\Models\Prescription;
use App\Models\Speciality;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DoctorController extends Controller
{
    public function DoctorDashboard()
    {
        return view('doctor.index');
    }
    // End Method

   

    public function DoctorProfile()
    {
        $doctor      = Auth::user();
        $memberships = $doctor->memberships()->get();
        return view('doctor.dashboard.profile.doctor_profile', compact('doctor', 'memberships'));
    }
    // End Method

    public function DoctorProfilePost(Request $request)
    {
        $doctor = Auth::user();

        $request->validate([
            'first_name'      => 'required|string|max:255',
            'last_name'       => 'required|string|max:255',
            'display_name'    => 'nullable|string|max:255',
            'designation'     => 'nullable|string|max:255',
            'phone'           => 'required|string|max:20',
            'known_languages' => 'nullable|string|max:500',
            'profile_photo'   => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:4096',
            'memberships'              => 'nullable|array',
            'memberships.*.title'      => 'required_with:memberships|string|max:255',
            'memberships.*.about'      => 'nullable|string|max:500',
        ]);

        // Profile photo
        $photoPath = $doctor->getRawOriginal('profile_photo');
        if ($request->hasFile('profile_photo')) {
            if ($photoPath) {
                Storage::disk('public')->delete($photoPath);
            }
            $photoPath = $request->file('profile_photo')->store('doctors', 'public');
        } elseif ($request->input('remove_photo') == '1') {
            if ($photoPath) {
                Storage::disk('public')->delete($photoPath);
            }
            $photoPath = null;
        }

        // Known languages: tagsinput sends comma-separated string
        $languages = [];
        if ($request->filled('known_languages')) {
            $languages = array_values(array_filter(array_map('trim', explode(',', $request->known_languages))));
        }

        $doctor->update([
            'first_name'      => $request->first_name,
            'last_name'       => $request->last_name,
            'display_name'    => $request->display_name,
            'designation'     => $request->designation,
            'phone'           => $request->phone,
            'known_languages' => $languages,
            'profile_photo'   => $photoPath,
        ]);

        // Memberships: delete all and re-insert
        $doctor->memberships()->delete();
        if ($request->has('memberships')) {
            foreach ($request->memberships as $item) {
                if (!empty($item['title'])) {
                    $doctor->memberships()->create([
                        'title' => $item['title'],
                        'about' => $item['about'] ?? null,
                    ]);
                }
            }
        }

        return back()->with('success', 'Profile updated successfully.');
    }
    // End Method

    public function DoctorExperience()
    {
        $doctor      = Auth::user();
        $experiences = $doctor->experiences()->orderBy('start_date', 'desc')->get();
        return view('doctor.dashboard.profile.doctor_experience', compact('doctor', 'experiences'));
    }
    // End Method

    public function DoctorExperiencePost(Request $request)
    {
        $doctor = Auth::user();

        $request->validate([
            'experiences'                       => 'nullable|array',
            'experiences.*.hospital_name'       => 'required_with:experiences|string|max:255',
            'experiences.*.title'               => 'nullable|string|max:255',
            'experiences.*.years_of_experience' => 'nullable|string|max:50',
            'experiences.*.location'            => 'nullable|string|max:255',
            'experiences.*.employment_type'     => 'nullable|in:Full Time,Part Time',
            'experiences.*.description'         => 'nullable|string',
            'experiences.*.start_date'          => 'nullable|date',
            'experiences.*.end_date'            => 'nullable|date|after_or_equal:experiences.*.start_date',
            'experiences.*.currently_working'   => 'nullable|boolean',
            'experience_logos.*'                => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:4096',
        ]);

        // Delete all existing and re-insert (after preserving old logos)
        $oldLogos = $doctor->experiences()->pluck('logo', 'id')->toArray();
        $doctor->experiences()->delete();

        if ($request->has('experiences')) {
            $uploadedLogos = $request->file('experience_logos') ?? [];

            foreach ($request->experiences as $i => $data) {
                if (empty($data['hospital_name'])) {
                    continue;
                }

                // Resolve logo: new upload > keep existing > null
                $logoPath = $data['existing_logo'] ?? null;

                if (!empty($data['remove_logo'])) {
                    if ($logoPath) {
                        Storage::disk('public')->delete($logoPath);
                    }
                    $logoPath = null;
                }

                if (isset($uploadedLogos[$i]) && $uploadedLogos[$i]->isValid()) {
                    if ($logoPath) {
                        Storage::disk('public')->delete($logoPath);
                    }
                    $logoPath = $uploadedLogos[$i]->store('experiences', 'public');
                }

                $doctor->experiences()->create([
                    'hospital_name'       => $data['hospital_name'],
                    'title'               => $data['title'] ?? null,
                    'years_of_experience' => $data['years_of_experience'] ?? null,
                    'location'            => $data['location'] ?? null,
                    'employment_type'     => $data['employment_type'] ?? 'Full Time',
                    'description'         => $data['description'] ?? null,
                    'start_date'          => $data['start_date'] ?: null,
                    'end_date'            => !empty($data['currently_working']) ? null : ($data['end_date'] ?: null),
                    'currently_working'   => !empty($data['currently_working']),
                    'logo'                => $logoPath,
                ]);
            }

            // Delete orphaned old logos not re-used
            foreach ($oldLogos as $oldLogo) {
                if ($oldLogo && !in_array($oldLogo, array_column($request->experiences, 'existing_logo'))) {
                    Storage::disk('public')->delete($oldLogo);
                }
            }
        }

        return back()->with('success', 'Experience updated successfully.');
    }
    // End Method

    public function DoctorEducation()
    {
        $doctor     = Auth::user();
        $educations = $doctor->educations()->orderBy('start_date', 'desc')->get();
        return view('doctor.dashboard.profile.doctor_education', compact('doctor', 'educations'));
    }
    // End Method

    public function DoctorEducationPost(Request $request)
    {
        $doctor = Auth::user();

        $request->validate([
            'educations'                        => 'nullable|array',
            'educations.*.institution_name'     => 'required_with:educations|string|max:255',
            'educations.*.course'               => 'nullable|string|max:255',
            'educations.*.start_date'           => 'nullable|date',
            'educations.*.end_date'             => 'nullable|date',
            'educations.*.no_of_years'          => 'nullable|string|max:50',
            'educations.*.description'          => 'nullable|string',
            'education_logos.*'                 => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:4096',
        ]);

        $doctor->educations()->delete();

        if ($request->has('educations')) {
            $uploadedLogos = $request->file('education_logos') ?? [];

            foreach ($request->educations as $i => $data) {
                if (empty($data['institution_name'])) {
                    continue;
                }

                $logoPath = $data['existing_logo'] ?? null;

                if (!empty($data['remove_logo'])) {
                    if ($logoPath) {
                        Storage::disk('public')->delete($logoPath);
                    }
                    $logoPath = null;
                }

                if (isset($uploadedLogos[$i]) && $uploadedLogos[$i]->isValid()) {
                    if ($logoPath) {
                        Storage::disk('public')->delete($logoPath);
                    }
                    $logoPath = $uploadedLogos[$i]->store('educations', 'public');
                }

                $doctor->educations()->create([
                    'institution_name' => $data['institution_name'],
                    'course'           => $data['course'] ?? null,
                    'start_date'       => $data['start_date'] ?: null,
                    'end_date'         => $data['end_date'] ?: null,
                    'no_of_years'      => $data['no_of_years'] ?? null,
                    'description'      => $data['description'] ?? null,
                    'logo'             => $logoPath,
                ]);
            }
        }

        return back()->with('success', 'Education updated successfully.');
    }
    // End Method

    public function DoctorClinics()
    {
        $doctor  = Auth::user();
        $clinics = $doctor->clinics()->get();
        return view('doctor.dashboard.profile.doctor_clinics', compact('doctor', 'clinics'));
    }
    // End Method

    public function DoctorClinicsPost(Request $request)
    {
        $doctor = Auth::user();

        $request->validate([
            'clinics'                  => 'nullable|array',
            'clinics.*.clinic_name'    => 'required_with:clinics|string|max:255',
            'clinics.*.location'       => 'nullable|string|max:255',
            'clinics.*.address'        => 'nullable|string|max:255',
            'clinic_logos.*'           => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:4096',
            'clinic_new_galleries.*.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);

        // Collect all old gallery images before deletion for cleanup
        $allOldGalleryImages = $doctor->clinics()
            ->whereNotNull('gallery')
            ->get()
            ->pluck('gallery')
            ->filter()
            ->flatten()
            ->toArray();

        $allOldLogos = $doctor->clinics()->pluck('logo')->filter()->toArray();

        $doctor->clinics()->delete();

        if ($request->has('clinics')) {
            $uploadedLogos     = $request->file('clinic_logos') ?? [];
            $uploadedGalleries = $request->file('clinic_new_galleries') ?? [];
            $allKeptImages     = [];

            foreach ($request->clinics as $i => $data) {
                if (empty($data['clinic_name'])) {
                    continue;
                }

                // ── Logo ──
                $logoPath = $data['existing_logo'] ?? null;

                if (!empty($data['remove_logo'])) {
                    $logoPath = null;
                }

                if (isset($uploadedLogos[$i]) && $uploadedLogos[$i]->isValid()) {
                    $logoPath = $uploadedLogos[$i]->store('clinics', 'public');
                }

                // ── Gallery: kept existing + new uploads ──
                $galleryImages = $data['keep_gallery'] ?? [];
                $allKeptImages = array_merge($allKeptImages, $galleryImages);

                if (isset($uploadedGalleries[$i])) {
                    foreach ($uploadedGalleries[$i] as $galleryFile) {
                        if ($galleryFile && $galleryFile->isValid()) {
                            $galleryImages[] = $galleryFile->store('clinic_galleries', 'public');
                        }
                    }
                }

                $doctor->clinics()->create([
                    'clinic_name' => $data['clinic_name'],
                    'location'    => $data['location'] ?? null,
                    'address'     => $data['address'] ?? null,
                    'logo'        => $logoPath,
                    'gallery'     => !empty($galleryImages) ? $galleryImages : null,
                ]);
            }

            // Delete old logos not reused
            foreach ($allOldLogos as $oldLogo) {
                if ($oldLogo && !in_array($oldLogo, array_column($request->clinics, 'existing_logo'))) {
                    Storage::disk('public')->delete($oldLogo);
                }
            }

            // Delete old gallery images that were removed by the user
            foreach ($allOldGalleryImages as $oldImg) {
                if ($oldImg && !in_array($oldImg, $allKeptImages)) {
                    Storage::disk('public')->delete($oldImg);
                }
            }
        }

        return back()->with('success', 'Clinics updated successfully.');
    }
    // End Method

    public function DoctorHours()
    {
        $doctor = Auth::user();
        $hours  = $doctor->businessHours()->get()->keyBy('day_of_week');
        return view('doctor.dashboard.profile.doctor_hours', compact('doctor', 'hours'));
    }
    // End Method

    public function DoctorHoursPost(Request $request)
    {
        $doctor = Auth::user();

        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

        $request->validate([
            'hours'                  => 'nullable|array',
            'hours.*.start_time'     => 'nullable|date_format:H:i',
            'hours.*.end_time'       => 'nullable|date_format:H:i',
        ]);

        foreach ($days as $day) {
            $data   = $request->input("hours.$day", []);
            $isOpen = !empty($data['is_open']);

            $doctor->businessHours()->updateOrCreate(
                ['day_of_week' => $day],
                [
                    'is_open'    => $isOpen,
                    'start_time' => $isOpen ? ($data['start_time'] ?? null) : null,
                    'end_time'   => $isOpen ? ($data['end_time'] ?? null) : null,
                ]
            );
        }

        return back()->with('success', 'Business hours updated successfully.');
    }
    // End Method


    public function SpecialitiesServices()
    {
        $doctor      = Auth::user();
        $specialities = Speciality::orderBy('name')->get();

        // Group existing services by speciality_id so each group = one accordion item
        $grouped = $doctor->specialityServices()
            ->with('speciality')
            ->get()
            ->groupBy('speciality_id');

        return view('doctor.dashboard.services.specialities_services',
            compact('specialities', 'grouped'));
    }
    // End Method

    public function SpecialitiesServicesPost(Request $request)
    {
        $doctor = Auth::user();

        $request->validate([
            'items'                          => 'nullable|array',
            'items.*.speciality_id'          => 'required_with:items|exists:specialities,id',
            'items.*.services'               => 'nullable|array',
            'items.*.services.*.service_name'=> 'required_with:items.*.services|string|max:255',
            'items.*.services.*.price'       => 'nullable|numeric|min:0',
            'items.*.services.*.about'       => 'nullable|string|max:500',
        ]);

        // Delete all and re-insert
        $doctor->specialityServices()->delete();

        if ($request->has('items')) {
            foreach ($request->items as $item) {
                $specialityId = $item['speciality_id'] ?? null;
                if (!$specialityId) {
                    continue;
                }

                foreach ($item['services'] ?? [] as $service) {
                    if (empty($service['service_name'])) {
                        continue;
                    }

                    $doctor->specialityServices()->create([
                        'speciality_id' => $specialityId,
                        'service_name'  => $service['service_name'],
                        'price'         => $service['price'] ?: null,
                        'about'         => $service['about'] ?? null,
                    ]);
                }
            }
        }

        return back()->with('success', 'Specialities & Services saved successfully.');
    }
    // End Method

    public function DoctorChangePassword()
    {
        return view('doctor.dashboard.changepassword.change_password');
    }
    // End Method

    public function DoctorChangePasswordPost(Request $request)
    {
        $request->validate([
            'old_password'     => 'required',
            'new_password'     => 'required|min:8|confirmed',
            'new_password_confirmation' => 'required',
        ], [
            'new_password.confirmed' => 'New password and confirm password do not match.',
            'new_password.min'       => 'New password must be at least 8 characters.',
        ]);

        $doctor = Auth::user();

        if (! \Illuminate\Support\Facades\Hash::check($request->old_password, $doctor->password)) {
            return back()
                ->withErrors(['old_password' => 'Old password does not match our records.'])
                ->withInput();
        }

        if ($request->old_password === $request->new_password) {
            return back()
                ->withErrors(['new_password' => 'New password must be different from the old password.'])
                ->withInput();
        }

        $doctor->update(['password' => $request->new_password]);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('status', 'Password changed successfully. Please log in with your new password.');
    }
    // End Method

    public function DoctorRequests()
    {
        $doctor = Auth::user();

        $appointments = $doctor->doctorAppointments()
            ->with(['patient', 'clinic'])
            ->where('status', 'pending')
            ->orderBy('appointment_date', 'asc')
            ->orderBy('appointment_time', 'asc')
            ->paginate(10);

        return view('doctor.dashboard.request.doctor_request', compact('appointments'));
    }
    // End Method

    public function DoctorAppointmentStatus(Request $request, $id)
    {
        $doctor = Auth::user();

        $appointment = $doctor->doctorAppointments()->findOrFail($id);

        $request->validate([
            'status' => 'required|in:confirmed,cancelled',
        ]);

        $appointment->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'status'  => $appointment->status,
            'message' => $request->status === 'confirmed'
                ? 'Appointment accepted successfully.'
                : 'Appointment rejected successfully.',
        ]);
    }
    // End Method

    public function DoctorAppointments()
    {
        $doctor = Auth::user();

        $upcoming  = $doctor->doctorAppointments()->with(['patient', 'clinic'])
            ->where('status', 'confirmed')
            ->orderBy('appointment_date', 'asc')->orderBy('appointment_time', 'asc')
            ->paginate(10, ['*'], 'upcoming');

        $cancelled = $doctor->doctorAppointments()->with(['patient', 'clinic'])
            ->where('status', 'cancelled')
            ->orderBy('appointment_date', 'desc')
            ->paginate(10, ['*'], 'cancelled');

        $completed = $doctor->doctorAppointments()->with(['patient', 'clinic'])
            ->where('status', 'completed')
            ->orderBy('appointment_date', 'desc')
            ->paginate(10, ['*'], 'completed');

        return view('doctor.dashboard.appointments.doctor_appointments',
            compact('upcoming', 'cancelled', 'completed'));
    }
    // End Method

    public function DoctorPatients()
    {
        $doctor = Auth::user();

        // Unique patients from completed appointments
        $rows = $doctor->doctorAppointments()
            ->with('patient')
            ->where('status', 'completed')
            ->orderBy('appointment_date', 'desc')
            ->get()
            ->unique('patient_id');

        // Attach last booking info to each patient model
        $patients = $rows->map(function ($apt) {
            $apt->patient->last_booking_date   = $apt->appointment_date;
            $apt->patient->last_apt_number     = $apt->appointment_number;
            return $apt->patient;
        })->values();

        return view('doctor.dashboard.appointments.doctor_patients', compact('patients'));
    }
    // End Method

    public function DoctorDetailsPage($id)
    {
        $doctor  = Auth::user();
        $patient = User::where('role', 'patient')->findOrFail($id);

        $appointments = Appointment::where('doctor_id', $doctor->id)
            ->where('patient_id', $patient->id)
            ->with(['clinic'])
            ->orderBy('appointment_date', 'desc')
            ->paginate(10, ['*'], 'appts');

        $medicalRecords = PatientMedicalRecord::where('patient_id', $patient->id)
            ->orderBy('record_date', 'desc')
            ->paginate(10, ['*'], 'records');

        $prescriptions = Prescription::where('doctor_id', $doctor->id)
            ->where('patient_id', $patient->id)
            ->with(['items'])
            ->orderBy('issued_date', 'desc')
            ->paginate(10, ['*'], 'prescriptions');

        $lastBooking = Appointment::where('doctor_id', $doctor->id)
            ->where('patient_id', $patient->id)
            ->orderBy('appointment_date', 'desc')
            ->first();

        return view('doctor.dashboard.appointments.doctor_detailspage',
            compact('patient', 'doctor', 'appointments', 'medicalRecords', 'prescriptions', 'lastBooking'));
    }
    // End Method

    public function DoctorCompleteAppointment(Request $request, $id)
    {
        $doctor      = Auth::user();
        $appointment = $doctor->doctorAppointments()->findOrFail($id);
        $appointment->update(['status' => 'completed']);

        return response()->json(['success' => true, 'message' => 'Appointment marked as completed.']);
    }
    // End Method

    public function StorePrescription(Request $request, $patientId)
    {
        $doctor  = Auth::user();
        $patient = User::where('role', 'patient')->findOrFail($patientId);

        $request->validate([
            'prescription_type'        => 'nullable|string|max:50',
            'issued_date'              => 'required|date',
            'other_info'               => 'nullable|string|max:2000',
            'follow_up'                => 'nullable|string|max:500',
            'medicines'                => 'required|array|min:1',
            'medicines.*.name'         => 'required|string|max:255',
            'medicines.*.type'         => 'nullable|string|max:100',
            'medicines.*.dosage'       => 'nullable|string|max:100',
            'medicines.*.frequency'    => 'nullable|string|max:100',
            'medicines.*.duration'     => 'nullable|string|max:100',
            'medicines.*.instruction'  => 'nullable|string|max:255',
        ]);

        $year   = now()->year;
        $count  = Prescription::whereYear('created_at', $year)->count();
        $seq    = str_pad($count + 1, 6, '0', STR_PAD_LEFT);
        $number = "PRX-{$year}-{$seq}";

        DB::transaction(function () use ($request, $doctor, $patient, $number) {
            $prescription = Prescription::create([
                'prescription_number' => $number,
                'doctor_id'           => $doctor->id,
                'patient_id'          => $patient->id,
                'prescription_type'   => $request->prescription_type ?? 'Visit',
                'issued_date'         => $request->issued_date,
                'other_info'          => $request->other_info,
                'follow_up'           => $request->follow_up,
            ]);

            foreach ($request->medicines as $med) {
                if (!empty($med['name'])) {
                    $prescription->items()->create([
                        'medicine_name' => $med['name'],
                        'medicine_type' => $med['type']        ?? null,
                        'dosage'        => $med['dosage']      ?? null,
                        'frequency'     => $med['frequency']   ?? null,
                        'duration'      => $med['duration']    ?? null,
                        'instruction'   => $med['instruction'] ?? null,
                    ]);
                }
            }
        });

        return back()->with('success', 'Prescription added successfully.');
    }
    // End Method

    public function GetPrescription($id)
    {
        $doctor       = Auth::user();
        $prescription = Prescription::where('doctor_id', $doctor->id)
            ->with(['doctor', 'patient', 'items'])
            ->findOrFail($id);

        return response()->json($prescription);
    }
    // End Method


    public function DoctorInvoices()
    {
        $doctor = Auth::user();

        $invoices = \App\Models\Invoice::where('doctor_id', $doctor->id)
            ->with(['patient', 'appointment'])
            ->orderBy('generated_at', 'desc')
            ->paginate(10);

        return view('doctor.dashboard.invoices.doctor_invoices', compact('invoices'));
    }
    // End Method

    public function DoctorPrintInvoice($appointmentNumber)
    {
        $doctor = Auth::user();

        $appointment = Appointment::where('appointment_number', $appointmentNumber)
            ->where('doctor_id', $doctor->id)
            ->with(['doctor', 'patient', 'clinic', 'payment', 'invoice'])
            ->firstOrFail();

        $services = \App\Models\DoctorSpecialityService::with('speciality')
            ->whereIn('id', $appointment->service_ids ?? [])
            ->get();

        $backUrl = route('doctor.invoices');

        return view('frontend.invoice_print', compact('appointment', 'services', 'backUrl'));
    }
    // End Method

    public function DoctorAccounts()
    {
        $doctor = Auth::user();

        // Financial statistics
        $totalBalance = Invoice::where('doctor_id', $doctor->id)
            ->where('status', 'paid')
            ->sum('total');

        $earned = PaymentRequest::where('doctor_id', $doctor->id)
            ->where('status', 'approved')
            ->sum('amount');

        $requested = PaymentRequest::where('doctor_id', $doctor->id)
            ->where('status', 'pending')
            ->sum('amount');

        $available = max(0, $totalBalance - $earned - $requested);

        // Bank account
        $bankAccount = DoctorBankAccount::where('doctor_id', $doctor->id)->first();

        // Payment requests table (paginated)
        $paymentRequests = PaymentRequest::where('doctor_id', $doctor->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Last pending/approved request date
        $lastRequest = PaymentRequest::where('doctor_id', $doctor->id)
            ->orderBy('created_at', 'desc')
            ->first();

        return view('doctor.dashboard.accounts.doctor_accounts',
            compact('totalBalance', 'earned', 'requested', 'available',
                    'bankAccount', 'paymentRequests', 'lastRequest'));
    }
    // End Method

    public function DoctorAccountsPost(Request $request)
    {
        $doctor = Auth::user();

        $request->validate([
            'bank_name'      => 'required|string|max:255',
            'branch_name'    => 'nullable|string|max:255',
            'account_number' => 'required|string|max:50',
            'account_name'   => 'required|string|max:255',
        ]);

        DoctorBankAccount::updateOrCreate(
            ['doctor_id' => $doctor->id],
            [
                'bank_name'      => $request->bank_name,
                'branch_name'    => $request->branch_name,
                'account_number' => $request->account_number,
                'account_name'   => $request->account_name,
            ]
        );

        return back()->with('success', 'Bank account details saved successfully.');
    }
    // End Method

    public function DoctorPaymentRequestPost(Request $request)
    {
        $doctor = Auth::user();

        $request->validate([
            'amount'      => 'required|numeric|min:1',
            'description' => 'nullable|string|max:1000',
        ]);

        // Recompute available balance
        $totalBalance = Invoice::where('doctor_id', $doctor->id)->where('status', 'paid')->sum('total');
        $earned       = PaymentRequest::where('doctor_id', $doctor->id)->where('status', 'approved')->sum('amount');
        $requested    = PaymentRequest::where('doctor_id', $doctor->id)->where('status', 'pending')->sum('amount');
        $available    = max(0, $totalBalance - $earned - $requested);

        if ($request->amount > $available) {
            return back()->withErrors(['amount' => 'Requested amount exceeds your available balance of $' . number_format($available, 2) . '.'])->withInput();
        }

        if (!DoctorBankAccount::where('doctor_id', $doctor->id)->exists()) {
            return back()->with('error', 'Please add your bank account details before requesting payment.');
        }

        $year   = now()->year;
        $count  = PaymentRequest::whereYear('created_at', $year)->count();
        $seq    = str_pad($count + 1, 6, '0', STR_PAD_LEFT);
        $number = "PR-{$year}-{$seq}";

        PaymentRequest::create([
            'request_number' => $number,
            'doctor_id'      => $doctor->id,
            'amount'         => $request->amount,
            'description'    => $request->description,
            'status'         => 'pending',
        ]);

        return back()->with('success', 'Payment request submitted successfully.');
    }
    // End Method


    public function DoctorReviews(){
    return view('doctor.dashboard.reviews.doctor_reviews');

    }
     // End Method


}
