<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
//use Illuminate\Http\Request;

class BlankController extends Controller
{
public function index()
	{ 		
		return view('admin.blank');
	}
}
