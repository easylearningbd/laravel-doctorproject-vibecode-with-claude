<section class="speciality-section">
<div class="container">
    <div class="section-header sec-header-one text-center aos" data-aos="fade-up">
        <span class="badge badge-primary">Top Specialties</span>
        <h2>Highlighting the Care & Support</h2>
    </div>

    <div class="owl-carousel spciality-slider aos" data-aos="fade-up">

        @forelse ($specialities as $speciality) 
        <div class="spaciality-item">
        <div class="spaciality-img">
            <img src="{{ asset('backend/assets/img/specialities/speciality-01.jpg') }}" alt="img">
            <span class="spaciality-icon"> 
                @if ($speciality->image)
                    <img src="{{ asset('storage/' . $speciality->image) }}" alt="{{ $speciality->name }}" style="width: 45px;">
                @else
                    <img src="{{ asset('backend/assets/img/specialities/speciality-01.jpg') }}" alt="{{ $speciality->name }}">
                @endif
            </span>
        </div>
        <h6><a href="doctor-grid.html">{{ $speciality->name }}</a></h6>
        <p class="mb-0">{{ $speciality->doctor_count }}
                {{ $speciality->doctor_count == 1 ? 'Doctor' : 'Doctors' }}</p>
    </div>
 
        @empty
        <div class="spaciality-item text-center py-4">
            <p class="text-muted">No specialities available yet.</p>
        </div>
        @endforelse

    </div>
    <div class="spciality-nav nav-bottom owl-nav"></div>
</div>
</section>
