@extends('patient.patient_master')
@section('patient')

@php
    $typeLabels = [
        'clinic'     => 'Clinic Visit',
        'video_call' => 'Video Call',
        'audio_call' => 'Audio Call',
        'chat'       => 'Chat',
        'home_visit' => 'Home Visit',
    ];
@endphp

<div class="col-lg-8 col-xl-9">
<div class="dashboard-header">
    <h3>Appointments</h3>
    <ul class="header-list-btns">
        <li>
            <div class="input-block dash-search-input">
                <input type="text" class="form-control" placeholder="Search">
                <span class="search-icon"><i class="isax isax-search-normal"></i></span>
            </div>
        </li>
        <li>
            <div class="view-icons">
                <a href="{{ route('patient.appointments') }}" class="active">
                    <i class="isax isax-grid-7"></i>
                </a>
            </div>
        </li>
    </ul>
</div>

<div class="appointment-tab-head">
    <div class="appointment-tabs">
        <ul class="nav nav-pills inner-tab" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-upcoming-tab"
                        data-bs-toggle="pill" data-bs-target="#pills-upcoming"
                        type="button" role="tab">
                    Upcoming<span>{{ $upcoming->total() }}</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ request()->has('cancelled_page') ? 'active' : '' }}"
                        id="pills-cancel-tab"
                        data-bs-toggle="pill" data-bs-target="#pills-cancel"
                        type="button" role="tab">
                    Cancelled<span>{{ $cancelled->total() }}</span>
                </button>
            </li>
        </ul>
    </div>
</div>

