<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NewsLatterController extends Controller
{
    public function showNewsletter()
    {
        return view('news_latter');
    }
}
