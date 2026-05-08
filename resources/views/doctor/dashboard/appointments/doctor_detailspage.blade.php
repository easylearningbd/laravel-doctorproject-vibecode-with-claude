@extends('doctor.doctor_master')
@section('doctor')

@php
    $patientNum  = 'PT' . str_pad($patient->id, 6, '0', STR_PAD_LEFT);
    $patientPhoto = $patient->profile_photo
        ? asset('storage/' . $patient->profile_photo)
        : asset('backend/assets/img/doctors-dashboard/profile-01.jpg');
    $age = $patient->dob
        ? \Carbon\Carbon::parse($patient->dob)->age
        : null;
@endphp

<div class="appointment-patient">

<div class="dashboard-header">
    <h3>
        <a href="{{ route('doctor.patients') }}">
            <i class="fa-solid fa-arrow-left me-2"></i>Patient Details
        </a>
    </h3>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-3">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show mb-3">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mb-3">
        <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="patient-wrap">
    <div class="patient-info">
        <img src="{{ $patientPhoto }}" alt="{{ $patient->first_name }}">
        <div class="user-patient">
            <h6>#{{ $patientNum }}</h6>
            <h5>{{ $patient->first_name }} {{ $patient->last_name }}</h5>
            <ul>
                @if ($age) <li>Age: {{ $age }}</li> @endif
                @if ($patient->blood_group) <li>{{ $patient->blood_group }}</li> @endif
                @if ($patient->email) <li>{{ $patient->email }}</li> @endif
            </ul>
        </div>
    </div>
    <div class="patient-book">
        <p><i class="isax isax-calendar-1"></i>Last Booking</p>
        <p>{{ $lastBooking?->appointment_date?->format('d M Y') ?? 'N/A' }}</p>
    </div>
</div>

<!-- Tabs -->
<div class="appointment-tabs user-tab">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link active" href="#pat_appointments" data-bs-toggle="tab">Appointments</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#prescription" data-bs-toggle="tab">Prescription</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#medical" data-bs-toggle="tab">Medical Records</a>
        </li>
    </ul>
</div>

