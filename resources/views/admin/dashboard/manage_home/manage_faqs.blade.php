@extends('admin.admin_master')
@section('admin')

<div class="content container-fluid">

    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h3 class="page-title">Manage FAQs</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('agent.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item">Manage Home</li>
                    <li class="breadcrumb-item active">FAQs</li>
                </ul>
            </div>
            <div class="col-sm-6 text-end">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                    <i class="fe fe-plus me-1"></i>Add FAQ
                </button>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="datatable table table-hover table-center mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Question</th>
                            <th>Answer</th>
                            <th>Status</th>
                            <th>Order</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($faqs as $faq)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td style="max-width:280px;">{{ $faq->question }}</td>
                        <td style="max-width:340px;">
                            <span class="text-truncate d-inline-block" style="max-width:320px;" title="{{ $faq->answer }}">
                                {{ Str::limit($faq->answer, 80) }}
                            </span>
                        </td>
                        <td>
                            @if($faq->is_active)
                                <span class="badge badge-success">Active</span>
                            @else
                                <span class="badge badge-danger">Inactive</span>
                            @endif
                        </td>
                        <td>{{ $faq->sort_order }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm bg-success-light edit-btn"
                                        data-id="{{ $faq->id }}"
                                        data-question="{{ $faq->question }}"
                                        data-answer="{{ $faq->answer }}"
                                        data-active="{{ $faq->is_active ? 1 : 0 }}"
                                        data-order="{{ $faq->sort_order }}"
                                        data-bs-toggle="modal" data-bs-target="#editModal">
                                    <i class="fe fe-edit"></i> Edit
                                </button>
                                <button class="btn btn-sm bg-danger-light delete-btn"
                                        data-id="{{ $faq->id }}"
                                        data-question="{{ Str::limit($faq->question, 60) }}"
                                        data-bs-toggle="modal" data-bs-target="#deleteModal">
                                    <i class="fe fe-trash"></i> Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            No FAQs yet. Click "Add FAQ" to get started.
                        </td>
                    </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

{{-- ── ADD MODAL ─────────────────────────────────────────── --}}
<div class="modal fade" id="addModal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add FAQ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('agent.manage.faqs.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Question <span class="text-danger">*</span></label>
                            <input type="text" name="question" class="form-control"
                                   placeholder="e.g. How do I book an appointment?" required maxlength="500">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Answer <span class="text-danger">*</span></label>
                            <textarea name="answer" class="form-control" rows="4"
                                      placeholder="Write the answer here..." required maxlength="2000"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Sort Order</label>
                            <input type="number" name="sort_order" class="form-control"
                                   value="0" min="0">
                            <small class="text-muted">Lower = appears first</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Status</label>
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" name="is_active"
                                       value="1" id="addActive" checked>
                                <label class="form-check-label" for="addActive">Active</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add FAQ</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ── EDIT MODAL ────────────────────────────────────────── --}}
<div class="modal fade" id="editModal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit FAQ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Question <span class="text-danger">*</span></label>
                            <input type="text" name="question" id="editQuestion" class="form-control"
                                   required maxlength="500">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Answer <span class="text-danger">*</span></label>
                            <textarea name="answer" id="editAnswer" class="form-control" rows="4"
                                      required maxlength="2000"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Sort Order</label>
                            <input type="number" name="sort_order" id="editOrder" class="form-control" min="0">
                            <small class="text-muted">Lower = appears first</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Status</label>
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" name="is_active"
                                       value="1" id="editActive">
                                <label class="form-check-label" for="editActive">Active</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ── DELETE MODAL ──────────────────────────────────────── --}}
<div class="modal fade" id="deleteModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center p-4">
                <span class="del-icon mb-3 mx-auto d-flex align-items-center justify-content-center"
                      style="width:60px;height:60px;background:#fee2e2;border-radius:50%;">
                    <i class="fe fe-trash text-danger fs-4"></i>
                </span>
                <h5 class="mb-2">Delete FAQ</h5>
                <p class="mb-4">Are you sure you want to delete:<br>
                    <strong id="deleteQuestion"></strong>
                </p>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="d-flex justify-content-center gap-3">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(function () {

    // ── Edit modal: populate from data attributes ─────────────
    $('#editModal').on('show.bs.modal', function (e) {
        var btn = $(e.relatedTarget);
        var id  = btn.data('id');

        $('#editForm').attr('action', '{{ url("agent/manage/faqs") }}/' + id);
        $('#editQuestion').val(btn.data('question'));
        $('#editAnswer').val(btn.data('answer'));
        $('#editOrder').val(btn.data('order'));
        $('#editActive').prop('checked', btn.data('active') == 1);
    });

    // ── Delete modal: set form action ────────────────────────
    $('#deleteModal').on('show.bs.modal', function (e) {
        var btn = $(e.relatedTarget);
        $('#deleteForm').attr('action', '{{ url("agent/manage/faqs") }}/' + btn.data('id'));
        $('#deleteQuestion').text(btn.data('question'));
    });

});
</script>
@endpush
