<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\DoctorReview;
use App\Models\User;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, $doctorId)
    {
        $patient = auth()->user();

        // Confirm the doctor exists
        User::where('role', 'doctor')->findOrFail($doctorId);

        // Must have at least one completed appointment with this doctor
        $completedAppointment = Appointment::where('patient_id', $patient->id)
            ->where('doctor_id', $doctorId)
            ->where('status', 'completed')
            ->latest()
            ->first();

        if (!$completedAppointment) {
            return back()->with('review_error', 'You can only review a doctor after completing an appointment.');
        }

        // Prevent duplicate reviews
        if (DoctorReview::where('patient_id', $patient->id)->where('doctor_id', $doctorId)->exists()) {
            return back()->with('review_error', 'You have already submitted a review for this doctor.');
        }

        $request->validate([
            'rating'    => 'required|integer|min:1|max:5',
            'comment'   => 'nullable|string|max:1000',
            'recommend' => 'nullable|boolean',
        ]);

        DoctorReview::create([
            'doctor_id'      => $doctorId,
            'patient_id'     => $patient->id,
            'appointment_id' => $completedAppointment->id,
            'rating'         => $request->rating,
            'comment'        => $request->comment,
            'recommend'      => $request->boolean('recommend', true),
        ]);

        return back()->with('review_success', 'Your review has been submitted successfully!');
    }
}
