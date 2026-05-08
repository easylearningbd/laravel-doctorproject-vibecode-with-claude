@extends('patient.patient_master')
@section('patient')

<div class="col-lg-8 col-xl-9">

<div class="dashboard-header flex-wrap">
    <h3>Records</h3>
    <div class="appointment-tabs">
        <ul class="nav">
            <li>
                <a href="#" class="nav-link active" data-bs-toggle="tab" data-bs-target="#medical">Medical Records</a>
            </li>
            <li>
                <a href="#" class="nav-link" data-bs-toggle="tab" data-bs-target="#prescription">Prescriptions</a>
            </li>
        </ul>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
        <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="tab-content pt-0">

    <!-- Prescription Tab (static placeholder) -->
    <div class="tab-pane fade" id="prescription">
        <div class="dashboard-header border-0 m-0">
            <ul class="header-list-btns">
                <li>
                    <div class="input-block dash-search-input">
                        <input type="text" class="form-control" placeholder="Search">
                        <span class="search-icon"><i class="isax isax-search-normal"></i></span>
                    </div>
                </li>
            </ul>
        </div>
        <div class="custom-table">
            <div class="table-responsive">
                <table class="table table-center mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Created Date</th>
                            <th>Prescribed By</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">No prescriptions available yet.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- /Prescription Tab -->

    <!-- Medical Records Tab -->
    <div class="tab-pane fade show active" id="medical">
        <div class="dashboard-header border-0 m-0">
            <ul class="header-list-btns">
                <li>
                    <div class="input-block dash-search-input">
                        <input type="text" class="form-control" placeholder="Search">
                        <span class="search-icon"><i class="isax isax-search-normal"></i></span>
                    </div>
                </li>
            </ul>
            <a href="#" class="btn btn-md btn-primary-gradient rounded-pill"
               data-bs-toggle="modal" data-bs-target="#add_medical_records">
                Add Medical Record
            </a>
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
                    @forelse ($records as $record)
                    <tr>
                        <td>
                            <a class="link-primary" href="javascript:void(0);"
                               data-bs-toggle="modal" data-bs-target="#view_report"
                               data-id="{{ $record->id }}"
                               data-number="{{ $record->record_number }}"
                               data-title="{{ $record->title }}"
                               data-for="{{ $record->record_for }}"
                               data-date="{{ $record->record_date->format('d M Y') }}"
                               data-comments="{{ $record->comments }}"
                               data-filename="{{ $record->file_original_name }}"
                               data-download="{{ $record->file_path ? route('patient.medical.records.download', $record->id) : '' }}">
                                #{{ $record->record_number }}
                            </a>
                        </td>
                        <td>
                            <a href="javascript:void(0);" class="lab-icon">{{ $record->title }}</a>
                        </td>
                        <td>{{ $record->record_date->format('d M Y') }}</td>
                        <td>{{ $record->record_for }}</td>
                        <td>{{ Str::limit($record->comments, 40) ?: '—' }}</td>
                        <td>
                            <div class="action-item">
                                {{-- View --}}
                                <a href="javascript:void(0);"
                                   data-bs-toggle="modal" data-bs-target="#view_report"
                                   data-id="{{ $record->id }}"
                                   data-number="{{ $record->record_number }}"
                                   data-title="{{ $record->title }}"
                                   data-for="{{ $record->record_for }}"
                                   data-date="{{ $record->record_date->format('d M Y') }}"
                                   data-comments="{{ $record->comments }}"
                                   data-filename="{{ $record->file_original_name }}"
                                   data-download="{{ $record->file_path ? route('patient.medical.records.download', $record->id) : '' }}"
                                   title="View">
                                    <i class="isax isax-link-2"></i>
                                </a>
                                {{-- Edit --}}
                                <a href="javascript:void(0);"
                                   data-bs-toggle="modal" data-bs-target="#edit_medical_records"
                                   data-id="{{ $record->id }}"
                                   data-title="{{ $record->title }}"
                                   data-for="{{ $record->record_for }}"
                                   data-date="{{ $record->record_date->format('Y-m-d') }}"
                                   data-comments="{{ $record->comments }}"
                                   data-filename="{{ $record->file_original_name }}"
                                   title="Edit">
                                    <i class="isax isax-edit-2"></i>
                                </a>
                                {{-- Download --}}
                                @if ($record->file_path)
                                <a href="{{ route('patient.medical.records.download', $record->id) }}" title="Download">
                                    <i class="isax isax-import"></i>
                                </a>
                                @else
                                <a href="javascript:void(0);" class="text-muted" title="No file attached">
                                    <i class="isax isax-import"></i>
                                </a>
                                @endif
                                {{-- Delete --}}
                                <a href="javascript:void(0);"
                                   data-bs-toggle="modal" data-bs-target="#delete_modal"
                                   data-id="{{ $record->id }}"
                                   data-title="{{ $record->title }}"
                                   title="Delete">
                                    <i class="isax isax-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            No medical records yet. Click "Add Medical Record" to get started.
                        </td>
                    </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if ($records->hasPages())
        <div class="mt-3 d-flex justify-content-center">
            {{ $records->links() }}
        </div>
        @endif

    </div>
    <!-- /Medical Records Tab -->

