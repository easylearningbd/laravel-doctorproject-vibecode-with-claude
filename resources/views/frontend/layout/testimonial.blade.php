@php
    use App\Models\Testimonial;
    $siteTestimonials = Testimonial::where('is_active', true)
        ->orderBy('sort_order')
        ->orderBy('id')
        ->get();
@endphp
<section class="testimonial-section-one">
<div class="container">
    <div class="section-header sec-header-one text-center aos" data-aos="fade-up">
        <span class="badge badge-primary">Testimonials</span>
        <h2>15k Users Trust Doccure Worldwide</h2>
    </div>

    <!-- Testimonial Slider -->
    <div class="owl-carousel testimonials-slider aos" data-aos="fade-up">
        @forelse($siteTestimonials as $t)
        <div class="card shadow-none mb-0">
            <div class="card-body">
                <div class="d-flex align-items-center mb-4">
                    <div class="rating d-flex">
                        @for($s = 1; $s <= 5; $s++)
                            <i class="fa-solid fa-star {{ $s <= $t->rating ? 'filled' : '' }} me-1"></i>
                        @endfor
                    </div>
                    <span>
                        <img src="{{ asset('backend/assets/img/icons/quote-icon.svg') }}" alt="img">
                    </span>
                </div>
                <h6 class="fs-16 fw-medium mb-2">{{ $t->title }}</h6>
                <p>{{ $t->content }}</p>
                <div class="d-flex align-items-center">
                    <a href="javascript:void(0);" class="avatar avatar-lg">
                        @if($t->photo)
                            <img src="{{ asset('storage/' . $t->photo) }}"
                                 class="rounded-circle"
                                 style="width:54px;height:54px;object-fit:cover;"
                                 alt="{{ $t->author_name }}">
                        @else
                            <img src="{{ asset('backend/assets/img/patients/patient22.jpg') }}"
                                 class="rounded-circle"
                                 alt="{{ $t->author_name }}">
                        @endif
                    </a>
                    <div class="ms-2">
                        <h6 class="mb-1"><a href="javascript:void(0);">{{ $t->author_name }}</a></h6>
                        <p class="fs-14 mb-0">{{ $t->author_location }}</p>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="card shadow-none mb-0">
            <div class="card-body">
                <div class="d-flex align-items-center mb-4">
                    <div class="rating d-flex">
                        <i class="fa-solid fa-star filled me-1"></i>
                        <i class="fa-solid fa-star filled me-1"></i>
                        <i class="fa-solid fa-star filled me-1"></i>
                        <i class="fa-solid fa-star filled me-1"></i>
                        <i class="fa-solid fa-star filled"></i>
                    </div>
                    <span>
                        <img src="{{ asset('backend/assets/img/icons/quote-icon.svg') }}" alt="img">
                    </span>
                </div>
                <h6 class="fs-16 fw-medium mb-2">Nice Treatment</h6>
                <p>I had a wonderful experience the staff was friendly and attentive, and Dr. Smith took the time to explain everything clearly.</p>
                <div class="d-flex align-items-center">
                    <a href="javascript:void(0);" class="avatar avatar-lg">
                        <img src="{{ asset('backend/assets/img/patients/patient22.jpg') }}" class="rounded-circle" alt="img">
                    </a>
                    <div class="ms-2">
                        <h6 class="mb-1"><a href="javascript:void(0);">Deny Hendrawan</a></h6>
                        <p class="fs-14 mb-0">United States</p>
                    </div>
                </div>
            </div>
        </div>
        @endforelse
    </div>
    <!-- /Testimonial Slider -->

    <!-- Counter -->
    <div class="testimonial-counter">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 row-gap-4">
            <div class="counter-item text-center aos" data-aos="fade-up">
                <h6 class="display-6"><span class="count-digit">500</span>+</h6>
                <p>Doctors Available</p>
            </div>
            <div class="counter-item text-center aos" data-aos="fade-up"">
                <h6 class="display-6 secondary-count"><span class="count-digit">18</span>+</h6>
                <p>Specialities</p>
            </div>
            <div class="counter-item text-center aos" data-aos="fade-up">
                <h6 class="display-6 purple-count"><span class="count-digit">30</span>K</h6>
                <p>Bookings Done</p>
            </div>
            <div class="counter-item text-center aos" data-aos="fade-up">
                <h6 class="display-6 pink-count"><span class="count-digit">97</span>+</h6>
                <p>Hospitals & Clinic</p>
            </div>
            <div class="counter-item text-center  aos" data-aos="fade-up">
                <h6 class="display-6 warning-count"><span class="count-digit">317</span>+</h6>
                <p>Lab Tests Available</p>
            </div>
        </div>
    </div>
    <!-- /Counter -->

</div>
</section>
