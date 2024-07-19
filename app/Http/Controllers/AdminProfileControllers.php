<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminProfileControllers extends Controller
{
    public function index()
    {
        return view('Admin_profile');
    }
}



