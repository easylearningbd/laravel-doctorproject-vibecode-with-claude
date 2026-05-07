@extends('patient.patient_master')
@section('patient')

<div class="col-lg-8 col-xl-9">

<div class="dashboard-header">
    <h3>Favourites</h3>
    <ul class="header-list-btns">
        <li>
            <div class="input-block dash-search-input">
                <input type="text" class="form-control" placeholder="Search">
                <span class="search-icon"><i class="isax isax-search-normal"></i></span>
            </div>
        </li>
    </ul>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Favourites -->
<div class="row" id="favouritesGrid">

    @forelse ($favourites as $doctor)
    @php
        $doctorName  = $doctor->display_name ?: 'Dr. ' . $doctor->first_name . ' ' . $doctor->last_name;
        $doctorPhoto = $doctor->profile_photo
            ? asset('storage/' . $doctor->profile_photo)
            : asset('assets/img/doctors/doctor-thumb-21.jpg');
        $speciality  = $doctor->specialization
            ?: ($doctor->specialityServices->first()?->speciality?->name ?? $doctor->designation ?? 'Doctor');
        $location    = collect([$doctor->city, $doctor->country])->filter()->implode(', ') ?: 'Location not set';

        // Next available day from business hours
        $nextAvailDay = $doctor->businessHours
            ->where('is_open', true)
            ->first()?->day_of_week;
        $nextAvailLabel = $nextAvailDay ? ucfirst($nextAvailDay) : 'Check schedule';
    @endphp

    <div class="col-md-6 col-lg-4 d-flex fav-card" id="fav-doctor-{{ $doctor->id }}">
        <div class="profile-widget patient-favour flex-fill">
            <div class="fav-head">
                {{-- Heart / Unfavourite button --}}
                <a href="javascript:void(0)"
                   class="fav-btn favourite-btn fav-toggle-btn"
                   data-doctor-id="{{ $doctor->id }}"
                   data-toggle-url="{{ route('favourite.toggle', $doctor->id) }}"
                   title="Remove from Favourites">
                    <span class="favourite-icon favourite">
                        <i class="isax isax-heart5"></i>
                    </span>
                </a>
                <div class="doc-img">
                    <a href="{{ route('doctor.details', $doctor->id) }}">
                        <img class="img-fluid" alt="{{ $doctorName }}" src="{{ $doctorPhoto }}">
                    </a>
                </div>
                <div class="pro-content">
                    <h3 class="title">
                        <a href="{{ route('doctor.details', $doctor->id) }}">{{ $doctorName }}</a>
                        <i class="isax isax-tick-circle5 verified"></i>
                    </h3>
                    <p class="speciality">{{ $speciality }}</p>
                    <div class="rating">
                        <i class="fas fa-star filled"></i>
                        <i class="fas fa-star filled"></i>
                        <i class="fas fa-star filled"></i>
                        <i class="fas fa-star filled"></i>
                        <i class="fas fa-star filled"></i>
                        <span class="d-inline-block average-rating">5.0</span>
                    </div>
                    <ul class="available-info">
                        <li>
                            <i class="isax isax-calendar5 me-1"></i>
                            <span>Next Availability :</span> {{ $nextAvailLabel }}
                        </li>
                        <li>
                            <i class="isax isax-location5 me-1"></i>
                            <span>Location :</span> {{ $location }}
                        </li>
                    </ul>
                </div>
            </div>
            <div class="fav-footer">
                <div class="row row-sm">
                    <div class="col-6">
                        <a href="{{ route('doctor.details', $doctor->id) }}"
                           class="btn btn-md btn-light w-100">View Details</a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('doctor.booking', $doctor->id) }}"
                           class="btn btn-md btn-outline-primary w-100">Book Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5" id="emptyFavourites">
        <i class="isax isax-heart5 fs-1 text-muted mb-3 d-block"></i>
        <h5 class="text-muted">No favourite doctors yet.</h5>
        <a href="{{ route('home') }}" class="btn btn-primary mt-2">Browse Doctors</a>
    </div>
    @endforelse

</div>
<!-- /Favourites -->

</div>

<script>
$(function () {
    $(document).on('click', '.fav-toggle-btn', function () {
        const btn      = $(this);
        const doctorId = btn.data('doctor-id');
        const url      = btn.data('toggle-url');
        const card     = $('#fav-doctor-' + doctorId);

        $.ajax({
            url   : url,
            method: 'POST',
            data  : { _token: '{{ csrf_token() }}' },
            success: function (resp) {
                if (!resp.favourited) {
                    // Removed — animate card out
                    card.fadeOut(400, function () {
                        card.remove();
                        // Show empty state if no cards left
                        if ($('#favouritesGrid .fav-card').length === 0) {
                            $('#favouritesGrid').html(`
                                <div class="col-12 text-center py-5">
                                    <i class="isax isax-heart5 fs-1 text-muted mb-3 d-block"></i>
                                    <h5 class="text-muted">No favourite doctors yet.</h5>
                                    <a href="{{ route('home') }}" class="btn btn-primary mt-2">Browse Doctors</a>
                                </div>`);
                        }
                    });
                }
            },
            error: function (xhr) {
                if (xhr.status === 401) {
                    window.location.href = '{{ route('login') }}';
                }
            }
        });
    });
});
</script>

@endsection
