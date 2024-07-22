<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Client_Model;
use App\Models\Competitor_Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
class ClientController extends Controller
{
    public function index(){
        $clients = DB::table('client')
        ->where('client_type','Company')
        ->select('*')
        ->get();
      
        return view('client', compact('clients'));
    }

    public function store(Request $request)
    {
        // Validate the form data
        $request->validate([
            'client_name' => 'required|string|max:255',
            'Keywords' => 'required|array',
            'Keywords.*' => 'string|max:45',
            'is_active' => 'required|boolean',
            // 'Sector' is not required, so it will default to null if not present
        ]);
    
        // Process keywords
        $keywords = $request->input('Keywords');
        $keywords_string = implode(',', $keywords);
    
        try {
            // Create a new client record
            $client = Client_Model::create([
                'client_name' => $request->input('client_name'),
                'client_keywords' => $keywords_string,
                'cilent_status' => $request->input('is_active'),
                'sector_id' => $request->input('Sector') ?? null, // Default to null if not provided
                'create_at' => now(),
                'client_type' => 'Company'
            ]);
    
            return redirect()->back()->with('success', 'Client added successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to add client: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to add client. Please try again.');
        }
    }
    
    public function addCompetitor(Request $request)
{
    // Validate the form data
    $request->validate([
        'Competitor_name' => 'required|string|max:255',
        'client_id' => 'required|integer',
        'CompetetorKeywords' => 'required|array',
        'CompetetorKeywords.*' => 'string|max:45',
        'is_active' => 'required|boolean',
        // 'Sector' is not required, so it will default to null if not present
    ]);

    // Process keywords
    $keywords = $request->input('CompetetorKeywords');
    $keywords_string = implode(',', $keywords);

    try {
        // Create a new competitor record
        $competitor = Competitor_Model::create([
            'Competitor_name' => $request->input('Competitor_name'),
            'client_id' => $request->input('client_id'),
            'is_active' => $request->input('is_active'),
            'Keywords' => $keywords_string,  // Fixed the typo here
        ]);

        return redirect()->back()->with('success', 'Competitor added successfully.');
    } catch (\Exception $e) {
        Log::error('Failed to add competitor: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Failed to add competitor. Please try again.');
    }
}
}
