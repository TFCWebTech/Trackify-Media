<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Publication_Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
class Publication extends Controller
{
    public function index(){
       $Publication = $Publication_Model = DB::table('mediaoutlet as m')
        ->leftJoin('mediatype as mt', 'mt.gidMediaType', '=', 'm.gidMediaType')
        ->leftJoin('publicationtype as pt', 'pt.gidPublicationType', '=', 'm.gidPublicationType')
        ->select('m.*', 'mt.MediaType as Media_type_name','pt.PublicationType as publication_type')
        ->orderBy('m.gidMediaOutlet_id', 'DESC')
        ->get();    

        $mediaType = DB::table('mediatype')
        ->select('gidMediaType', 'MediaType')
        ->get();

        $publicationType = DB::table('publicationtype')
        ->select('gidPublicationType', 'PublicationType')
        ->get();
        return view('master/publication', compact('Publication','mediaType','publicationType'));
    }

    public function store(Request $request)
    {
        // Validate the form data
        $request->validate([
            'publiction_name' => 'required|string|max:255',
            'media_type' => 'required|string|max:45',
            'publicationType' => 'required|string|max:45',
            'publication_language' => 'required|string|max:45',
            'master_head' => 'required|string|max:500',
            'Priority' => 'required|in:10,3', // Ensure Priority is either 10 or 3
            'Short_name' => 'required|string|max:45',
            'status' => 'required|boolean',
        ]);
    
        // Retrieve user_id from session
        $userId = session('user_name');
        $gidMediaOutlet = bin2hex(random_bytes(20)); // 40 characters
    
        try {
            $publication = Publication_Model::create([
                'gidMediaOutlet' => $gidMediaOutlet,
                'MediaOutlet' => $request->input('publiction_name'),
                'gidMediaType' => $request->input('media_type'),
                'gidPublicationType' => $request->input('publicationType'),
                'gidTier' => $request->input('tier_type') ?? null,
                'Language' => $request->input('publication_language'),
                'Masthead' => $request->input('master_head'),
                'Priority' => $request->input('Priority'),
                'ShortName' => $request->input('Short_name'),
                'Status' => $request->input('status'),
                'CreatedOn' => now(),
                'CreatedBy' => $userId,
                'MediaOutletCorrections' => 77, // Ensure this is included if necessary
            ]);
    
            return redirect()->back()->with('success', 'Publication added successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to add publication: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to add publication. Please try again.');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'publiction_name' => 'required|string|max:255',
            'media_type' => 'required|string|max:45',
            'publicationType' => 'required|string|max:45',
            'publication_language' => 'required|string|max:45',
            'master_head' => 'required|string|max:500',
            'Priority' => 'required|in:10,3', // Ensure Priority is either 10 or 3
            'Short_name' => 'required|string|max:45',
            'status' => 'required|boolean',
        ]);
    
        $userId = session('user_name');
    
        try {
            $publication = Publication_Model::findOrFail($id);
            \Log::info('Publication found: ' . json_encode($publication)); 
    
            $publication->MediaOutlet = $request->publiction_name;
            $publication->gidMediaType = $request->media_type;
            $publication->gidPublicationType = $request->publicationType;
            $publication->gidTier = $request->tier_type ?? null;
            $publication->Language = $request->publication_language;
            $publication->Masthead = $request->master_head;
            $publication->Priority = $request->Priority;
            $publication->ShortName = $request->Short_name;
            $publication->Status = $request->status;
            $publication->UpdatedOn = now();
            $publication->UpdatedBy = $userId;
    
            \Log::info('Attempting to save updated publication: ' . json_encode($publication)); 
            $publication->save();
            \Log::info('Publication updated successfully: ' . $publication->gidMediaOutlet_id); 
    
            return redirect()->back()->with('success', 'Publication updated successfully!');
        } catch (\Exception $e) {
            \Log::error('Failed to update publication: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Failed to update publication. Please try again.']);
        }
    }

}
