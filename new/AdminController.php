<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Auth;

class AdminController extends Controller
{
	public function __construct() {
    $this->middleware('auth');
  }
    public function index(Request $request)
	{
		//return view('admin_deshboard');
		$users = User::all();
		//echo '<pre>';
		//print_r($users);
		//echo $users[0]->role_type;
		
		//if(Auth::user()->role_type =='admin'){
			
		return view('admin_deshboard', compact('users'));
//		}
//		else{
			
//			 return redirect('home');
//		}
	}
	public function status(Request $request){
		
		//echo 'ashish'.$request->id;
		
		$post = User::find($request->id);

		if($post->status == 1){
			$changestatus = 0;
		}
		else{
			$changestatus = 1;
		}
		$post->status = $changestatus;
		$post->save();
		
		die();
	}
}

