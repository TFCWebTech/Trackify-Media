<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CheckEditionController extends Controller
{
    public function check_edition()
    {
        return view('check_edition');
    }
}
