<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function AdminDashboard(){
    return view('admin.index');
    }
    // End Method 

    public function AdminLogin(){
    return view('admin.login.admin_login');
    }
    // End Method 




}
