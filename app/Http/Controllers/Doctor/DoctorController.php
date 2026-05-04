<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
   public function DoctorDashboard(){
    return view('doctor.index');
   }
    // End Method 

  public function DoctorProfile(){
    return view('doctor.dashboard.profile.doctor_profile');
   }
    // End Method 

   public function DoctorExperience(){
    return view('doctor.dashboard.profile.doctor_experience');
   }
    // End Method 

     public function DoctorEducation(){
    return view('doctor.dashboard.profile.doctor_education');
   }
    // End Method 

  public function DoctorClinics(){
    return view('doctor.dashboard.profile.doctor_clinics');
   }
    // End Method 

  public function DoctorHours(){
    return view('doctor.dashboard.profile.doctor_hours');
   }
    // End Method 


}
