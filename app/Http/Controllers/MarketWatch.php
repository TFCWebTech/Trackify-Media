<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MarketWatch extends Controller
{
    //
    public function index(){
        return view('master/market_watch');
    }
}
