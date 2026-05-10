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
                        <h4>Reviews
                            @if($reviewCount > 0)
                                <small class="text-muted fs-14 fw-normal ms-2">({{ $reviewCount }} review{{ $reviewCount != 1 ? 's' : '' }})</small>
                            @endif
                        </h4>
                    </div>

                    {{-- Overall rating summary --}}
                    @if($reviewCount > 0)
                    <div class="doc-review-card mb-3">
                        <div class="d-flex align-items-center gap-4 flex-wrap">
                            <div class="text-center">
                                <h1 class="mb-0 fw-bold text-orange">{{ number_format($avgRating, 1) }}</h1>
                                <div class="rating">
                                    @for($s = 1; $s <= 5; $s++)
                                        <i class="fas fa-star {{ $s <= round($avgRating) ? 'filled' : '' }}"></i>
                                    @endfor
                                </div>
                                <p class="text-muted mb-0 fs-13">{{ $reviewCount }} review{{ $reviewCount != 1 ? 's' : '' }}</p>
                            </div>
                            <div class="flex-fill" style="max-width:340px;">
                                @foreach($ratingBreakdown as $stars => $data)
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <span class="fs-13 text-nowrap">{{ $stars }} <i class="fas fa-star text-warning fs-11"></i></span>
                                    <div class="progress flex-fill" style="height:8px;">
                                        <div class="progress-bar bg-warning" style="width:{{ $data['percent'] }}%"></div>
                                    </div>
                                    <span class="fs-13 text-muted" style="min-width:28px;">{{ $data['count'] }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- Individual reviews --}}
                    @forelse($reviews as $review)
                    @php
                        $rPhoto = $review->patient?->profile_photo
                            ? asset('storage/' . $review->patient->profile_photo)
                            : asset('backend/assets/img/doctors-dashboard/profile-01.jpg');
                        $rName = trim(($review->patient?->first_name ?? '') . ' ' . ($review->patient?->last_name ?? '')) ?: 'Patient';
                    @endphp
                    <div class="doc-review-card">
                        <div class="user-info-review">
                            <div class="reviewer-img">
                                <a href="#" class="avatar-img">
                                    <img src="{{ $rPhoto }}" alt="{{ $rName }}">
                                </a>
                                <div class="review-star">
                                    <a href="#">{{ $rName }}</a>
                                    <div class="rating">
                                        @for($s = 1; $s <= 5; $s++)
                                            <i class="fas fa-star {{ $s <= $review->rating ? 'filled' : '' }}"></i>
                                        @endfor
                                        <span>{{ number_format($review->rating, 1) }}</span>
                                    </div>
                                    <small class="text-muted fs-12">{{ $review->created_at->format('d M Y') }}</small>
                                </div>
                            </div>
                            @if($review->recommend)
                            <span class="thumb-icon">
                                <i class="fa-regular fa-thumbs-up"></i>Yes, Recommend for Appointment
                            </span>
                            @endif
                        </div>
                        @if($review->comment)
                        <p class="mt-2 mb-0">{{ $review->comment }}</p>
                        @endif
                    </div>
                    @empty
                    <div class="doc-review-card text-center py-3">
                        <p class="text-muted mb-0">No reviews yet. Be the first to review!</p>
                    </div>
                    @endforelse

                    {{-- Pagination --}}
                    @if($reviews->hasPages())
                    <div class="mt-3">{{ $reviews->links() }}</div>
                    @endif

                    {{-- ── Write a Review ──────────────────────────────────── --}}
                    <div class="write-review mt-4">
                        <h5 class="mb-3">Write a Review</h5>

                        @if(session('review_success'))
                            <div class="alert alert-success alert-dismissible fade show">
                                {{ session('review_success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif
                        @if(session('review_error'))
                            <div class="alert alert-danger alert-dismissible fade show">
                                {{ session('review_error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @auth
                            @if(auth()->user()->role === 'patient')
                                @if($hasReviewed)
                                    <div class="alert alert-info">
                                        <i class="fa-solid fa-circle-check me-2"></i>
                                        You have already submitted a review for this doctor. Thank you!
                                    </div>
                                @elseif($notMet)
                                    <div class="alert alert-warning">
                                        <i class="fa-solid fa-triangle-exclamation me-2"></i>
                                        You didn't meet with this doctor yet. Only patients who have completed an appointment can leave a review.
                                    </div>
                                @elseif($canReview)
                                <form action="{{ route('doctor.review.store', $doctor->id) }}" method="POST" id="reviewForm">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label fw-medium">Your Rating <span class="text-danger">*</span></label>
                                        <div class="star-rating d-flex gap-2" id="starRating">
                                            @for($s = 1; $s <= 5; $s++)
                                            <i class="fas fa-star review-star-btn" data-value="{{ $s }}"
                                               style="font-size:2rem;cursor:pointer;color:#ddd;transition:color .15s;"></i>
                                            @endfor
                                        </div>
                                        <input type="hidden" name="rating" id="ratingInput" value="">
                                        @error('rating')<small class="text-danger">{{ $message }}</small>@enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-medium">Your Review</label>
                                        <textarea name="comment" class="form-control" rows="4"
                                                  placeholder="Share your experience with this doctor...">{{ old('comment') }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="recommend"
                                                   value="1" id="recommendCheck" checked>
                                            <label class="form-check-label" for="recommendCheck">
                                                <i class="fa-regular fa-thumbs-up me-1"></i>
                                                I recommend this doctor
                                            </label>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary rounded-pill px-4"
                                            id="submitReviewBtn" disabled>
                                        Submit Review
                                    </button>
                                    <small class="text-muted ms-2">Please select a star rating first.</small>
                                </form>
                                @endif
                            @else
                                <div class="alert alert-info">
                                    <i class="isax isax-info-circle me-2"></i>
                                    Only patients can write reviews. Please log in as a patient.
                                </div>
                            @endif
                        @else
                            <div class="alert alert-info">
                                <i class="isax isax-login me-2"></i>
                                <a href="{{ route('login') }}">Log in</a> to write a review for this doctor.
                            </div>
                        @endauth
                    </div>
                    {{-- /Write a Review --}}

                </div>
                {{-- /Review --}}

            </div>
        </div>
        <!-- /Detail Sections -->

    </div>
</div>
<!-- /Page Content -->

@endsection

@push('scripts')
<script>
$(function () {
    var selected = 0;

    // Hover — highlight up to hovered star
    $(document).on('mouseenter', '.review-star-btn', function () {
        var val = $(this).data('value');
        $('.review-star-btn').each(function () {
            $(this).css('color', $(this).data('value') <= val ? '#f4c150' : '#ddd');
        });
    });

    // Mouse leave — restore to selected state
    $(document).on('mouseleave', '#starRating', function () {
        $('.review-star-btn').each(function () {
            $(this).css('color', $(this).data('value') <= selected ? '#f4c150' : '#ddd');
        });
    });

    // Click — lock selection
    $(document).on('click', '.review-star-btn', function () {
        selected = $(this).data('value');
        $('#ratingInput').val(selected);
        $('#submitReviewBtn').prop('disabled', false).siblings('small').hide();
        $('.review-star-btn').each(function () {
            $(this).css('color', $(this).data('value') <= selected ? '#f4c150' : '#ddd');
        });
    });
});
</script>
@endpush
