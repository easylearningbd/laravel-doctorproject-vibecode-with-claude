@php
    $badge           = \App\Models\SiteSetting::get('bookus_badge',            'Why Book With Us');
    $headingBefore   = \App\Models\SiteSetting::get('bookus_heading_before',   'We are committed to understanding your');
    $headingGradient = \App\Models\SiteSetting::get('bookus_heading_gradient', 'unique needs and delivering care.');
    $description     = \App\Models\SiteSetting::get('bookus_description',      'As a trusted healthcare provider in our community, we are passionate about promoting health and wellness beyond the clinic. We actively engage in community outreach programs, health fairs, and educational workshop.');
    $faq1Title       = \App\Models\SiteSetting::get('bookus_faq_1_title',      'Our Vision');
    $faq1Content     = \App\Models\SiteSetting::get('bookus_faq_1_content',    'We envision a community where everyone has access to high-quality healthcare and the resources they need to lead healthy, fulfilling lives.');
    $faq2Title       = \App\Models\SiteSetting::get('bookus_faq_2_title',      'Our Mission');
    $faq2Content     = \App\Models\SiteSetting::get('bookus_faq_2_content',    'We envision a community where everyone has access to high-quality healthcare and the resources they need to lead healthy, fulfilling lives.');
    $img1            = \App\Models\SiteSetting::get('bookus_image_1',          null);
    $img2            = \App\Models\SiteSetting::get('bookus_image_2',          null);
    $img3            = \App\Models\SiteSetting::get('bookus_image_3',          null);
@endphp

<section class="bookus-section bg-dark">
<div class="container">
    <div class="row align-items-center row-gap-4">

        {{-- ── Left: images ──────────────────────────────────── --}}
        <div class="col-lg-6">
            <div class="bookus-img">
                <div class="row g-3">
                    <div class="col-md-12 aos" data-aos="fade-up">
                        @if($img1 && \Illuminate\Support\Facades\Storage::disk('public')->exists($img1))
                            <img src="{{ asset('storage/' . $img1) }}"
                                 width="1060" height="516"
                                 alt="img" class="img-fluid" style="object-fit:cover;">
                        @else
                            <img src="{{ asset('backend/assets/img/book-01.jpg') }}"
                                 alt="img" class="img-fluid">
                        @endif
                    </div>
                    <div class="col-sm-6 aos" data-aos="fade-up">
                        @if($img2 && \Illuminate\Support\Facades\Storage::disk('public')->exists($img2))
                            <img src="{{ asset('storage/' . $img2) }}"
                                 width="512" height="516"
                                 alt="img" class="img-fluid" style="object-fit:cover;">
                        @else
                            <img src="{{ asset('backend/assets/img/book-02.jpg') }}"
                                 alt="img" class="img-fluid">
                        @endif
                    </div>
                    <div class="col-sm-6 aos" data-aos="fade-up">
                        @if($img3 && \Illuminate\Support\Facades\Storage::disk('public')->exists($img3))
                            <img src="{{ asset('storage/' . $img3) }}"
                                 width="512" height="516"
                                 alt="img" class="img-fluid" style="object-fit:cover;">
                        @else
                            <img src="{{ asset('backend/assets/img/book-03.jpg') }}"
                                 alt="img" class="img-fluid">
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Right: text + accordion ───────────────────────── --}}
        <div class="col-lg-6">
            <div class="section-header sec-header-one mb-2 aos" data-aos="fade-up">
                <span class="badge badge-primary">{{ $badge }}</span>
                <h2 class="text-white mb-3">
                    {{ $headingBefore }}
                    <span class="text-primary-gradient">{{ $headingGradient }}</span>
                </h2>
            </div>
            <p class="text-light mb-4">{{ $description }}</p>

            <div class="faq-info aos" data-aos="fade-up">
                <div class="accordion" id="faq-details">

                    <!-- FAQ Item 1 -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <a href="javascript:void(0);" class="accordion-button"
                               data-bs-toggle="collapse" data-bs-target="#collapseOne"
                               aria-expanded="true" aria-controls="collapseOne">
                                01 . {{ $faq1Title }}
                            </a>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show"
                             aria-labelledby="headingOne" data-bs-parent="#faq-details">
                            <div class="accordion-body">
                                <div class="accordion-content">
                                    <p>{{ $faq1Content }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Item 2 -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <a href="javascript:void(0);" class="accordion-button collapsed"
                               data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                               aria-controls="collapseTwo">
                                02 . {{ $faq2Title }}
                            </a>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse"
                             aria-labelledby="headingTwo" data-bs-parent="#faq-details">
                            <div class="accordion-body">
                                <div class="accordion-content">
                                    <p>{{ $faq2Content }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>

    {{-- ── Bottom steps (static — not managed) ──────────────── --}}
    <div class="bookus-sec">
        <div class="row g-4">
            <div class="col-lg-3">
                <div class="book-item">
                    <div class="book-icon bg-primary">
                        <i class="isax isax-search-normal5"></i>
                    </div>
                    <div class="book-info">
                        <h6 class="text-white mb-2">Search For Doctors</h6>
                        <p class="fs-14 text-light">Search for a doctor based on specialization, location, or availability for your Treatements</p>
                    </div>
                    <div class="way-icon">
                        <img src="{{ asset('backend/assets/img/icons/way-icon.svg') }}" alt="img">
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="book-item">
                    <div class="book-icon bg-orange">
                        <i class="isax isax-security-user5"></i>
                    </div>
                    <div class="book-info">
                        <h6 class="text-white mb-2">Check Doctor Profile</h6>
                        <p class="fs-14 text-light">Explore detailed doctor profiles on our platform to make informed healthcare decisions.</p>
                    </div>
                    <div class="way-icon">
                        <img src="{{ asset('backend/assets/img/icons/way-icon.svg') }}" alt="img">
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="book-item">
                    <div class="book-icon bg-cyan">
                        <i class="isax isax-calendar5"></i>
                    </div>
                    <div class="book-info">
                        <h6 class="text-white mb-2">Schedule Appointment</h6>
                        <p class="fs-14 text-light">After choose your preferred doctor, select a convenient time slot, & confirm your appointment.</p>
                    </div>
                    <div class="way-icon">
                        <img src="{{ asset('backend/assets/img/icons/way-icon.svg') }}" alt="img">
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="book-item">
                    <div class="book-icon bg-indigo">
                        <i class="isax isax-blend5"></i>
                    </div>
                    <div class="book-info">
                        <h6 class="text-white mb-2">Get Your Solution</h6>
                        <p class="fs-14 text-light">Discuss your health concerns with the doctor and receive the personalized advice & with solution.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
