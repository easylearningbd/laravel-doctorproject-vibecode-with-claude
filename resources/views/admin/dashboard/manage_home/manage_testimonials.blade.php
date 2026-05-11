@extends('admin.admin_master')
@section('admin')

<div class="content container-fluid">

    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h3 class="page-title">Manage Testimonials</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('agent.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item">Manage Home</li>
                    <li class="breadcrumb-item active">Testimonials</li>
                </ul>
            </div>
            <div class="col-sm-6 text-end">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                    <i class="fe fe-plus me-1"></i>Add Testimonial
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
                            <th>Photo</th>
                            <th>Author</th>
                            <th>Title</th>
                            <th>Rating</th>
                            <th>Status</th>
                            <th>Order</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($testimonials as $t)
                    <tr>
                        <td>
                            @if($t->photo)
                                <img src="{{ asset('storage/' . $t->photo) }}"
                                     class="rounded-circle"
                                     style="width:48px;height:48px;object-fit:cover;"
                                     alt="{{ $t->author_name }}">
                            @else
                                <span class="avatar avatar-sm bg-primary-light d-inline-flex align-items-center justify-content-center rounded-circle"
                                      style="width:48px;height:48px;">
                                    <i class="fe fe-user text-primary"></i>
                                </span>
                            @endif
                        </td>
                        <td>
                            <strong>{{ $t->author_name }}</strong>
                            <small class="d-block text-muted">{{ $t->author_location }}</small>
                        </td>
                        <td>{{ $t->title }}</td>
                        <td>
                            @for($s = 1; $s <= 5; $s++)
                                <i class="fe {{ $s <= $t->rating ? 'fe-star text-warning' : 'fe-star-o text-secondary' }}"></i>
                            @endfor
                        </td>
                        <td>
                            @if($t->is_active)
                                <span class="badge badge-success">Active</span>
                            @else
                                <span class="badge badge-danger">Inactive</span>
                            @endif
                        </td>
                        <td>{{ $t->sort_order }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm bg-success-light edit-btn"
                                        data-id="{{ $t->id }}"
                                        data-rating="{{ $t->rating }}"
                                        data-title="{{ $t->title }}"
                                        data-content="{{ $t->content }}"
                                        data-author="{{ $t->author_name }}"
                                        data-location="{{ $t->author_location }}"
                                        data-active="{{ $t->is_active ? 1 : 0 }}"
                                        data-order="{{ $t->sort_order }}"
                                        data-photo="{{ $t->photo ? asset('storage/' . $t->photo) : '' }}"
                                        data-bs-toggle="modal" data-bs-target="#editModal">
                                    <i class="fe fe-edit"></i> Edit
                                </button>
                                <button class="btn btn-sm bg-danger-light delete-btn"
                                        data-id="{{ $t->id }}"
                                        data-name="{{ $t->author_name }}"
                                        data-bs-toggle="modal" data-bs-target="#deleteModal">
                                    <i class="fe fe-trash"></i> Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
                            No testimonials yet. Click "Add Testimonial" to get started.
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
                <h5 class="modal-title">Add Testimonial</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('agent.manage.testimonials.store') }}" method="POST"
                  enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Author Name <span class="text-danger">*</span></label>
                            <input type="text" name="author_name" class="form-control"
                                   placeholder="e.g. Deny Hendrawan" required maxlength="150">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Location</label>
                            <input type="text" name="author_location" class="form-control"
                                   placeholder="e.g. United States" maxlength="100">
                        </div>
                        <div class="col-md-8">
                            <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control"
                                   placeholder="e.g. Nice Treatment" required maxlength="150">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Rating <span class="text-danger">*</span></label>
                            <select name="rating" class="form-select" required>
                                @for($i = 5; $i >= 1; $i--)
                                    <option value="{{ $i }}" {{ $i === 5 ? 'selected' : '' }}>
                                        {{ $i }} Star{{ $i != 1 ? 's' : '' }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Review Content <span class="text-danger">*</span></label>
                            <textarea name="content" class="form-control" rows="3"
                                      placeholder="Write the testimonial content here..." required maxlength="1000"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Author Photo
                                <small class="text-muted fw-normal">(will be resized to 300 × 300 px)</small>
                            </label>
                            <input type="file" name="photo" class="form-control preview-trigger"
                                   data-target="#addPhotoPreview"
                                   accept="image/jpeg,image/png,image/webp">
                            <div id="addPhotoPreview" class="mt-2 d-none">
                                <img src="#" alt="Preview"
                                     class="rounded-circle"
                                     style="width:64px;height:64px;object-fit:cover;">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Sort Order</label>
                            <input type="number" name="sort_order" class="form-control"
                                   value="0" min="0">
                            <small class="text-muted">Lower = appears first</small>
                        </div>
                        <div class="col-md-3">
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
                    <button type="submit" class="btn btn-primary">Add Testimonial</button>
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
                <h5 class="modal-title">Edit Testimonial</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Author Name <span class="text-danger">*</span></label>
                            <input type="text" name="author_name" id="editAuthor" class="form-control"
                                   required maxlength="150">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Location</label>
                            <input type="text" name="author_location" id="editLocation" class="form-control"
                                   maxlength="100">
                        </div>
                        <div class="col-md-8">
                            <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="editTitle" class="form-control"
                                   required maxlength="150">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Rating <span class="text-danger">*</span></label>
                            <select name="rating" id="editRating" class="form-select" required>
                                @for($i = 5; $i >= 1; $i--)
                                    <option value="{{ $i }}">{{ $i }} Star{{ $i != 1 ? 's' : '' }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Review Content <span class="text-danger">*</span></label>
                            <textarea name="content" id="editContent" class="form-control" rows="3"
                                      required maxlength="1000"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Author Photo
                                <small class="text-muted fw-normal">(300 × 300 px · leave blank to keep current)</small>
                            </label>
                            <div id="editCurrentPhoto" class="mb-2 d-none">
                                <img id="editCurrentPhotoImg" src="#" alt="Current photo"
                                     class="rounded-circle"
                                     style="width:64px;height:64px;object-fit:cover;">
                                <p class="text-muted fs-12 mt-1 mb-0">Current photo</p>
                            </div>
                            <input type="file" name="photo" class="form-control preview-trigger"
                                   data-target="#editPhotoPreview"
                                   accept="image/jpeg,image/png,image/webp">
                            <div id="editPhotoPreview" class="mt-2 d-none">
                                <img src="#" alt="New preview" class="rounded-circle"
                                     style="width:64px;height:64px;object-fit:cover;">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Sort Order</label>
                            <input type="number" name="sort_order" id="editOrder" class="form-control" min="0">
                            <small class="text-muted">Lower = appears first</small>
                        </div>
                        <div class="col-md-3">
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
                <h5 class="mb-2">Delete Testimonial</h5>
                <p class="mb-4">Are you sure you want to delete the testimonial by
                    <strong id="deleteAuthorName"></strong>?
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

        $('#editForm').attr('action', '{{ url("agent/manage/testimonials") }}/' + id);
        $('#editAuthor').val(btn.data('author'));
        $('#editLocation').val(btn.data('location'));
        $('#editTitle').val(btn.data('title'));
        $('#editContent').val(btn.data('content'));
        $('#editRating').val(btn.data('rating'));
        $('#editOrder').val(btn.data('order'));
        $('#editActive').prop('checked', btn.data('active') == 1);

        var photo = btn.data('photo');
        if (photo) {
            $('#editCurrentPhotoImg').attr('src', photo);
            $('#editCurrentPhoto').removeClass('d-none');
        } else {
            $('#editCurrentPhoto').addClass('d-none');
        }

        // Clear new-photo preview
        $('#editPhotoPreview').addClass('d-none').find('img').attr('src', '#');
    });

    // ── Delete modal: set form action ────────────────────────
    $('#deleteModal').on('show.bs.modal', function (e) {
        var btn = $(e.relatedTarget);
        $('#deleteForm').attr('action', '{{ url("agent/manage/testimonials") }}/' + btn.data('id'));
        $('#deleteAuthorName').text(btn.data('name'));
    });

    // ── Instant image preview ────────────────────────────────
    $(document).on('change', '.preview-trigger', function () {
        var $wrap = $($(this).data('target'));
        var file  = this.files[0];
        if (!file) { $wrap.addClass('d-none'); return; }
        var reader = new FileReader();
        reader.onload = function (e) {
            $wrap.find('img').attr('src', e.target.result);
            $wrap.removeClass('d-none');
        };
        reader.readAsDataURL(file);
    });

});
</script>
@endpush
