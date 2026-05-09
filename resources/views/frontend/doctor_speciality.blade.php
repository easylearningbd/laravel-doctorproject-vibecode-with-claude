@extends('frontend.home_master')
@section('home')

{{-- Breadcrumb --}}
<div class="breadcrumb-bar overflow-visible">
    <div class="container">
        <div class="row align-items-center inner-banner">
            <div class="col-md-12 col-12 text-center">
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}"><i class="isax isax-home-15"></i></a>
                        </li>
                        <li class="breadcrumb-item">Speciality</li>
                        <li class="breadcrumb-item active">{{ $speciality->name }}</li>
                    </ol>
                    <h2 class="breadcrumb-title">{{ $speciality->name }} Doctors</h2>
                </nav>
            </div>
        </div>
    </div>
    <div class="breadcrumb-bg">
        <img src="{{ asset('backend/assets/img/bg/breadcrumb-bg-01.png') }}" alt="img" class="breadcrumb-bg-01">
        <img src="{{ asset('backend/assets/img/bg/breadcrumb-bg-02.png') }}" alt="img" class="breadcrumb-bg-02">
        <img src="{{ asset('backend/assets/img/bg/breadcrumb-bg-03.png') }}" alt="img" class="breadcrumb-bg-03">
    </div>
</div>
{{-- /Breadcrumb --}}

<div class="content mt-5">
<div class="container">

