<?php

namespace App\Http\Controllers\ClientDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\Client_Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Mail\ResetPassword;
use Illuminate\Support\Facades\Hash;
class ClientLogin extends Controller
{
    public function index(){
        return view('ClientDashboard.client_login');
    }
    
    
    public function loginClient(Request $request)
    {
        $request->validate([
            'userId' => 'required',
            'user_password' => 'required'
        ]);
    
        $userId = $request->input('userId');
        $userPassword = $request->input('user_password');

        $check = Client_Model::where('email', $userId)->first();
    
        if ($check) {
            if (Hash::check($userPassword, $check->password)) {
                Session::put('client_id', $check->client_id);
                Session::put('client_name', $check->client_name);
                Session::put('client_type', $check->client_type);
    
                return response()->json([
                    'success' => true,
                    'redirect' => route('generateReport')
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'error' => 'Invalid Client Id or Password!',
                ], 422);
            }
        } else {
            return response()->json([
                'success' => false,
                'error' => 'Client not found!',
            ], 404); 
        }
    }

}
