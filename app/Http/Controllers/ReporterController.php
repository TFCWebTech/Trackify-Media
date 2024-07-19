<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Reporter_Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use App\Mail\ReporterAdded;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
class ReporterController extends Controller
{
    public function index(){
        $reporters = DB::table('user')
        ->where('user_type', 'Reporter')
        ->select('*')   
        ->get();      
        // echo '<pre>';
        // print_r($publication);
        // echo '</pre>';
        return view('repoter', compact('reporters'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'update_reporter_name' => 'required|string|max:255',
            'email' => 'required|email|unique:user,user_email|max:255', // Validate unique email
            'status' => 'required|boolean',
        ]);
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        
        for ($i = 0; $i < 10; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }
        $reporter = Reporter_Model::create([
            'user_name' => $request->input('update_reporter_name'),
            'user_email' => $request->input('email'),
            'user_status' => $request->input('status'),
            'user_type' => 'Reporter',
            'token' => $randomString
        ]);
        Mail::to($reporter->user_email)->send(new ReporterAdded($reporter->user_name, $reporter->user_email, $reporter->user_id, $reporter->token));

        return redirect()->back()->with('success', 'Reporter added successfully!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'update_reporter_name' => 'required|string|max:255',
            'email' => 'required|email|unique:user,user_email|max:255', // Validate unique email
            'status' => 'required|boolean',
        ]);

        $reporter = Reporter_Model::findOrFail($id);
        $reporter->update([
            'user_name' => $request->update_reporter_name,
            'user_email' => $request->email,
            'user_status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Reporter updated successfully!');
    }

    public function resetPassword(Request $request, $id, $token){
           // Find the reporter by ID
    $reporter = Reporter_Model::findOrFail($id);

    // Check if the token matches
    if ($reporter->token !== $token) {
        return redirect()->back()->with('error', 'Invalid token.');
    }
    // Get user_id and user_email
    $userId = $reporter->user_id;
    $userEmail = $reporter->user_email;
    return view('emails.ResetPassword', compact('reporter'));
    }

    public function updatePassword(Request $request)
    {
        // Validate the request
        $request->validate([
            'user_id' => 'required|integer|exists:user,user_id',
            'password1' => 'required|string|min:6',
            'password2' => 'required|string|same:password1', // Ensure passwords match
        ]);
    
        // Retrieve the user by ID
        $reporter = Reporter_Model::findOrFail($request->input('user_id'));
        // Update the password securely
        $reporter->user_password = Hash::make($request->input('password1'));
        $reporter->save(); // Save the changes
    
        return redirect()->route('login')->with('success', 'Password updated successfully! Please log in.');
    }
} 
