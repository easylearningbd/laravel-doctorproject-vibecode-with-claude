@extends('frontend.home_master')
@section('home')

@php
    $fullName    = $doctor->display_name ?: 'Dr. ' . $doctor->first_name . ' ' . $doctor->last_name;
    $location    = collect([$doctor->address, $doctor->city, $doctor->state, $doctor->country])
                        ->filter()->implode(', ');
    $languages   = implode(', ', $doctor->known_languages ?? []);
    $days        = ['monday','tuesday','wednesday','thursday','friday','saturday','sunday'];
@endphp

<!-- Breadcrumb -->
<div class="breadcrumb-bar">
    <div class="container">
        <div class="row align-items-center inner-banner">
            <div class="col-md-12 col-12 text-center">
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="isax isax-home-15"></i></a></li>
                        <li class="breadcrumb-item" aria-current="page">Doctors</li>
                        <li class="breadcrumb-item active">{{ $fullName }}</li>
                    </ol>
                    <h2 class="breadcrumb-title">Doctor Profile</h2>
                </nav>
            </div>
        </div>
    </div>
    <div class="breadcrumb-bg">
        <img src="{{ asset('backend/assets/img/bg/breadcrumb-bg-01.png') }}" alt="img" class="breadcrumb-bg-01">
        <img src="{{ asset('backend/assets/img/bg/breadcrumb-bg-02.png') }}" alt="img" class="breadcrumb-bg-02">
        <img src="{{ asset('backend/assets/img/bg/breadcrumb-icon.png') }}" alt="img" class="breadcrumb-bg-03">
        <img src="{{ asset('backend/assets/img/bg/breadcrumb-icon.png') }}" alt="img" class="breadcrumb-bg-04">
    </div>
</div>
<!-- /Breadcrumb -->