<div class="tab-content pt-0">

    {{-- ── APPOINTMENTS TAB ──────────────────────────────────── --}}
    <div id="pat_appointments" class="tab-pane fade show active">
        <div class="search-header">
            <div class="search-field">
                <input type="text" class="form-control" placeholder="Search">
                <span class="search-icon"><i class="fa-solid fa-magnifying-glass"></i></span>
            </div>
        </div>

        <div class="custom-table">
            <div class="table-responsive">
                <table class="table table-center mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Appt Date</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse ($appointments as $apt)
                    @php
                        $badgeClass = match($apt->status) {
                            'confirmed' => 'badge-blue',
                            'completed' => 'badge-success',
                            'cancelled' => 'badge-danger',
                            default     => 'badge-yellow',
                        };
                    @endphp
                    <tr>
                        <td><span class="text-primary fw-medium">#{{ $apt->appointment_number }}</span></td>
                        <td>{{ $apt->appointment_date->format('d M Y') }} &nbsp;
                            {{ \Carbon\Carbon::createFromFormat('H:i', $apt->appointment_time)->format('h:i A') }}
                        </td>
                        <td>{{ $apt->appointment_type ?? 'Direct Visit' }}</td>
                        <td>${{ number_format($apt->total_amount, 2) }}</td>
                        <td><span class="badge {{ $badgeClass }} status-badge">{{ ucfirst($apt->status) }}</span></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">No appointments found.</td>
                    </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($appointments->hasPages())
            <div class="mt-3 d-flex justify-content-center">{{ $appointments->links() }}</div>
        @endif
    </div>

    {{-- ── PRESCRIPTION TAB ──────────────────────────────────── --}}
    <div class="tab-pane fade" id="prescription">
        <div class="search-header">
            <div class="search-field">
                <input type="text" class="form-control" placeholder="Search">
                <span class="search-icon"><i class="fa-solid fa-magnifying-glass"></i></span>
            </div>
            <div>
                <a href="#" class="btn btn-primary prime-btn"
                   data-bs-toggle="modal" data-bs-target="#add_prescription">
                    Add New Prescription
                </a>
            </div>
        </div>

        <div class="custom-table">
            <div class="table-responsive">
                <table class="table table-center mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Prescribed By</th>
                            <th>Type</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse ($prescriptions as $rx)
                    <tr>
                        <td>
                            <a href="javascript:void(0);" class="text-primary view-rx-btn"
                               data-id="{{ $rx->id }}"
                               data-url="{{ route('doctor.prescription.show', $rx->id) }}">
                                #{{ $rx->prescription_number }}
                            </a>
                        </td>
                        <td>
                            <h2 class="table-avatar">
                                @if ($doctor->profile_photo)
                                    <a href="#" class="avatar avatar-sm me-2">
                                        <img class="avatar-img rounded-3"
                                             src="{{ asset('storage/' . $doctor->profile_photo) }}"
                                             alt="{{ $doctor->first_name }}">
                                    </a>
                                @endif
                                <a href="#">Dr. {{ $doctor->first_name }} {{ $doctor->last_name }}</a>
                            </h2>
                        </td>
                        <td>{{ $rx->prescription_type }}</td>
                        <td>{{ $rx->issued_date->format('d M Y') }}</td>
                        <td>
                            <div class="action-item">
                                <a href="javascript:void(0);" class="view-rx-btn"
                                   data-id="{{ $rx->id }}"
                                   data-url="{{ route('doctor.prescription.show', $rx->id) }}"
                                   title="View">
                                    <i class="isax isax-link-2"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">No prescriptions yet.</td>
                    </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($prescriptions->hasPages())
            <div class="mt-3 d-flex justify-content-center">{{ $prescriptions->links() }}</div>
        @endif
    </div>

    {{-- ── MEDICAL RECORDS TAB ───────────────────────────────── --}}
    <div class="tab-pane fade" id="medical">
        <div class="search-header">
            <div class="search-field">
                <input type="text" class="form-control" placeholder="Search">
                <span class="search-icon"><i class="fa-solid fa-magnifying-glass"></i></span>
            </div>
        </div>

        <div class="custom-table">
            <div class="table-responsive">
                <table class="table table-center mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Date</th>
                            <th>Record For</th>
                            <th>Comments</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse ($medicalRecords as $rec)
                    <tr>
                        <td><span class="text-primary fw-medium">#{{ $rec->record_number }}</span></td>
                        <td>
                            <a href="javascript:void(0);" class="lab-icon">{{ $rec->title }}</a>
                        </td>
                        <td>{{ $rec->record_date->format('d M Y') }}</td>
                        <td>{{ $rec->record_for }}</td>
                        <td>{{ Str::limit($rec->comments, 40) ?: '—' }}</td>
                        <td>
                            <div class="action-item">
                                @if ($rec->file_path)
                                <a href="{{ route('patient.medical.records.download', $rec->id) }}"
                                   title="Download">
                                    <i class="isax isax-import"></i>
                                </a>
                                @else
                                <a href="javascript:void(0);" class="text-muted" title="No file">
                                    <i class="isax isax-import"></i>
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">No medical records found.</td>
                    </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($medicalRecords->hasPages())
            <div class="mt-3 d-flex justify-content-center">{{ $medicalRecords->links() }}</div>
        @endif
    </div>

</div>
</div>
{{-- /appointment-patient --}}


{{-- ========================================================
     MODALS
======================================================== --}}

