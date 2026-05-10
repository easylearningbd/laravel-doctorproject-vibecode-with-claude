<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\DoctorReview;
use App\Models\Speciality;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

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

        // Favourite IDs for logged-in patient
        $favouriteIds = (auth()->check() && auth()->user()->role === 'patient')
            ? auth()->user()->favouriteDoctors()->pluck('users.id')->toArray()
            : [];

        // Specialities with distinct doctor count (subquery for accuracy)
        $specialities = Speciality::select('specialities.*')
            ->selectSub(
                DB::table('doctor_speciality_services')
                    ->selectRaw('COUNT(DISTINCT user_id)')
                    ->whereColumn('speciality_id', 'specialities.id'),
                'doctor_count'
            )
            ->orderBy('name')
            ->get();

        return view('frontend.index', compact('doctors', 'favouriteIds', 'specialities'));
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

        $isFavourited = (auth()->check() && auth()->user()->role === 'patient')
            && auth()->user()->favouriteDoctors()->where('users.id', $id)->exists();

        // Reviews
        $reviews = DoctorReview::where('doctor_id', $id)
            ->with('patient')
            ->latest()
            ->paginate(5);

        $avgRating   = DoctorReview::where('doctor_id', $id)->avg('rating') ?? 0;
        $reviewCount = DoctorReview::where('doctor_id', $id)->count();

        // Rating breakdown (5→1)
        $ratingBreakdown = [];
        for ($s = 5; $s >= 1; $s--) {
            $count = DoctorReview::where('doctor_id', $id)->where('rating', $s)->count();
            $ratingBreakdown[$s] = [
                'count'   => $count,
                'percent' => $reviewCount > 0 ? round(($count / $reviewCount) * 100) : 0,
            ];
        }

        // Can current patient review?
        $canReview    = false;
        $hasReviewed  = false;
        $notMet       = false;

        if (auth()->check() && auth()->user()->role === 'patient') {
            $pid = auth()->id();
            $hasCompleted = Appointment::where('patient_id', $pid)
                ->where('doctor_id', $id)
                ->where('status', 'completed')
                ->exists();

            $hasReviewed = DoctorReview::where('patient_id', $pid)
                ->where('doctor_id', $id)
                ->exists();

            $canReview = $hasCompleted && !$hasReviewed;
            $notMet    = !$hasCompleted;
        }

        return view('frontend.doctor_details',
            compact('doctor', 'businessHours', 'todayHours', 'todayKey', 'isFavourited',
                    'reviews', 'avgRating', 'reviewCount', 'ratingBreakdown',
                    'canReview', 'hasReviewed', 'notMet'));
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


    public function DoctorAllSpeciality(Request $request, $id)
    {
        $speciality = Speciality::findOrFail($id);

        // Which speciality IDs are active (current + any extra checked in sidebar)
        $checkedIds = array_filter(array_map('intval', (array) $request->get('specialities', [])));
        if (!in_array((int)$id, $checkedIds)) {
            array_unshift($checkedIds, (int)$id);
        }

        $today = strtolower(now()->format('l'));

        // Base query — doctors who have a service in any of the selected specialities
        $query = User::where('role', 'doctor')
            ->select('users.*')
            ->selectSub(
                DB::table('doctor_speciality_services')
                    ->selectRaw('MIN(price)')
                    ->whereColumn('user_id', 'users.id'),
                'min_price'
            )
            ->whereHas('specialityServices', fn($q) => $q->whereIn('speciality_id', $checkedIds))
            ->with(['specialityServices.speciality', 'businessHours', 'experiences']);

        // Availability filter
        if ($request->boolean('available')) {
            $query->whereHas('businessHours',
                fn($q) => $q->where('day_of_week', $today)->where('is_open', true));
        }

        // Experience filter (min years)
        if ($request->filled('experience') && (int)$request->experience > 0) {
            $minYears = (int)$request->experience;
            $query->whereHas('experiences', function ($q) use ($minYears) {
                $q->whereNotNull('start_date')
                  ->whereRaw('TIMESTAMPDIFF(YEAR, start_date, CURDATE()) >= ?', [$minYears]);
            });
        }

        // Sort
        $sort = $request->get('sort', 'price_asc');
        $query->orderByRaw('min_price IS NULL, min_price ' . ($sort === 'price_desc' ? 'DESC' : 'ASC'))
              ->orderBy('users.id');

        $doctors = $query->paginate(9)->withQueryString();

        $doctors->each(function ($doctor) use ($today) {
            $doctor->display_speciality = $doctor->specialization
                ?: ($doctor->specialityServices->first()?->speciality?->name
                    ?? $doctor->designation ?? 'Doctor');

            $doctor->is_available = $doctor->businessHours
                ->where('day_of_week', $today)
                ->where('is_open', true)
                ->isNotEmpty();
        });

        // All specialities for the sidebar filter (with doctor count)
        $allSpecialities = Speciality::select('specialities.*')
            ->selectSub(
                DB::table('doctor_speciality_services')
                    ->selectRaw('COUNT(DISTINCT user_id)')
                    ->whereColumn('speciality_id', 'specialities.id'),
                'doctor_count'
            )
            ->orderBy('name')
            ->get();

        $favouriteIds = (auth()->check() && auth()->user()->role === 'patient')
            ? auth()->user()->favouriteDoctors()->pluck('users.id')->toArray()
            : [];

        return view('frontend.doctor_speciality',
            compact('speciality', 'doctors', 'allSpecialities',
                    'favouriteIds', 'sort', 'checkedIds', 'id'));
    }
    // End Method





}
