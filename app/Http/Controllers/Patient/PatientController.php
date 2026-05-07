<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PatientController extends Controller
{
     public function PatientLogout(Request $request) {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }



    public function PatientSetting()
    {
        $patient = Auth::user();
        return view('patient.dashboard.setting.patient_setting', compact('patient'));
    }
    // End Method

    public function PatientSettingPost(Request $request)
    {
        $patient = Auth::user();

        $request->validate([
            'first_name'    => 'required|string|max:255',
            'last_name'     => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'phone'         => 'required|string|max:20',
            'blood_group'   => 'required|string|max:10',
            'address'       => 'required|string|max:255',
            'city'          => 'required|string|max:100',
            'state'         => 'required|string|max:100',
            'country'       => 'required|string|max:100',
            'pincode'       => 'required|string|max:20',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:4096',
        ]);

        // Profile photo
        $photoPath = $patient->getRawOriginal('profile_photo');

        if ($request->hasFile('profile_photo')) {
            if ($photoPath) {
                Storage::disk('public')->delete($photoPath);
            }
            $photoPath = $request->file('profile_photo')->store('patients', 'public');
        } elseif ($request->input('remove_photo') == '1') {
            if ($photoPath) {
                Storage::disk('public')->delete($photoPath);
            }
            $photoPath = null;
        }

        $patient->update([
            'first_name'    => $request->first_name,
            'last_name'     => $request->last_name,
            'date_of_birth' => $request->date_of_birth,
            'phone'         => $request->phone,
            'blood_group'   => $request->blood_group,
            'address'       => $request->address,
            'city'          => $request->city,
            'state'         => $request->state,
            'country'       => $request->country,
            'pincode'       => $request->pincode,
            'profile_photo' => $photoPath,
        ]);

        return back()->with('success', 'Profile updated successfully.');
    }
    // End Method

    public function PatientChangePassword()
    {
        return view('patient.dashboard.setting.change_password');
    }
    // End Method

    public function PatientChangePasswordPost(Request $request)
    {
        $request->validate([
            'old_password'              => 'required',
            'new_password'              => 'required|min:8|confirmed',
            'new_password_confirmation' => 'required',
        ], [
            'new_password.confirmed' => 'New password and confirm password do not match.',
            'new_password.min'       => 'New password must be at least 8 characters.',
        ]);

        $patient = Auth::user();

        if (! \Illuminate\Support\Facades\Hash::check($request->old_password, $patient->password)) {
            return back()
                ->withErrors(['old_password' => 'Current password does not match our records.'])
                ->withInput();
        }

        if ($request->old_password === $request->new_password) {
            return back()
                ->withErrors(['new_password' => 'New password must be different from the current password.'])
                ->withInput();
        }

        $patient->update(['password' => $request->new_password]);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('status', 'Password changed successfully. Please log in with your new password.');
    }
    // End Method

    public function PatientAppointments()
    {
        $patient = Auth::user();

        $upcoming = $patient->patientAppointments()
            ->with(['doctor', 'clinic'])
            ->whereIn('status', ['pending', 'confirmed'])
            ->orderBy('appointment_date', 'asc')
            ->orderBy('appointment_time', 'asc')
            ->paginate(10, ['*'], 'upcoming_page');

        $cancelled = $patient->patientAppointments()
            ->with(['doctor', 'clinic'])
            ->where('status', 'cancelled')
            ->orderBy('appointment_date', 'desc')
            ->paginate(10, ['*'], 'cancelled_page');

        return view('patient.dashboard.appointments.patient_appointments',
            compact('upcoming', 'cancelled'));
    }
    // End Method


    public function PatientInvoices(){
    return view('patient.dashboard.invoices.patient_invoices');
    }
    // End Method

 

} 
