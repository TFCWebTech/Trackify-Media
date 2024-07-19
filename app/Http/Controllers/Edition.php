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
        ->orderBy('ed.edition_id', 'DESC')
        ->get();
        $publication = DB::table('mediaoutlet')
        ->select('*')   
        ->get();        
        // Pass the editions to the view
        return view('master.edition', compact('editions', 'publication'));
    }

    public function addEdition(Request $request)
    {
        $user_id = Session::get('user_id');
        $user_name = Session::get('user_name');
        $gidEdition = bin2hex(random_bytes(40 / 2));
        // Validate the form data
        $request->validate([
            'Edition' => 'required|string|max:255',
            'EditionOrder' => 'required|integer',
            'MediaOutletId' => 'required|string|max:255',
            'Status' => 'required|integer',
        ]);
        // Insert data into the database
        DB::table('edition')->insert([
            'gidEdition' => $gidEdition,
            'Edition' => $request->Edition,
            'EditionOrder' => $request->EditionOrder,
            'MediaOutletId' => $request->MediaOutletId,
            'Status' => $request->Status,
            'CreatedOn' => now(),
            'CreatedBy' => $user_name, 
        ]);
        // Redirect back or to another page
         return redirect()->route('edition')->with('success', 'Edition added successfully');
    }

    public function updatedEdition(Request $request)
    {
        try {
            // Retrieve session variables if needed
            // $user_id = Session::get('user_id');
            // $user_name = Session::get('user_name');
            $editionId = $request->input('edition_id');
    
            // Validate the request data
            $request->validate([
                'Edition' => 'required|string|max:255',
                'EditionOrder' => 'required|integer',
                'MediaOutletId' => 'required|string|max:255',
                'Status' => 'required|integer',
            ]);
    
            // Find the edition by ID
            $edition = ManageEditionsModel::findOrFail($editionId);
    
            // Update the edition attributes
            $edition->Edition = $request->Edition;
            $edition->EditionOrder = $request->EditionOrder;
            $edition->MediaOutletId = $request->MediaOutletId;
            $edition->Status = $request->Status;
    
            // Save the updated edition
            $saved = $edition->save();
    
            if ($saved) {
                // Redirect back or to another page with a success message
                return redirect()->route('edition.index')->with('success', 'Edition updated successfully');
            } else {
                // Log the error if save failed
                \Log::error('Failed to save edition after update');
                return redirect()->back()->with('error', 'Failed to update edition');
            }
        } catch (\Exception $e) {
            // Handle any errors, log them, and return a response
            \Log::error('Error updating edition: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update edition');
        }
    }
}