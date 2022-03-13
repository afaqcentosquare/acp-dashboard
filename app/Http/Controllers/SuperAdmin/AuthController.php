<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Display a login view.
     *
     * @return \Illuminate\Http\Response
     */
    public function loginView()
    {
        return view("superadmin.auth.login");
    }


    public function checkLogin(Request $request)
    {
        
        $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);

        $user = User::where('email', $request->email)->first();
        if($user){
            if (Hash::check($request->password, $user->password)) {
                session([
                    'user_id' => $user->id
                ]);
                return redirect()->route('superadmin.dashboard');
             }else{
                return back()->withError("email or password is incorrect")->withInput();
             }
        }else{
            return back()->withError("email or password is incorrect")->withInput();
        }
       
    }

    public function logout()
    {
        session()->forget('user_id');
        return redirect()->route('superadmin.login');
    }

   
}
