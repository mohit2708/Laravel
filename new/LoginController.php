<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Hash;
//use Auth; 
use Illuminate\Support\Facades\Auth;
class LoginController extends Controller
{



    public function login()
	{
		return view('auth.login');
	}

	
	public function doLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');
       	
        if (Auth::attempt($credentials)) {
        	if(Auth::user()->role_type == 'admin'){
			return redirect('admin-deshboard');
		}
		else{
			return redirect()->intended('home');
		}
            //return redirect()->intended('home');
        }


        return redirect('login')->with('error', 'Oppes! You have entered invalid credentials');
    }
	public function logout() {
		Auth::logout();

		return redirect('login');
	}
}