<!-- Page Content -->
<div class="content">
    <div class="container">

        <!-- Doctor Widget -->
        <div class="card doc-profile-card">
            <div class="card-body">
                <div class="doctor-widget doctor-profile-two">

                    <!-- Left: Photo + Info -->
                    <div class="doc-info-left">
                        <div class="doctor-img">
                            @if ($doctor->profile_photo)
                                <img src="{{ asset('storage/' . $doctor->profile_photo) }}"
                                     class="img-fluid" alt="{{ $fullName }}">
                            @else
                                <img src="{{ asset('backend/assets/img/doctors/doc-profile-02.jpg') }}"
                                     class="img-fluid" alt="{{ $fullName }}">
                            @endif
                        </div>
                        <div class="doc-info-cont">
                            @if ($doctor->is_available)
                                <span class="badge doc-avail-badge">
                                    <i class="fa-solid fa-circle"></i>Available
                                </span>
                            @else
                                <span class="badge bg-danger-light">
                                    <i class="fa-solid fa-circle"></i>Unavailable
                                </span>
                            @endif

                            <h4 class="doc-name">
                                {{ $fullName }}
                                <img src="{{ asset('backend/assets/img/icons/badge-check.svg') }}" alt="Verified">
                                @if ($doctor->display_speciality)
                                    <span class="badge doctor-role-badge">
                                        <i class="fa-solid fa-circle"></i>{{ $doctor->display_speciality }}
                                    </span>
                                @endif
                            </h4>

                            @if ($doctor->designation)
                                <p>{{ $doctor->designation }}</p>
                            @endif

                            @if ($languages)
                                <p>Speaks : {{ $languages }}</p>
                            @endif

                            @if ($location)
                                <p class="address-detail">
                                    <span class="loc-icon"><i class="feather-map-pin"></i></span>
                                    {{ $location }}
                                </p>
                            @endif
                        </div>
                    </div>

                    <!-- Right: Stats -->
                    <div class="doc-info-right">
                        <ul class="doctors-activities">
                            <li>
                                <div class="hospital-info">
                                    <span class="list-icon">
                                        <img src="{{ asset('backend/assets/img/icons/watch-icon.svg') }}" alt="Img">
                                    </span>
                                    @php
                                        $empType = $doctor->experiences->first()?->employment_type ?? 'Full Time';
                                    @endphp
                                    <p>{{ $empType }}, Online Therapy Available</p>
                                </div>
                                <ul class="sub-links">
                                    <li>
                                        <a href="javascript:void(0)"
                                           class="fav-toggle-btn {{ $isFavourited ? 'fav-active' : '' }}"
                                           data-doctor-id="{{ $doctor->id }}"
                                           data-toggle-url="{{ route('favourite.toggle', $doctor->id) }}"
                                           title="{{ $isFavourited ? 'Remove from Favourites' : 'Add to Favourites' }}"
                                           style="{{ $isFavourited ? 'color:#e02020;' : '' }}">
                                            <i class="feather-heart"></i>
                                        </a>
                                    </li>
                                    <li><a href="#"><i class="feather-share-2"></i></a></li>
                                    <li><a href="#"><i class="feather-link"></i></a></li>
                                </ul>
                            </li>
                            <li>
                                <div class="hospital-info">
                                    <span class="list-icon">
                                        <img src="{{ asset('backend/assets/img/icons/thumb-icon.svg') }}" alt="Img">
                                    </span>
                                    <p><b>94% </b> Recommended</p>
                                </div>
                            </li>
                            <li>
                                <div class="hospital-info">
                                    <span class="list-icon">
                                        <img src="{{ asset('backend/assets/img/icons/building-icon.svg') }}" alt="Img">
                                    </span>
                                    <p>{{ $doctor->clinics->first()?->clinic_name ?? 'Private Practice' }}</p>
                                </div>
                                <h5 class="accept-text">
                                    <span><i class="feather-check"></i></span>Accepting New Patients
                                </h5>
                            </li>
                            <li>
                                <div class="rating">
                                    <i class="fas fa-star filled"></i>
                                    <i class="fas fa-star filled"></i>
                                    <i class="fas fa-star filled"></i>
                                    <i class="fas fa-star filled"></i>
                                    <i class="fas fa-star filled"></i>
                                    <span>5.0</span>
                                    <a href="#review" class="d-inline-block average-rating">Reviews</a>
                                </div>
                                <ul class="contact-doctors">
                                    <li><a href="#"><span><img src="{{ asset('backend/assets/img/icons/device-message2.svg') }}" alt="Img"></span>Chat</a></li>
                                    <li><a href="#"><span class="bg-violet"><i class="feather-phone-forwarded"></i></span>Audio Call</a></li>
                                    <li><a href="#"><span class="bg-indigo"><i class="fa-solid fa-video"></i></span>Video Call</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Bottom Bar -->
                <div class="doc-profile-card-bottom">
                    <ul>
                        <li>
                            <span class="bg-blue">
                                <img src="{{ asset('backend/assets/img/icons/calendar3.svg') }}" alt="Img">
                            </span>
                            Nearly 200+ Appointment Booked
                        </li>
                        <li>
                            <span class="bg-dark-blue">
                                <img src="{{ asset('backend/assets/img/icons/bullseye.svg') }}" alt="Img">
                            </span>
                            @if ($doctor->years_in_practice)
                                In Practice for {{ $doctor->years_in_practice }} Years
                            @else
                                Experienced Professional
                            @endif
                        </li>
                        <li>
                            <span class="bg-green">
                                <img src="{{ asset('backend/assets/img/icons/bookmark-star.svg') }}" alt="Img">
                            </span>
                            {{ $doctor->memberships->count() }}+ Memberships
                        </li>
                    </ul>
                    <div class="bottom-book-btn">
                        @if ($doctor->min_price || $doctor->max_price)
                            <p>
                                <span>
                                    Price :
                                    ${{ number_format($doctor->min_price ?? 0, 0) }}
                                    @if ($doctor->max_price && $doctor->max_price != $doctor->min_price)
                                        - ${{ number_format($doctor->max_price, 0) }}
                                    @endif
                                </span> for a Session
                            </p>
                        @endif
    <div class="clinic-booking">
        <a class="apt-btn" href="{{ route('doctor.booking',$doctor->id) }}">Book Appointment</a>
    </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Doctor Widget -->

        <!-- Detail Sections -->
        <div class="doctors-detailed-info">
            <ul class="information-title-list">
                <li class="active"><a href="#doc_bio">Doctor Bio</a></li>
                @if ($doctor->experiences->count())
                    <li><a href="#experience">Experience</a></li>
                @endif
                @if ($doctor->specialityServices->count())
                    <li><a href="#services">Treatments</a></li>
                    <li><a href="#speciality">Speciality</a></li>
                @endif
                @if ($doctor->businessHours->where('is_open', true)->count())
                    <li><a href="#availability">Availability</a></li>
                @endif
                @if ($doctor->clinics->count())
                    <li><a href="#clinic">Clinics</a></li>
                @endif
                @if ($doctor->memberships->count())
                    <li><a href="#membership">Memberships</a></li>
                @endif
                <li><a href="#bussiness_hour">Business Hours</a></li>
                <li><a href="#review">Review</a></li>
            </ul>

            <div class="doc-information-main">

                <!-- Doctor Bio -->
                <div class="doc-information-details bio-detail" id="doc_bio">
                    <div class="detail-title">
                        <h4>Doctor Bio</h4>
                    </div>
                    @if ($doctor->designation)
                        <p>{{ $doctor->designation }}</p>
                    @endif
                    @if ($languages)
                        <p><strong>Languages Spoken:</strong> {{ $languages }}</p>
                    @endif
                    @if ($location)
                        <p><strong>Location:</strong> {{ $location }}</p>
                    @endif
                    @if (!$doctor->designation && !$languages && !$location)
                        <p>No bio information available yet.</p>
                    @endif
                </div>

                <!-- Experience -->
                @if ($doctor->experiences->count())
                <div class="doc-information-details" id="experience">
                    <div class="detail-title">
                        <h4>Practice Experience</h4>
                    </div>
                    @foreach ($doctor->experiences as $index => $exp)
                    <div class="experience-info {{ !$loop->last ? 'mb-3' : '' }}">
                        <div class="experience-logo">
                            <span>
                                @if ($exp->logo)
                                    <img src="{{ asset('storage/' . $exp->logo) }}" alt="Logo"
                                         style="width:100px;height:100px;object-fit:cover;border-radius:8px;">
                                @else
                                    <img src="{{ asset('backend/assets/img/icons/experience-logo-0' . (($index % 2) + 1) . '.svg') }}" alt="Img"
                                         style="width:100px;height:100px;object-fit:contain;">
                                @endif
                            </span>
                        </div>
                        <div class="experience-content {{ $loop->last ? 'mb-0' : '' }}">
                            <h5>{{ $exp->hospital_name }}@if($exp->location), {{ $exp->location }}@endif</h5>
                            <ul class="ent-list">
                                @if ($exp->title)
                                    <li>{{ $exp->title }}</li>
                                @endif
                                @if ($exp->employment_type)
                                    <li>{{ $exp->employment_type }}</li>
                                @endif
                            </ul>
                            <ul class="date-list">
                                <li>
                                    {{ $exp->start_date?->format('M Y') }}
                                    —
                                    {{ $exp->currently_working ? 'Present' : $exp->end_date?->format('M Y') }}
                                </li>
                                @if ($exp->years_of_experience)
                                    <li>{{ $exp->years_of_experience }} Years</li>
                                @endif
                            </ul>
                            @if ($exp->description)
                                <p>{{ $exp->description }}</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif

                <!-- Speciality (service names) -->
                @if ($doctor->specialityServices->count())
                <div class="doc-information-details" id="speciality">
                    <div class="detail-title">
                        <h4>Speciality</h4>
                    </div>
                    <ul class="special-links">
                        @foreach ($doctor->specialityServices->unique('speciality_id') as $svc)
                            <li><a href="#">{{ $svc->speciality?->name }}</a></li>
                        @endforeach
                    </ul>
                </div>

                <!-- Services & Pricing -->
                <div class="doc-information-details" id="services">
                    <div class="detail-title">
                        <h4>Services &amp; Pricing</h4>
                    </div>
                    <ul class="special-links">
                        @foreach ($doctor->specialityServices as $svc)
                            <li>
                                <a href="#">
                                    {{ $svc->service_name }}
                                    @if ($svc->price)
                                        <span>${{ number_format($svc->price, 0) }}</span>
                                    @endif
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Availability (open business days) -->
                @if ($doctor->businessHours->where('is_open', true)->count())
                <div class="doc-information-details" id="availability">
                    <div class="detail-title slider-nav d-flex justify-content-between align-items-center">
                        <h4>Availability</h4>
                        <div class="nav nav-container slide-2"></div>
                    </div>
                    <div class="availability-slots-slider owl-carousel">
                        @foreach ($doctor->businessHours->where('is_open', true) as $bh)
                        <div class="availability-date">
                            <div class="book-date">
                                <h6>{{ ucfirst($bh->day_of_week) }}</h6>
                                <span>
                                    {{ $bh->start_time ? \Carbon\Carbon::createFromFormat('H:i', $bh->start_time)->format('h:i A') : '--' }}
                                    -
                                    {{ $bh->end_time ? \Carbon\Carbon::createFromFormat('H:i', $bh->end_time)->format('h:i A') : '--' }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Clinics -->
                @if ($doctor->clinics->count())
                <div class="doc-information-details" id="clinic">
                    <div class="detail-title">
                        <h4>Clinics &amp; Locations</h4>
                    </div>
                    @foreach ($doctor->clinics as $clinic)
                    <div class="clinic-loc {{ !$loop->last ? 'mb-3' : 'mb-0' }}">
                        <div class="row align-items-center">
                            <div class="col-lg-7">
                                <div class="clinic-info">
                                    <div class="clinic-img">
                                        @if ($clinic->logo)
                                            <img src="{{ asset('storage/' . $clinic->logo) }}" alt="Clinic">
                                        @elseif (!empty($clinic->gallery[0]))
                                            <img src="{{ asset('storage/' . $clinic->gallery[0]) }}" alt="Clinic">
                                        @else
                                            <img src="{{ asset('assets/img/clinic/clinic-11.jpg') }}" alt="Clinic">
                                        @endif
                                    </div>
                                    <div class="detail-clinic">
                                        <h5>{{ $clinic->clinic_name }}</h5>
                                        @if ($doctor->min_price)
                                            <span>${{ number_format($doctor->min_price, 0) }} / Appointment</span>
                                        @endif
                                        @if ($clinic->address || $clinic->location)
                                            <p>{{ collect([$clinic->address, $clinic->location])->filter()->implode(', ') }}</p>
                                        @endif
                                    </div>
                                </div>

                                {{-- Show first two open business days under clinic --}}
                                <div class="d-flex align-items-center avail-time-slot flex-wrap gap-2">
                                    @foreach ($doctor->businessHours->where('is_open', true)->take(2) as $bh)
                                    <div class="availability-date">
                                        <div class="book-date">
                                            <h6>{{ ucfirst($bh->day_of_week) }}</h6>
                                            <span>
                                                {{ $bh->start_time ? \Carbon\Carbon::createFromFormat('H:i', $bh->start_time)->format('h:i A') : '--' }}
                                                -
                                                {{ $bh->end_time ? \Carbon\Carbon::createFromFormat('H:i', $bh->end_time)->format('h:i A') : '--' }}
                                            </span>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="contact-map d-flex">
                                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3193.7301009561315!2d-76.13077892422932!3d36.82498697224007!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89bae976cfe9f8af%3A0xa61eac05156fbdb9!2sBeachStreet%20USA!5e0!3m2!1sen!2sin!4v1669777904208!5m2!1sen!2sin"
                                        allowfullscreen="" loading="lazy"
                                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif

                <!-- Memberships -->
                @if ($doctor->memberships->count())
                <div class="doc-information-details" id="membership">
                    <div class="detail-title">
                        <h4>Membership</h4>
                    </div>
                    @foreach ($doctor->memberships as $membership)
                    <div class="member-ship-info {{ $loop->last ? 'mb-0' : '' }}">
                        <span class="mem-check"><i class="fa-solid fa-check"></i></span>
                        <p>
                            <strong>{{ $membership->title }}</strong>
                            @if ($membership->about)
                                — {{ $membership->about }}
                            @endif
                        </p>
                    </div>
                    @endforeach
                </div>
                @endif

                <!-- Business Hours -->
                <div class="doc-information-details" id="bussiness_hour">
                    <div class="detail-title">
                        <h4>Business Hours</h4>
                    </div>
                    <div class="hours-business">
                        <ul>
                            {{-- Today row --}}
                            <li>
                                <div class="today-hours">
                                    <h6>Today</h6>
                                    <span>{{ now()->format('d M Y') }}</span>
                                </div>
                                <div class="availed">
                                    @if ($todayHours && $todayHours->is_open)
                                        <span class="badge doc-avail-badge">
                                            <i class="fa-solid fa-circle"></i>Available
                                        </span>
                                        <p>
                                            {{ \Carbon\Carbon::createFromFormat('H:i', $todayHours->start_time)->format('h:i A') }}
                                            -
                                            {{ \Carbon\Carbon::createFromFormat('H:i', $todayHours->end_time)->format('h:i A') }}
                                        </p>
                                    @else
                                        <span class="badge bg-danger-light">
                                            <i class="fa-solid fa-circle"></i>Closed
                                        </span>
                                    @endif
                                </div>
                            </li>

                            {{-- All 7 days --}}
                            @foreach ($days as $day)
                            @php $bh = $businessHours->get($day); @endphp
                            <li>
                                <h6>{{ ucfirst($day) }}</h6>
                                @if ($bh && $bh->is_open && $bh->start_time && $bh->end_time)
                                    <p>
                                        {{ \Carbon\Carbon::createFromFormat('H:i', $bh->start_time)->format('h:i A') }}
                                        -
                                        {{ \Carbon\Carbon::createFromFormat('H:i', $bh->end_time)->format('h:i A') }}
                                    </p>
                                @else
                                    <p class="text-muted">Closed</p>
                                @endif
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Review -->
                <div class="doc-information-details" id="review">
                    <div class="detail-title">
                        <h4>Reviews</h4>
                    </div>
                    <div class="doc-review-card">
                        <div class="user-info-review">
                            <div class="reviewer-img">
                                <a href="#" class="avatar-img">
                                    <img src="{{ asset('backend/assets/img/clients/client-13.jpg') }}" alt="Img">
                                </a>
                                <div class="review-star">
                                    <a href="#">Patient</a>
                                    <div class="rating">
                                        <i class="fas fa-star filled"></i>
                                        <i class="fas fa-star filled"></i>
                                        <i class="fas fa-star filled"></i>
                                        <i class="fas fa-star filled"></i>
                                        <i class="fas fa-star filled"></i>
                                        <span>5.0</span>
                                    </div>
                                </div>
                            </div>
                            <span class="thumb-icon">
                                <i class="fa-regular fa-thumbs-up"></i>Yes, Recommend for Appointment
                            </span>
                        </div>
                        <p>Reviews coming soon.</p>
                    </div>
                </div>

            </div>
        </div>
        <!-- /Detail Sections -->

    </div>
</div>
<!-- /Page Content -->

@endsection
