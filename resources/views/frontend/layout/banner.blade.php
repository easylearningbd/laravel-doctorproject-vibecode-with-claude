@php
    $bannerBefore   = \App\Models\SiteSetting::get('banner_heading_before', 'Discover Health: Find Your Trusted');
    $bannerGradient = \App\Models\SiteSetting::get('banner_gradient_word',  'Doctors');
    $bannerAfter    = \App\Models\SiteSetting::get('banner_heading_after',  'Today');
    $bannerImage    = \App\Models\SiteSetting::get('banner_image',          null);
@endphp

<section class="banner-section banner-sec-one">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <div class="banner-content aos" data-aos="fade-up">
                    <div class="rating-appointment d-inline-flex align-items-center gap-2">
                        <div class="avatar-list-stacked avatar-group-lg">
                            <span class="avatar avatar-rounded">
                                <img class="border border-white" src="{{ asset('backend/assets/img/doctors/doctor-thumb-22.jpg') }}" alt="img">
                            </span>
                            <span class="avatar avatar-rounded">
                                <img class="border border-white" src="{{ asset('backend/assets/img/doctors/doctor-thumb-23.jpg') }}" alt="img">
                            </span>
                            <span class="avatar avatar-rounded">
                                <img src="{{ asset('backend/assets/img/doctors/doctor-thumb-24.jpg') }}" alt="img">
                            </span>
                        </div>
                        <div class="me-2">
                            <h6 class="mb-1">5K+ Appointments</h6>
                            <div class="d-flex align-items-center">
                                <div class="d-flex align-items-center">
                                    <i class="fa-solid fa-star text-orange me-1"></i>
                                    <i class="fa-solid fa-star text-orange me-1"></i>
                                    <i class="fa-solid fa-star text-orange me-1"></i>
                                    <i class="fa-solid fa-star text-orange me-1"></i>
                                    <i class="fa-solid fa-star text-orange me-1"></i>
                                </div>
                                <p>5.0 Ratings</p>
                            </div>
                        </div>
                    </div>

                    {{-- Dynamic heading — video.svg icon position is always fixed --}}
                    <h1 class="display-5">
                        {{ $bannerBefore }}
                        <span class="banner-icon">
                            <img src="{{ asset('backend/assets/img/icons/video.svg') }}" alt="img">
                        </span>
                        <span class="text-gradient">{{ $bannerGradient }}</span>
                        {{ $bannerAfter }}
                    </h1>

                    <div class="search-box-one aos" data-aos="fade-up">
                        <form action="search-2.html">
                            <div class="search-input search-line">
                                <i class="isax isax-hospital5 bficon"></i>
                                <div class="mb-0">
                                    <input type="text" class="form-control" placeholder="Search doctors, clinics, hospitals, etc">
                                </div>
                            </div>
                            <div class="search-input search-map-line">
                                <i class="isax isax-location5"></i>
                                <div class="mb-0">
                                    <input type="text" class="form-control" placeholder="Location">
                                </div>
                            </div>
                            <div class="search-input search-calendar-line">
                                <i class="isax isax-calendar-tick5"></i>
                                <div class="mb-0">
                                    <input type="text" class="form-control datetimepicker" placeholder="Date">
                                </div>
                            </div>
                            <div class="form-search-btn">
                                <button class="btn btn-primary" type="submit">
                                    <i class="isax isax-search-normal5 me-2"></i>Search
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="banner-img aos" data-aos="fade-up">
                    {{-- Dynamic banner image (464×606) or default SVG --}}
                    @if($bannerImage && \Illuminate\Support\Facades\Storage::disk('public')->exists($bannerImage))
                        <img src="{{ asset('storage/' . $bannerImage) }}"
                             width="464" height="606"
                             class="img-fluid" alt="patient-image"
                             style="object-fit:cover;">
                    @else
                        <img src="{{ asset('backend/assets/img/banner/banner-doctor.svg') }}"
                             width="464" height="606"
                             class="img-fluid" alt="patient-image">
                    @endif

                    <div class="banner-appointment">
                        <h6>1K</h6>
                        <p>Appointments <span class="d-block">Completed</span></p>
                    </div>
                    <div class="banner-patient">
                        <div class="avatar-list-stacked avatar-group-sm">
                            <span class="avatar avatar-rounded">
                                <img src="{{ asset('backend/assets/img/patients/patient19.jpg') }}" alt="img">
                            </span>
                            <span class="avatar avatar-rounded">
                                <img src="{{ asset('backend/assets/img/patients/patient16.jpg') }}" alt="img">
                            </span>
                            <span class="avatar avatar-rounded">
                                <img src="{{ asset('backend/assets/img/patients/patient18.jpg') }}" alt="img">
                            </span>
                        </div>
                        <p>15K+</p>
                        <p>Satisfied Patients</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="banner-bg">
        <img src="{{ asset('backend/assets/img/bg/banner-bg-02.png') }}" alt="img" class="banner-bg-01">
        <img src="{{ asset('backend/assets/img/bg/banner-bg-03.png') }}" alt="img" class="banner-bg-02">
        <img src="{{ asset('backend/assets/img/bg/banner-bg-04.png') }}" alt="img" class="banner-bg-03">
        <img src="{{ asset('backend/assets/img/bg/banner-bg-05.png') }}" alt="img" class="banner-bg-04">
        <img src="{{ asset('backend/assets/img/bg/banner-icon-01.svg') }}" alt="img" class="banner-bg-05">
        <img src="{{ asset('backend/assets/img/bg/banner-icon-01.svg') }}" alt="img" class="banner-bg-06">
    </div>
</section>
