<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        return view('doctor.dashboard.profile.doctor_experience');
    }
    // End Method

    public function DoctorEducation()
    {
        return view('doctor.dashboard.profile.doctor_education');
    }
    // End Method

    public function DoctorClinics()
    {
        return view('doctor.dashboard.profile.doctor_clinics');
    }
    // End Method

    public function DoctorHours()
    {
        return view('doctor.dashboard.profile.doctor_hours');
    }
    // End Method
}
