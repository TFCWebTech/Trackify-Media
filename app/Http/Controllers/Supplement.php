<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\ManageEditionsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class Supplement extends Controller
{
    public function index(){
        $supplements = DB::table('supplements as sp')
        ->leftJoin('edition as e', 'sp.gidEdition', '=', 'e.gidEdition')
        ->select('sp.*', 'e.Edition as edition_name')
        ->orderBy('sp.supplement_id', 'DESC')
        ->get();
        // echo '<pre>';
        // print_r($supplements);
        // echo '</pre>';
        $publication = DB::table('mediaoutlet')
        ->select('*')   
        ->get();        
        // Pass the editions to the view
        return view('master.supplement', compact('supplements', 'publication'));
    }

    public function getEdition(Request $request)
    {
        echo $publication = $request->input('publication');
        // Assuming you are getting the edition details from some model
        // $get_edition = $this->addRate->getEdition($publication);
        // Return data for the AJAX call (this is just an example)
        return response()->json([
            'edition' => $publication // Replace this with actual data from your model
        ]);
    }

}