{{-- ── ADD PRESCRIPTION MODAL ──────────────────────────── --}}
<div class="modal fade custom-modals" id="add_prescription">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Add Prescription</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <form action="{{ route('doctor.prescription.store', $patient->id) }}" method="POST">
                @csrf
                <div class="modal-body">

                    {{-- Patient summary --}}
                    <div class="patient-wrap mb-3">
                        <div class="patient-info mt-0">
                            <img src="{{ $patientPhoto }}" alt="{{ $patient->first_name }}"
                                 style="width:56px;height:56px;object-fit:cover;border-radius:50%;">
                            <div class="user-patient">
                                <h6>#{{ $patientNum }}</h6>
                                <h5>{{ $patient->first_name }} {{ $patient->last_name }}</h5>
                                <ul>
                                    <li>{{ $patient->email }}</li>
                                </ul>
                            </div>
                        </div>
                        <div class="patient-book patien-inv">
                            <div>
                                <label class="col-form-label fw-medium">Type</label>
                                <select name="prescription_type" class="select form-select form-select-sm" style="min-width:120px;">
                                    <option value="Visit">Visit</option>
                                    <option value="Online">Online</option>
                                </select>
                            </div>
                            <div class="mt-2">
                                <label class="col-form-label fw-medium">Date <span class="text-danger">*</span></label>
                                <input type="date" name="issued_date" class="form-control form-control-sm"
                                       value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>
                    </div>

                    {{-- Medicine rows --}}
                    <div id="medicineRows">
                        <div class="add-prescripe-info">
                            <div class="row prescripe-cont medicine-row align-items-end">
                                <div class="col-xl-2 col-lg-3 col-md-6">
                                    <div class="form-wrap">
                                        <label class="col-form-label">Medicine Name <span class="text-danger">*</span></label>
                                        <input type="text" name="medicines[0][name]" class="form-control" required placeholder="e.g. Aspirin 75mg">
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-3 col-md-6">
                                    <div class="form-wrap">
                                        <label class="col-form-label">Form</label>
                                        <select name="medicines[0][type]" class="select form-select">
                                            <option value="">Select</option>
                                            <option>Oral Tab</option>
                                            <option>Capsule</option>
                                            <option>Syrup</option>
                                            <option>Injection</option>
                                            <option>Drops</option>
                                            <option>Cream</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-3 col-md-6">
                                    <div class="form-wrap">
                                        <label class="col-form-label">Dosage</label>
                                        <input type="text" name="medicines[0][dosage]" class="form-control" placeholder="e.g. 75 mg">
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-3 col-md-6">
                                    <div class="form-wrap">
                                        <label class="col-form-label">Frequency</label>
                                        <input type="text" name="medicines[0][frequency]" class="form-control" placeholder="e.g. 1-0-1">
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-3 col-md-6">
                                    <div class="form-wrap">
                                        <label class="col-form-label">Duration</label>
                                        <input type="text" name="medicines[0][duration]" class="form-control" placeholder="e.g. 1 Month">
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-3 col-md-6">
                                    <div class="d-flex align-items-end gap-2">
                                        <div class="form-wrap w-100">
                                            <label class="col-form-label">Instruction</label>
                                            <input type="text" name="medicines[0][instruction]" class="form-control" placeholder="Before/After Meal">
                                        </div>
                                        <div class="form-wrap">
                                            <label class="d-block">&nbsp;</label>
                                            <a href="#" class="trash text-danger remove-row d-none">
                                                <i class="isax isax-trash"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-end mb-3">
                        <a href="#" id="addMoreMed" class="add-prescribe">+ Add More</a>
                    </div>

                    {{-- Other info & follow-up --}}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-wrap">
                                <label class="col-form-label">Other Information</label>
                                <textarea name="other_info" class="form-control" rows="3"
                                          placeholder="Any additional notes..."></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-wrap">
                                <label class="col-form-label">Follow Up</label>
                                <textarea name="follow_up" class="form-control" rows="3"
                                          placeholder="e.g. Follow up after 3 months"></textarea>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <div class="modal-btn text-end">
                        <button type="button" class="btn btn-gray" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary prime-btn">Save Prescription</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- /Add Prescription Modal --}}


{{-- ── VIEW PRESCRIPTION MODAL ─────────────────────────── --}}
<div class="modal fade custom-modals" id="view_prescription">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">View Prescription</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body pb-0" id="rxModalBody">
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status"></div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- /View Prescription Modal --}}


@endsection

