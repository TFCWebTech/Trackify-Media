<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\ManageEditionsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class Edition extends Controller
{
    public function index(){
        //get all edition records 
        $editions = DB::table('edition as ed')
        ->leftJoin('mediaoutlet as mo', 'ed.MediaOutletId', '=', 'mo.gidMediaOutlet')
        ->select('ed.*', 'mo.MediaOutlet as media_outlet_name')
        ->orderBy('ed.gidEdition_id', 'DESC')
        ->get();
        $publication = DB::table('mediaoutlet')
        ->select('*')   
        ->get();        
        // Pass the editions to the view
        return view('master.edition', compact('editions', 'publication'));
    }

    public function store(Request $request)
    {
        $user_id = Session::get('user_id');
        $user_name = Session::get('user_name');
        $gidEdition = bin2hex(random_bytes(40 / 2));
    
        // Validate the form data
        $request->validate([
            'Edition' => 'required|string|max:255',
            'EditionOrder' => 'required|integer',
            'MediaOutletId' => 'required|string|max:255',
            'Status' => 'required|boolean',
        ]);
    
        try {
            // Insert data into the database
            DB::table('edition')->insert([
                'gidEdition' => $gidEdition,
                'Edition' => $request->Edition,
                'EditionOrder' => $request->EditionOrder,
                'MediaOutletId' => $request->MediaOutletId,
                'Status' => $request->Status,
                'CreatedOn' => now(),
                'CreatedBy' => $user_name, 
                'ShortName' => 'null'
            ]);
    
            // Redirect back or to another page
            return redirect()->route('edition')->with('success', 'Edition added successfully');
        } catch (\Exception $e) {
            \Log::error('Failed to add Edition: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Failed to add Edition. Please try again.']);
        }
    }

    public function update(Request $request, $id)
    {
        $user_name = Session::get('user_name');
    
        // Validate the form data
        $request->validate([
            'Edition' => 'required|string|max:255',
            'EditionOrder' => 'required|integer',
            'MediaOutletId' => 'required|string|max:255',
            'Status' => 'required|boolean',
        ]);
    
        try {
            \Log::info('Attempting to update edition with id: ' . $id);
            $edition = ManageEditionsModel::findOrFail($id);
            \Log::info('Edition found: ' . json_encode($edition)); // Log the found edition
    
            // Set the new values
            $edition->Edition = $request->Edition;
            $edition->EditionOrder = $request->EditionOrder;
            $edition->MediaOutletId = $request->MediaOutletId;
            $edition->Status = $request->Status;
            $edition->UpdatedOn = now();
            $edition->UpdatedBy = $user_name;
            $edition->ShortName = 'null';
    
            \Log::info('Attempting to save updated edition: ' . json_encode($edition)); // Log the edition before saving
            $edition->save();
            \Log::info('Edition updated successfully: ' . $edition->gidEdition_id); // Log the successful update
    
            return redirect()->back()->with('success', 'Edition updated successfully!');
        } catch (\Exception $e) {
            \Log::error('Failed to update Edition: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Failed to update Edition. Please try again.']);
        }
    }
}