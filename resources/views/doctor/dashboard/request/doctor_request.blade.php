@extends('doctor.doctor_master')
@section('doctor')

<div class="dashboard-header">
    <h3>Requests</h3>
    <ul>
        <li>
            <span class="badge bg-warning-light text-warning fs-13">
                Pending Appointments
            </span>
        </li>
    </ul>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- Alert placeholder for AJAX feedback --}}
<div id="apptAlert" class="alert d-none mb-3" role="alert"></div>

<!-- Request List -->
<div id="requestsContainer">

@forelse ($appointments as $appointment)
@php
    $patient     = $appointment->patient;
    $patientName = trim($patient->first_name . ' ' . $patient->last_name);
    $patientPhoto = $patient->profile_photo
        ? asset('storage/' . $patient->profile_photo)
        : asset('backend/assets/img/doctors-dashboard/profile-01.jpg');

    $apptDate = $appointment->appointment_date->format('d M Y');
    $apptTime = \Carbon\Carbon::createFromFormat('H:i', $appointment->appointment_time)->format('h:i A');

    $typeIcon = match($appointment->appointment_type ?? '') {
        'Video Call'  => 'isax-video5',
        'Audio Call'  => 'isax-call5',
        default       => 'isax-building5',
    };
@endphp

<div class="appointment-wrap" id="appt-row-{{ $appointment->id }}">
    <ul>
        <li>
            <div class="patinet-information">
                <a href="#">
                    <img src="{{ $patientPhoto }}" alt="{{ $patientName }}">
                </a>
                <div class="patient-info">
                    <p>#{{ $appointment->appointment_number }}</p>
                    <h6>
                        <a href="#">{{ $patientName }}</a>
                        <span class="badge new-tag">New</span>
                    </h6>
                </div>
            </div>
        </li>
        <li class="appointment-info">
            <p><i class="isax isax-clock5"></i>{{ $apptDate }} {{ $apptTime }}</p>
            <p class="md-text">{{ $appointment->reason_for_visit ?: 'General Visit' }}</p>
        </li>
        <li class="appointment-type">
            <p class="md-text">Type of Appointment</p>
            <p>
                <i class="isax {{ $typeIcon }} text-green"></i>
                {{ $appointment->appointment_type ?? 'Direct Visit' }}
            </p>
        </li>
        <li>
            <ul class="request-action">
                <li>
                    <a href="javascript:void(0)"
                       class="accept-link appt-action-btn"
                       data-id="{{ $appointment->id }}"
                       data-status="confirmed"
                       data-url="{{ route('doctor.appointment.status', $appointment->id) }}">
                        <i class="fa-solid fa-check"></i>Accept
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)"
                       class="reject-link appt-action-btn"
                       data-id="{{ $appointment->id }}"
                       data-status="cancelled"
                       data-url="{{ route('doctor.appointment.status', $appointment->id) }}">
                        <i class="fa-solid fa-xmark"></i>Reject
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</div>
<!-- /Request List -->

@empty

<div class="text-center py-5" id="emptyRequests">
    <i class="isax isax-calendar5 fs-1 text-muted mb-3 d-block"></i>
    <h5 class="text-muted">No pending appointment requests.</h5>
    <p class="text-muted">New booking requests from patients will appear here.</p>
</div>

@endforelse

</div>
{{-- /requestsContainer --}}

<!-- Pagination -->
@if ($appointments->hasPages())
<div class="row mt-3">
    <div class="col-md-12 d-flex justify-content-center">
        {{ $appointments->links() }}
    </div>
</div>
@endif

@endsection

@push('scripts')
<script>
$(function () {

    function showAlert(msg, type) {
        $('#apptAlert')
            .removeClass('d-none alert-success alert-danger alert-warning')
            .addClass('alert-' + type)
            .text(msg)
            .show();
        setTimeout(function () {
            $('#apptAlert').fadeOut(400, function () { $(this).addClass('d-none').show(); });
        }, 3000);
    }

    $(document).on('click', '.appt-action-btn', function () {
        var btn    = $(this);
        var id     = btn.data('id');
        var status = btn.data('status');
        var url    = btn.data('url');
        var row    = $('#appt-row-' + id);
        var label  = status === 'confirmed' ? 'accept' : 'reject';

        if (!confirm('Are you sure you want to ' + label + ' this appointment?')) return;

        // Disable both action buttons while request is in flight
        row.find('.appt-action-btn').css('pointer-events', 'none').css('opacity', '0.5');

        $.ajax({
            url   : url,
            method: 'POST',
            data  : { _token: '{{ csrf_token() }}', status: status },
            success: function (resp) {
                if (resp.success) {
                    showAlert(resp.message, status === 'confirmed' ? 'success' : 'warning');
                    row.fadeOut(400, function () {
                        row.remove();
                        // Show empty state if no rows remain
                        if ($('#requestsContainer .appointment-wrap').length === 0) {
                            $('#requestsContainer').html(
                                '<div class="text-center py-5">' +
                                '<i class="isax isax-calendar5 fs-1 text-muted mb-3 d-block"></i>' +
                                '<h5 class="text-muted">No pending appointment requests.</h5>' +
                                '<p class="text-muted">New booking requests from patients will appear here.</p>' +
                                '</div>'
                            );
                        }
                    });
                }
            },
            error: function () {
                row.find('.appt-action-btn').css('pointer-events', '').css('opacity', '');
                showAlert('Something went wrong. Please try again.', 'danger');
            }
        });
    });

});
</script>
@endpush
