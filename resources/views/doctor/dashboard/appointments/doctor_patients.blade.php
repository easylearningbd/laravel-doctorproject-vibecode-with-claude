@extends('doctor.doctor_master')
@section('doctor')


 

<div class="dashboard-header">
    <h3>My Patients</h3>
    <ul class="header-list-btns">
        <li>
            <div class="input-block dash-search-input">
                    <input type="text" class="form-control" placeholder="Search">
                    <span class="search-icon"><i class="isax isax-search-normal"></i></span>
                </div>
        </li>
    </ul>
</div>
<div class="appointment-tab-head">
    <div class="appointment-tabs">
        <ul class="nav nav-pills inner-tab " id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-upcoming-tab" data-bs-toggle="pill" data-bs-target="#pills-upcoming" type="button" role="tab" aria-controls="pills-upcoming" aria-selected="false">Active<span>200</span></button>
            </li>	
            
        </ul>
    </div>
     
</div>

<div class="tab-content appointment-tab-content grid-patient">
    <div class="tab-pane fade show active" id="pills-upcoming" role="tabpanel" aria-labelledby="pills-upcoming-tab">
        <div class="row">

            <!-- Appointment Grid -->
<div class="col-xl-4 col-lg-6 col-md-6 d-flex">
    <div class="appointment-wrap appointment-grid-wrap">
        <ul>
            <li>
                <div class="appointment-grid-head">
                    <div class="patinet-information">
                        <a href="patient-profile.html">
                            <img src="assets/img/doctors-dashboard/profile-01.jpg" alt="User Image">
                        </a>
                        <div class="patient-info">
                            <p>#Apt0001</p>
                            <h6><a href="{{ route('patient.details.page',3) }}">Adrian</a></h6>
                            <ul>
                                <li>Age : 42</li>
                                <li>Male</li>
                                <li>AB+</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </li>
            <li class="appointment-info">
                <p><i class="isax isax-clock5"></i>11 Nov 2024 10.45 AM</p>
                <p class="mb-0"><i class="isax isax-location5"></i>Alabama, USA</p>
            </li>
            <li class="appointment-action">
                <div class="patient-book">
                    <p><i class="isax isax-calendar-1"></i>Last Booking <span>27 Feb 2024</span></p>
                </div>
            </li>
        </ul>
    </div>
</div>
            <!-- /Appointment Grid -->

          

            <div class="col-md-12">
                <div class="loader-item text-center">
                    <a href="javascript:void(0);" class="btn btn-load">Load More</a>
                </div>
            </div>	

        </div>
    </div>
     
</div>

					 





@endsection