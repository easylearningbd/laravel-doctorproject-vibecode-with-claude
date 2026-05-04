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


}
