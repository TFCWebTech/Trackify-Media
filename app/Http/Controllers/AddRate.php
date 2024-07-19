<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\AddRate_Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class AddRate extends Controller
{
    public function index(){
        $addrate = DB::table('addrate as ad')
        ->leftJoin('mediatype as mt', 'mt.gidMediaType', '=', 'ad.gidMediaType')
        ->leftJoin('mediaoutlet as mo', 'mo.gidMediaOutlet', '=', 'ad.gidMediaOutlet')
        ->leftJoin('edition as ed', 'ed.gidEdition', '=', 'ad.gidEdition')
        ->leftJoin('supplements as sp', 'sp.gidSupplement', '=', 'ad.gidSupplement')
        ->select('ad.*', 'mt.MediaType as media_name', 'mo.MediaOutlet as publication', 'ed.Edition as edition', 'sp.Supplement as supplement') 
        ->orderBy('ad.gidAddRate_id', 'DESC')  
        ->distinct()
        ->limit(100)
        ->get();     

        $media_type = DB::table('mediatype')
        ->select('*')   
        ->get();   
        
        return view('master/addRate', compact('addrate', 'media_type'));

    }

    public function getPublication(Request $request)
    {
        $media = $request->input('media');
        $get_publication = DB::table('mediaoutlet')
            ->where('gidMediaType', $media) // Ensure this column name and logic match your database structure
            ->select('*')
            ->get();

        $options = '<option value="">Select Publication</option>';
        foreach ($get_publication as $value) {
            $options .= '<option value="' . $value->gidMediaOutlet . '">' . $value->MediaOutlet . '</option>';
        }

        return response()->json(['options' => $options]);
    }

    public function getEdition(Request $request)
    {
        $publication = $request->input('publication');
        $get_edition = DB::table('edition')
            ->where('MediaOutletId', $publication) // Ensure this column name and logic match your database structure
            ->select('*')
            ->get();

        $options = '<option value="">Select Edition</option>';
        foreach ($get_edition as $value) {
            $options .= '<option value="' . $value->gidEdition . '">' . $value->Edition . '</option>';
        }

        return response()->json(['options' => $options]);
    }
    
    public function getSupplement(Request $request)
    {
        $edition = $request->input('edition');
        $get_supplement = DB::table('supplements')
            ->where('gidEdition', $edition) // Ensure this column name and logic match your database structure
            ->select('*')
            ->get();

        $options = '<option value="">Select Supplement</option>';
        foreach ($get_supplement as $value) {
            $options .= '<option value="' . $value->gidSupplement . '">' . $value->Supplement . '</option>';
        }

        return response()->json(['options' => $options]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'media_type' => 'required|string|max:255',
            'publication' => 'required|string|max:255',
            'edition' => 'required|string|max:255',
            'supplement' => 'required|string|max:255',
            'rate' => 'required|numeric',
            'new_rate' => 'required|numeric',
            'number_of_circulation' => 'required|numeric',
            'status' => 'required|boolean'
        ]);
        $userId = session('user_id');
        $gidAddRate = bin2hex(random_bytes(40 / 2));
        $addRate = AddRate_Model::create([
            'gidMediaType' => $request->input('media_type'),
            'gidMediaOutlet' => $request->input('publication'),
            'gidEdition' => $request->input('edition'),
            'gidSupplement' => $request->input('supplement'),
            'Rate' => $request->input('rate'),
            'NewRate' => $request->input('new_rate'),
            'Status' => $request->input('status'),
            'Circulation_Fig' => $request->input('number_of_circulation'),
            'gidAddRate' => $gidAddRate,
            'CreatedOn' => now(),
            'CreatedBy' => $userId,
            'UpdatedOn' => now()
        ]);
        return redirect()->back()->with('success', 'Add Rate added successfully!');
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'media_type' => 'required|string|max:255',
        'publication' => 'required|string|max:255',
        'edition' => 'required|string|max:255',
        'supplement' => 'required|string|max:255',
        'rate' => 'required|numeric',
        'new_rate' => 'required|numeric',
        'number_of_circulation' => 'required|numeric',
        'status' => 'required|boolean' // Ensure 'status' is boolean as per your requirement
    ]);
    
    try {
        $addRate = AddRate_Model::findOrFail($id);
        $addRate->update([
            'gidMediaType' => $request->input('media_type'),
            'gidMediaOutlet' => $request->input('publication'),
            'gidEdition' => $request->input('edition'),
            'gidSupplement' => $request->input('supplement'),
            'Rate' => $request->input('rate'),
            'NewRate' => $request->input('new_rate'),
            'Status' => $request->input('status'),
            'Circulation_Fig' => $request->input('number_of_circulation'),
            'UpdatedOn' => now()
        ]);
        
        return redirect()->back()->with('success', 'Add Rate updated successfully!');
    } catch (\Exception $e) {
        return redirect()->back()->withErrors(['error' => 'Failed to update Add Rate. Please try again.']);
    }
}

public function getDataByMedia(Request $request) {
        $media_types = $request->input('media_types');

        // Start building the query
        $query = DB::table('addrate as ad')
            ->leftJoin('mediatype as mt', 'mt.gidMediaType', '=', 'ad.gidMediaType')
            ->leftJoin('mediaoutlet as mo', 'mo.gidMediaOutlet', '=', 'ad.gidMediaOutlet')
            ->leftJoin('edition as ed', 'ed.gidEdition', '=', 'ad.gidEdition')
            ->leftJoin('supplements as sp', 'sp.gidSupplement', '=', 'ad.gidSupplement')
            ->select(
                'ad.*',
                'mt.MediaType as media_name',
                'mo.MediaOutlet as publication',
                'ed.Edition as edition',
                'sp.Supplement as supplement'
            )
            ->orderBy('ad.gidAddRate_id', 'DESC')
            ->distinct();

        // Apply the condition if media_types is not 'All'
        if ($media_types != 'All') {
            $query->where('ad.gidMediaType', $media_types);
        }

        // Execute the query and get the results
        $addrate = $query->get();

        return view('master/addRate_ajax', compact('addrate'));
    }
}
