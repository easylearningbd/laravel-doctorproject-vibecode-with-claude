<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Booking Confirmed — {{ $appointment->appointment_number }}</title>

    <link rel="shortcut icon" href="{{ asset('backend/assets/img/favicon.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/plugins/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/iconsax.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/custom.css') }}">
</head>
<body>

<div class="main-wrapper">

    <!-- Header -->
    <header class="header header-custom header-fixed inner-header relative">
        <div class="container">
            <nav class="navbar navbar-expand-lg header-nav">
                <div class="navbar-header">
                    <a href="{{ route('home') }}" class="navbar-brand logo">
                        <img src="{{ asset('backend/assets/img/logo.svg') }}" class="img-fluid" alt="Logo">
                    </a>
                </div>
            </nav>
        </div>
    </header>

    <div class="doctor-content">
    <div class="container">
    <div class="row">
    <div class="col-lg-10 mx-auto">

    @php
        $doctor      = $appointment->doctor;
        $doctorName  = $doctor->display_name ?: 'Dr. ' . $doctor->first_name . ' ' . $doctor->last_name;
        $doctorPhoto = $doctor->profile_photo
            ? asset('storage/' . $doctor->profile_photo)
            : asset('backend/assets/img/doctors/doc-profile-02.jpg');
        $apptDate    = $appointment->appointment_date->format('D, d M Y');
        $apptTime    = \Carbon\Carbon::createFromFormat('H:i', $appointment->appointment_time)->format('h:i A');
        $apptTypeLbl = str_replace('_', ' ', ucfirst($appointment->appointment_type));
    @endphp

    <!-- Progress Bar (step 6 active) -->
    <div class="booking-wizard">
        <ul class="form-wizard-steps d-sm-flex align-items-center justify-content-center" id="progressbar2">
            <li class="progress-active activated"><div class="profile-step"><span class="multi-steps">1</span><div class="step-section"><h6>Specialty</h6></div></div></li>
            <li class="progress-active activated"><div class="profile-step"><span class="multi-steps">2</span><div class="step-section"><h6>Appointment Type</h6></div></div></li>
            <li class="progress-active activated"><div class="profile-step"><span class="multi-steps">3</span><div class="step-section"><h6>Date &amp; Time</h6></div></div></li>
            <li class="progress-active activated"><div class="profile-step"><span class="multi-steps">4</span><div class="step-section"><h6>Basic Information</h6></div></div></li>
            <li class="progress-active activated"><div class="profile-step"><span class="multi-steps">5</span><div class="step-section"><h6>Payment</h6></div></div></li>
            <li class="progress-active"><div class="profile-step"><span class="multi-steps">6</span><div class="step-section"><h6>Confirmation</h6></div></div></li>
        </ul>
    </div>

    <div class="booking-widget mb-5">
        <div class="card booking-card">
            <div class="card-body booking-body pb-1">
                <div class="row">

                    <!-- Left: Booking Details -->
                    <div class="col-lg-8 d-flex">
                        <div class="flex-fill">

                            <!-- Confirmed Banner -->
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="d-flex align-items-center">
                                        <i class="isax isax-tick-circle5 text-success me-2 fs-4"></i>
                                        Booking Confirmed
                                    </h5>
                                </div>
                                <div class="card-header d-flex align-items-center">
                                    <span class="avatar avatar-lg avatar-rounded me-2 flex-shrink-0">
                                        <img src="{{ $doctorPhoto }}" alt="{{ $doctorName }}">
                                    </span>
                                    <p class="mb-0">
                                        Your booking has been confirmed with
                                        <strong>{{ $doctorName }}</strong>.
                                        Please be on time, at least
                                        <strong>15 minutes</strong> before the appointment.
                                    </p>
                                </div>

                                <!-- Booking Info -->
                                <div class="card-body pb-1">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <h6>Booking Info</h6>
                                        <a href="{{ route('invoice.print', $appointment->appointment_number) }}"
                                           target="_blank"
                                           class="btn btn-light rounded-pill">
                                            <i class="isax isax-document-text me-1"></i>Print Invoice
                                        </a>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Appointment Number</label>
                                                <div class="form-plain-text fw-bold text-primary">{{ $appointment->appointment_number }}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Invoice Number</label>
                                                <div class="form-plain-text">{{ $appointment->invoice_number }}</div>
                                            </div>
                                        </div>
                                        @if ($services->count())
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Services</label>
                                                <div class="form-plain-text">
                                                    {{ $services->pluck('service_name')->implode(', ') }}
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Date &amp; Time</label>
                                                <div class="form-plain-text">{{ $apptDate }} at {{ $apptTime }}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Appointment Type</label>
                                                <div class="form-plain-text">{{ $apptTypeLbl }}</div>
                                            </div>
                                        </div>
                                        @if ($appointment->clinic)
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Clinic</label>
                                                <div class="form-plain-text">{{ $appointment->clinic->clinic_name }}</div>
                                            </div>
                                        </div>
                                        @endif
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Payment Status</label>
                                                <div class="form-plain-text">
                                                    <span class="badge bg-success">{{ ucfirst($appointment->payment_status) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Amount Paid</label>
                                                <div class="form-plain-text fw-bold">${{ number_format($appointment->total_amount, 2) }}</div>
                                            </div>
                                        </div>
                                        @if ($appointment->payment)
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Transaction ID</label>
                                                <div class="form-plain-text text-muted">{{ $appointment->payment->transaction_id }}</div>
                                            </div>
                                        </div>
                                        @endif
                                        @if ($appointment->symptoms)
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label">Symptoms</label>
                                                <div class="form-plain-text">{{ $appointment->symptoms }}</div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Call Us -->
                            <div class="card">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <div>
                                        <h6 class="mb-1">Need Assistance?</h6>
                                        <p class="mb-0">Call us if you face any issue with your booking or cancellation.</p>
                                    </div>
                                    <a href="javascript:void(0);" class="btn btn-light rounded-pill">
                                        <i class="isax isax-call5 me-1"></i>Call Us
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Right: QR + Actions -->
                    <div class="col-lg-4 d-flex">
                        <div class="card flex-fill">
                            <div class="card-body d-flex flex-column justify-content-between">
                                <div class="text-center">
                                    <h6 class="fs-14 mb-2">Booking Number</h6>
                                    <span class="booking-id-badge mb-3 d-inline-block">{{ $appointment->appointment_number }}</span>

                                    <!-- QR Code via free API -->
                                    <span class="d-block mb-3 mt-3">
                                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode($appointment->appointment_number) }}"
                                             alt="QR Code" width="150" height="150"
                                             style="border-radius:8px;">
                                    </span>
                                    <p class="small text-muted">Scan this QR Code to view your appointment details</p>

                                    <!-- Payment Summary Card -->
                                    <div class="bg-light rounded p-3 text-start mt-3">
                                        <div class="d-flex justify-content-between mb-1">
                                            <small>Consultation Fee</small>
                                            <small>${{ number_format($appointment->consultation_fee, 2) }}</small>
                                        </div>
                                        <div class="d-flex justify-content-between mb-1">
                                            <small>Booking Fee</small>
                                            <small>${{ number_format($appointment->booking_fee, 2) }}</small>
                                        </div>
                                        <div class="d-flex justify-content-between mb-1">
                                            <small>Tax (5%)</small>
                                            <small>${{ number_format($appointment->tax, 2) }}</small>
                                        </div>
                                        <hr class="my-2">
                                        <div class="d-flex justify-content-between fw-bold">
                                            <span>Total Paid</span>
                                            <span class="text-primary">${{ number_format($appointment->total_amount, 2) }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <a href="{{ route('invoice.print', $appointment->appointment_number) }}"
                                       target="_blank"
                                       class="btn w-100 mb-3 btn-md btn-dark inline-flex align-items-center rounded-pill">
                                        <i class="isax isax-document-text me-1"></i>
                                        Download Invoice
                                    </a>
                                    <a href="{{ route('home') }}"
                                       class="btn w-100 btn-md btn-primary-gradient inline-flex align-items-center rounded-pill">
                                        Start New Booking
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="text-center mb-4">
        <p class="mb-0">Copyright &copy; {{ now()->year }}. All Rights Reserved, Doccure</p>
    </div>

    </div>
    </div>
    </div>
    </div>

    <div class="mouse-cursor cursor-outer"></div>
    <div class="mouse-cursor cursor-inner"></div>
</div>

<script src="{{ asset('backend/assets/js/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('backend/assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('backend/assets/js/feather.min.js') }}"></script>
<script src="{{ asset('backend/assets/js/script.js') }}"></script>
</body>
</html>
