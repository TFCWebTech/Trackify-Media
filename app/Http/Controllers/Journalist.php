<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\managejournlmodel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class Journalist extends Controller
{
    //
    public function index(){
        $journalists = DB::table('journalist')
        ->select('*') 
        ->orderBy('journalist_id', 'DESC')  
        ->get();      
        return view('master/journalist', compact('journalists'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'journalist_name' => 'required|string|max:255',
            'journalist_email' => 'required|email|max:255', // Validate unique email
            'journalist_status' => 'required|boolean',
        ]);
        $gidJournalist = bin2hex(random_bytes(40 / 2));
        $journalists = managejournlmodel::create([
            'Journalist' => $request->input('journalist_name'),
            'JEmailId' => $request->input('journalist_email'),
            'Status' => $request->input('journalist_status'),
            'gidJournalist' => $gidJournalist,
            'CreatedOn' => now()
        ]);

        return redirect()->back()->with('success', 'Journalist added successfully!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
             'journalist_name' => 'required|string|max:255',
            'journalist_email' => 'required|email|max:255', // Validate unique email
            'journalist_status' => 'required|boolean',
        ]);
        
        $Journalist = managejournlmodel::findOrFail($id);
        $Journalist->update([
            'Journalist' => $request->input('journalist_name'),
            'JEmailId' => $request->input('journalist_email'),
            'Status' => $request->input('journalist_status'),
        ]);
        return redirect()->back()->with('success', 'Journalist updated successfully!');
    }
}
