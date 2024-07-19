<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NewsLetterPreview extends Controller
{
    //
    public function index(){
        return view('News_letter_preview');
    }
}
