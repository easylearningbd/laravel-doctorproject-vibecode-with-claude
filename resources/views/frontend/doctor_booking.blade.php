<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Book Appointment — {{ $doctor->display_name ?: 'Dr. ' . $doctor->first_name . ' ' . $doctor->last_name }}</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('backend/assets/img/favicon.png') }}" type="image/x-icon">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('backend/assets/css/bootstrap.min.css') }}">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{ asset('backend/assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/plugins/fontawesome/css/all.min.css') }}">

    <!-- Iconsax CSS -->
    <link rel="stylesheet" href="{{ asset('backend/assets/css/iconsax.css') }}">

    <!-- Feathericon CSS -->
    <link rel="stylesheet" href="{{ asset('backend/assets/css/feather.css') }}">

    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="{{ asset('backend/assets/css/bootstrap-datetimepicker.min.css') }}">

    <!-- select CSS -->
    <link rel="stylesheet" href="{{ asset('backend/assets/plugins/select2/css/select2.min.css') }}">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('backend/assets/css/custom.css') }}">
    <style>
        .visit-btns input:disabled + .visit-rsn { opacity: .4; cursor: not-allowed; }
        .visit-btns input:disabled ~ * { pointer-events: none; }
        .slot-booked label { opacity: .4; cursor: not-allowed; }
        #slotsLoading { display:none; }
        .no-slots-msg { display:none; color:#888; font-style:italic; }
    </style>
</head>
<body>

<!-- Main Wrapper -->
<div class="main-wrapper">

    <!-- Header -->
    <header class="header header-custom header-fixed inner-header relative">
        <div class="container">
            <nav class="navbar navbar-expand-lg header-nav">
                <div class="navbar-header">
                    <a id="mobile_btn" href="javascript:void(0);">
                        <span class="bar-icon"><span></span><span></span><span></span></span>
                    </a>
                    <a href="{{ route('home') }}" class="navbar-brand logo">
                        <img src="{{ asset('backend/assets/img/logo.svg') }}" class="img-fluid" alt="Logo">
                    </a>
                </div>
            </nav>
        </div>
    </header>
    <!-- /Header -->

    <!-- Booking Content -->
    <div class="doctor-content">
    <div class="container">
    <div class="row">
    <div class="col-lg-10 mx-auto">

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Progress Bar -->
    <div class="booking-wizard">
        <ul class="form-wizard-steps d-sm-flex align-items-center justify-content-center" id="progressbar2">
            <li class="progress-active"><div class="profile-step"><span class="multi-steps">1</span><div class="step-section"><h6>Specialty</h6></div></div></li>
            <li><div class="profile-step"><span class="multi-steps">2</span><div class="step-section"><h6>Appointment Type</h6></div></div></li>
            <li><div class="profile-step"><span class="multi-steps">3</span><div class="step-section"><h6>Date &amp; Time</h6></div></div></li>
            <li><div class="profile-step"><span class="multi-steps">4</span><div class="step-section"><h6>Basic Information</h6></div></div></li>
            <li><div class="profile-step"><span class="multi-steps">5</span><div class="step-section"><h6>Payment</h6></div></div></li>
            <li><div class="profile-step"><span class="multi-steps">6</span><div class="step-section"><h6>Confirmation</h6></div></div></li>
        </ul>
    </div>

    @php
        $doctorName = $doctor->display_name ?: 'Dr. ' . $doctor->first_name . ' ' . $doctor->last_name;
        $doctorLocation = collect([$doctor->city, $doctor->state, $doctor->country])->filter()->implode(', ') ?: 'Location not set';
        $doctorPhoto = $doctor->profile_photo ? asset('storage/' . $doctor->profile_photo) : asset('backend/assets/img/doctors/doc-profile-02.jpg');
    @endphp

    <!-- ═══ BOOKING FORM ═══════════════════════════════════════════════ -->
    <form id="bookingForm"
          action="{{ route('appointment.store', $doctor->id) }}"
          method="POST"
          enctype="multipart/form-data">
    @csrf

    <div class="booking-widget multistep-form mb-5">

        {{-- ──────────────────────────────────────────────────────────────── --}}
        {{-- STEP 1: Specialty & Services --}}
        {{-- ──────────────────────────────────────────────────────────────── --}}
        <fieldset id="first">
            <div class="card booking-card mb-0">
                <div class="card-header">
                    <div class="booking-header pb-0">
                        <div class="card mb-0">
                            <div class="card-body">
                                <div class="d-flex align-items-center flex-wrap row-gap-2">
                                    <span class="avatar avatar-xxxl avatar-rounded me-2 flex-shrink-0">
                                        <img src="{{ $doctorPhoto }}" alt="{{ $doctorName }}">
                                    </span>
                                    <div>
                                        <h4 class="mb-1">{{ $doctorName }}
                                            <span class="badge bg-orange fs-12"><i class="fa-solid fa-star me-1"></i>5.0</span>
                                        </h4>
                                        <p class="text-indigo mb-3 fw-medium">{{ $doctor->display_speciality }}</p>
                                        <p class="mb-0"><i class="isax isax-location me-2"></i>{{ $doctorLocation }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body booking-body">
                    <div class="card mb-0">
                        <div class="card-body pb-1">
                            @forelse ($servicesGrouped as $specialityName => $services)
                            <div class="mb-4 pb-4 border-bottom">
                                <h6 class="mb-3">{{ $specialityName }}</h6>
                                <div class="row">
                                    @foreach ($services as $service)
                                    <div class="col-lg-4 col-md-6">
                                        <div class="service-item">
                                            <input class="form-check-input ms-0 mt-0 service-checkbox"
                                                   name="service_ids[]"
                                                   type="checkbox"
                                                   id="svc_{{ $service->id }}"
                                                   value="{{ $service->id }}"
                                                   data-price="{{ $service->price }}"
                                                   data-name="{{ $service->service_name }}">
                                            <label class="form-check-label ms-2" for="svc_{{ $service->id }}">
                                                <span class="service-title d-block mb-1">{{ $service->service_name }}</span>
                                                <span class="fs-14 d-block">
                                                    @if ($service->price) ${{ number_format($service->price, 0) }} @else Free @endif
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @empty
                            <p class="text-muted">No services available for this doctor.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex align-items-center flex-wrap justify-content-between">
                        <a href="{{ route('doctor.details', $doctor->id) }}" class="btn btn-md btn-dark inline-flex align-items-center rounded-pill">
                            <i class="isax isax-arrow-left-2 me-1"></i> Back
                        </a>
                        <a href="javascript:void(0);" class="btn btn-md btn-primary-gradient next_btns inline-flex align-items-center rounded-pill">
                            Select Appointment Type <i class="isax isax-arrow-right-3 ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </fieldset>

        {{-- ──────────────────────────────────────────────────────────────── --}}
        {{-- STEP 2: Appointment Type & Clinic --}}
        {{-- ──────────────────────────────────────────────────────────────── --}}
        <fieldset>
            <div class="card booking-card mb-0">
                <div class="card-header">
                    <div class="booking-header pb-0">
                        <div class="card mb-0">
                            <div class="card-body">
                                <div class="d-flex align-items-center flex-wrap row-gap-2">
                                    <span class="avatar avatar-xxxl avatar-rounded me-2 flex-shrink-0">
                                        <img src="{{ $doctorPhoto }}" alt="{{ $doctorName }}">
                                    </span>
                                    <div>
                                        <h4 class="mb-1">{{ $doctorName }}
                                            <span class="badge bg-orange fs-12"><i class="fa-solid fa-star me-1"></i>5.0</span>
                                        </h4>
                                        <p class="text-indigo mb-3 fw-medium">{{ $doctor->display_speciality }}</p>
                                        <p class="mb-0"><i class="isax isax-location me-2"></i>{{ $doctorLocation }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body booking-body">
                    <div class="card mb-0">
                        <div class="card-body pb-1">
                            <h6 class="mb-3">Select Appointment Type</h6>
                            <div class="row">
                                @php
                                    $types = [
                                        'clinic'     => ['icon' => 'isax-hospital5',    'label' => 'Clinic'],
                                        'video_call' => ['icon' => 'isax-video5',        'label' => 'Video Call'],
                                        'audio_call' => ['icon' => 'isax-call5',         'label' => 'Audio Call'],
                                        'chat'       => ['icon' => 'isax-messages-15',   'label' => 'Chat'],
                                        'home_visit' => ['icon' => 'isax-house5',        'label' => 'Home Visit'],
                                    ];
                                @endphp
                                @foreach ($types as $value => $type)
                                <div class="col-xl col-md-3 col-sm-4">
                                    <div class="radio-select text-center">
                                        <input class="form-check-input ms-0 mt-0 appt-type-radio"
                                               name="appointment_type"
                                               type="radio"
                                               id="type_{{ $value }}"
                                               value="{{ $value }}"
                                               {{ $value === 'clinic' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="type_{{ $value }}">
                                            <i class="isax {{ $type['icon'] }}"></i>
                                            <span class="service-title d-block">{{ $type['label'] }}</span>
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            {{-- Clinics: show only when type=clinic --}}
                            <div class="clinics-path" id="clinicSection">
                                <h6 class="mb-3 mt-3">Select Clinic</h6>
                                @forelse ($doctor->clinics as $clinic)
                                <div class="service-item">
                                    <input class="form-check-input ms-0 mt-0"
                                           name="clinic_id"
                                           type="radio"
                                           id="clinic_{{ $clinic->id }}"
                                           value="{{ $clinic->id }}"
                                           {{ $loop->first ? 'checked' : '' }}>
                                    <label class="form-check-label ms-2" for="clinic_{{ $clinic->id }}">
                                        <span class="d-flex align-items-center flex-wrap">
                                            <span class="d-inline-block me-2">
                                                @if ($clinic->logo)
                                                    <img src="{{ asset('storage/' . $clinic->logo) }}" class="rounded-circle" style="width:40px;height:40px;object-fit:cover;" alt="">
                                                @else
                                                    <img src="{{ asset('assets/img/icons/clinic-icon-01.svg') }}" class="rounded-circle" alt="">
                                                @endif
                                            </span>
                                            <span>
                                                <span class="service-title d-block mb-1">{{ $clinic->clinic_name }}</span>
                                                <span class="fs-14">{{ collect([$clinic->address, $clinic->location])->filter()->implode(', ') ?: 'Address not set' }}</span>
                                            </span>
                                        </span>
                                    </label>
                                </div>
                                @empty
                                <p class="text-muted small">No clinic registered for this doctor.</p>
                                @endforelse
                            </div>

                            {{-- Home visit address: show only when type=home_visit --}}
                            <div id="homeVisitSection" style="display:none;" class="mt-3">
                                <h6 class="mb-2">Your Address for Home Visit</h6>
                                <input type="text" name="home_address" class="form-control"
                                       placeholder="Enter your full address"
                                       value="{{ $patient->address }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex align-items-center flex-wrap justify-content-between">
                        <a href="javascript:void(0);" class="btn btn-md btn-dark prev_btns inline-flex align-items-center rounded-pill">
                            <i class="isax isax-arrow-left-2 me-1"></i> Back
                        </a>
                        <a href="javascript:void(0);" class="btn btn-md btn-primary-gradient next_btns inline-flex align-items-center rounded-pill">
                            Select Date &amp; Time <i class="isax isax-arrow-right-3 ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </fieldset>

        {{-- ──────────────────────────────────────────────────────────────── --}}
        {{-- STEP 3: Date & Time --}}
        {{-- ──────────────────────────────────────────────────────────────── --}}
        <fieldset>
            <div class="card booking-card mb-0">
                <div class="card-header">
                    <div class="booking-header pb-0">
                        <div class="card mb-0">
                            <div class="card-body">
                                <div class="d-flex align-items-center flex-wrap row-gap-2 mb-4">
                                    <span class="avatar avatar-xxxl avatar-rounded me-2 flex-shrink-0">
                                        <img src="{{ $doctorPhoto }}" alt="{{ $doctorName }}">
                                    </span>
                                    <div>
                                        <h4 class="mb-1">{{ $doctorName }}
                                            <span class="badge bg-orange fs-12"><i class="fa-solid fa-star me-1"></i>5.0</span>
                                        </h4>
                                        <p class="text-indigo mb-3 fw-medium">{{ $doctor->display_speciality }}</p>
                                        <p class="mb-0"><i class="isax isax-location me-2"></i>{{ $doctorLocation }}</p>
                                    </div>
                                </div>
                                <h6 class="mb-2">Booking Info</h6>
                                <div class="row gx-2 gy-3">
                                    <div class="col-lg-3 col-sm-6">
                                        <h6 class="fs-14 fw-medium mb-1">Selected Services</h6>
                                        <p class="mb-0" id="summary-services">—</p>
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <h6 class="fs-14 fw-medium mb-1">Appointment Type</h6>
                                        <p class="mb-0" id="summary-type">—</p>
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <h6 class="fs-14 fw-medium mb-1">Date &amp; Time</h6>
                                        <p class="mb-0" id="summary-datetime">Not selected</p>
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <h6 class="fs-14 fw-medium mb-1">Total Fee</h6>
                                        <p class="mb-0" id="summary-total">$0</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body booking-body">
                    <div class="card mb-0">
                        <div class="card-body pb-1">
                            <div class="row">
                                <div class="col-lg-5">
                                    <div class="card">
                                        <div class="card-body p-2 pt-3">
                                            <div id="datetimepickershow"></div>
                                            <input type="hidden" name="appointment_date" id="appointmentDate">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <div class="card booking-wizard-slots">
                                        <div class="card-body">
                                            <div id="slotsLoading" class="text-center py-3">
                                                <div class="spinner-border spinner-border-sm text-primary"></div>
                                                <span class="ms-2 small">Loading slots…</span>
                                            </div>
                                            <p class="no-slots-msg" id="noSlotsMsg">No available slots for this day.</p>

                                            <div id="morningSlots">
                                                <div class="book-title"><h6 class="fs-14 mb-2">Morning</h6></div>
                                                <div class="token-slot mt-2 mb-2" id="morningContainer"></div>
                                            </div>
                                            <div id="afternoonSlots">
                                                <div class="book-title"><h6 class="fs-14 mb-2">Afternoon</h6></div>
                                                <div class="token-slot mt-2 mb-2" id="afternoonContainer"></div>
                                            </div>
                                            <div id="eveningSlots">
                                                <div class="book-title"><h6 class="fs-14 mb-2">Evening</h6></div>
                                                <div class="token-slot mt-2 mb-2" id="eveningContainer"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="appointment_time" id="appointmentTime">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex align-items-center flex-wrap justify-content-between">
                        <a href="javascript:void(0);" class="btn btn-md btn-dark prev_btns inline-flex align-items-center rounded-pill">
                            <i class="isax isax-arrow-left-2 me-1"></i> Back
                        </a>
                        <a href="javascript:void(0);" class="btn btn-md btn-primary-gradient next_btns inline-flex align-items-center rounded-pill" id="toStep4Btn">
                            Add Basic Information <i class="isax isax-arrow-right-3 ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </fieldset>

        {{-- ──────────────────────────────────────────────────────────────── --}}
        {{-- STEP 4: Patient Information --}}
        {{-- ──────────────────────────────────────────────────────────────── --}}
        <fieldset>
            <div class="card booking-card mb-0">
                <div class="card-header">
                    <div class="booking-header pb-0">
                        <div class="card mb-0">
                            <div class="card-body">
                                <div class="d-flex align-items-center flex-wrap row-gap-2 mb-4">
                                    <span class="avatar avatar-xxxl avatar-rounded me-2 flex-shrink-0">
                                        <img src="{{ $doctorPhoto }}" alt="{{ $doctorName }}">
                                    </span>
                                    <div>
                                        <h4 class="mb-1">{{ $doctorName }}
                                            <span class="badge bg-orange fs-12"><i class="fa-solid fa-star me-1"></i>5.0</span>
                                        </h4>
                                        <p class="text-indigo mb-3 fw-medium">{{ $doctor->display_speciality }}</p>
                                        <p class="mb-0"><i class="isax isax-location me-2"></i>{{ $doctorLocation }}</p>
                                    </div>
                                </div>
                                <h6 class="mb-2">Booking Info</h6>
                                <div class="row gx-2 gy-3">
                                    <div class="col-lg-3 col-sm-6">
                                        <h6 class="fs-14 fw-medium mb-1">Services</h6>
                                        <p class="mb-0 summary-services-display">—</p>
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <h6 class="fs-14 fw-medium mb-1">Date &amp; Time</h6>
                                        <p class="mb-0 summary-datetime-display">Not selected</p>
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <h6 class="fs-14 fw-medium mb-1">Appointment Type</h6>
                                        <p class="mb-0 summary-type-display">—</p>
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <h6 class="fs-14 fw-medium mb-1">Total Fee</h6>
                                        <p class="mb-0 summary-total-display">$0</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body booking-body">
                    <div class="card mb-0">
                        <div class="card-body pb-1">
                            <div class="row">
                                <div class="col-lg-4 col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">First Name <span class="text-danger">*</span></label>
                                        <input type="text" name="first_name" class="form-control"
                                               value="{{ old('first_name', $patient->first_name) }}" required>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Last Name <span class="text-danger">*</span></label>
                                        <input type="text" name="last_name" class="form-control"
                                               value="{{ old('last_name', $patient->last_name) }}" required>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                                        <input type="text" name="phone" class="form-control"
                                               value="{{ old('phone', $patient->phone) }}" required>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Email Address <span class="text-danger">*</span></label>
                                        <input type="email" name="email" class="form-control"
                                               value="{{ old('email', $patient->email) }}" required>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Symptoms</label>
                                        <input type="text" name="symptoms" class="form-control"
                                               value="{{ old('symptoms') }}"
                                               placeholder="e.g. headache, fever">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Medical Attachment</label>
                                        <input type="file" name="attachment" class="form-control"
                                               accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                                        <small class="text-muted">Max 5 MB. jpg, png, pdf, doc</small>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label class="form-label">Reason for Visit</label>
                                        <textarea name="reason_for_visit" class="form-control" rows="3"
                                                  placeholder="Describe your reason for visit">{{ old('reason_for_visit') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex align-items-center flex-wrap justify-content-between">
                        <a href="javascript:void(0);" class="btn btn-md btn-dark prev_btns inline-flex align-items-center rounded-pill">
                            <i class="isax isax-arrow-left-2 me-1"></i> Back
                        </a>
                        <a href="javascript:void(0);" class="btn btn-md btn-primary-gradient next_btns inline-flex align-items-center rounded-pill">
                            Select Payment <i class="isax isax-arrow-right-3 ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </fieldset>

        {{-- ──────────────────────────────────────────────────────────────── --}}
        {{-- STEP 5: Payment --}}
        {{-- ──────────────────────────────────────────────────────────────── --}}
        <fieldset>
            <div class="card booking-card mb-0">
                <div class="card-header">
                    <div class="booking-header pb-0">
                        <div class="card mb-0">
                            <div class="card-body">
                                <div class="d-flex align-items-center flex-wrap row-gap-2">
                                    <span class="avatar avatar-xxxl avatar-rounded me-2 flex-shrink-0">
                                        <img src="{{ $doctorPhoto }}" alt="{{ $doctorName }}">
                                    </span>
                                    <div>
                                        <h4 class="mb-1">{{ $doctorName }}
                                            <span class="badge bg-orange fs-12"><i class="fa-solid fa-star me-1"></i>5.0</span>
                                        </h4>
                                        <p class="text-indigo mb-3 fw-medium">{{ $doctor->display_speciality }}</p>
                                        <p class="mb-0"><i class="isax isax-location me-2"></i>{{ $doctorLocation }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body booking-body">
                    <div class="row">
                        {{-- Credit Card --}}
                        <div class="col-lg-6 d-flex">
                            <div class="card flex-fill mb-3 mb-lg-0">
                                <div class="card-body">
                                    <h6 class="mb-3">Payment Gateway</h6>
                                    <div class="payment-tabs">
                                        <ul class="nav nav-pills mb-3 row" id="pills-tab" role="tablist">
                                            <li class="nav-item col-sm-4" role="presentation">
                                                <button class="nav-link active" id="pills-cc-tab"
                                                        data-bs-toggle="pill" data-bs-target="#pills-cc"
                                                        type="button" role="tab">
                                                    <img src="{{ asset('assets/img/icons/payment-icon-05.svg') }}" class="me-2" alt="">
                                                    Credit Card
                                                </button>
                                            </li>
                                            <li class="nav-item col-sm-4" role="presentation">
                                                <button class="nav-link" disabled
                                                        type="button"
                                                        title="Coming soon">
                                                    <img src="{{ asset('assets/img/icons/payment-icon-06.svg') }}" class="me-2" alt="">
                                                    Paypal
                                                </button>
                                            </li>
                                            <li class="nav-item col-sm-4" role="presentation">
                                                <button class="nav-link" disabled
                                                        type="button"
                                                        title="Coming soon">
                                                    <img src="{{ asset('assets/img/icons/payment-icon-07.svg') }}" class="me-2" alt="">
                                                    Stripe
                                                </button>
                                            </li>
                                        </ul>
                                        <div class="tab-content" id="pills-tabContent">
                                            <div class="tab-pane fade show active" id="pills-cc" role="tabpanel">
                                                <div class="mb-3">
                                                    <label class="form-label">Card Holder Name <span class="text-danger">*</span></label>
                                                    <div class="position-relative input-icon">
                                                        <input type="text" name="card_holder_name"
                                                               class="form-control"
                                                               value="{{ old('card_holder_name', $patient->first_name . ' ' . $patient->last_name) }}"
                                                               placeholder="Name on card" required>
                                                        <span><i class="isax isax-user"></i></span>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Card Number <span class="text-danger">*</span></label>
                                                    <div class="position-relative input-icon">
                                                        <input type="text" name="card_number"
                                                               class="form-control"
                                                               placeholder="XXXX XXXX XXXX XXXX"
                                                               maxlength="19" required>
                                                        <span><i class="isax isax-card-tick"></i></span>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Expire Date <span class="text-danger">*</span></label>
                                                    <div class="position-relative input-icon">
                                                        <input type="text" name="card_expiry"
                                                               class="form-control"
                                                               placeholder="MM/YYYY" maxlength="7" required>
                                                        <span><i class="isax isax-calendar-2"></i></span>
                                                    </div>
                                                </div>
                                                <div class="mb-0">
                                                    <label class="form-label">CVV <span class="text-danger">*</span></label>
                                                    <div class="position-relative input-icon">
                                                        <input type="password" name="card_cvv"
                                                               class="form-control"
                                                               placeholder="•••" maxlength="4" required>
                                                        <span><i class="isax isax-check"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Payment Summary --}}
                        <div class="col-lg-6 d-flex">
                            <div class="card flex-fill mb-0">
                                <div class="card-body">
                                    <h6 class="mb-3">Booking Summary</h6>
                                    <div class="mb-3">
                                        <label class="form-label">Date &amp; Time</label>
                                        <div class="form-plain-text summary-datetime-display">Not selected</div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Appointment Type</label>
                                        <div class="form-plain-text summary-type-display">—</div>
                                    </div>
                                    <div class="pt-3 border-top booking-more-info">
                                        <h6 class="mb-3">Payment Info</h6>
                                        <div id="servicesFeeList"></div>
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <p class="mb-0">Booking Fee</p>
                                            <span class="fw-medium d-block">$20</span>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <p class="mb-0">Tax (5%)</p>
                                            <span class="fw-medium d-block" id="taxDisplay">$0</span>
                                        </div>
                                    </div>
                                    <div class="bg-primary d-flex align-items-center justify-content-between p-3 rounded mt-2">
                                        <h6 class="text-white">Total</h6>
                                        <h6 class="text-white" id="grandTotalDisplay">$20</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex align-items-center flex-wrap justify-content-between">
                        <a href="javascript:void(0);" class="btn btn-md btn-dark prev_btns inline-flex align-items-center rounded-pill">
                            <i class="isax isax-arrow-left-2 me-1"></i> Back
                        </a>
                        {{-- Submit button (no next_btn class — form submits) --}}
                        <button type="submit" id="confirmPayBtn"
                                class="btn btn-md btn-primary-gradient inline-flex align-items-center rounded-pill">
                            Confirm &amp; Pay <i class="isax isax-arrow-right-3 ms-1"></i>
                        </button>
                    </div>
                </div>
            </div>
        </fieldset>

    </div><!-- /booking-widget -->
    </form>
    <!-- ═══ END BOOKING FORM ════════════════════════════════════════════ -->

    <div class="text-center">
        <p class="mb-0">Copyright &copy; {{ now()->year }}. All Rights Reserved, Doccure</p>
    </div>

    </div>
    </div>
    </div>
    </div>
    <!-- /Booking Content -->

    <div class="mouse-cursor cursor-outer"></div>
    <div class="mouse-cursor cursor-inner"></div>

</div><!-- /Main Wrapper -->

<!-- jQuery -->
<script src="{{ asset('backend/assets/js/jquery-3.7.1.min.js') }}"></script>
<!-- Bootstrap Bundle JS -->
<script src="{{ asset('backend/assets/js/bootstrap.bundle.min.js') }}"></script>
<!-- Feather Icon JS -->
<script src="{{ asset('backend/assets/js/feather.min.js') }}"></script>
<!-- Datetimepicker JS -->
<script src="{{ asset('backend/assets/js/moment.min.js') }}"></script>
<script src="{{ asset('backend/assets/js/bootstrap-datetimepicker.min.js') }}"></script>
<!-- select JS -->
<script src="{{ asset('backend/assets/plugins/select2/js/select2.min.js') }}"></script>
<!-- Custom JS -->
<script src="{{ asset('backend/assets/js/script.js') }}"></script>

<script>
$(function () {
    /* ── Doctor open days ─────────────────────────────────────────────── */
    const openDays   = @json($openDays);
    const doctorId   = {{ $doctor->id }};
    const slotsUrl   = '{{ route('appointment.slots', $doctor->id) }}';
    const BOOKING_FEE = 20;

    /* ── Date picker ──────────────────────────────────────────────────── */
    $('#datetimepickershow').datetimepicker({
        format: 'YYYY-MM-DD',
        inline: true,
        minDate: moment().format('YYYY-MM-DD'),
        daysOfWeekDisabled: getDaysOfWeekDisabled(openDays),
    });

    $('#datetimepickershow').on('dp.change', function (e) {
        const date = e.date ? e.date.format('YYYY-MM-DD') : '';
        $('#appointmentDate').val(date);
        $('#appointmentTime').val('');
        updateSummaryDatetime();
        if (date) loadSlots(date);
    });

    function getDaysOfWeekDisabled(openDays) {
        const allDays   = ['sunday','monday','tuesday','wednesday','thursday','friday','saturday'];
        const disabled  = [];
        allDays.forEach((d, i) => { if (!openDays.includes(d)) disabled.push(i); });
        return disabled;
    }

    /* ── Load slots via AJAX ──────────────────────────────────────────── */
    function loadSlots(date) {
        $('#morningContainer,#afternoonContainer,#eveningContainer').empty();
        $('#slotsLoading').show();
        $('#noSlotsMsg').hide();
        $('#morningSlots,#afternoonSlots,#eveningSlots').hide();

        $.get(slotsUrl, { date: date }, function (resp) {
            $('#slotsLoading').hide();
            const slots = resp.slots || [];

            if (!slots.length) {
                $('#noSlotsMsg').show();
                return;
            }

            let hasMorning = false, hasAfternoon = false, hasEvening = false;

            slots.forEach(function (slot) {
                const disabled = slot.booked;
                const html = `
                    <div class="form-check-inline visits me-0 ${disabled ? 'slot-booked' : ''}">
                        <label class="visit-btns">
                            <input type="radio" class="form-check-input slot-radio" name="appointment_time_ui"
                                   value="${slot.time}" ${disabled ? 'disabled' : ''}
                                   data-display="${slot.display}">
                            <span class="visit-rsn">${slot.display}</span>
                        </label>
                    </div>`;

                if (slot.period === 'morning')   { $('#morningContainer').append(html);   hasMorning   = true; }
                if (slot.period === 'afternoon') { $('#afternoonContainer').append(html); hasAfternoon = true; }
                if (slot.period === 'evening')   { $('#eveningContainer').append(html);   hasEvening   = true; }
            });

            if (hasMorning)   $('#morningSlots').show();
            if (hasAfternoon) $('#afternoonSlots').show();
            if (hasEvening)   $('#eveningSlots').show();
        }).fail(function () {
            $('#slotsLoading').hide();
            $('#noSlotsMsg').text('Failed to load slots. Please try again.').show();
        });
    }

    /* ── Slot selection ───────────────────────────────────────────────── */
    $(document).on('change', '.slot-radio', function () {
        $('#appointmentTime').val($(this).val());
        updateSummaryDatetime();
    });

    /* ── Service checkboxes ───────────────────────────────────────────── */
    $(document).on('change', '.service-checkbox', function () {
        updatePaymentSummary();
    });

    /* ── Appointment type toggle ──────────────────────────────────────── */
    $(document).on('change', '.appt-type-radio', function () {
        const val = $(this).val();
        if (val === 'clinic') {
            $('#clinicSection').show();
            $('#homeVisitSection').hide();
        } else if (val === 'home_visit') {
            $('#clinicSection').hide();
            $('#homeVisitSection').show();
        } else {
            $('#clinicSection').hide();
            $('#homeVisitSection').hide();
        }
        updateSummaryType();
    });

    /* ── Summary update helpers ───────────────────────────────────────── */
    function updatePaymentSummary() {
        let subtotal = 0;
        let serviceNames = [];
        let serviceLines = '';

        $('.service-checkbox:checked').each(function () {
            const price = parseFloat($(this).data('price')) || 0;
            const name  = $(this).data('name');
            subtotal += price;
            serviceNames.push(name);
            serviceLines += `<div class="d-flex justify-content-between mb-2">
                <p class="mb-0">${name}</p>
                <span class="fw-medium">$${price.toFixed(0)}</span>
            </div>`;
        });

        const tax   = parseFloat((subtotal * 0.05).toFixed(2));
        const total = subtotal + BOOKING_FEE + tax;

        $('#servicesFeeList').html(serviceLines);
        $('#taxDisplay').text('$' + tax.toFixed(2));
        $('#grandTotalDisplay').text('$' + total.toFixed(2));

        // Update all summary displays
        const servicesText = serviceNames.length ? serviceNames.join(', ') : '—';
        $('.summary-services-display, #summary-services').text(servicesText);
        $('.summary-total-display, #summary-total').text('$' + total.toFixed(2));
    }

    function updateSummaryType() {
        const labels = {
            clinic: 'Clinic', video_call: 'Video Call',
            audio_call: 'Audio Call', chat: 'Chat', home_visit: 'Home Visit'
        };
        const val  = $('input[name="appointment_type"]:checked').val() || 'clinic';
        const text = labels[val] || val;
        $('.summary-type-display, #summary-type').text(text);
    }

    function updateSummaryDatetime() {
        const date = $('#appointmentDate').val();
        const time = $('#appointmentTime').val();
        if (date && time) {
            const displayTime = $(`input[value="${time}"]`).data('display') || time;
            const text = moment(date).format('ddd, DD MMM YYYY') + ' at ' + displayTime;
            $('.summary-datetime-display, #summary-datetime').text(text);
        }
    }

    /* ── Prevent Step 3 → 4 if no time selected ──────────────────────── */
    $('#toStep4Btn').on('click', function (e) {
        if (!$('#appointmentDate').val()) {
            alert('Please select an appointment date.');
            e.stopImmediatePropagation();
            return false;
        }
        if (!$('#appointmentTime').val()) {
            alert('Please select a time slot.');
            e.stopImmediatePropagation();
            return false;
        }
    });

    /* ── Confirm & Pay button loading state ───────────────────────────── */
    $('#bookingForm').on('submit', function () {
        $('#confirmPayBtn').prop('disabled', true)
            .html('<span class="spinner-border spinner-border-sm me-2"></span>Processing…');
    });

    /* ── Card number formatting ───────────────────────────────────────── */
    $('input[name="card_number"]').on('input', function () {
        let v = $(this).val().replace(/\D/g, '').substring(0, 16);
        $(this).val(v.replace(/(.{4})/g, '$1 ').trim());
    });

    /* ── Init summary ─────────────────────────────────────────────────── */
    updatePaymentSummary();
    updateSummaryType();
});
</script>

</body>
</html>
