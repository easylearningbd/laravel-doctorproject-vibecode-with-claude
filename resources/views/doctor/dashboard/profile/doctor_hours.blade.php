@extends('doctor.doctor_master')
@section('doctor')

@php
    $days = [
        'monday'    => 'Monday',
        'tuesday'   => 'Tuesday',
        'wednesday' => 'Wednesday',
        'thursday'  => 'Thursday',
        'friday'    => 'Friday',
        'saturday'  => 'Saturday',
        'sunday'    => 'Sunday',
    ];

    // Default open Mon–Fri if doctor hasn't saved yet
    $defaultOpen = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'];
@endphp

<!-- Profile Settings -->
<div class="dashboard-header">
    <h3>Profile Settings</h3>
</div>

<!-- Settings List -->
<div class="setting-tab">
    <div class="appointment-tabs">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('doctor.profile') }}">Basic Details</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('doctor.experience') }}">Experience</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('doctor.education') }}">Education</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('doctor.clinics') }}">Clinics</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="{{ route('doctor.hours') }}">Business Hours</a>
            </li>
        </ul>
    </div>
</div>
<!-- /Settings List -->

<div class="dashboard-header border-0 mb-0">
    <h3>Business Hours</h3>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<form action="{{ route('doctor.hours.post') }}" method="POST" id="hoursForm">
    @csrf

    {{-- Hidden is_open inputs — updated by JS on submit --}}
    @foreach ($days as $dayKey => $dayLabel)
        @php
            $record = $hours->get($dayKey);
            $isOpen = $record ? $record->is_open : in_array($dayKey, $defaultOpen);
        @endphp
        <input type="hidden"
               name="hours[{{ $dayKey }}][is_open]"
               id="isOpen_{{ $dayKey }}"
               value="{{ $isOpen ? '1' : '0' }}">
    @endforeach

    <div class="business-wrap">
        <h4>Select Business Days</h4>
        <ul class="business-nav">
            @foreach ($days as $dayKey => $dayLabel)
                @php
                    $record = $hours->get($dayKey);
                    $isOpen = $record ? $record->is_open : in_array($dayKey, $defaultOpen);
                @endphp
                <li>
                    <a class="tab-link {{ $isOpen ? 'active' : '' }}"
                       data-tab="day-{{ $dayKey }}"
                       data-day="{{ $dayKey }}"
                       href="javascript:void(0);">
                        {{ $dayLabel }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="accordions business-info" id="list-accord">

        @foreach ($days as $dayKey => $dayLabel)
            @php
                $record     = $hours->get($dayKey);
                $isOpen     = $record ? $record->is_open : in_array($dayKey, $defaultOpen);
                $startTime  = old("hours.$dayKey.start_time", $record?->start_time ?? '');
                $endTime    = old("hours.$dayKey.end_time",   $record?->end_time   ?? '');
            @endphp

            <div class="user-accordion-item tab-items {{ $isOpen ? 'active' : '' }}"
                 id="day-{{ $dayKey }}">
                <a href="#"
                   class="accordion-wrap {{ $isOpen ? '' : 'collapsed' }}"
                   data-bs-toggle="collapse"
                   data-bs-target="#collapse_{{ $dayKey }}">
                    {{ $dayLabel }}<span class="edit">Edit</span>
                </a>
                <div class="accordion-collapse collapse {{ $isOpen ? 'show' : '' }}"
                     id="collapse_{{ $dayKey }}">
                    <div class="content-collapse pb-0">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <div class="form-wrap">
                                    <label class="col-form-label">From <span class="text-danger">*</span></label>
                                    <div class="form-icon">
                                        <input type="time"
                                               class="form-control"
                                               name="hours[{{ $dayKey }}][start_time]"
                                               value="{{ $startTime }}">
                                        <span class="icon"><i class="fa-solid fa-clock"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-wrap">
                                    <label class="col-form-label">To <span class="text-danger">*</span></label>
                                    <div class="form-icon">
                                        <input type="time"
                                               class="form-control"
                                               name="hours[{{ $dayKey }}][end_time]"
                                               value="{{ $endTime }}">
                                        <span class="icon"><i class="fa-solid fa-clock"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @endforeach

    </div>

    <div class="modal-btn text-end mt-3">
        <a href="{{ route('doctor.hours') }}" class="btn btn-gray">Cancel</a>
        <button type="submit" class="btn btn-primary prime-btn">Save Changes</button>
    </div>

</form>
<!-- /Profile Settings -->


<script>
(function () {
    // On form submit: read current active state of each tab and update hidden is_open inputs.
    // script.js already handles the visual toggle; we just sync the values at submit time.
    document.getElementById('hoursForm').addEventListener('submit', function () {
        document.querySelectorAll('.tab-link[data-day]').forEach(function (tab) {
            const day   = tab.getAttribute('data-day');
            const input = document.getElementById('isOpen_' + day);
            if (input) {
                input.value = tab.classList.contains('active') ? '1' : '0';
            }
        });
    });
})();
</script>

@endsection
