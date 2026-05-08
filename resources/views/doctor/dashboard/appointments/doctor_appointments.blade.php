@extends('doctor.doctor_master')
@section('doctor')

<div class="dashboard-header">
    <h3>Appointments</h3>
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
    <div class="alert alert-success alert-dismissible fade show mb-3">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div id="apptAlert" class="alert d-none mb-3"></div>

<div class="appointment-tab-head">
    <div class="appointment-tabs">
        <ul class="nav nav-pills inner-tab" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#pills-upcoming"
                        type="button">Upcoming<span>{{ $upcoming->total() }}</span></button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-cancel"
                        type="button">Cancelled<span>{{ $cancelled->total() }}</span></button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-complete"
                        type="button">Completed<span>{{ $completed->total() }}</span></button>
            </li>
        </ul>
    </div>
</div>

<div class="tab-content appointment-tab-content">

    {{-- ── UPCOMING (confirmed) ─────────────────────────────── --}}
    <div class="tab-pane fade show active" id="pills-upcoming" role="tabpanel">

        @forelse ($upcoming as $apt)
        @php
            $patient = $apt->patient;
            $photo   = $patient->profile_photo
                ? asset('storage/' . $patient->profile_photo)
                : asset('backend/assets/img/doctors-dashboard/profile-01.jpg');
        @endphp
        <div class="appointment-wrap" id="apt-row-{{ $apt->id }}">
            <ul>
                <li>
                    <div class="patinet-information">
                        <a href="{{ route('patient.details.page', $patient->id) }}">
                            <img src="{{ $photo }}" alt="{{ $patient->first_name }}">
                        </a>
                        <div class="patient-info">
                            <p>#{{ $apt->appointment_number }}</p>
                            <h6><a href="{{ route('patient.details.page', $patient->id) }}">{{ $patient->first_name }} {{ $patient->last_name }}</a></h6>
                        </div>
                    </div>
                </li>
                <li class="appointment-info">
                    <p><i class="isax isax-clock5"></i>{{ $apt->appointment_date->format('d M Y') }} {{ \Carbon\Carbon::createFromFormat('H:i', $apt->appointment_time)->format('h:i A') }}</p>
                    <ul class="d-flex apponitment-types">
                        <li>{{ $apt->reason_for_visit ?: 'General Visit' }}</li>
                        <li>{{ $apt->appointment_type ?? 'Direct Visit' }}</li>
                    </ul>
                </li>
                <li class="mail-info-patient">
                    <ul>
                        <li><i class="isax isax-sms5"></i>{{ $patient->email }}</li>
                        <li><i class="isax isax-call5"></i>{{ $patient->phone ?: 'N/A' }}</li>
                    </ul>
                </li>
                <li class="appointment-action">
                    <ul>
                        <li>
                            <a href="{{ route('patient.details.page', $patient->id) }}" title="View Patient">
                                <i class="isax isax-eye4"></i>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="appointment-start">
                    <a href="javascript:void(0)"
                       class="start-link start-now-btn"
                       data-id="{{ $apt->id }}"
                       data-url="{{ route('doctor.appointment.complete', $apt->id) }}">
                        Start Now
                    </a>
                </li>
            </ul>
        </div>
        @empty
        <div class="text-center py-5">
            <i class="isax isax-calendar5 fs-1 text-muted mb-3 d-block"></i>
            <p class="text-muted">No confirmed appointments at this time.</p>
        </div>
        @endforelse

        @if ($upcoming->hasPages())
        <div class="mt-3 d-flex justify-content-center">{{ $upcoming->links() }}</div>
        @endif
    </div>

    {{-- ── CANCELLED ────────────────────────────────────────── --}}
    <div class="tab-pane fade" id="pills-cancel" role="tabpanel">

        @forelse ($cancelled as $apt)
        @php
            $patient = $apt->patient;
            $photo   = $patient->profile_photo
                ? asset('storage/' . $patient->profile_photo)
                : asset('backend/assets/img/doctors-dashboard/profile-01.jpg');
        @endphp
        <div class="appointment-wrap">
            <ul>
                <li>
                    <div class="patinet-information">
                        <a href="{{ route('patient.details.page', $patient->id) }}">
                            <img src="{{ $photo }}" alt="{{ $patient->first_name }}">
                        </a>
                        <div class="patient-info">
                            <p>#{{ $apt->appointment_number }}</p>
                            <h6><a href="{{ route('patient.details.page', $patient->id) }}">{{ $patient->first_name }} {{ $patient->last_name }}</a></h6>
                        </div>
                    </div>
                </li>
                <li class="appointment-info">
                    <p><i class="isax isax-clock5"></i>{{ $apt->appointment_date->format('d M Y') }} {{ \Carbon\Carbon::createFromFormat('H:i', $apt->appointment_time)->format('h:i A') }}</p>
                    <ul class="d-flex apponitment-types">
                        <li>{{ $apt->reason_for_visit ?: 'General Visit' }}</li>
                        <li>{{ $apt->appointment_type ?? 'Direct Visit' }}</li>
                    </ul>
                </li>
                <li class="appointment-detail-btn">
                    <a href="{{ route('patient.details.page', $patient->id) }}" class="start-link">View Details</a>
                </li>
            </ul>
        </div>
        @empty
        <div class="text-center py-5">
            <p class="text-muted">No cancelled appointments.</p>
        </div>
        @endforelse

        @if ($cancelled->hasPages())
        <div class="mt-3 d-flex justify-content-center">{{ $cancelled->links() }}</div>
        @endif
    </div>

    {{-- ── COMPLETED ────────────────────────────────────────── --}}
    <div class="tab-pane fade" id="pills-complete" role="tabpanel">

        @forelse ($completed as $apt)
        @php
            $patient = $apt->patient;
            $photo   = $patient->profile_photo
                ? asset('storage/' . $patient->profile_photo)
                : asset('backend/assets/img/doctors-dashboard/profile-01.jpg');
        @endphp
        <div class="appointment-wrap">
            <ul>
                <li>
                    <div class="patinet-information">
                        <a href="{{ route('patient.details.page', $patient->id) }}">
                            <img src="{{ $photo }}" alt="{{ $patient->first_name }}">
                        </a>
                        <div class="patient-info">
                            <p>#{{ $apt->appointment_number }}</p>
                            <h6><a href="{{ route('patient.details.page', $patient->id) }}">{{ $patient->first_name }} {{ $patient->last_name }}</a></h6>
                        </div>
                    </div>
                </li>
                <li class="appointment-info">
                    <p><i class="isax isax-clock5"></i>{{ $apt->appointment_date->format('d M Y') }} {{ \Carbon\Carbon::createFromFormat('H:i', $apt->appointment_time)->format('h:i A') }}</p>
                    <ul class="d-flex apponitment-types">
                        <li>{{ $apt->reason_for_visit ?: 'General Visit' }}</li>
                        <li>{{ $apt->appointment_type ?? 'Direct Visit' }}</li>
                    </ul>
                </li>
                <li class="appointment-detail-btn">
                    <a href="{{ route('patient.details.page', $patient->id) }}" class="start-link">View Details</a>
                </li>
            </ul>
        </div>
        @empty
        <div class="text-center py-5">
            <p class="text-muted">No completed appointments yet.</p>
        </div>
        @endforelse

        @if ($completed->hasPages())
        <div class="mt-3 d-flex justify-content-center">{{ $completed->links() }}</div>
        @endif
    </div>

</div>

@endsection

@push('scripts')
<script>
$(function () {
    function showAlert(msg, type) {
        $('#apptAlert').removeClass('d-none alert-success alert-danger')
            .addClass('alert-' + type).text(msg).show();
        setTimeout(function () {
            $('#apptAlert').fadeOut(300, function () { $(this).addClass('d-none').show(); });
        }, 3000);
    }

    $(document).on('click', '.start-now-btn', function () {
        var btn = $(this);
        var id  = btn.data('id');
        var url = btn.data('url');
        var row = $('#apt-row-' + id);

        if (!confirm('Mark this appointment as completed?')) return;

        btn.text('Please wait...').css('pointer-events', 'none');

        $.ajax({
            url   : url,
            method: 'POST',
            data  : { _token: '{{ csrf_token() }}' },
            success: function (resp) {
                if (resp.success) {
                    showAlert('Appointment marked as completed.', 'success');
                    row.fadeOut(400, function () { row.remove(); });
                }
            },
            error: function () {
                btn.text('Start Now').css('pointer-events', '');
                showAlert('Something went wrong. Please try again.', 'danger');
            }
        });
    });
});
</script>
@endpush
