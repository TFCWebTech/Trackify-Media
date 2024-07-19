<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CompareChartConteoller extends Controller
{
    
     //
     public function index(){
        return view('compare_charts');
    }
}
