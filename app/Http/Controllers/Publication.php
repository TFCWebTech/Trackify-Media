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
    // Dump and die to check the request data
    // dd($request->all());

    $request->validate([
        'publiction_name' => 'required|string|max:255',
        'media_type' => 'required',
        'publicationType' => 'required',
        'publication_language' => 'required',
        'master_head' => 'required',
        'Priority' => 'required|integer', // Ensure this matches the expected type
        'Short_name' => 'required',
        'status' => 'required|boolean',
        'tier_type' => 'nullable', // Make sure this is defined if it's optional
    ]);

    // Retrieve user_id from session
    $userId = session('user_id');
    $gidMediaOutlet = bin2hex(random_bytes(20)); // 40 characters

    // Enable query logging
    \DB::enableQueryLog();

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
            'MediaOutletCorrections' => 'Your value here', // Ensure this is included if necessary
        ]);
    } catch (\Exception $e) {
        Log::error('Failed to add publication: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Failed to add publication. Please try again.');
    }
    }
}
