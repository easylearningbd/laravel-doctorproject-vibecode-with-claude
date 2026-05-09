@extends('admin.admin_master')
@section('admin')

<div class="content container-fluid">

    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Payment Requests</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('agent.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Payment Requests</li>
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
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Summary cards --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-warning">
                <div class="card-body d-flex align-items-center gap-3">
                    <i class="fa fa-clock fs-2 text-warning"></i>
                    <div>
                        <p class="mb-0 text-muted">Pending</p>
                        <h4 class="mb-0">{{ $requests->where('status','pending')->count() }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-success">
                <div class="card-body d-flex align-items-center gap-3">
                    <i class="fa fa-check-circle fs-2 text-success"></i>
                    <div>
                        <p class="mb-0 text-muted">Approved</p>
                        <h4 class="mb-0">{{ $requests->where('status','approved')->count() }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-danger">
                <div class="card-body d-flex align-items-center gap-3">
                    <i class="fa fa-times-circle fs-2 text-danger"></i>
                    <div>
                        <p class="mb-0 text-muted">Cancelled</p>
                        <h4 class="mb-0">{{ $requests->where('status','cancelled')->count() }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="datatable table table-hover table-center mb-0">
                            <thead>
                                <tr>
                                    <th>Request ID</th>
                                    <th>Doctor</th>
                                    <th>Amount</th>
                                    <th>Requested On</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse ($requests as $req)
                            @php
                                $doctor = $req->doctor;
                                $photo  = $doctor?->profile_photo
                                    ? asset('storage/' . $doctor->profile_photo)
                                    : asset('backend/assets/img/doctors-dashboard/profile-01.jpg');
                                $badgeClass = match($req->status) {
                                    'approved'  => 'badge-success',
                                    'cancelled' => 'badge-danger',
                                    default     => 'badge-warning',
                                };
                            @endphp
                            <tr>
                                <td><span class="text-primary fw-medium">#{{ $req->request_number }}</span></td>
                                <td>
                                    <h2 class="table-avatar">
                                        <a href="#" class="avatar avatar-sm me-2">
                                            <img class="avatar-img rounded-circle" src="{{ $photo }}"
                                                 alt="{{ $doctor?->first_name }}">
                                        </a>
                                        <a href="#">Dr. {{ $doctor?->first_name }} {{ $doctor?->last_name }}</a>
                                    </h2>
                                </td>
                                <td class="fw-semibold">${{ number_format($req->amount, 2) }}</td>
                                <td>{{ $req->created_at->format('d M Y') }}</td>
                                <td>
                                    <span class="badge {{ $badgeClass }}">{{ ucfirst($req->status) }}</span>
                                </td>
                                <td>
                                    @if($req->status === 'pending')
                                    <div class="d-flex gap-2">
                                        {{-- Approve --}}
                                        <form method="POST"
                                              action="{{ route('agent.payment.requests.action', $req->id) }}"
                                              onsubmit="return confirm('Approve this payment request of ${{ number_format($req->amount,2) }}?')">
                                            @csrf
                                            <input type="hidden" name="action" value="approved">
                                            <button type="submit" class="btn btn-sm btn-success rounded-pill">
                                                <i class="fa fa-check me-1"></i>Approve
                                            </button>
                                        </form>
                                        {{-- Cancel --}}
                                        <button type="button" class="btn btn-sm btn-danger rounded-pill"
                                                data-bs-toggle="modal"
                                                data-bs-target="#cancelModal"
                                                data-id="{{ $req->id }}"
                                                data-number="{{ $req->request_number }}"
                                                data-amount="{{ number_format($req->amount,2) }}">
                                            <i class="fa fa-times me-1"></i>Cancel
                                        </button>
                                    </div>
                                    @else
                                    <span class="text-muted fs-13">
                                        {{ $req->status === 'approved' ? 'Credited: ' . $req->credited_on?->format('d M Y') : 'Cancelled' }}
                                    </span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">No payment requests yet.</td>
                            </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($requests->hasPages())
                    <div class="mt-3 d-flex justify-content-center">{{ $requests->links() }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>

{{-- Cancel modal --}}
<div class="modal fade" id="cancelModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger">Cancel Payment Request</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="cancelForm" method="POST">
                @csrf
                <input type="hidden" name="action" value="cancelled">
                <div class="modal-body">
                    <p>Cancelling request <strong id="cancelNumber"></strong> for <strong id="cancelAmount"></strong>.</p>
                    <div class="mb-3">
                        <label class="form-label">Reason (optional)</label>
                        <textarea name="admin_note" class="form-control" rows="3"
                                  placeholder="Reason for cancellation..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Confirm Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(function () {
    $('#cancelModal').on('show.bs.modal', function (e) {
        var btn = $(e.relatedTarget);
        $('#cancelForm').attr('action', '{{ url("agent/payment-requests") }}/' + btn.data('id') + '/action');
        $('#cancelNumber').text('#' + btn.data('number'));
        $('#cancelAmount').text('$' + btn.data('amount'));
    });
});
</script>
@endpush
