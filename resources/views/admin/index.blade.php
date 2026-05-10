@extends('admin.admin_master')
@section('admin')

<div class="content container-fluid">

    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Welcome Admin!</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item active">Dashboard</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->

    {{-- ── Stat Cards ──────────────────────────────────────────── --}}
    <div class="row">
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="dash-widget-header">
                        <span class="dash-widget-icon text-primary border-primary">
                            <i class="fe fe-users"></i>
                        </span>
                        <div class="dash-count">
                            <h3>{{ $doctorCount }}</h3>
                        </div>
                    </div>
                    <div class="dash-widget-info">
                        <h6 class="text-muted">Doctors</h6>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-primary"
                                 style="width:{{ $doctorCount > 0 ? min(100, ($doctorCount / max($doctorCount, $patientCount)) * 100) : 0 }}%">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="dash-widget-header">
                        <span class="dash-widget-icon text-success">
                            <i class="fe fe-credit-card"></i>
                        </span>
                        <div class="dash-count">
                            <h3>{{ $patientCount }}</h3>
                        </div>
                    </div>
                    <div class="dash-widget-info">
                        <h6 class="text-muted">Patients</h6>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-success w-75"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="dash-widget-header">
                        <span class="dash-widget-icon text-danger border-danger">
                            <i class="fe fe-calendar"></i>
                        </span>
                        <div class="dash-count">
                            <h3>{{ $appointmentCount }}</h3>
                        </div>
                    </div>
                    <div class="dash-widget-info">
                        <h6 class="text-muted">Appointments</h6>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-danger w-60"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="dash-widget-header">
                        <span class="dash-widget-icon text-warning border-warning">
                            <i class="fe fe-folder"></i>
                        </span>
                        <div class="dash-count">
                            <h3>${{ number_format($totalRevenue, 0) }}</h3>
                        </div>
                    </div>
                    <div class="dash-widget-info">
                        <h6 class="text-muted">Revenue</h6>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-warning w-50"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Charts ───────────────────────────────────────────────── --}}
    <div class="row">
        <div class="col-md-12 col-lg-6">
            <div class="card card-chart">
                <div class="card-header">
                    <h4 class="card-title">Monthly Revenue (Last 12 Months)</h4>
                </div>
                <div class="card-body">
                    <div id="morrisArea" style="min-height:220px;"></div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-6">
            <div class="card card-chart">
                <div class="card-header">
                    <h4 class="card-title">Appointments by Status (Last 6 Months)</h4>
                </div>
                <div class="card-body">
                    <div id="morrisLine" style="min-height:220px;"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Doctors + Patients Lists ─────────────────────────────── --}}
    <div class="row">

        {{-- Doctors List --}}
        <div class="col-md-6 d-flex">
            <div class="card card-table flex-fill">
                <div class="card-header">
                    <h4 class="card-title">
                        Top Doctors
                        <a href="{{ route('all.doctors.agent') }}"
                           class="float-end text-primary fs-13 fw-normal">View All</a>
                    </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-center mb-0">
                            <thead>
                                <tr>
                                    <th>Doctor Name</th>
                                    <th>Speciality</th>
                                    <th>Earned</th>
                                    <th>Reviews</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($topDoctors as $doc)
                            @php
                                $dPhoto = $doc->profile_photo
                                    ? asset('storage/' . $doc->profile_photo)
                                    : asset('backend/assets/img/doctors-dashboard/doctor-profile-img.jpg');
                                $dSpec  = $doc->primary_speciality
                                    ?: ($doc->specialization ?: ($doc->designation ?? '—'));
                                $rating = round($doc->avg_rating);
                            @endphp
                            <tr>
                                <td>
                                    <h2 class="table-avatar">
                                        <a href="#" class="avatar avatar-sm me-2">
                                            <img class="avatar-img rounded-circle"
                                                 src="{{ $dPhoto }}"
                                                 alt="{{ $doc->first_name }}">
                                        </a>
                                        <a href="#">Dr. {{ $doc->first_name }} {{ $doc->last_name }}</a>
                                    </h2>
                                </td>
                                <td>{{ $dSpec }}</td>
                                <td>${{ number_format($doc->total_earned, 2) }}</td>
                                <td>
                                    @for($s = 1; $s <= 5; $s++)
                                        <i class="fe {{ $s <= $rating ? 'fe-star text-warning' : 'fe-star-o text-secondary' }}"></i>
                                    @endfor
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3">No doctors yet.</td>
                            </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Patients List --}}
        <div class="col-md-6 d-flex">
            <div class="card card-table flex-fill">
                <div class="card-header">
                    <h4 class="card-title">
                        Latest Patients
                        <a href="{{ route('all.patients.agent') }}"
                           class="float-end text-primary fs-13 fw-normal">View All</a>
                    </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-center mb-0">
                            <thead>
                                <tr>
                                    <th>Patient Name</th>
                                    <th>Phone</th>
                                    <th>Last Visit</th>
                                    <th>Paid</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($latestPatients as $pat)
                            @php
                                $pPhoto = $pat->profile_photo
                                    ? asset('storage/' . $pat->profile_photo)
                                    : asset('backend/assets/img/doctors-dashboard/profile-01.jpg');
                                $lastVisit = $pat->last_visit
                                    ? \Carbon\Carbon::parse($pat->last_visit)->format('d M Y')
                                    : '—';
                            @endphp
                            <tr>
                                <td>
                                    <h2 class="table-avatar">
                                        <a href="#" class="avatar avatar-sm me-2">
                                            <img class="avatar-img rounded-circle"
                                                 src="{{ $pPhoto }}"
                                                 alt="{{ $pat->first_name }}">
                                        </a>
                                        <a href="#">{{ $pat->first_name }} {{ $pat->last_name }}</a>
                                    </h2>
                                </td>
                                <td>{{ $pat->phone ?: '—' }}</td>
                                <td>{{ $lastVisit }}</td>
                                <td>${{ number_format($pat->total_paid, 2) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3">No patients yet.</td>
                            </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- ── Appointments List ────────────────────────────────────── --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card card-table">
                <div class="card-header">
                    <h4 class="card-title">
                        Recent Appointments
                        <a href="{{ route('agent.appointments') }}"
                           class="float-end text-primary fs-13 fw-normal">View All</a>
                    </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-center mb-0">
                            <thead>
                                <tr>
                                    <th>Doctor Name</th>
                                    <th>Speciality</th>
                                    <th>Patient Name</th>
                                    <th>Appointment Time</th>
                                    <th>Status</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($latestAppointments as $apt)
                            @php
                                $aDocPhoto = $apt->doctor?->profile_photo
                                    ? asset('storage/' . $apt->doctor->profile_photo)
                                    : asset('backend/assets/img/doctors-dashboard/doctor-profile-img.jpg');
                                $aPatPhoto = $apt->patient?->profile_photo
                                    ? asset('storage/' . $apt->patient->profile_photo)
                                    : asset('backend/assets/img/doctors-dashboard/profile-01.jpg');
                                $aDate = $apt->appointment_date->format('d M Y');
                                $aTime = \Carbon\Carbon::createFromFormat('H:i', $apt->appointment_time)->format('h:i A');
                                $sBadge = match($apt->status) {
                                    'confirmed' => 'badge-info',
                                    'completed' => 'badge-success',
                                    'cancelled' => 'badge-danger',
                                    default     => 'badge-warning',
                                };
                            @endphp
                            <tr>
                                <td>
                                    <h2 class="table-avatar">
                                        <a href="#" class="avatar avatar-sm me-2">
                                            <img class="avatar-img rounded-circle"
                                                 src="{{ $aDocPhoto }}"
                                                 alt="{{ $apt->doctor?->first_name }}">
                                        </a>
                                        <a href="#">
                                            Dr. {{ $apt->doctor?->first_name }} {{ $apt->doctor?->last_name }}
                                        </a>
                                    </h2>
                                </td>
                                <td>{{ $apt->doctor->display_speciality ?? '—' }}</td>
                                <td>
                                    <h2 class="table-avatar">
                                        <a href="#" class="avatar avatar-sm me-2">
                                            <img class="avatar-img rounded-circle"
                                                 src="{{ $aPatPhoto }}"
                                                 alt="{{ $apt->patient?->first_name }}">
                                        </a>
                                        <a href="#">
                                            {{ $apt->patient?->first_name }} {{ $apt->patient?->last_name }}
                                        </a>
                                    </h2>
                                </td>
                                <td>
                                    {{ $aDate }}
                                    <span class="text-primary d-block">{{ $aTime }}</span>
                                </td>
                                <td>
                                    <span class="badge {{ $sBadge }}">{{ ucfirst($apt->status) }}</span>
                                </td>
                                <td>${{ number_format($apt->total_amount, 2) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-3">No appointments yet.</td>
                            </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
$(function () {

    // ── Revenue Area Chart ────────────────────────────────────────
    var revenueData = {!! json_encode($monthlyRevenue->values()) !!};

    if (typeof Morris !== 'undefined' && revenueData.length > 0) {
        $('#morrisArea').empty();
        Morris.Area({
            element   : 'morrisArea',
            data      : revenueData,
            xkey      : 'y',
            ykeys     : ['a'],
            labels    : ['Revenue ($)'],
            lineColors: ['#1b5a90'],
            fillOpacity: 0.6,
            hideHover : 'auto',
            resize    : true
        });
    }

    // ── Appointment Status Line Chart ─────────────────────────────
    var apptData = {!! json_encode($monthlyAppointments) !!};

    if (typeof Morris !== 'undefined' && apptData.length > 0) {
        $('#morrisLine').empty();
        Morris.Line({
            element   : 'morrisLine',
            data      : apptData,
            xkey      : 'y',
            ykeys     : ['completed', 'confirmed', 'cancelled', 'pending'],
            labels    : ['Completed', 'Confirmed', 'Cancelled', 'Pending'],
            lineColors: ['#00cc99', '#1b5a90', '#ff5252', '#f8a900'],
            hideHover : 'auto',
            resize    : true
        });
    }

});
</script>
@endpush
