<?php

namespace App\Http\Controllers;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
class AdminProfile extends Controller
{
    public function profile() {
        $adminId = session('admin_id');
        $admin = Admin::where('admin_id', $adminId)->first();
    
        return view('Admin_profile', ['admin' => $admin]);
    }

    public function updateAdminPassword(request $request){
        $request->validate([
            // 'adminId' => 'required',
            'password' => 'required|confirmed', 
            'password_confirmation' => 'required', 
        ], [
            'password.confirmed' => 'The passwords do not match.', 
        ]);
        $adminId = session('admin_id');
        $admin = Admin::find($adminId);
        // Convert the password to MD5
        $md5Password = md5($request->input('password'));

        // Update the admin's password
        $admin->admin_password = $md5Password;
        // $admin-> admin_password= $request['password'];
        $admin->save();
        return redirect('Profile')->with('success', 'Password updated successfully.');
    }

    public function updateAdminInformation(request $request){
        $request->validate([
            // 'adminId' => 'required',
            'admin_name' => 'required', 
            'admin_mail' => 'required|email', 
            'admin_status' => 'required'
        ]);
        echo $adminId = session('admin_id');
         $admin = Admin::find($adminId);
       echo $admin->admin_name = $request['admin_name']; 
       echo $admin->admin_mail = $request['admin_mail']; 
       echo $admin->status = $request['admin_status']; 
        $admin->save();
        return redirect('Profile')->with('success', 'Informtion updated successfully.');
    }

}
