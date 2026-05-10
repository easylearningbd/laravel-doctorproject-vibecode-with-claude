<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function AdminDashboard()
    {
        return view('admin.index');
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


}
