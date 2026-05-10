@extends('admin.admin_master')
@section('admin')

<div class="content container-fluid">

    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Reviews</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('agent.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Reviews</li>
                </ul>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
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
                                    <th>Patient</th>
                                    <th>Doctor</th>
                                    <th>Rating</th>
                                    <th>Review</th>
                                    <th>Recommend</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($reviews as $review)
                            @php
                                $patientPhoto = $review->patient?->profile_photo
                                    ? asset('storage/' . $review->patient->profile_photo)
                                    : asset('backend/assets/img/doctors-dashboard/profile-01.jpg');
                                $doctorPhoto  = $review->doctor?->profile_photo
                                    ? asset('storage/' . $review->doctor->profile_photo)
                                    : asset('backend/assets/img/doctors-dashboard/doctor-profile-img.jpg');
                            @endphp
                            <tr>
                                <td>
                                    <h2 class="table-avatar">
                                        <a href="#" class="avatar avatar-sm me-2">
                                            <img class="avatar-img rounded-circle"
                                                 src="{{ $patientPhoto }}"
                                                 alt="{{ $review->patient?->first_name }}">
                                        </a>
                                        <a href="#">
                                            {{ $review->patient?->first_name }}
                                            {{ $review->patient?->last_name }}
                                        </a>
                                    </h2>
                                </td>
                                <td>
                                    <h2 class="table-avatar">
                                        <a href="#" class="avatar avatar-sm me-2">
                                            <img class="avatar-img rounded-circle"
                                                 src="{{ $doctorPhoto }}"
                                                 alt="{{ $review->doctor?->first_name }}">
                                        </a>
                                        <a href="#">
                                            Dr. {{ $review->doctor?->first_name }}
                                            {{ $review->doctor?->last_name }}
                                        </a>
                                    </h2>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-1">
                                        @for($s = 1; $s <= 5; $s++)
                                            <i class="fe fe-star {{ $s <= $review->rating ? 'text-warning' : 'text-secondary' }}"></i>
                                        @endfor
                                        <span class="ms-1 fw-semibold">{{ $review->rating }}.0</span>
                                    </div>
                                </td>
                                <td style="max-width:260px;">
                                    {{ $review->comment ? \Illuminate\Support\Str::limit($review->comment, 80) : '—' }}
                                </td>
                                <td>
                                    @if($review->recommend)
                                        <span class="badge bg-success-light text-success">
                                            <i class="fe fe-thumbs-up me-1"></i>Yes
                                        </span>
                                    @else
                                        <span class="badge bg-danger-light text-danger">No</span>
                                    @endif
                                </td>
                                <td>
                                    {{ $review->created_at->format('d M Y') }}<br>
                                    <small class="text-muted">{{ $review->created_at->format('h:i A') }}</small>
                                </td>
                                <td>
                                    <div class="actions">
                                        <a class="btn btn-sm bg-danger-light"
                                           href="javascript:void(0);"
                                           data-bs-toggle="modal"
                                           data-bs-target="#delete_modal"
                                           data-id="{{ $review->id }}"
                                           data-name="{{ $review->patient?->first_name }} {{ $review->patient?->last_name }}">
                                            <i class="fe fe-trash"></i> Delete
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">No reviews yet.</td>
                            </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($reviews->hasPages())
                    <div class="mt-3 d-flex justify-content-center">
                        {{ $reviews->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Delete Modal -->
<div class="modal fade" id="delete_modal" aria-hidden="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-content p-2">
                    <h4 class="modal-title">Delete Review</h4>
                    <p class="mb-4">
                        Are you sure you want to delete the review by
                        <strong id="deletePatientName"></strong>?
                    </p>
                    <form id="deleteReviewForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(function () {
    $('#delete_modal').on('show.bs.modal', function (e) {
        var btn = $(e.relatedTarget);
        var id  = btn.data('id');
        var name = btn.data('name');
        $('#deletePatientName').text(name);
        $('#deleteReviewForm').attr('action', '{{ url("agent/reviews") }}/' + id);
    });
});
</script>
@endpush
