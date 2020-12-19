<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Redirect;
use Validator;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest')->except('logout');
    }
	
	/*
	* Function to check admin login
	*/
	
	public function doLogin(Request $request){

		$input = $request->all();

		$remember = ($request->get('remember')) ? true : false;
		$validate = Validator::make($input, [
			'email' 	=> 'required',
			'password' 	=> 'required'
		]);	
		
		if (!$validate->fails()){
			
			$userdata = array(
				'email'  	=> $request->get('email'),
				'password'  => $request->get('password')
			);
			
			if (Auth::attempt($userdata,$remember)) {
				$user = Auth::user();
				if($user->status == 0){
					Auth::logout();
					return Redirect::back()->with('error', 'Your account is not activated.');
				}
				if(($user->role_id == 1)){
					//updateLastLogin($user->id);		
					return redirect()->intended('admin');
				}else{
					return Redirect::back()->with('error', 'You don\'t have privilege.');
				}
			}else{
				return Redirect::back()->with('error', 'Incorrect username or password.');
			}
		}else{
			return Redirect::back()->with('error', 'Incorrect username or password.');
		}
	}
	
	/*
	* Function to Logout
	*/
	
	public function doLogout(){

		Auth::logout();
	    return redirect('/');
		
	}
}
