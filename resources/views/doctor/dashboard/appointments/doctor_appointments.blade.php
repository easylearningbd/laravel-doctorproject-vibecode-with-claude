@extends('doctor.doctor_master')
@section('doctor')



 
<div class="dashboard-header">
    <h3>Appointments</h3>
    <ul class="header-list-btns">
        <li>
            <div class="input-block dash-search-input">
                <input type="text" class="form-control" placeholder="Search">
                <span class="search-icon"><i class="isax isax-search-normal"></i></span>
            </div>
        </li>
        <li>
            <div class="view-icons">
                <a href="appointments.html" class="active"><i class="isax isax-grid-7"></i></a>
            </div>
        </li>
        <li>
            <div class="view-icons">
                <a href="doctor-appointments-grid.html"><i class="fa-solid fa-th"></i></a>
            </div>
        </li>
        <li>
            <div class="view-icons">
                <a href="#"><i class="isax isax-calendar-tick"></i></a>
            </div>
        </li>
    </ul>
</div>
<div class="appointment-tab-head">
    <div class="appointment-tabs">
        <ul class="nav nav-pills inner-tab " id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-upcoming-tab" data-bs-toggle="pill" data-bs-target="#pills-upcoming" type="button" role="tab" aria-controls="pills-upcoming" aria-selected="false">Upcoming<span>21</span></button>
            </li>	
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-cancel-tab" data-bs-toggle="pill" data-bs-target="#pills-cancel" type="button" role="tab" aria-controls="pills-cancel" aria-selected="true">Cancelled<span>16</span></button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-complete-tab" data-bs-toggle="pill" data-bs-target="#pills-complete" type="button" role="tab" aria-controls="pills-complete" aria-selected="true">Completed<span>214</span></button>
            </li>
        </ul>
    </div>
     
</div>

