@extends('patient.patient_master')
@section('patient')

<!-- Change Password -->
<div class="col-lg-8 col-xl-9">
    <nav class="settings-tab mb-1">
        <ul class="nav nav-tabs-bottom" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link" href="{{ route('patient.setting') }}">Profile</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link active" href="{{ route('patient.change.password') }}">Change Password</a>
            </li>
        </ul>
    </nav>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="border-bottom pb-3 mb-3">
                <h5>Change Password</h5>
            </div>

            <form action="{{ route('patient.change.password.post') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">

                        {{-- Current Password --}}
                        <div class="mb-3">
                            <label class="form-label">Current Password <span class="text-danger">*</span></label>
                            <div class="pass-group">
                                <input type="password"
                                       name="old_password"
                                       class="form-control pass-input-sub @error('old_password') is-invalid @enderror"
                                       placeholder="Enter current password"
                                       required>
                                <span class="feather-eye-off toggle-password-sub"></span>
                            </div>
                            @error('old_password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- New Password --}}
                        <div class="mb-3">
                            <label class="form-label">New Password <span class="text-danger">*</span></label>
                            <div class="pass-group">
                                <input type="password"
                                       name="new_password"
                                       class="form-control pass-input @error('new_password') is-invalid @enderror"
                                       placeholder="Minimum 8 characters"
                                       required>
                                <span class="feather-eye-off toggle-password"></span>
                            </div>
                            @error('new_password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Confirm Password --}}
                        <div class="mb-3">
                            <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                            <div class="pass-group">
                                <input type="password"
                                       name="new_password_confirmation"
                                       class="form-control pass-input-sub @error('new_password_confirmation') is-invalid @enderror"
                                       placeholder="Re-enter new password"
                                       required>
                                <span class="feather-eye-off toggle-password-sub"></span>
                            </div>
                            @error('new_password_confirmation')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </div>

                <div class="modal-btn border-top pt-3 text-end">
                    <a href="{{ route('patient.change.password') }}" class="btn btn-md btn-light rounded-pill">Cancel</a>
                    <button type="submit" class="btn btn-md btn-primary-gradient rounded-pill">Save Changes</button>
                </div>
            </form>

        </div>
    </div>
</div>
<!-- /Change Password -->

@endsection
