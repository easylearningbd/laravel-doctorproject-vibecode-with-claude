@extends('doctor.doctor_master')
@section('doctor')

<div class="dashboard-header">
    <h3>My Patients</h3>
    <ul class="header-list-btns">
        <li>
            <div class="input-block dash-search-input">
                <input type="text" class="form-control" placeholder="Search">
                <span class="search-icon"><i class="isax isax-search-normal"></i></span>
            </div>
        </li>
    </ul>
</div>

<div class="appointment-tab-head">
    <div class="appointment-tabs">
        <ul class="nav nav-pills inner-tab" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#pills-active"
                        type="button">Active<span>{{ $patients->count() }}</span></button>
            </li>
        </ul>
    </div>
</div>

<div class="tab-content appointment-tab-content grid-patient">
    <div class="tab-pane fade show active" id="pills-active" role="tabpanel">
        <div class="row">

        @forelse ($patients as $patient)
        @php
            $photo      = $patient->profile_photo
                ? asset('storage/' . $patient->profile_photo)
                : asset('backend/assets/img/doctors-dashboard/profile-01.jpg');
            $age        = $patient->dob
                ? \Carbon\Carbon::parse($patient->dob)->age . ' yrs'
                : 'N/A';
            $location   = collect([$patient->city, $patient->country])->filter()->implode(', ') ?: 'N/A';
            $lastDate   = $patient->last_booking_date?->format('d M Y') ?? 'N/A';
            $patientNum = 'PT' . str_pad($patient->id, 6, '0', STR_PAD_LEFT);
        @endphp

        <!-- Appointment Grid -->
        <div class="col-xl-4 col-lg-6 col-md-6 d-flex">
            <div class="appointment-wrap appointment-grid-wrap flex-fill">
                <ul>
                    <li>
                        <div class="appointment-grid-head">
                            <div class="patinet-information">
                                <a href="{{ route('patient.details.page', $patient->id) }}">
                                    <img src="{{ $photo }}" alt="{{ $patient->first_name }}">
                                </a>
                                <div class="patient-info">
                                    <p>#{{ $patientNum }}</p>
                                    <h6>
                                        <a href="{{ route('patient.details.page', $patient->id) }}">
                                            {{ $patient->first_name }} {{ $patient->last_name }}
                                        </a>
                                    </h6>
                                    <ul>
                                        <li>Age: {{ $age }}</li>
                                        @if ($patient->blood_group)
                                            <li>{{ $patient->blood_group }}</li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="appointment-info">
                        <p><i class="isax isax-location5"></i>{{ $location }}</p>
                    </li>
                    <li class="appointment-action">
                        <div class="patient-book">
                            <p>
                                <i class="isax isax-calendar-1"></i>Last Booking
                                <span>{{ $lastDate }}</span>
                            </p>
                        </div>
                    </li>
                </ul>
                <div class="patient-grid-footer">
                    <a href="{{ route('patient.details.page', $patient->id) }}"
                       class="btn btn-sm btn-outline-primary w-100 rounded-pill mt-2">
                        View Details
                    </a>
                </div>
            </div>
        </div>
        <!-- /Appointment Grid -->

        @empty
        <div class="col-12 text-center py-5">
            <i class="isax isax-people fs-1 text-muted mb-3 d-block"></i>
            <h5 class="text-muted">No patients yet.</h5>
            <p class="text-muted">Patients will appear here after you complete an appointment.</p>
        </div>
        @endforelse

        </div>
    </div>
</div>

@endsection
