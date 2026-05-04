@extends('admin.admin_master')
@section('admin')

<div class="content container-fluid">

<!-- Page Header -->
<div class="page-header">
    <div class="row">
        <div class="col-sm-7 col-auto">
            <h3 class="page-title">Specialities</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('agent.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Specialities</li>
            </ul>
        </div>
        <div class="col-sm-5 col">
            <a href="#Add_Specialities_details" data-bs-toggle="modal" class="btn btn-primary float-end mt-2">Add</a>
        </div>
    </div>
</div>
<!-- /Page Header -->

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="datatable table table-hover table-center mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Specialities</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($specialities as $speciality)
                            <tr>
                                <td>#SP{{ str_pad($speciality->id, 3, '0', STR_PAD_LEFT) }}</td>

                                <td>
                                    <h2 class="table-avatar">
                                        <a href="#" class="avatar avatar-sm me-2">
                                            @if ($speciality->image)
                                                <img class="avatar-img" src="{{ asset('storage/' . $speciality->image) }}" alt="{{ $speciality->name }}">
                                            @else
                                                <img class="avatar-img" src="{{ asset('admin/assets/img/specialities/default.png') }}" alt="{{ $speciality->name }}">
                                            @endif
                                        </a>
                                        <a href="#">{{ $speciality->name }}</a>
                                    </h2>
                                </td>

                                <td>
                                    <div class="actions">
                                        <a class="btn btn-sm bg-success-light"
                                           data-bs-toggle="modal"
                                           data-bs-target="#edit_specialities_details"
                                           data-id="{{ $speciality->id }}"
                                           data-name="{{ $speciality->name }}"
                                           href="#">
                                            <i class="fe fe-pencil"></i> Edit
                                        </a>
                                        <a class="btn btn-sm bg-danger-light"
                                           data-bs-toggle="modal"
                                           data-bs-target="#delete_modal"
                                           data-id="{{ $speciality->id }}"
                                           href="#">
                                            <i class="fe fe-trash"></i> Delete
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center">No specialities found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


<!-- Add Modal -->
<div class="modal fade" id="Add_Specialities_details" aria-hidden="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Specialities</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('agent.spcialities.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <div class="mb-3">
                                <label class="mb-2">Specialities</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter speciality name" required>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="mb-3">
                                <label class="mb-2">Image</label>
                                <input type="file" name="image" class="form-control" accept="image/*">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /ADD Modal -->

<!-- Edit Modal -->
<div class="modal fade" id="edit_specialities_details" aria-hidden="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Specialities</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm" action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <div class="mb-3">
                                <label class="mb-2">Specialities</label>
                                <input type="text" id="editName" name="name" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="mb-3">
                                <label class="mb-2">Image <small class="text-muted">(leave blank to keep current)</small></label>
                                <input type="file" name="image" class="form-control" accept="image/*">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Edit Modal -->

<!-- Delete Modal -->
<div class="modal fade" id="delete_modal" aria-hidden="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-content p-2">
                    <h4 class="modal-title">Delete</h4>
                    <p class="mb-4">Are you sure you want to delete this speciality?</p>
                    <form id="deleteForm" action="" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-primary">Yes, Delete</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Delete Modal -->


<script>
    // Populate edit modal
    document.getElementById('edit_specialities_details').addEventListener('show.bs.modal', function (event) {
        const btn = event.relatedTarget;
        const id   = btn.getAttribute('data-id');
        const name = btn.getAttribute('data-name');

        document.getElementById('editName').value = name;
        document.getElementById('editForm').action = '/agent/spcialities/' + id;
    });

    // Populate delete modal
    document.getElementById('delete_modal').addEventListener('show.bs.modal', function (event) {
        const btn = event.relatedTarget;
        const id  = btn.getAttribute('data-id');

        document.getElementById('deleteForm').action = '/agent/spcialities/' + id;
    });
</script>

@endsection