</div>

</div>
{{-- /col --}}


{{-- ============================================================
     MODALS
============================================================ --}}

<!-- Add Medical Records Modal -->
<div class="modal fade custom-modals" id="add_medical_records">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Add Medical Record</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <form action="{{ route('patient.medical.records.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body pb-0">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control" placeholder="e.g. Blood Test Report" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label">Record For <span class="text-danger">*</span></label>
                                <input type="text" name="record_for" class="form-control"
                                       value="{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="col-form-label">Date <span class="text-danger">*</span></label>
                                <div class="form-icon">
                                    <input type="date" name="record_date" class="form-control" required>
                                    <span class="icon"><i class="isax isax-calendar-1"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="col-form-label">Comments</label>
                                <textarea name="comments" class="form-control" rows="3" placeholder="Any notes or observations..."></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="col-form-label">Attach File <small class="text-muted">(PDF, Image, DOC — max 10 MB)</small></label>
                                <div class="file-upload">
                                    <input type="file" name="record_file" accept=".pdf,.jpg,.jpeg,.png,.gif,.webp,.doc,.docx">
                                    <p><i class="isax isax-document-upload me-1"></i>Upload File</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="modal-btn text-end">
                        <button type="button" class="btn btn-md btn-dark rounded-pill" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-md btn-primary-gradient rounded-pill">Add Medical Record</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /Add Medical Records Modal -->

<!-- Edit Medical Records Modal -->
<div class="modal fade custom-modals" id="edit_medical_records">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Edit Medical Record</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <form id="editRecordForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body pb-0">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" id="editTitle" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label">Record For <span class="text-danger">*</span></label>
                                <input type="text" name="record_for" id="editRecordFor" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="col-form-label">Date <span class="text-danger">*</span></label>
                                <div class="form-icon">
                                    <input type="date" name="record_date" id="editRecordDate" class="form-control" required>
                                    <span class="icon"><i class="isax isax-calendar-1"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="col-form-label">Comments</label>
                                <textarea name="comments" id="editComments" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="col-form-label">Attach New File <small class="text-muted">(leave blank to keep existing)</small></label>
                                <div id="editCurrentFile" class="mb-2 d-none">
                                    <span class="text-muted fs-13">Current: </span>
                                    <span id="editCurrentFileName" class="fw-medium fs-13"></span>
                                    <label class="ms-2 text-danger fs-13" style="cursor:pointer;">
                                        <input type="checkbox" name="remove_file" value="1" style="display:none;" id="removeFileCheck">
                                        Remove file
                                    </label>
                                </div>
                                <div class="file-upload">
                                    <input type="file" name="record_file" accept=".pdf,.jpg,.jpeg,.png,.gif,.webp,.doc,.docx">
                                    <p><i class="isax isax-document-upload me-1"></i>Upload New File</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="modal-btn text-end">
                        <button type="button" class="btn btn-md btn-dark rounded-pill" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-md btn-primary-gradient rounded-pill">Save Changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /Edit Medical Records Modal -->

