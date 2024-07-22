<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Industry_model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class IndustryController extends Controller
{
     public function index(){
        $industries = DB::table('industry as ind')
        ->leftJoin('client as c', DB::raw("FIND_IN_SET(c.client_id, ind.client_id)"), '>', DB::raw('0'))
        ->select(
            'ind.Industry_id',
            'ind.Industry_name',
            'ind.client_id',
            'ind.competitor_id',
            'ind.is_active',
            'ind.Keywords',
            DB::raw('GROUP_CONCAT(c.client_name SEPARATOR ", ") as client_names')
        )
        ->groupBy(
            'ind.Industry_id',
            'ind.Industry_name',
            'ind.client_id',
            'ind.competitor_id',
            'ind.is_active',
            'ind.Keywords'
        )
        ->get();
        
        $clients = DB::table('client')
        ->select('client_id', 'client_name')
        ->get();
        $competitors = DB::table('competitor')
        ->select('competitor_id', 'Competitor_name')
        ->get();
        // echo '<pre>';
        // print_r($clients);
        // echo '</pre>';
        return view('industry', compact('industries','clients','competitors'));
    }

    public function store(Request $request)
    {
        // Validate the form data
        $request->validate([
            'Industry_name' => 'required|string|max:255',
            'Keywords' => 'required|array',
            'Keywords.*' => 'string|max:45',
            'status' => 'required|boolean',
        ]);
    
        $client_names = $request->input('client_name');
        $competitor_names = $request->input('compitertors_name');
        $keywords = $request->input('Keywords');
    
        $client_id_string = $client_names ? implode(',', $client_names) : null;
        $competitor_id_string = $competitor_names ? implode(',', $competitor_names) : null;
        $keywords_string = implode(',', $keywords);
    
        try {
            $industry = Industry_model::create([
                'Industry_name' => $request->input('Industry_name'),
                'client_id' => $client_id_string,
                'competitor_id' => $competitor_id_string,
                'Keywords' => $keywords_string,
                'is_active' => $request->input('status'),
            ]);
    
            return redirect()->back()->with('success', 'Industry added successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to add Industry: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to add Industry. Please try again.');
        }
    }


    public function update(Request $request, $id)
{
    // Validate the form data
    $request->validate([
        'Industry_name' => 'required|string|max:255',
        'status' => 'required|boolean',
    ]);

    $client_names = $request->input('client_name');
    $competitor_names = $request->input('compitertors_name');

    // Convert client and competitor names arrays to comma-separated strings
    $client_id_string = $client_names ? implode(',', $client_names) : null;
    $competitor_id_string = $competitor_names ? implode(',', $competitor_names) : null;

    try {
        // Find the industry by ID
        $industry = Industry_model::findOrFail($id);

        // Update industry properties
        $industry->Industry_name = $request->Industry_name;
        $industry->client_id = $client_id_string;
        $industry->competitor_id = $competitor_id_string;
        $industry->is_active = $request->status;

        // Save the updated industry
        $industry->save();

        return redirect()->back()->with('success', 'Industry updated successfully!');
    } catch (\Exception $e) {
        \Log::error('Failed to update industry: ' . $e->getMessage());
        return redirect()->back()->withErrors(['error' => 'Failed to update industry. Please try again.']);
    }
}
}
