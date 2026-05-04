<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\DoctorClinic;
use App\Models\DoctorEducation;
use App\Models\DoctorExperience;
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
        return view('doctor.dashboard.profile.doctor_hours');
    }
    // End Method
}
