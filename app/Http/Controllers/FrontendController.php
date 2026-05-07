<?php

namespace App\Http\Controllers;

use App\Models\Speciality;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class FrontendController extends Controller
{
    public function index()
    { 
        $doctors = User::where('role', 'doctor')
            ->with(['specialityServices.speciality'])
            ->get()
            ->map(function ($doctor) {
                // Resolve display speciality: field → first service speciality → designation
                $doctor->display_speciality = $doctor->specialization
                    ?: ($doctor->specialityServices->first()?->speciality?->name
                        ?? $doctor->designation
                        ?? 'Doctor');

                // Lowest consultation fee across all services
                $doctor->min_price = $doctor->specialityServices->min('price');

                return $doctor;
            });

        return view('frontend.index', compact('doctors'));
    }


    public function DoctorDetails($id)
    {
        $doctor = User::where('role', 'doctor')
            ->with([
                'specialityServices.speciality',
                'experiences',
                'clinics',
                'memberships',
                'businessHours',
            ])
            ->findOrFail($id);

        $doctor->display_speciality = $doctor->specialization
            ?: ($doctor->specialityServices->first()?->speciality?->name
                ?? $doctor->designation
                ?? 'Doctor');

        $doctor->min_price = $doctor->specialityServices->min('price');
        $doctor->max_price = $doctor->specialityServices->max('price');

        // Years in practice from earliest experience start_date
        $earliest = $doctor->experiences->whereNotNull('start_date')->min('start_date');
        $doctor->years_in_practice = $earliest
            ? (int) Carbon::parse($earliest)->diffInYears(now())
            : null;

        // Business hours keyed by day_of_week
        $businessHours = $doctor->businessHours->keyBy('day_of_week');

        // Today
        $todayKey   = strtolower(now()->format('l'));
        $todayHours = $businessHours->get($todayKey);

        return view('frontend.doctor_details',
            compact('doctor', 'businessHours', 'todayHours', 'todayKey'));
    }


    public function DoctorBooking($id)
    {
        // Guests → redirect to login
        if (!auth()->check()) {
            return redirect()->route('login')
                ->with('error', 'Please log in as a patient to book an appointment.');
        }

        // Only patients can book
        if (auth()->user()->role !== 'patient') {
            return redirect()->route('home')
                ->with('error', 'Only patients can book appointments.');
        }

        $doctor = User::where('role', 'doctor')
            ->with(['specialityServices.speciality', 'clinics', 'businessHours'])
            ->findOrFail($id);

        $doctor->display_speciality = $doctor->specialization
            ?: ($doctor->specialityServices->first()?->speciality?->name
                ?? $doctor->designation ?? 'Doctor');

        // Group services by speciality for step 1
        $servicesGrouped = $doctor->specialityServices
            ->groupBy(fn($s) => $s->speciality?->name ?? 'General');

        // Open days for the date picker (disable closed days)
        $openDays = $doctor->businessHours
            ->where('is_open', true)
            ->pluck('day_of_week')
            ->toArray();

        $patient = auth()->user();

        return view('frontend.doctor_booking',
            compact('doctor', 'servicesGrouped', 'openDays', 'patient'));
    }
    // End Method








}
