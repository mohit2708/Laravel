<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;


class UserListConroller extends Controller
{
    public function index(){
    	$showUserList = User::all();
    	return view('admin.user_list',compact('showUserList'));
    }
    public function UserStore(Request $request){
    	//dd('$request');
		$user 			= new User;
		$user->name 	= $request->fname;
		$user->email 	= $request->email;             
		$user->save();
		return redirect('admin.user_list')->with('success', 'Facility added successfully');
    }
}
