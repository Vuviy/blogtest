<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Controller
{
    public function loginForm ()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ]);

        if(\auth()->user()->is_admin){
            return redirect(route('admin'));
        } else{
            return redirect(route('home'));
        }
        return back();
    }


    public function logout()
    {
        Auth::logout(\auth()->user());
        return back();
    }
}
