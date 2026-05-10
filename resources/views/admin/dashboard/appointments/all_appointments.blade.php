@extends('admin.admin_master')
@section('admin')

<div class="content container-fluid">

    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-sm-12">
                <h3 class="page-title">Appointments</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('agent.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active">Appointments</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Summary cards --}}
    @php
        $activeStyle  = 'style="outline:2px solid currentColor;"';
        $noStatus     = !request('status');
        $reqStatus    = request('status');
    @endphp
    <div class="row mb-4">
        <div class="col-6 col-md col-xl mb-2">
            <a href="{{ route('agent.appointments') }}"
               class="card shadow-sm text-center py-3 text-decoration-none"
               {!! $noStatus ? 'style="outline:2px solid #4f46e5;"' : '' !!}>
                <div class="card-body p-2">
                    <h4 class="mb-1 text-primary">{{ $counts['total'] }}</h4>
                    <p class="mb-0 text-muted fs-13">All</p>
                </div>
            </a>
        </div>
        <div class="col-6 col-md col-xl mb-2">
            <a href="{{ route('agent.appointments', ['status' => 'pending']) }}"
               class="card shadow-sm text-center py-3 text-decoration-none"
               {!! $reqStatus === 'pending' ? 'style="outline:2px solid #f59e0b;"' : '' !!}>
                <div class="card-body p-2">
                    <h4 class="mb-1 text-warning">{{ $counts['pending'] }}</h4>
                    <p class="mb-0 text-muted fs-13">Pending</p>
                </div>
            </a>
        </div>
        <div class="col-6 col-md col-xl mb-2">
            <a href="{{ route('agent.appointments', ['status' => 'confirmed']) }}"
               class="card shadow-sm text-center py-3 text-decoration-none"
               {!! $reqStatus === 'confirmed' ? 'style="outline:2px solid #0ea5e9;"' : '' !!}>
                <div class="card-body p-2">
                    <h4 class="mb-1 text-info">{{ $counts['confirmed'] }}</h4>
                    <p class="mb-0 text-muted fs-13">Confirmed</p>
                </div>
            </a>
        </div>
        <div class="col-6 col-md col-xl mb-2">
            <a href="{{ route('agent.appointments', ['status' => 'completed']) }}"
               class="card shadow-sm text-center py-3 text-decoration-none"
               {!! $reqStatus === 'completed' ? 'style="outline:2px solid #22c55e;"' : '' !!}>
                <div class="card-body p-2">
                    <h4 class="mb-1 text-success">{{ $counts['completed'] }}</h4>
                    <p class="mb-0 text-muted fs-13">Completed</p>
                </div>
            </a>
        </div>
        <div class="col-6 col-md col-xl mb-2">
            <a href="{{ route('agent.appointments', ['status' => 'cancelled']) }}"
               class="card shadow-sm text-center py-3 text-decoration-none"
               {!! $reqStatus === 'cancelled' ? 'style="outline:2px solid #ef4444;"' : '' !!}>
                <div class="card-body p-2">
                    <h4 class="mb-1 text-danger">{{ $counts['cancelled'] }}</h4>
                    <p class="mb-0 text-muted fs-13">Cancelled</p>
                </div>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="datatable table table-hover table-center mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Doctor</th>
                                    <th>Speciality</th>
                                    <th>Patient</th>
                                    <th>Appointment Date & Time</th>
                                    <th>Type</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse ($appointments as $appointment)
                            @php
                                $doctor  = $appointment->doctor;
                                $patient = $appointment->patient;

                                $doctorPhoto  = $doctor?->profile_photo
                                    ? asset('storage/' . $doctor->profile_photo)
                                    : asset('backend/assets/img/doctors-dashboard/doctor-profile-img.jpg');

                                $patientPhoto = $patient?->profile_photo
                                    ? asset('storage/' . $patient->profile_photo)
                                    : asset('backend/assets/img/doctors-dashboard/profile-01.jpg');

                                $speciality = $doctor?->specialization
                                    ?: ($doctor?->specialityServices->first()?->speciality?->name
                                        ?? $doctor?->designation
                                        ?? '—');

                                $apptDate = $appointment->appointment_date->format('d M Y');
                                $apptTime = \Carbon\Carbon::createFromFormat('H:i', $appointment->appointment_time)->format('h:i A');

                                $statusConfig = match($appointment->status) {
                                    'confirmed' => ['badge-info',    'Confirmed'],
                                    'completed' => ['badge-success', 'Completed'],
                                    'cancelled' => ['badge-danger',  'Cancelled'],
                                    default     => ['badge-warning', 'Pending'],
                                };
                            @endphp
                            <tr>
                                <td class="text-primary fw-medium">
                                    #{{ $appointment->appointment_number }}
                                </td>
                                <td>
                                    <h2 class="table-avatar">
                                        <a href="#" class="avatar avatar-sm me-2">
                                            <img class="avatar-img rounded-circle"
                                                 src="{{ $doctorPhoto }}"
                                                 alt="{{ $doctor?->first_name }}">
                                        </a>
                                        <a href="#">
                                            Dr. {{ $doctor?->first_name }} {{ $doctor?->last_name }}
                                        </a>
                                    </h2>
                                </td>
                                <td>{{ $speciality }}</td>
                                <td>
                                    <h2 class="table-avatar">
                                        <a href="#" class="avatar avatar-sm me-2">
                                            <img class="avatar-img rounded-circle"
                                                 src="{{ $patientPhoto }}"
                                                 alt="{{ $patient?->first_name }}">
                                        </a>
                                        <a href="#">
                                            {{ $patient?->first_name }} {{ $patient?->last_name }}
                                        </a>
                                    </h2>
                                </td>
                                <td>
                                    {{ $apptDate }}
                                    <span class="text-primary d-block">{{ $apptTime }}</span>
                                </td>
                                <td>{{ $appointment->appointment_type ?? 'Direct Visit' }}</td>
                                <td>${{ number_format($appointment->total_amount, 2) }}</td>
                                <td>
                                    <span class="badge {{ $statusConfig[0] }}">
                                        {{ $statusConfig[1] }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">
                                    No appointments found.
                                </td>
                            </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($appointments->hasPages())
                    <div class="mt-3 d-flex justify-content-center">
                        {{ $appointments->links() }}
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

</div>

@endsection