{{-- Filter form wraps everything so sidebar + sort all submit together --}}
<form method="GET" action="{{ route('doctor.all.speciality', $id) }}" id="filterForm">
<div class="row">

    {{-- ── LEFT SIDEBAR FILTERS ────────────────────────────────── --}}
    <div class="col-xl-3">
        <div class="card filter-lists">
            <div class="card-header">
                <div class="d-flex align-items-center filter-head justify-content-between">
                    <h4>Filter</h4>
                    <a href="{{ route('doctor.all.speciality', $id) }}"
                       class="text-secondary text-decoration-underline">Clear All</a>
                </div>
            </div>
            <div class="card-body p-0">

                {{-- Specialities --}}
                <div class="accordion-item border-bottom">
                    <div class="accordion-header">
                        <div class="accordion-button" data-bs-toggle="collapse"
                             data-bs-target="#colSpeciality" role="button">
                            <div class="d-flex align-items-center w-100">
                                <h5>Specialities</h5>
                                <div class="ms-auto"><span><i class="fas fa-chevron-down"></i></span></div>
                            </div>
                        </div>
                    </div>
                    <div id="colSpeciality" class="accordion-collapse show">
                        <div class="accordion-body pt-3">
                            @foreach ($allSpecialities as $sp)
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <div class="form-check">
                                    <input class="form-check-input filter-trigger"
                                           type="checkbox"
                                           name="specialities[]"
                                           value="{{ $sp->id }}"
                                           id="sp_{{ $sp->id }}"
                                           {{ in_array($sp->id, $checkedIds) ? 'checked' : '' }}
                                           {{ $sp->id == $id ? 'disabled checked' : '' }}>
                                    <label class="form-check-label" for="sp_{{ $sp->id }}">
                                        {{ $sp->name }}
                                    </label>
                                </div>
                                <span class="filter-badge">{{ $sp->doctor_count }}</span>
                            </div>
                            @endforeach
                            {{-- Keep current speciality in query even when its checkbox is disabled --}}
                            <input type="hidden" name="specialities[]" value="{{ $id }}">
                        </div>
                    </div>
                </div>

                {{-- Availability --}}
                <div class="accordion-item border-bottom">
                    <div class="accordion-header">
                        <div class="accordion-button" data-bs-toggle="collapse"
                             data-bs-target="#colAvail" role="button">
                            <div class="d-flex align-items-center w-100">
                                <h5>Availability</h5>
                                <div class="ms-auto"><span><i class="fas fa-chevron-down"></i></span></div>
                            </div>
                        </div>
                    </div>
                    <div id="colAvail" class="accordion-collapse show">
                        <div class="accordion-body pt-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="status-toggle status-tog">
                                    <input type="checkbox" id="availToggle"
                                           name="available" value="1"
                                           class="check filter-trigger"
                                           {{ request()->boolean('available') ? 'checked' : '' }}>
                                    <label for="availToggle" class="checktoggle">checkbox</label>
                                </div>
                                <label for="availToggle" class="mb-0">Available Today</label>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Experience --}}
                <div class="accordion-item border-bottom">
                    <div class="accordion-header">
                        <div class="accordion-button" data-bs-toggle="collapse"
                             data-bs-target="#colExp" role="button">
                            <div class="d-flex align-items-center w-100">
                                <h5>Experience</h5>
                                <div class="ms-auto"><span><i class="fas fa-chevron-down"></i></span></div>
                            </div>
                        </div>
                    </div>
                    <div id="colExp" class="accordion-collapse show">
                        <div class="accordion-body pt-3">
                            @foreach ([0 => 'Any Experience', 2 => '2+ Years', 5 => '5+ Years', 7 => '7+ Years', 10 => '10+ Years'] as $val => $label)
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <div class="form-check">
                                    <input class="form-check-input filter-trigger"
                                           type="radio" name="experience"
                                           value="{{ $val }}" id="exp_{{ $val }}"
                                           {{ (string)request('experience', '0') === (string)$val ? 'checked' : '' }}>
                                    <label class="form-check-label" for="exp_{{ $val }}">
                                        {{ $label }}
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>{{-- /card-body --}}
        </div>{{-- /card --}}
    </div>
    {{-- /LEFT SIDEBAR --}}

    {{-- ── DOCTOR LISTING ──────────────────────────────────────── --}}
    <div class="col-xl-9">

        {{-- Results header + sort --}}
        <div class="row align-items-center mb-4">
            <div class="col-md-6">
                <h3>Showing
                    <span class="text-secondary">{{ $doctors->total() }}</span>
                    Doctor{{ $doctors->total() != 1 ? 's' : '' }}
                    for <em>{{ $speciality->name }}</em>
                </h3>
            </div>
            <div class="col-md-6">
                <div class="d-flex align-items-center justify-content-end gap-2">
                    <div class="dropdown header-dropdown">
                        <a class="dropdown-toggle sort-dropdown" data-bs-toggle="dropdown" href="javascript:void(0);">
                            <span>Sort By </span>
                            {{ $sort === 'price_desc' ? 'Price (High to Low)' : 'Price (Low to High)' }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="javascript:void(0);" class="dropdown-item sort-option"
                               data-value="price_asc">Price (Low to High)</a>
                            <a href="javascript:void(0);" class="dropdown-item sort-option"
                               data-value="price_desc">Price (High to Low)</a>
                        </div>
                    </div>
                    <input type="hidden" name="sort" id="sortInput" value="{{ $sort }}">
                </div>
            </div>
        </div>

        {{-- Doctor cards --}}
        <div class="row">
        @forelse ($doctors as $doctor)
        @php
            $photo = $doctor->profile_photo
                ? asset('storage/' . $doctor->profile_photo)
                : asset('backend/assets/img/doctor-grid/doctor-grid-01.jpg');
            $location = collect([$doctor->city, $doctor->country])->filter()->implode(', ') ?: $doctor->designation;
        @endphp
        <div class="col-xxl-4 col-md-6 d-flex">
            <div class="card flex-fill">
                <div class="card-img card-img-hover">
                    <a href="{{ route('doctor.details', $doctor->id) }}">
                        <img src="{{ $photo }}" alt="{{ $doctor->first_name }} {{ $doctor->last_name }}">
                    </a>
                    <div class="grid-overlay-item d-flex align-items-center justify-content-between">
                        <span class="badge bg-orange"><i class="fa-solid fa-star me-1"></i>5.0</span>
                        <a href="javascript:void(0)"
                           class="fav-icon fav-toggle-btn {{ in_array($doctor->id, $favouriteIds) ? 'fav-active' : '' }}"
                           data-toggle-url="{{ route('favourite.toggle', $doctor->id) }}"
                           style="{{ in_array($doctor->id, $favouriteIds) ? 'color:#e02020;' : '' }}"
                           title="{{ in_array($doctor->id, $favouriteIds) ? 'Remove from Favourites' : 'Add to Favourites' }}">
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
                                <i class="fa-solid fa-circle fs-5 me-1"></i>Available
                            </span>
                        @else
                            <span class="badge bg-danger-light d-inline-flex align-items-center">
                                <i class="fa-solid fa-circle fs-5 me-1"></i>Unavailable
                            </span>
                        @endif
                    </div>
                    <div class="p-3 pt-0">
                        <div class="doctor-info-detail mb-3 pb-3">
                            <h3 class="mb-1">
                                <a href="{{ route('doctor.details', $doctor->id) }}">
                                    {{ $doctor->display_name ?: 'Dr. ' . $doctor->first_name . ' ' . $doctor->last_name }}
                                </a>
                            </h3>
                            <div class="d-flex align-items-center">
                                <p class="d-flex align-items-center mb-0 fs-14">
                                    <i class="isax isax-location me-2"></i>
                                    {{ $location }}
                                </p>
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
                            <a href="{{ route('doctor.booking', $doctor->id) }}"
                               class="btn btn-md btn-dark d-inline-flex align-items-center rounded-pill">
                                <i class="isax isax-calendar-1 me-2"></i>Book Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <i class="isax isax-stethoscope fs-1 text-muted mb-3 d-block"></i>
            <h5 class="text-muted">No doctors found for the selected filters.</h5>
            <a href="{{ route('doctor.all.speciality', $id) }}"
               class="btn btn-primary rounded-pill mt-2">Clear Filters</a>
        </div>
        @endforelse
        </div>{{-- /row --}}

        {{-- Pagination --}}
        @if ($doctors->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $doctors->links() }}
        </div>
        @endif

    </div>
    {{-- /DOCTOR LISTING --}}

</div>{{-- /row --}}
</form>

</div>{{-- /container --}}
</div>{{-- /content --}}

@endsection

@push('scripts')
<script>
$(function () {
    // Any filter checkbox/radio change → auto-submit
    $(document).on('change', '.filter-trigger', function () {
        $('#filterForm').submit();
    });

    // Sort dropdown
    $(document).on('click', '.sort-option', function (e) {
        e.preventDefault();
        $('#sortInput').val($(this).data('value'));
        $('#filterForm').submit();
    });
});
</script>
@endpush
