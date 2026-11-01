<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AllCategories extends Controller
{
    //
    public function index(){
        return view('category/allCatogories');
    }

    public function addKeywords(){
        return view('category/keywords');
    }
}
