<?php namespace App\Http\Controllers;

use DB;
use Redirect;
use Input;
use Validator;
use Auth;
use Hash;
use App\User;
use Request;
use Mail;
use Session;

class HomeController extends Controller {
	
	public function adminDashboard(){
		
		return view('admin.dashboard');
		
	}
	
}