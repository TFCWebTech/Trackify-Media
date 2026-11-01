<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Competition extends Controller
{
    //
    public function index(){
        return view('category/competition');
    }
}
