<?php

namespace App\Http\Controllers;

use App\Models\DoctorFavourite;
use App\Models\User;
use Illuminate\Http\Request;

class FavouriteController extends Controller
{
    // AJAX toggle — returns JSON {favourited: true/false, count: N}
    public function toggle(Request $request, $doctorId)
    {
        if (!auth()->check() || auth()->user()->role !== 'patient') {
            return response()->json(['error' => 'Login as a patient to save favourites.'], 401);
        }

        $patientId = auth()->id();

        User::where('role', 'doctor')->findOrFail($doctorId);

        $existing = DoctorFavourite::where('patient_id', $patientId)
            ->where('doctor_id', $doctorId)
            ->first();

        if ($existing) {
            $existing->delete();
            $favourited = false;
        } else {
            DoctorFavourite::create([
                'patient_id' => $patientId,
                'doctor_id'  => $doctorId,
            ]);
            $favourited = true;
        }

        $count = DoctorFavourite::where('doctor_id', $doctorId)->count();

        return response()->json(['favourited' => $favourited, 'count' => $count]);
    }
}
