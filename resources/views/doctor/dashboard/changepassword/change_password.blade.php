@extends('doctor.doctor_master')
@section('doctor')

<div class="dashboard-header">
    <h3>Change Password</h3>
</div>

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<form action="{{ route('doctor.change.password.post') }}" method="POST">
    @csrf
    <div class="card pass-card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">

                    {{-- Old Password --}}
                    <div class="input-block input-block-new">
                        <label class="form-label">Old Password <span class="text-danger">*</span></label>
                        <div class="pass-group">
                            <input type="password"
                                   name="old_password"
                                   class="form-control pass-input @error('old_password') is-invalid @enderror"
                                   placeholder="Enter old password"
                                   required>
                            <span class="feather-eye-off toggle-password"></span>
                        </div>
                        @error('old_password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- New Password --}}
                    <div class="input-block input-block-new">
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

                    {{-- Confirm New Password --}}
                    <div class="input-block input-block-new mb-0">
                        <label class="form-label">Confirm New Password <span class="text-danger">*</span></label>
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
        </div>
    </div>
    <div class="form-set-button">
        <a href="{{ route('doctor.profile') }}" class="btn btn-light">Cancel</a>
        <button class="btn btn-primary" type="submit">Save Changes</button>
    </div>
</form>

@endsection
