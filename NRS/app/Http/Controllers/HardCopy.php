<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HardCopy extends Controller
{
    //
    public function index(){
        return view('category/hard_copy');
    }
}
