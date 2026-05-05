<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
     public function PatientLogout(Request $request) {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }



    public function PatientSetting(){
    return view('patient.dashboard.setting.patient_setting');
    }
    // End Method 

    public function PatientChangePassword(){
    return view('patient.dashboard.setting.change_password');
    }
    // End Method 

 

} 
