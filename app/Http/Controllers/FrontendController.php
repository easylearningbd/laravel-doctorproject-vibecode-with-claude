<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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
}
