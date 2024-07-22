<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\ManageSupplementModal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Exception; 
class Supplement extends Controller
{
    public function index(){
        $supplements = DB::table('supplements as sp')
        ->leftJoin('edition as e', 'sp.gidEdition', '=', 'e.gidEdition')
        ->select('sp.*', 'e.Edition as edition_name', 'e.gidEdition as edition_id')
        ->orderBy('sp.supplement_id', 'DESC')
        ->get();
    
    // Pre-fetch MediaOutlet names to avoid querying inside a loop
    $mediaOutlets = DB::table('mediaoutlet')->pluck('MediaOutlet', 'gidMediaOutlet');
    
    // Iterate over supplements and attach MediaOutlet names
    foreach ($supplements as $supplement) {
        // Assuming gidMediaOutlet is a field in the 'edition' table
        if (isset($supplement->gidEdition)) {
            $mediaOutlet = DB::table('edition as e')
                ->leftJoin('mediaoutlet as mo', 'mo.gidMediaOutlet', '=', 'e.MediaOutletId')
                ->where('e.gidEdition', $supplement->gidEdition)
                ->select('mo.gidMediaOutlet')
                ->first();  // Use first() to get a single result
            $supplement->mediaOutlet = $mediaOutlet ? $mediaOutlet->gidMediaOutlet : null;
        }
    }
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
        $publication = $request->input('publication');
        $get_edition = DB::table('edition')
            ->where('MediaOutletId', $publication)
            ->select('*')
            ->get();
    
        $options = '<option value="">Select Edition</option>';
        foreach ($get_edition as $value) {
            $options .= '<option value="' . $value->gidEdition . '">' . $value->Edition . '</option>';
        }
    
        return response()->json(['options' => $options]);
    }

    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'Supplement_name' => 'required|string|max:255',
            'Edition' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);
        
        try {
            $user_name = session('user_name');
            if (!$user_name) {
                throw new \Exception('User name not found in session.');
            }
    
            $createdOn = now()->format('Y-m-d H:i:s'); // Format date as string
            $gidSupplement = bin2hex(random_bytes(20)); // 40 / 2 = 20 bytes
            
            // Attempt to create the new supplement entry
            $Supplement = ManageSupplementModal::create([
                'gidSupplement' => $gidSupplement,
                'Supplement' => $request->input('Supplement_name'),
                'gidEdition' => $request->input('Edition'),
                'Status' => $request->input('status'),
                'CreatedOn' => $createdOn,
                'CreatedBy' => $user_name
            ]);
    
            // Redirect with success message
            return redirect()->back()->with('success', 'Supplement added successfully!');
            
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Error adding Supplement', ['exception' => $e]);
            
            // Redirect back with error message
            return redirect()->back()->with('error', 'An error occurred while adding the Supplement. Please try again.');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'Supplement_name' => 'required|string|max:255',
            'Edition' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);
        
        try {
            $Supplement = ManageSupplementModal::findOrFail($id);
            $Supplement->update([
                'Supplement' => $request->input('Supplement_name'),
                'gidEdition' => $request->input('Edition'),
                'Status' => $request->input('status'),
            ]);
            
            return redirect()->back()->with('success', 'Supplement updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to update Supplement. Please try again.']);
        }
    }
    
}
