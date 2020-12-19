<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
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
    protected $redirectTo = RouteServiceProvider::HOME;
    //protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest')->except('logout');
    }
    public function doLogin(Request $request)
    {
        $input = $request->all();

        $remember = ($request->get('remember')) ? true : false;
        $validate = Validator::make($input, [
            'email'     => 'required',
            'password'  => 'required'
        ]); 
        
        if (!$validate->fails()){
            
            $userdata = array(
                'email'     => $request->get('email'),
                'password'  => $request->get('password')
            );
            
            if (Auth::attempt($userdata,$remember)) {
                $user = Auth::user();
                if($user->status == 0){
                    Auth::logout();
                    return Redirect::back()->with('error', 'Your account is not activated.');
                }
                if(($user->role_type == 'super_admin')){      
                    return redirect()->intended('admin-dashboard');
                }
                if(($user->role_type == 'admin')){      
                    return redirect()->intended('route-opertion');
                }
                else{
                    return redirect('home');
                }
            }else{
                return Redirect::back()->with('error', 'Incorrect username or password.');
            }
        }else{
            return Redirect::back()->with('error', 'Incorrect username or password.');
        }
    }
    public function logout() {
        Auth::logout();
        //Auth::guard('admin')->logout();
        return redirect('/');
    }
}
