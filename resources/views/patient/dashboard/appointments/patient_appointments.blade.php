@extends('patient.patient_master')
@section('patient')


<div class="col-lg-8 col-xl-9">
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
                <a href="patient-appointments.html" class="active"><i class="isax isax-grid-7"></i></a>
            </div>
        </li>
        <li>
            <div class="view-icons">
                <a href="patient-appointments-grid.html"><i class="fa-solid fa-th"></i></a>
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
                        <a href="patient-upcoming-appointment.html">
                            <img src="assets/img/doctors/doctor-thumb-21.jpg" alt="User Image">
                        </a>
                        <div class="patient-info">
                            <p>#Apt0001</p>
                            <h6><a href="patient-upcoming-appointment.html">Dr Edalin</a></h6>
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
                        <li><i class="isax isax-sms5"></i>edalin@example.com</li>
                        <li><i class="isax isax-call5"></i>+1 504 368 6874</li>
                    </ul>
                </li>
                <li class="appointment-action">
                    <ul>
                        <li>
                            <a href="patient-upcoming-appointment.html"><i class="isax isax-eye4"></i></a>
                        </li>
                        <li>
                            <a href="#"><i class="isax isax-messages-25"></i></a>
                        </li>
                        <li>
                            <a href="#"><i class="isax isax-close-circle5"></i></a>
                        </li>
                    </ul>
                </li>
                <li class="appointment-detail-btn">
                    <a href="#" class="btn btn-md btn-primary-gradient"><i class="isax isax-calendar-tick5 me-1"></i>Attend</a>
                </li>
            </ul>
        </div>
        <!-- /Appointment List -->

        

        <!-- Pagination -->
        <div class="pagination dashboard-pagination">
            <ul>
                <li>
                    <a href="#" class="page-link prev">Prev</a>
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
                    <a href="#" class="page-link next">Next</a>
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
                        <a href="patient-cancelled-appointment.html">
                            <img src="assets/img/doctors/doctor-thumb-21.jpg" alt="User Image">
                        </a>
                        <div class="patient-info">
                            <p>#Apt00011</p>
                            <h6><a href="patient-cancelled-appointment.html">Dr Edalin</a></h6>
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
                        <li><i class="isax isax-sms5"></i>edalin@example.com</li>
                        <li><i class="isax isax-call5"></i>+1 504 368 6874</li>
                    </ul>
                </li>
                <li class="appointment-detail-btn">
                    <a href="patient-cancelled-appointment.html" class="btn btn-md btn-primary-gradient"><i class="isax isax-calendar-tick5 me-1"></i>Reschedule</a>
                </li>
            </ul>
        </div>
        <!-- /Appointment List -->

      

        <!-- Pagination -->
        <div class="pagination dashboard-pagination">
            <ul>
                <li>
                    <a href="#" class="page-link prev">Prev</a>
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
                    <a href="#" class="page-link next">Next</a>
                </li>
            </ul>
        </div>
        <!-- /Pagination -->
    </div>
     
</div>

</div>





@endsection
