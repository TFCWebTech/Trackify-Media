<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use App\Mail\ResetPassword;
use Illuminate\Support\Facades\Hash;
class Login extends Controller
{

    public function index(){
        return view('login');
    }
    
    public function loginUser(Request $request)
    {
        $request->validate([
            'userId' => 'required',
            'user_password' => 'required'
        ]);
    
        $userId = $request->input('userId');
        $userPassword = $request->input('user_password');
    //  \Log::info('Attempting to find user:', ['userId' => $userId]);

        $check = User::where('user_name', $userId)->first();
    
        if ($check) {
            if (Hash::check($userPassword, $check->user_password)) {
                Session::put('user_id', $check->user_id);
                Session::put('user_name', $check->user_name);
                Session::put('user_type', $check->user_type);
    
                return response()->json([
                    'success' => true,
                    'redirect' => route('news_latter')
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'error' => 'Invalid User Id or Password!',
                ], 422);
            }
        } else {
            return response()->json([
                'success' => false,
                'error' => 'User not found!',
            ], 404); // 404 Not Found if user does not exist
        }
    }

    public function checkUserMail(Request $request)
    {
        $searchEmail = $request->input('searchEmail');
        // $check_mail1 = $user->checkUserEmail($searchEmail);
        $check_mail1 = User::where('user_email', $searchEmail)->first();
        if ($check_mail1) {
            echo "true";
        } else {
            echo "false";
        }
    }

    // public function checkUserMail(Request $request)
    // {
    //     $searchEmail = $request->input('searchEmail');
    //     // $check_mail1 = $user->checkUserEmail($searchEmail);
    //     $check_mail1 = Admin::where('admin_mail', $searchEmail)->first();;
    //     if ($check_mail1) {
    //         echo "true";
    //     } else {
    //         echo "false";
    //     }
    // }

    public function forgotPassword(Request $request){
        $validator = Validator::make($request->all(), [
            'send_email' => 'required|email', // Corrected the validation rule
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->with('error', 'Enter a valid E-mail.');
        }
    
        $send_email = $request->input('send_email');
        $check_mail1 = User::where('user_email', $searchEmail)->first();
    
        if (!$check_mail1) {
            return redirect()->back()->with('error', 'User not found.'); // Handle case where admin with specified email does not exist
        }
    
        $token = Str::random(60);
        $check_mail1->update(['teset_token' => $token]); // Note: Ensure you have 'teset_token' spelled correctly
    
        try {
            Mail::to($admin->admin_mail)->send(new \App\Mail\ResetPassword($admin, $token));
            Log::info("Password reset link sent to {$admin->admin_mail}");
            return redirect()->back()->with('success', 'Password reset link sent to your email.');
    
        } catch (\Exception $e) {
            Log::error("Error sending password reset email: {$e->getMessage()}");
            return redirect()->back()->with('error', 'Error sending password reset link. Please try again later.');
        }
    }
    

    public function userLogout(Request $request) {
        Auth::logout(); // Logout the user
        $request->session()->invalidate(); // Invalidate the session
        $request->session()->regenerateToken(); // Regenerate the CSRF token
        return redirect('/'); 
    }


}