@push('scripts')
<script>
$(function () {

    // ── Add More medicine rows ────────────────────────────────────
    var rowIndex = 1;

    $('#addMoreMed').on('click', function (e) {
        e.preventDefault();
        var $first = $('#medicineRows .add-prescripe-info').first();
        var $clone = $first.clone();

        // Update name indices
        $clone.find('[name]').each(function () {
            var name = $(this).attr('name').replace(/\[\d+\]/, '[' + rowIndex + ']');
            $(this).attr('name', name).val('');
        });

        // Show remove button
        $clone.find('.remove-row').removeClass('d-none');

        $clone.appendTo('#medicineRows');
        rowIndex++;
    });

    $(document).on('click', '.remove-row', function (e) {
        e.preventDefault();
        $(this).closest('.add-prescripe-info').remove();
    });

    // ── View prescription (AJAX) ─────────────────────────────────
    $(document).on('click', '.view-rx-btn', function () {
        var url = $(this).data('url');
        $('#rxModalBody').html('<div class="text-center py-4"><div class="spinner-border text-primary"></div></div>');
        $('#view_prescription').modal('show');

        $.ajax({
            url    : url,
            method : 'GET',
            success: function (rx) {
                var html = '';

                html += '<div class="prescribe-download gap-2">';
                html +=   '<div>';
                html +=     '<h5 class="mb-0">#' + rx.prescription_number + '</h5>';
                html +=     '<p class="text-muted fs-13 mb-0">' + rx.prescription_type + ' &mdash; Issued: ' + rx.issued_date + '</p>';
                html +=   '</div>';
                html += '</div>';

                html += '<div class="view-prescribe invoice-content mt-3">';

                // Doctor / Patient info
                html += '<div class="invoice-item"><div class="row">';
                html += '<div class="col-md-6"><div class="invoice-info"><h6 class="customer-text">Doctor Details</h6>';
                html += '<p class="invoice-details">Dr. ' + rx.doctor.first_name + ' ' + rx.doctor.last_name + '</p>';
                html += '</div></div>';
                html += '<div class="col-md-6"><div class="invoice-info invoice-info2"><h6 class="customer-text">Patient Details</h6>';
                html += '<p class="invoice-details">' + rx.patient.first_name + ' ' + rx.patient.last_name + '<br>' + rx.patient.email + '</p>';
                html += '</div></div>';
                html += '</div></div>';

                // Medicine table
                html += '<div class="invoice-item invoice-table-wrap"><div class="row"><div class="col-md-12">';
                html += '<h6>Prescription Details</h6><div class="table-responsive">';
                html += '<table class="invoice-table table table-bordered"><thead><tr>';
                html += '<th>Medicine Name</th><th>Form</th><th>Dosage</th><th>Frequency</th><th>Duration</th><th>Instruction</th>';
                html += '</tr></thead><tbody>';

                if (rx.items && rx.items.length) {
                    $.each(rx.items, function (i, item) {
                        html += '<tr>';
                        html += '<td>' + (item.medicine_name || '—') + '</td>';
                        html += '<td>' + (item.medicine_type || '—') + '</td>';
                        html += '<td>' + (item.dosage       || '—') + '</td>';
                        html += '<td>' + (item.frequency    || '—') + '</td>';
                        html += '<td>' + (item.duration     || '—') + '</td>';
                        html += '<td>' + (item.instruction  || '—') + '</td>';
                        html += '</tr>';
                    });
                } else {
                    html += '<tr><td colspan="6" class="text-center text-muted">No medicines added.</td></tr>';
                }

                html += '</tbody></table></div></div></div></div>';

                if (rx.other_info) {
                    html += '<div class="other-info"><h4>Other Information</h4><p class="text-muted mb-0">' + rx.other_info + '</p></div>';
                }
                if (rx.follow_up) {
                    html += '<div class="other-info"><h4>Follow Up</h4><p class="text-muted mb-0">' + rx.follow_up + '</p></div>';
                }

                html += '<div class="prescriber-info">';
                html += '<h6>Dr. ' + rx.doctor.first_name + ' ' + rx.doctor.last_name + '</h6>';
                html += '<p>' + (rx.doctor.designation || 'Doctor') + '</p>';
                html += '</div>';

                html += '</div>';

                $('#rxModalBody').html(html);
            },
            error: function () {
                $('#rxModalBody').html('<div class="text-center text-danger py-4">Failed to load prescription.</div>');
            }
        });
    });

});
</script>
@endpush
