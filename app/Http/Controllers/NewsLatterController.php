<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Client_Model;
class NewsLatterController extends Controller
{
    public function CompanyNewsLetterList()
    {
        $Company = DB::table('client')
        ->where('client_type', 'Company')
        ->select('*')   
        ->get();    
        
        return view('newsLatter_list', compact('Company'));
    }
}
