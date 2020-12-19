<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use DB;
use App\Mail\VerifyEmail;
use Mail;

class AdminController extends Controller
{	
	public function __construct()
	{
		$this->middleware('auth');
	}
    public function adminDashboard(Request $request)
	{
		$users = User::where('id', '!=', 1)->paginate(10);
		return view('admin_dashboard', compact('users'));
	}
	public function status(Request $request){

		$post = User::find($request->id);
		$email1 = $post->email;
		$name1 = $post->name;
		if($post->status == 1){
			$changestatus = 0;
			$rolechange = 'NULL';
		}else{
			$changestatus = 1;
			$rolechange = 'admin';
		}
		$post->status = $changestatus;
		$post->role_type = $rolechange;
		$post->save();

		if($post->status == 1){
			$data = array('name'=>$name1,'email'=>$email1 );   
            Mail::send(['text'=>'mailactive'], $data, function($message) use ($email1, $name1) {
                 $message->to($email1, '911 Inform')->subject
                    ('Your Account is Activate');
                 $message->from('mksaxena27@gmail.com','911 Inform');
              });  
		}else{
			$data = array('name'=>$name1);   
              Mail::send(['text'=>'maildeactivate'], $data, function($message) use ($email1, $name1){
                 $message->to($email1, '911 Inform')->subject
                    ('Your Account is Deactivated');
                 $message->from('mksaxena27@gmail.com','911 Inform');
              });
			
		}
	}

	public function getUserData(Request $request)
    {
        $users = User::findorFail($request['id']);
        return $users;
	}   

	public function delete($id){		
			User::where('id', $id)->delete();	
			return redirect('admin-dashboard')->with('success', 'Service deleted successfully!');	
		
	}	
}
