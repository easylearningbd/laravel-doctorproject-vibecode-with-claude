<section class="doctor-section">
<div class="container">
    <div class="section-header sec-header-one text-center aos" data-aos="fade-up">
        <span class="badge badge-primary">Featured Doctors</span>
        <h2>Our Highlighted Doctors</h2>
    </div>
 
    <div class="doctors-slider owl-carousel aos" data-aos="fade-up">

        @forelse ($doctors as $doctor)
        <div class="card">
            <div class="card-img card-img-hover">
                <a href="#">
                    @if ($doctor->profile_photo)
                        <img src="{{ asset('storage/' . $doctor->profile_photo) }}"
                             alt="{{ $doctor->first_name }} {{ $doctor->last_name }}">
                    @else
                        <img src="{{ asset('assets/img/doctor-grid/doctor-grid-01.jpg') }}"
                             alt="{{ $doctor->first_name }} {{ $doctor->last_name }}">
                    @endif
                </a>
                <div class="grid-overlay-item d-flex align-items-center justify-content-between">
                    <span class="badge bg-orange"><i class="fa-solid fa-star me-1"></i>5.0</span>
                    <a href="javascript:void(0)"
                       class="fav-icon fav-toggle-btn {{ in_array($doctor->id, $favouriteIds ?? []) ? 'fav-active' : '' }}"
                       data-doctor-id="{{ $doctor->id }}"
                       data-toggle-url="{{ route('favourite.toggle', $doctor->id) }}"
                       title="{{ in_array($doctor->id, $favouriteIds ?? []) ? 'Remove from Favourites' : 'Add to Favourites' }}"
                       style="{{ in_array($doctor->id, $favouriteIds ?? []) ? 'color:#e02020;' : '' }}">
                        <i class="fa fa-heart"></i>
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="d-flex active-bar align-items-center justify-content-between p-3">
                    <a href="#" class="text-indigo fw-medium fs-14">
                        {{ $doctor->display_speciality }}
                    </a>
                    @if ($doctor->is_available)
                        <span class="badge bg-success-light d-inline-flex align-items-center">
                            <i class="fa-solid fa-circle fs-5 me-1"></i>
                            Available
                        </span>
                    @else
                        <span class="badge bg-danger-light d-inline-flex align-items-center">
                            <i class="fa-solid fa-circle fs-5 me-1"></i>
                            Unavailable
                        </span>
                    @endif
                </div>
                <div class="p-3 pt-0">
                    <div class="doctor-info-detail mb-3 pb-3">
                        <h3 class="mb-1">
                            <a href="{{ route('doctor.details',$doctor->id) }}">
                                {{ $doctor->display_name ?: 'Dr. ' . $doctor->first_name . ' ' . $doctor->last_name }}
                            </a>
                        </h3>
                        <div class="d-flex align-items-center">
                            @if ($doctor->city || $doctor->country)
                                <p class="d-flex align-items-center mb-0 fs-14">
                                    <i class="isax isax-location me-2"></i>
                                    {{ collect([$doctor->city, $doctor->country])->filter()->implode(', ') }}
                                </p>
                            @else
                                <p class="d-flex align-items-center mb-0 fs-14">
                                    <i class="isax isax-location me-2"></i>
                                    {{ $doctor->designation }}
                                </p>
                            @endif
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-1">Consultation Fees</p>
                            @if ($doctor->min_price)
                                <h3 class="text-orange">${{ number_format($doctor->min_price, 0) }}</h3>
                            @else
                                <h3 class="text-orange">N/A</h3>
                            @endif
                        </div>
                        <a href="{{ route('doctor.booking', $doctor->id) }}" class="btn btn-md btn-dark d-inline-flex align-items-center rounded-pill">
                            <i class="isax isax-calendar-1 me-2"></i>
                            Book Now
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-5">
            <p>No doctors available at the moment.</p>
        </div>
        @endforelse

    </div>
    <div class="doctor-nav nav-bottom owl-nav"></div>
</div>
</section>
