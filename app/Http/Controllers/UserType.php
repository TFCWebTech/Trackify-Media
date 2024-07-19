<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\UserTypeModel;

class UserType extends Controller
{
    //
    public function index(){
        $user_type_data = UserTypeModel::all();
   
        $data = compact('user_type_data');
        return view('users/user_type')->with($data);
    }

    public function AddUserType(Request $request) {
        $validation = [
            'user_type' => ['required', 'string', 'max:255'],
        ];

        // Validate the request
        $validator = Validator::make($request->all(), $validation);

        // Check if validation fails
        if ($validator->fails()) {
            // Return back with error messages
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            try {
                $userType = new UserTypeModel;
                $userType->user_type = $request['user_type'];
                $userType->save();
                
                // Success message
                return redirect()->back()->with('success', 'User type added successfully.');
            } catch (\Exception $e) {
                // Error message
                return redirect()->back()->with('error', 'Failed to add user type. ' . $e->getMessage());
            }
        }
    }

    public function editUserType(Request $request) {
        $validation = [
            'user_type_id' => ['required', 'exists:user_type,user_type_id'], // Assuming 'user_type_table' is your table name
            'user_type' => ['required', 'string', 'max:255'],
        ];
    
        // Validate the request
        $validator = Validator::make($request->all(), $validation);
    
        // Check if validation fails
        if ($validator->fails()) {
            // Return back with error messages
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            try {
                // Retrieve user type data
                $userType = UserTypeModel::find($request->input('user_type_id'));
               
                if (!$userType) {
                    // Handle if user type not found
                    return redirect()->back()->with('error', 'User type not found.');
                }
    
                // Update user type
                $userType->user_type = $request->input('user_type');
                $userType->user_type_status = $request->input('user_type_status');
                $userType->save();
    
                // Success message
                return redirect()->back()->with('success', 'User type updated successfully.');
            } catch (\Exception $e) {
                // Error message
                return redirect()->back()->with('error', 'Failed to update user type. ' . $e->getMessage());
            }
        }
    }


    public function deleteUserType(Request $request) {
        $validation = [
            'user_type_id' => ['required', 'exists:user_type,user_type_id'], // Assuming 'user_type_table' is your table name
        ];
    
        // Validate the request
        $validator = Validator::make($request->all(), $validation);
    
        // Check if validation fails
        if ($validator->fails()) {
            // Return back with error messages
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            try {
                // Retrieve user type data
                $userType = UserTypeModel::find($request->input('user_type_id'));
               
                if (!$userType) {
                    // Handle if user type not found
                    return redirect()->back()->with('error', 'User type not found.');
                }
                // Update user type
                $userType->user_type_id = $request->input('user_type_id');
                $userType->delete();
    
                // Success message
                return redirect()->back()->with('success', 'User type deleted successfully.');
            } catch (\Exception $e) {
                // Error message
                return redirect()->back()->with('error', 'Failed to delete user type. ' . $e->getMessage());
            }
        }
    }
}
