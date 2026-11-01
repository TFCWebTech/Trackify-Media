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
        // Validate the input fields
        $request->validate([
            'userId' => 'required',
            'user_password' => 'required'
        ]);
    
        $userId = $request->input('userId');
        $userPassword = $request->input('user_password');
    
        // Attempt to find the user by user_name
        $check = User::where('user_name', $userId)->first();
    
        if ($check) {
            // Check if the provided password matches the stored hashed password
            if (Hash::check($userPassword, $check->user_password)) {
                // Store user information in the session
                Session::put('user_id', $check->user_id);
                Session::put('user_name', $check->user_name);
                Session::put('user_type', $check->user_type);
    
                // Redirect based on user type
                if ($check->user_type === 'Admin') {
                    return response()->json([
                        'success' => true,
                        'redirect' => route('news_latter')
                    ]);
                } elseif ($check->user_type === 'Reporter') {
                    return response()->json([
                        'success' => true,
                        'redirect' => route('news_upload')
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'error' => 'Unauthorized user type.',
                    ], 403); // 403 Forbidden if user type is not recognized
                }
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

    public function forgotPassword(Request $request)
    {
        // Validate email input
        $validator = Validator::make($request->all(), [
            'send_email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', 'Enter a valid E-mail.');
        }

        $send_email = $request->input('send_email');
        $user = User::where('user_email', $send_email)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        // Generate a token
        $token = Str::random(60);

        // Update the user's token in the database
        $user->update(['token' => $token]);

        // Debugging: Verify if token is updated

        try {
           $user_id =  $user->user_id;
    Mail::to($user->user_email)->send(new \App\Mail\UserForgotPassword($user_id, $token));
    
    if (count(Mail::failures()) > 0) {
        Log::error('Failed to send email to: ' . implode(', ', Mail::failures()));
        return redirect()->back()->with('error', 'Failed to send email.');
    } else {
        Log::info("Password reset link sent to {$user->user_email}");
        return redirect()->back()->with('success', 'Passwords reset link sent to your email.');
    }
} catch (\Exception $e) {
    Log::error("Error sending password reset email: {$e->getMessage()}");
    return redirect()->back()->with('error', 'Error sending password reset link. Please try again later.');
}
    }
    public function ganerateUserPassword(Request $request, $id, $token){
        $User = user::findOrFail($id);
        // Check if the token matches
        $userId = $User->user_id;
         $userEmail = $User->user_email;
        return view('emails.set_admin_reporter_password', compact('User'));
    }
    public function setUserRepoterPassword(Request $request)
    {
        // Validate the request
        $request->validate([
            'user_id' => 'required|integer|exists:user,user_id',
            'password1' => 'required|string|min:6',
            'password2' => 'required|string|same:password1', // Ensure passwords match
            'token' => 'required|string' // Ensure token is present
        ]);
    
        // Retrieve the user by client_id and token
        $User = user::where('user_id', $request->input('user_id'))
                            ->where('token', $request->input('token'))
                            ->first();
    
        // Check if user exists and token matches
        if (!$User) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    
        // Update the password securely
        $User->user_password = Hash::make($request->input('password1'));
        // Invalidate the token after password reset
        $User->token = null;
        $User->save(); // Save the changes
    
        return redirect()->route('login')->with('success', 'Password updated successfully! Please log in.');
    }

    public function userLogout(Request $request) {
        Auth::logout(); // Logout the user
        $request->session()->invalidate(); // Invalidate the session
        $request->session()->regenerateToken(); // Regenerate the CSRF token
        return redirect('/'); 
    }


}