<div class="tab-content appointment-tab-content">
    <div class="tab-pane fade show active" id="pills-upcoming" role="tabpanel" aria-labelledby="pills-upcoming-tab">
        <!-- Appointment List -->
        <div class="appointment-wrap">
            <ul>
                <li>
                    <div class="patinet-information">
                        <a href="doctor-upcoming-appointment.html">
                            <img src="assets/img/doctors-dashboard/profile-01.jpg" alt="User Image">
                        </a>
                        <div class="patient-info">
                            <p>#Apt0001</p>
                            <h6><a href="doctor-upcoming-appointment.html">Adrian</a></h6>
                        </div>
                    </div>
                </li>
                <li class="appointment-info">
                    <p><i class="isax isax-clock5"></i>11 Nov 2024 10.45 AM</p>
                    <ul class="d-flex apponitment-types">
                        <li>General Visit</li>
                        <li>Video Call</li>
                    </ul>
                    
                </li>
                <li class="mail-info-patient">
                    <ul>
                        <li><i class="isax isax-sms5"></i>adran@example.com</li>
                        <li><i class="isax isax-call5"></i>+1 504 368 6874</li>
                    </ul>
                </li>
                <li class="appointment-action">
                    <ul>
                        <li>
                            <a href="doctor-upcoming-appointment.html"><i class="isax isax-eye4"></i></a>
                        </li>
                        <li>
                            <a href="#"><i class="isax isax-messages-25"></i></a>
                        </li>
                        <li>
                            <a href="#"><i class="isax isax-close-circle5"></i></a>
                        </li>
                    </ul>
                </li>
                <li class="appointment-start">
                    <a href="doctor-appointment-start.html" class="start-link">Start Now</a>
                </li>
            </ul>
        </div>
        <!-- /Appointment List -->
 

        <!-- Pagination -->
        <div class="pagination dashboard-pagination">
            <ul>
                <li>
                    <a href="#" class="page-link"><i class="fa-solid fa-chevron-left"></i></a>
                </li>
                <li>
                    <a href="#" class="page-link">1</a>
                </li>
                <li>
                    <a href="#" class="page-link active">2</a>
                </li>
                <li>
                    <a href="#" class="page-link">3</a>
                </li>
                <li>
                    <a href="#" class="page-link">4</a>
                </li>
                <li>
                    <a href="#" class="page-link">...</a>
                </li>
                <li>
                    <a href="#" class="page-link"><i class="fa-solid fa-chevron-right"></i></a>
                </li>
            </ul>
        </div>
        <!-- /Pagination -->

    </div>
    <div class="tab-pane fade" id="pills-cancel" role="tabpanel" aria-labelledby="pills-cancel-tab">
        <!-- Appointment List -->
        <div class="appointment-wrap">
            <ul>
                <li>
                    <div class="patinet-information">
                        <a href="doctor-cancelled-appointment.html">
                            <img src="assets/img/doctors-dashboard/profile-01.jpg" alt="User Image">
                        </a>
                        <div class="patient-info">
                            <p>#Apt0001</p>
                            <h6><a href="doctor-cancelled-appointment.html">Adrian</a></h6>
                        </div>
                    </div>
                </li>
                <li class="appointment-info">
                    <p><i class="isax isax-clock5"></i>11 Nov 2024 10.45 AM</p>
                    <ul class="d-flex apponitment-types">
                        <li>General Visit</li>
                        <li>Video Call</li>
                    </ul>
                    
                </li>
                <li class="appointment-detail-btn">
                    <a href="doctor-cancelled-appointment.html" class="start-link">View Details</a>
                </li>
            </ul>
        </div>
        <!-- /Appointment List -->

      

        <!-- Pagination -->
        <div class="pagination dashboard-pagination">
            <ul>
                <li>
                    <a href="#" class="page-link"><i class="fa-solid fa-chevron-left"></i></a>
                </li>
                <li>
                    <a href="#" class="page-link">1</a>
                </li>
                <li>
                    <a href="#" class="page-link active">2</a>
                </li>
                <li>
                    <a href="#" class="page-link">3</a>
                </li>
                <li>
                    <a href="#" class="page-link">4</a>
                </li>
                <li>
                    <a href="#" class="page-link">...</a>
                </li>
                <li>
                    <a href="#" class="page-link"><i class="fa-solid fa-chevron-right"></i></a>
                </li>
            </ul>
        </div>
        <!-- /Pagination -->
    </div>
    <div class="tab-pane fade" id="pills-complete" role="tabpanel" aria-labelledby="pills-complete-tab">
        <!-- Appointment List -->
        <div class="appointment-wrap">
            <ul>
                <li>
                    <div class="patinet-information">
                        <a href="doctor-completed-appointment.html">
                            <img src="assets/img/doctors-dashboard/profile-01.jpg" alt="User Image">
                        </a>
                        <div class="patient-info">
                            <p>#Apt0001</p>
                            <h6><a href="doctor-completed-appointment.html">Adrian</a></h6>
                        </div>
                    </div>
                </li>
                <li class="appointment-info">
                    <p><i class="isax isax-clock5"></i>11 Nov 2024 10.45 AM</p>
                    <ul class="d-flex apponitment-types">
                        <li>General Visit</li>
                        <li>Video Call</li>
                    </ul>
                    
                </li>
                <li class="appointment-detail-btn">
                    <a href="doctor-completed-appointment.html" class="start-link">View Details</a>
                </li>
            </ul>
        </div>
        <!-- /Appointment List -->

      

        <!-- Pagination -->
        <div class="pagination dashboard-pagination">
            <ul>
                <li>
                    <a href="#" class="page-link"><i class="fa-solid fa-chevron-left"></i></a>
                </li>
                <li>
                    <a href="#" class="page-link">1</a>
                </li>
                <li>
                    <a href="#" class="page-link active">2</a>
                </li>
                <li>
                    <a href="#" class="page-link">3</a>
                </li>
                <li>
                    <a href="#" class="page-link">4</a>
                </li>
                <li>
                    <a href="#" class="page-link">...</a>
                </li>
                <li>
                    <a href="#" class="page-link"><i class="fa-solid fa-chevron-right"></i></a>
                </li>
            </ul>
        </div>
        <!-- /Pagination -->
    </div>
</div>
 





@endsection