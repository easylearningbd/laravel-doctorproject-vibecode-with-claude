@extends('doctor.doctor_master')
@section('doctor')

@php
    $bankMasked = $bankAccount ? ('XXXX XXXX XXXX ' . substr(preg_replace('/\s+/','',$bankAccount->account_number), -4)) : null;
@endphp

<div class="accunts-sec">
    <div class="dashboard-header">
        <div class="header-back">
            <h3>Accounts</h3>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3">
            {{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-3">
            {{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mb-3">
            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="account-details-box">
        <div class="row">

            {{-- Statistics + Request Payment --}}
            <div class="col-xxl-6 col-lg-7">
                <div class="account-payment-info">
                    <h4>Statistics</h4>
                    <div class="row">
                        <div class="col-lg-4 col-md-6">
                            <div class="payment-amount">
                                <h6><i class="fa-solid fa-file-invoice-dollar text-success"></i>Total Balance</h6>
                                <span>${{ number_format($totalBalance, 2) }}</span>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="payment-amount">
                                <h6><i class="fa-solid fa-money-bill-1 text-orange"></i>Earned</h6>
                                <span>${{ number_format($earned, 2) }}</span>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="payment-amount">
                                <h6><i class="fa-solid fa-circle-question text-pink"></i>Requested</h6>
                                <span>${{ number_format($requested, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="payment-request">
                        @if($lastRequest)
                            <span>Last Request : {{ $lastRequest->created_at->format('d M Y') }}
                                &mdash;
                                <span class="badge {{ $lastRequest->status === 'pending' ? 'badge-yellow' : ($lastRequest->status === 'approved' ? 'badge-success' : 'badge-danger') }}">
                                    {{ ucfirst($lastRequest->status) }}
                                </span>
                            </span>
                        @else
                            <span>No payment requests yet.</span>
                        @endif

                        @if($available > 0 && $bankAccount)
                            <a href="#payment_request" class="btn btn-primary prime-btn" data-bs-toggle="modal">
                                Request Payment
                            </a>
                        @elseif(!$bankAccount)
                            <a href="#account_details" class="btn btn-warning prime-btn" data-bs-toggle="modal">
                                Add Bank Account First
                            </a>
                        @else
                            <button class="btn btn-secondary prime-btn" disabled title="No available balance">
                                Request Payment
                            </button>
                        @endif
                    </div>

                    @if($available > 0)
                    <p class="text-muted fs-13 mt-1">
                        Available for withdrawal: <strong class="text-success">${{ number_format($available, 2) }}</strong>
                    </p>
                    @endif
                </div>
            </div>

            <div class="col-xxl-1 d-lg-none d-xxl-block"></div>

            {{-- Bank Details --}}
            <div class="col-lg-5">
                <div class="bank-details-info">
                    <h3>Bank Details</h3>
                    @if($bankAccount)
                    <ul>
                        <li>
                            <h6>Bank Name</h6>
                            <h5>{{ $bankAccount->bank_name }}</h5>
                        </li>
                        <li>
                            <h6>Account Number</h6>
                            <h5>{{ $bankMasked }}</h5>
                        </li>
                        <li>
                            <h6>Branch Name</h6>
                            <h5>{{ $bankAccount->branch_name ?: '—' }}</h5>
                        </li>
                        <li>
                            <h6>Account Name</h6>
                            <h5>{{ $bankAccount->account_name }}</h5>
                        </li>
                    </ul>
                    @else
                    <p class="text-muted py-3">No bank account added yet.</p>
                    @endif
                    <div class="edit-detail-link">
                        <a href="#account_details" data-bs-toggle="modal">Edit Or Add Account Details</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- Payment Requests Table --}}
<div class="row">
    <div class="col-sm-12">
        <div class="account-detail-table">
            <nav class="accounts-tab">
                <ul class="nav nav-tabs-bottom">
                    <li class="nav-item">
                        <a class="nav-link active" href="#pat_accounts" data-bs-toggle="tab">Payment Requests</a>
                    </li>
                </ul>
            </nav>

            <div class="tab-content pt-0">
                <div id="pat_accounts" class="tab-pane fade show active">
                    <div class="custom-new-table">
                        <div class="table-responsive">
                            <table class="table table-hover table-center mb-0">
                                <thead>
                                    <tr>
                                        <th>Request ID</th>
                                        <th>Requested Date</th>
                                        <th>Account No</th>
                                        <th>Credited On</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @forelse ($paymentRequests as $req)
                                @php
                                    $badgeClass = match($req->status) {
                                        'approved'  => 'badge-success-bg',
                                        'cancelled' => 'badge-danger-bg',
                                        default     => 'badge-warning-bg',
                                    };
                                @endphp
                                <tr>
                                    <td>
                                        <a href="javascript:void(0);" class="text-blue view-req-btn"
                                           data-id="{{ $req->id }}"
                                           data-number="{{ $req->request_number }}"
                                           data-amount="{{ number_format($req->amount,2) }}"
                                           data-date="{{ $req->created_at->format('d M Y') }}"
                                           data-credited="{{ $req->credited_on?->format('d M Y') ?? '—' }}"
                                           data-status="{{ $req->status }}"
                                           data-description="{{ $req->description }}"
                                           data-admin-note="{{ $req->admin_note }}"
                                           data-bank="{{ $bankMasked ?? '—' }}"
                                           data-bank-name="{{ $bankAccount?->bank_name ?? '—' }}"
                                           data-branch="{{ $bankAccount?->branch_name ?? '—' }}"
                                           data-bs-toggle="modal" data-bs-target="#request_details_modal">
                                            #{{ $req->request_number }}
                                        </a>
                                    </td>
                                    <td>{{ $req->created_at->format('d M Y') }}</td>
                                    <td>{{ $bankMasked ?? '—' }}</td>
                                    <td>{{ $req->credited_on?->format('d M Y') ?? '—' }}</td>
                                    <td>${{ number_format($req->amount, 2) }}</td>
                                    <td>
                                        <span class="badge {{ $badgeClass }}">{{ ucfirst($req->status) }}</span>
                                    </td>
                                    <td>
                                        <a href="javascript:void(0);"
                                           class="account-action view-req-btn"
                                           data-id="{{ $req->id }}"
                                           data-number="{{ $req->request_number }}"
                                           data-amount="{{ number_format($req->amount,2) }}"
                                           data-date="{{ $req->created_at->format('d M Y') }}"
                                           data-credited="{{ $req->credited_on?->format('d M Y') ?? '—' }}"
                                           data-status="{{ $req->status }}"
                                           data-description="{{ $req->description }}"
                                           data-admin-note="{{ $req->admin_note }}"
                                           data-bank="{{ $bankMasked ?? '—' }}"
                                           data-bank-name="{{ $bankAccount?->bank_name ?? '—' }}"
                                           data-branch="{{ $bankAccount?->branch_name ?? '—' }}"
                                           data-bs-toggle="modal" data-bs-target="#request_details_modal">
                                            <i class="isax isax-link-2"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">
                                        No payment requests yet.
                                    </td>
                                </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    @if($paymentRequests->hasPages())
                    <div class="mt-3 d-flex justify-content-center">
                        {{ $paymentRequests->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>


{{-- ============================================================
     MODALS
============================================================ --}}

{{-- Payment Request Modal --}}
<div class="modal fade custom-modal custom-modal-two modal-lg" id="payment_request">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Payment Request
                    <small class="text-muted fs-13">Available: <strong class="text-success">${{ number_format($available, 2) }}</strong></small>
                </h5>
                <button type="button" data-bs-dismiss="modal" aria-label="Close">
                    <span><i class="fa-solid fa-x"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('doctor.payment.request') }}" method="POST">
                    @csrf
                    <div class="input-block input-block-new">
                        <label class="form-label">Request Amount <span class="text-danger">*</span>
                            <small class="text-muted">(max ${{ number_format($available, 2) }})</small>
                        </label>
                        <input type="number" name="amount" class="form-control" step="0.01"
                               min="1" max="{{ $available }}" placeholder="Enter amount" required>
                    </div>
                    <div class="input-block input-block-new">
                        <label class="form-label">Description</label>
                        <textarea name="description" rows="3" class="form-control"
                                  placeholder="Optional note..."></textarea>
                    </div>
                    <div class="form-set-button">
                        <button class="btn btn-light" type="button" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary" type="submit">Submit Request</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Account Details Modal --}}
<div class="modal fade custom-modal custom-modal-two modal-lg" id="account_details">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Account Details</h5>
                <button type="button" data-bs-dismiss="modal" aria-label="Close">
                    <span><i class="fa-solid fa-x"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('doctor.accounts.post') }}" method="POST">
                    @csrf
                    <div class="input-block input-block-new">
                        <label class="form-label">Bank Name <span class="text-danger">*</span></label>
                        <input type="text" name="bank_name" class="form-control"
                               value="{{ $bankAccount?->bank_name }}" required placeholder="e.g. Citi Bank">
                    </div>
                    <div class="input-block input-block-new">
                        <label class="form-label">Branch Name</label>
                        <input type="text" name="branch_name" class="form-control"
                               value="{{ $bankAccount?->branch_name }}" placeholder="e.g. London">
                    </div>
                    <div class="input-block input-block-new">
                        <label class="form-label">Account Number <span class="text-danger">*</span></label>
                        <input type="text" name="account_number" class="form-control"
                               value="{{ $bankAccount?->account_number }}" required
                               placeholder="e.g. 1234567890">
                    </div>
                    <div class="input-block input-block-new">
                        <label class="form-label">Account Name <span class="text-danger">*</span></label>
                        <input type="text" name="account_name" class="form-control"
                               value="{{ $bankAccount?->account_name }}" required
                               placeholder="Account holder name">
                    </div>
                    <div class="form-set-button">
                        <button class="btn btn-light" type="button" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary" type="submit">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Request Details Modal (dynamic) --}}
<div class="modal fade custom-modal custom-modal-two" id="request_details_modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Request Details
                    <span id="reqStatusBadge" class="badge ms-2"></span>
                </h5>
                <button type="button" data-bs-dismiss="modal" aria-label="Close">
                    <span><i class="fa-solid fa-x"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <div class="completed-request">
                    <ul>
                        <li>
                            <h6>ID</h6>
                            <span id="reqNumber"></span>
                        </li>
                        <li>
                            <h6>Requested on</h6>
                            <span id="reqDate"></span>
                        </li>
                        <li>
                            <h6>Credited Date</h6>
                            <span id="reqCredited"></span>
                        </li>
                        <li>
                            <h6>Amount</h6>
                            <span id="reqAmount" class="text-blue fw-semibold"></span>
                        </li>
                    </ul>
                    <div class="bank-detail">
                        <h4>Bank Details</h4>
                        <div class="accont-information">
                            <h6>Bank Name</h6>
                            <span id="reqBankName"></span>
                        </div>
                        <div class="accont-information">
                            <h6>Account No</h6>
                            <span id="reqBankAcct"></span>
                        </div>
                        <div class="accont-information">
                            <h6>Branch</h6>
                            <span id="reqBranch"></span>
                        </div>
                    </div>
                    <div class="request-des" id="reqDescSection">
                        <h4>Request Description</h4>
                        <p id="reqDesc"></p>
                    </div>
                    <div class="request-des d-none" id="reqAdminNoteSection">
                        <h4>Admin Note</h4>
                        <p id="reqAdminNote" class="text-danger"></p>
                    </div>
                    <a href="#" class="btn btn-primary prime-btn w-100 mt-2" data-bs-dismiss="modal">Close</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(function () {
    $('#request_details_modal').on('show.bs.modal', function (e) {
        var btn = $(e.relatedTarget);

        var status  = btn.data('status');
        var badge   = $('#reqStatusBadge');

        badge.removeClass('badge-success badge-danger badge-warning badge-yellow');
        if (status === 'approved') {
            badge.addClass('badge-success').text('Approved');
        } else if (status === 'cancelled') {
            badge.addClass('badge-danger').text('Cancelled');
        } else {
            badge.addClass('badge-warning').text('Pending');
        }

        $('#reqNumber').text('#' + btn.data('number'));
        $('#reqDate').text(btn.data('date'));
        $('#reqCredited').text(btn.data('credited') || '—');
        $('#reqAmount').text('$' + btn.data('amount'));
        $('#reqBankName').text(btn.data('bank-name'));
        $('#reqBankAcct').text(btn.data('bank'));
        $('#reqBranch').text(btn.data('branch'));

        var desc = btn.data('description');
        if (desc) {
            $('#reqDescSection').removeClass('d-none');
            $('#reqDesc').text(desc);
        } else {
            $('#reqDescSection').addClass('d-none');
        }

        var note = btn.data('admin-note');
        if (note) {
            $('#reqAdminNoteSection').removeClass('d-none');
            $('#reqAdminNote').text(note);
        } else {
            $('#reqAdminNoteSection').addClass('d-none');
        }
    });
});
</script>
@endpush