<!-- View Report Modal -->
<div class="modal fade custom-modals" id="view_report">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">View Medical Record</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body pb-0">
                <div class="prescribe-download gap-2">
                    <div>
                        <h5 id="viewTitle" class="mb-0"></h5>
                        <p id="viewDate" class="text-muted mb-0 fs-13"></p>
                    </div>
                    <ul class="d-flex gap-2 list-unstyled mb-0 align-items-center">
                        <li>
                            <a id="viewDownloadBtn" href="#"
                               class="btn btn-md btn-primary-gradient rounded-pill d-none">
                                <i class="isax isax-import me-1"></i>Download File
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="view-prescribe-details p-0 border-0 mt-3">

                    <!-- Patient Info Row -->
                    <div class="invoice-item mb-3">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center gap-2">
                                    @if(auth()->user()->profile_photo)
                                        <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}"
                                             class="rounded-circle" width="48" height="48" alt="Patient" style="object-fit:cover;">
                                    @else
                                        <span class="avatar bg-primary-light d-inline-flex align-items-center justify-content-center rounded-circle"
                                              style="width:48px;height:48px;">
                                            <i class="isax isax-user fs-4 text-primary"></i>
                                        </span>
                                    @endif
                                    <div>
                                        <h6 class="mb-0 fw-semibold">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</h6>
                                        <p class="mb-0 text-muted fs-13">Patient</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1 fs-14"><span class="text-gray-9 fw-medium">Record Number : </span><span id="viewNumber"></span></p>
                                <p class="mb-1 fs-14"><span class="text-gray-9 fw-medium">Record For : </span><span id="viewRecordFor"></span></p>
                                <p class="mb-0 fs-14"><span class="text-gray-9 fw-medium">Date : </span><span id="viewDateInfo"></span></p>
                            </div>
                        </div>
                    </div>

                    <!-- Comments -->
                    <div class="invoice-item">
                        <h6 class="fw-semibold mb-2">Comments / Notes</h6>
                        <p id="viewComments" class="text-muted mb-0">—</p>
                    </div>

                    <!-- File attachment info -->
                    <div id="viewFileSection" class="invoice-item d-none mt-3">
                        <h6 class="fw-semibold mb-2">Attached File</h6>
                        <div class="d-flex align-items-center gap-3">
                            <i class="isax isax-document fs-2 text-primary"></i>
                            <div>
                                <p id="viewFileName" class="mb-1 fw-medium"></p>
                                <a id="viewDownloadLink" href="#" class="btn btn-sm btn-outline-primary rounded-pill">
                                    <i class="isax isax-import me-1"></i>Download
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- /View Report Modal -->

<!-- Delete Modal -->
<div class="modal fade custom-modals" id="delete_modal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body p-4 text-center">
                <form id="deleteRecordForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <span class="del-icon mb-2 mx-auto">
                        <i class="isax isax-trash"></i>
                    </span>
                    <h3 class="mb-2">Delete Record</h3>
                    <p class="mb-1">Are you sure you want to delete</p>
                    <p class="mb-3 fw-semibold" id="deleteRecordTitle">this record</p>
                    <div class="d-flex justify-content-center flex-wrap gap-3">
                        <button type="button" class="btn btn-md btn-dark rounded-pill" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-md btn-primary-gradient rounded-pill">Yes, Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Delete Modal -->

@endsection

@push('scripts')
<script>
$(function () {

    // ── Edit Modal: populate fields from data attributes ──────────────────
    $('#edit_medical_records').on('show.bs.modal', function (e) {
        var btn = $(e.relatedTarget);
        var id  = btn.data('id');

        $('#editRecordForm').attr('action', '{{ url("patient/medical/records") }}/' + id);
        $('#editTitle').val(btn.data('title'));
        $('#editRecordFor').val(btn.data('for'));
        $('#editRecordDate').val(btn.data('date'));
        $('#editComments').val(btn.data('comments'));

        var filename = btn.data('filename');
        if (filename) {
            $('#editCurrentFile').removeClass('d-none');
            $('#editCurrentFileName').text(filename);
        } else {
            $('#editCurrentFile').addClass('d-none');
        }
        $('#removeFileCheck').prop('checked', false);
    });

    // ── View Modal: populate from data attributes ─────────────────────────
    $('#view_report').on('show.bs.modal', function (e) {
        var btn      = $(e.relatedTarget);
        var title    = btn.data('title')    || '—';
        var number   = btn.data('number')   || '—';
        var forName  = btn.data('for')      || '—';
        var date     = btn.data('date')     || '—';
        var comments = btn.data('comments') || '—';
        var filename = btn.data('filename') || '';
        var dlUrl    = btn.data('download') || '';

        $('#viewTitle').text(title);
        $('#viewDate').text(date);
        $('#viewNumber').text(number);
        $('#viewRecordFor').text(forName);
        $('#viewDateInfo').text(date);
        $('#viewComments').text(comments || '—');

        if (filename && dlUrl) {
            $('#viewFileSection').removeClass('d-none');
            $('#viewFileName').text(filename);
            $('#viewDownloadLink').attr('href', dlUrl);
            $('#viewDownloadBtn').attr('href', dlUrl).removeClass('d-none');
        } else {
            $('#viewFileSection').addClass('d-none');
            $('#viewDownloadBtn').addClass('d-none');
        }
    });

    // ── Delete Modal: set form action from data attributes ────────────────
    $('#delete_modal').on('show.bs.modal', function (e) {
        var btn   = $(e.relatedTarget);
        var id    = btn.data('id');
        var title = btn.data('title') || 'this record';

        $('#deleteRecordForm').attr('action', '{{ url("patient/medical/records") }}/' + id);
        $('#deleteRecordTitle').text('"' + title + '"');
    });

});
</script>
@endpush
