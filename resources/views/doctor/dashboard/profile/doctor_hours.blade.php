@extends('doctor.doctor_master')
@section('doctor')

	<!-- Profile Settings -->
<div class="dashboard-header">
    <h3>Profile Settings</h3>
</div>

<!-- Settings List -->
<div class="setting-tab">
    <div class="appointment-tabs">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link " href="{{ route('doctor.profile') }}">Basic Details</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('doctor.experience') }}">Experience</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('doctor.education') }}">Education</a>
            </li>
             
            <li class="nav-item">
                <a class="nav-link" href="{{ route('doctor.clinics') }}">Clinics</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="{{ route('doctor.hours') }}">Business Hours</a>
            </li>
        </ul>
    </div>
</div>
<!-- /Settings List -->

<div class="dashboard-header border-0 mb-0">
    <h3>Business Hours</h3>
</div>

<form action="doctor-business-settings.html">
    <div class="business-wrap">
        <h4>Select Business days</h4>
        <ul class="business-nav">
            <li>
                <a class="tab-link active" data-tab="day-monday">Monday</a>
            </li>
            <li>
                <a class="tab-link active" data-tab="day-tuesday">Tuesday</a>
            </li>
            <li>
                <a class="tab-link active" data-tab="day-wednesday">Wednesday</a>
            </li>
            <li>
                <a class="tab-link active" data-tab="day-thursday">Thursday</a>
            </li>
            <li>
                <a class="tab-link active" data-tab="day-friday">Friday</a>
            </li>
            <li>
                <a class="tab-link" data-tab="day-saturday">Saturday</a>
            </li>
            <li>
                <a class="tab-link" data-tab="day-sunday">Sunday</a>
            </li>
        </ul>
    </div>

    <div class="accordions business-info" id="list-accord">

        <!-- Business Hours -->
        <div class="user-accordion-item tab-items active" id="day-monday">
            <a href="#" class="accordion-wrap" data-bs-toggle="collapse" data-bs-target="#monday">Monday<span class="edit">Edit</span></a>
            <div class="accordion-collapse collapse show" id="monday" data-bs-parent="#list-accord">
                <div class="content-collapse pb-0">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="form-wrap">
                                <label class="col-form-label">From <span class="text-danger">*</span></label>
                                <div class="form-icon">
                                    <input type="text" class="form-control timepicker1">
                                    <span class="icon"><i class="fa-solid fa-clock"></i></span>
                                </div>
                            </div>													
                        </div>
                        <div class="col-md-6">
                            <div class="form-wrap">
                                <label class="col-form-label">To <span class="text-danger">*</span></label>
                                <div class="form-icon">
                                    <input type="text" class="form-control timepicker1">
                                    <span class="icon"><i class="fa-solid fa-clock"></i></span>
                                </div>
                            </div>													
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Business Hours -->

        <!-- Business Hours -->
        <div class="user-accordion-item tab-items active" id="day-tuesday">
            <a href="#" class="accordion-wrap collapsed" data-bs-toggle="collapse" data-bs-target="#tuesday">Tuesday<span class="edit">Edit</span></a>
            <div class="accordion-collapse collapse" id="tuesday" data-bs-parent="#list-accord">
                <div class="content-collapse pb-0">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="form-wrap">
                                <label class="col-form-label">From <span class="text-danger">*</span></label>
                                <div class="form-icon">
                                    <input type="text" class="form-control timepicker1">
                                    <span class="icon"><i class="fa-solid fa-clock"></i></span>
                                </div>
                            </div>													
                        </div>
                        <div class="col-md-6">
                            <div class="form-wrap">
                                <label class="col-form-label">To <span class="text-danger">*</span></label>
                                <div class="form-icon">
                                    <input type="text" class="form-control timepicker1">
                                    <span class="icon"><i class="fa-solid fa-clock"></i></span>
                                </div>
                            </div>													
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Business Hours -->

        <!-- Business Hours -->
        <div class="user-accordion-item tab-items active" id="day-wednesday">
            <a href="#" class="accordion-wrap collapsed" data-bs-toggle="collapse" data-bs-target="#wednesday">Wednesday<span class="edit">Edit</span></a>
            <div class="accordion-collapse collapse" id="wednesday" data-bs-parent="#list-accord">
                <div class="content-collapse pb-0">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="form-wrap">
                                <label class="col-form-label">From <span class="text-danger">*</span></label>
                                <div class="form-icon">
                                    <input type="text" class="form-control timepicker1">
                                    <span class="icon"><i class="fa-solid fa-clock"></i></span>
                                </div>
                            </div>													
                        </div>
                        <div class="col-md-6">
                            <div class="form-wrap">
                                <label class="col-form-label">To <span class="text-danger">*</span></label>
                                <div class="form-icon">
                                    <input type="text" class="form-control timepicker1">
                                    <span class="icon"><i class="fa-solid fa-clock"></i></span>
                                </div>
                            </div>													
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Business Hours -->

        <!-- Business Hours -->
        <div class="user-accordion-item tab-items active" id="day-thursday">
            <a href="#" class="accordion-wrap collapsed" data-bs-toggle="collapse" data-bs-target="#thursday">Thursday<span class="edit">Edit</span></a>
            <div class="accordion-collapse collapse" id="thursday" data-bs-parent="#list-accord">
                <div class="content-collapse pb-0">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="form-wrap">
                                <label class="col-form-label">From <span class="text-danger">*</span></label>
                                <div class="form-icon">
                                    <input type="text" class="form-control timepicker1">
                                    <span class="icon"><i class="fa-solid fa-clock"></i></span>
                                </div>
                            </div>													
                        </div>
                        <div class="col-md-6">
                            <div class="form-wrap">
                                <label class="col-form-label">To <span class="text-danger">*</span></label>
                                <div class="form-icon">
                                    <input type="text" class="form-control timepicker1">
                                    <span class="icon"><i class="fa-solid fa-clock"></i></span>
                                </div>
                            </div>													
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Business Hours -->

        <!-- Business Hours -->
        <div class="user-accordion-item tab-items active" id="day-friday">
            <a href="#" class="accordion-wrap collapsed" data-bs-toggle="collapse" data-bs-target="#friday">Friday<span class="edit">Edit</span></a>
            <div class="accordion-collapse collapse" id="friday" data-bs-parent="#list-accord">
                <div class="content-collapse pb-0">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="form-wrap">
                                <label class="col-form-label">From <span class="text-danger">*</span></label>
                                <div class="form-icon">
                                    <input type="text" class="form-control timepicker1">
                                    <span class="icon"><i class="fa-solid fa-clock"></i></span>
                                </div>
                            </div>													
                        </div>
                        <div class="col-md-6">
                            <div class="form-wrap">
                                <label class="col-form-label">To <span class="text-danger">*</span></label>
                                <div class="form-icon">
                                    <input type="text" class="form-control timepicker1">
                                    <span class="icon"><i class="fa-solid fa-clock"></i></span>
                                </div>
                            </div>													
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Business Hours -->

        <!-- Business Hours -->
        <div class="user-accordion-item tab-items" id="day-saturday">
            <a href="#" class="accordion-wrap collapsed" data-bs-toggle="collapse" data-bs-target="#saturday">Saturday<span class="edit">Edit</span></a>
            <div class="accordion-collapse collapse" id="saturday" data-bs-parent="#list-accord">
                <div class="content-collapse pb-0">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="form-wrap">
                                <label class="col-form-label">From <span class="text-danger">*</span></label>
                                <div class="form-icon">
                                    <input type="text" class="form-control timepicker1">
                                    <span class="icon"><i class="fa-solid fa-clock"></i></span>
                                </div>
                            </div>													
                        </div>
                        <div class="col-md-6">
                            <div class="form-wrap">
                                <label class="col-form-label">To <span class="text-danger">*</span></label>
                                <div class="form-icon">
                                    <input type="text" class="form-control timepicker1">
                                    <span class="icon"><i class="fa-solid fa-clock"></i></span>
                                </div>
                            </div>													
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Business Hours -->

        <!-- Business Hours -->
        <div class="user-accordion-item tab-items" id="day-sunday">
            <a href="#" class="accordion-wrap collapsed" data-bs-toggle="collapse" data-bs-target="#sunday">Sunday<span class="edit">Edit</span></a>
            <div class="accordion-collapse collapse" id="sunday" data-bs-parent="#list-accord">
                <div class="content-collapse pb-0">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="form-wrap">
                                <label class="col-form-label">From <span class="text-danger">*</span></label>
                                <div class="form-icon">
                                    <input type="text" class="form-control timepicker1">
                                    <span class="icon"><i class="fa-solid fa-clock"></i></span>
                                </div>
                            </div>													
                        </div>
                        <div class="col-md-6">
                            <div class="form-wrap">
                                <label class="col-form-label">To <span class="text-danger">*</span></label>
                                <div class="form-icon">
                                    <input type="text" class="form-control timepicker1">
                                    <span class="icon"><i class="fa-solid fa-clock"></i></span>
                                </div>
                            </div>													
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Business Hours -->

    </div>
    
    <div class="modal-btn text-end">
        <a href="#" class="btn btn-gray">Cancel</a>
        <button type="submit" class="btn btn-primary prime-btn">Save Changes</button>
    </div>

</form>
<!-- /Profile Settings -->
 
@endsection