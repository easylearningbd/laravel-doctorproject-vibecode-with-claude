@extends('patient.patient_master')
@section('patient')


<div class="col-lg-8 col-xl-9">

<div class="dashboard-header">
    <h3>Favourites</h3>
    <ul class="header-list-btns">
        <li>
            <div class="input-block dash-search-input">
                <input type="text" class="form-control" placeholder="Search">
                <span class="search-icon"><i class="isax isax-search-normal"></i></span>
            </div>
        </li>
    </ul>
</div>

<!-- Favourites -->
<div class="row">
    <div class="col-md-6 col-lg-4 d-flex">
        <div class="profile-widget patient-favour flex-fill">
            <div class="fav-head">
                <a href="javascript:void(0)" class="fav-btn favourite-btn">
                    <span class="favourite-icon favourite"><i class="isax isax-heart5"></i></span>
                </a>
                <div class="doc-img">
                    <a href="doctor-profile.html">
                        <img class="img-fluid" alt="User Image" src="assets/img/doctors/doctor-thumb-21.jpg">
                    </a>
                </div>
                <div class="pro-content">
                    <h3 class="title">
                        <a href="doctor-profile.html">Dr.Edalin Hendry</a> 
                        <i class="isax isax-tick-circle5 verified"></i>
                    </h3>
                    <p class="speciality">MD - Cardiology</p>
                    <div class="rating">
                        <i class="fas fa-star filled"></i>
                        <i class="fas fa-star filled"></i>
                        <i class="fas fa-star filled"></i>
                        <i class="fas fa-star filled"></i>
                        <i class="fas fa-star filled"></i>
                        <span class="d-inline-block average-rating">5.0</span>
                    </div>
                    <ul class="available-info">
                        <li>
                            <i class="isax isax-calendar5 me-1"></i><span>Next Availability :</span> 23 Mar 2024
                        </li>
                        <li>
                            <i class="isax isax-location5 me-1"></i><span>Location :</span> Newyork, USA
                        </li>
                    </ul>
                    <div class="last-book">
                        <p>Last Book on 21 Jan 2023</p>
                    </div>
                </div>
            </div>
            <div class="fav-footer">
                <div class="row row-sm">
                    <div class="col-6">
                        <a href="doctor-profile.html" class="btn btn-md btn-light w-100">View Details</a>
                    </div>
                    <div class="col-6">
                        <a href="booking.html" class="btn btn-md btn-outline-primary w-100">Book Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    							
    
</div>
<!-- /Favourites -->

<div class="col-md-12">
    <div class="loader-item text-center mt-0">
        <a href="javascript:void(0);" class="btn btn-outline-primary rounded-pill">Load More</a>
    </div>
</div>	

</div>



@endsection