<div class="tab-content appointment-tab-content">

    {{-- ── UPCOMING TAB ────────────────────────────────────────────────── --}}
    <div class="tab-pane fade {{ !request()->has('cancelled_page') ? 'show active' : '' }}"
         id="pills-upcoming" role="tabpanel">

        <div class="appointment-wrap">
            <ul>
            @forelse ($upcoming as $apt)
                @php
                    $doctor      = $apt->doctor;
                    $doctorName  = $doctor->display_name ?: 'Dr. ' . $doctor->first_name . ' ' . $doctor->last_name;
                    $doctorPhoto = $doctor->profile_photo
                        ? asset('storage/' . $doctor->profile_photo)
                        : asset('assets/img/doctors/doctor-thumb-21.jpg');
                    $apptDate    = $apt->appointment_date->format('d M Y');
                    $apptTime    = \Carbon\Carbon::createFromFormat('H:i', $apt->appointment_time)->format('h:i A');
                    $typeLabel   = $typeLabels[$apt->appointment_type] ?? ucfirst($apt->appointment_type);
                @endphp
                <li>
                    <div class="patinet-information">
                        <a href="{{ route('invoice.print', $apt->appointment_number) }}" target="_blank">
                            <img src="{{ $doctorPhoto }}" alt="{{ $doctorName }}">
                        </a>
                        <div class="patient-info">
                            <p>#{{ $apt->appointment_number }}</p>
                            <h6><a href="{{ route('doctor.details', $doctor->id) }}">{{ $doctorName }}</a></h6>
                            @if ($apt->clinic)
                                <p class="small text-muted mb-0">{{ $apt->clinic->clinic_name }}</p>
                            @endif
                        </div>
                    </div>
                </li>
                <li class="appointment-info">
                    <p><i class="isax isax-clock5"></i>{{ $apptDate }} {{ $apptTime }}</p>
                    <ul class="d-flex apponitment-types">
                        <li>{{ $typeLabel }}</li>
                        <li>
                            <span class="badge {{ $apt->status === 'confirmed' ? 'bg-success-light' : 'bg-warning-light' }}">
                                {{ ucfirst($apt->status) }}
                            </span>
                        </li>
                    </ul>
                </li>
                <li class="mail-info-patient">
                    <ul>
                        <li><i class="isax isax-sms5"></i>{{ $doctor->email }}</li>
                        <li><i class="isax isax-call5"></i>{{ $doctor->phone }}</li>
                    </ul>
                </li>
                <li class="appointment-action">
                    <ul>
                        <li>
                            <a href="{{ route('invoice.print', $apt->appointment_number) }}"
                               target="_blank" title="View Invoice">
                                <i class="isax isax-eye4"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#" title="Message"><i class="isax isax-messages-25"></i></a>
                        </li>
                    </ul>
                </li>
                <li class="appointment-detail-btn">
                    <a href="{{ route('invoice.print', $apt->appointment_number) }}"
                       target="_blank"
                       class="btn btn-md btn-primary-gradient">
                        <i class="isax isax-calendar-tick5 me-1"></i>View Details
                    </a>
                </li>
            @empty
                <li class="w-100 text-center py-4 text-muted">
                    No upcoming appointments found.
                </li>
            @endforelse
            </ul>
        </div>

        {{-- Upcoming Pagination --}}
        @if ($upcoming->hasPages())
        <div class="pagination dashboard-pagination">
            <ul>
                <li>
                    <a href="{{ $upcoming->previousPageUrl() }}"
                       class="page-link prev {{ $upcoming->onFirstPage() ? 'disabled' : '' }}">Prev</a>
                </li>
                @foreach ($upcoming->getUrlRange(1, $upcoming->lastPage()) as $page => $url)
                <li>
                    <a href="{{ $url }}"
                       class="page-link {{ $page == $upcoming->currentPage() ? 'active' : '' }}">
                        {{ $page }}
                    </a>
                </li>
                @endforeach
                <li>
                    <a href="{{ $upcoming->nextPageUrl() }}"
                       class="page-link next {{ !$upcoming->hasMorePages() ? 'disabled' : '' }}">Next</a>
                </li>
            </ul>
        </div>
        @endif

    </div>

    {{-- ── CANCELLED TAB ───────────────────────────────────────────────── --}}
    <div class="tab-pane fade {{ request()->has('cancelled_page') ? 'show active' : '' }}"
         id="pills-cancel" role="tabpanel">

        <div class="appointment-wrap">
            <ul>
            @forelse ($cancelled as $apt)
                @php
                    $doctor      = $apt->doctor;
                    $doctorName  = $doctor->display_name ?: 'Dr. ' . $doctor->first_name . ' ' . $doctor->last_name;
                    $doctorPhoto = $doctor->profile_photo
                        ? asset('storage/' . $doctor->profile_photo)
                        : asset('assets/img/doctors/doctor-thumb-21.jpg');
                    $apptDate    = $apt->appointment_date->format('d M Y');
                    $apptTime    = \Carbon\Carbon::createFromFormat('H:i', $apt->appointment_time)->format('h:i A');
                    $typeLabel   = $typeLabels[$apt->appointment_type] ?? ucfirst($apt->appointment_type);
                @endphp
                <li>
                    <div class="patinet-information">
                        <a href="{{ route('doctor.details', $doctor->id) }}">
                            <img src="{{ $doctorPhoto }}" alt="{{ $doctorName }}">
                        </a>
                        <div class="patient-info">
                            <p>#{{ $apt->appointment_number }}</p>
                            <h6><a href="{{ route('doctor.details', $doctor->id) }}">{{ $doctorName }}</a></h6>
                            @if ($apt->clinic)
                                <p class="small text-muted mb-0">{{ $apt->clinic->clinic_name }}</p>
                            @endif
                        </div>
                    </div>
                </li>
                <li class="appointment-info">
                    <p><i class="isax isax-clock5"></i>{{ $apptDate }} {{ $apptTime }}</p>
                    <ul class="d-flex apponitment-types">
                        <li>{{ $typeLabel }}</li>
                        <li>
                            <span class="badge bg-danger-light">Cancelled</span>
                        </li>
                    </ul>
                </li>
                <li class="mail-info-patient">
                    <ul>
                        <li><i class="isax isax-sms5"></i>{{ $doctor->email }}</li>
                        <li><i class="isax isax-call5"></i>{{ $doctor->phone }}</li>
                    </ul>
                </li>
                <li class="appointment-detail-btn">
                    <a href="{{ route('doctor.booking', $doctor->id) }}"
                       class="btn btn-md btn-primary-gradient">
                        <i class="isax isax-calendar-tick5 me-1"></i>Rebook
                    </a>
                </li>
            @empty
                <li class="w-100 text-center py-4 text-muted">
                    No cancelled appointments.
                </li>
            @endforelse
            </ul>
        </div>

        {{-- Cancelled Pagination --}}
        @if ($cancelled->hasPages())
        <div class="pagination dashboard-pagination">
            <ul>
                <li>
                    <a href="{{ $cancelled->previousPageUrl() }}"
                       class="page-link prev {{ $cancelled->onFirstPage() ? 'disabled' : '' }}">Prev</a>
                </li>
                @foreach ($cancelled->getUrlRange(1, $cancelled->lastPage()) as $page => $url)
                <li>
                    <a href="{{ $url }}"
                       class="page-link {{ $page == $cancelled->currentPage() ? 'active' : '' }}">
                        {{ $page }}
                    </a>
                </li>
                @endforeach
                <li>
                    <a href="{{ $cancelled->nextPageUrl() }}"
                       class="page-link next {{ !$cancelled->hasMorePages() ? 'disabled' : '' }}">Next</a>
                </li>
            </ul>
        </div>
        @endif

    </div>

</div>
</div>

@endsection
