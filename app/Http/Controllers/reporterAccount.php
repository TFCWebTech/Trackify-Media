<?php

namespace App\Http\Controllers;
use App\Models\Reporter_Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
class reporterAccount extends Controller
{
    public function index(){
        $user_id = session('user_id');
        $user = Reporter_Model::where('user_id', $user_id)->first();
        return view('reporter_profile', ['user' => $user]);
    }

    public function updateReporterPassword(Request $request) {
        $request->validate([
            'password' => 'required|confirmed', 
            'password_confirmation' => 'required', 
        ], [
            'password.confirmed' => 'The passwords do not match.', 
        ]);
    
        try {
            $user_id = session('user_id');
            $user = Reporter_Model::find($user_id);
    
            // Hash the password using bcrypt
            $hashedPassword = Hash::make($request->input('password'));
            $user->user_password = $hashedPassword;
            $user->save();
    
            return redirect()->back()->with('success', 'Password updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to update password. Please try again.']);
        }
    }

    public function updateReporterInformation(Request $request) {
        $request->validate([
            'user_name' => 'required', 
            'user_email' => 'required|email', 
            'user_status' => 'required'
        ]);
    
        try {
            $user_id = session('user_id');
            $user = Reporter_Model::find($user_id);
            
            $user->user_name = $request->input('user_name');
            $user->user_email = $request->input('user_email');
            $user->user_status = $request->input('user_status');
            
            $user->save();
            
            return redirect()->back()->with('success', 'User information updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to update User information. Please try again.']);
        }
    }
}
