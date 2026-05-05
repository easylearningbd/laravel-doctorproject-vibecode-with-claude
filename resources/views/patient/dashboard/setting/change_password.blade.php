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
<div class="card">
    <div class="card-body">
        <div class="border-bottom pb-3 mb-3">
            <h5>Change Password</h5>
        </div>
        <form action="change-password.html">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Current Password <span class="text-danger">*</span></label>
                        <div class="pass-group">
                            <input type="password" class="form-control pass-input-sub">
                            <span class="feather-eye-off toggle-password-sub"></span>
                        </div>									
                    </div>
                    <div class="mb-3">
                        <label class="form-label">New Password <span class="text-danger">*</span></label>
                        <div class="pass-group">
                            <input type="password" class="form-control pass-input">
                            <span class="feather-eye-off toggle-password"></span>
                        </div>									
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                        <div class="pass-group">
                            <input type="password" class="form-control pass-input-sub">
                            <span class="feather-eye-off toggle-password-sub"></span>
                        </div>									
                    </div>
                </div>
            </div>
            <div class="modal-btn border-top pt-3 text-end">
                <a href="#" class="btn btn-md btn-light rounded-pill">Cancel</a>
                <button type="submit" class="btn btn-md btn-primary-gradient rounded-pill">Save Changes</button>
            </div>
        </form>
    </div>
</div>
</div>
<!-- /Change Password -->





@endsection