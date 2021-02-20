<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Employee;
use Session;
// use Helper; 
// use DB;

class EmployeeController extends Controller
{
    public function index(){
    	return view('admin.employee.index');
    }
    public function add(){
		return view('admin.employee.add');
    }


    /*
	* Employee Store
	*/

    public function store(Request $request){

		$request->validate(
		    [
		        'fname' 	=> 'required',
		        'lname' 	=> 'required',		
		        'emp_email' => 'required|email',		
		        'mnumber' 	=> 'required|min:11|numeric',		
		        'gender' 	=> 'required',		
		    ],
		    [
		        'fname.required'	 => 'Enter Your First Name.',
		        'lname.required'     => 'Enter Your Last Name.',
		        'emp_email.required' => 'Enter Your Email Address.',
		        'mnumber.required'   => 'Enter Your Mobile Number.',
		        'mnumber.numeric'    => 'Please Input the Number Not Character.',
		        'gender.required'    => 'Enter Your Gender.',
		    ]
		);

		$employee 				= new Employee;
		$employee->f_name 		= $request->fname;
		$employee->l_name 		= $request->lname;
		$employee->email 		= $request->emp_email;
		$employee->m_number		= $request->mnumber;
		$employee->gender		= $request->gender;
		$employee->save();

		return redirect('/employee/add')->with('success', 'Employee added successfully');
    }
}

 //    public function store(Request $request){
			
		
	// 	try{
			
	// 		$module 				= new Module;
	// 		$module->role_id 		= $request->role;
	// 		$module->module_title 	= $request->module_title;
	// 		$module->icon 			= $request->icon;
	// 		$module->show_on_menu	= $request->show_on_menu;
	// 		$module->priority		= $request->priority;
	// 		$module->save();
			
 //            return redirect('admin/acl/module')->with('success', 'Module added successfully');
			
 //        }catch(\Exception $e){
 //            return redirect()->back()->with('error', 'Error occurs! Please try again!');
            
 //        }
 //    }
	
	// /*
	// * Module Edit
	// */
	
	// public function edit($id){
	// 	$dataModule = Module::where('id', $id)->first();
	// 	$arrRoles = Role::get();
	// 	return view('admin.acl.module.edit', compact('arrRoles', 'dataModule'));
		
	// }

 //    public function update(Request $request, $id)
 //    {
		
	// 	$this->validate($request,[
 //            'module_title'	=> 'required|min:3|max:100|Regex:/^[a-z-.]+( [a-z-.]+)*$/i',
 //            'role'			=> 'required|numeric',
 //            'icon'			=> 'required',
 //        ]);


 //        try{
			
	// 		$module 				= Module::find($id);
	// 		$module->role_id 		= $request->role;
	// 		$module->module_title 	= $request->module_title;
	// 		$module->icon 			= $request->icon;
	// 		$module->show_on_menu	= $request->show_on_menu;
	// 		$module->priority		= $request->priority;
	// 		$module->save();
			
 //            return redirect('admin/acl/module')->with('success', 'Module updated successfully');

	// 	}catch(\Exception $e){
	// 		return redirect()->back()->with('error', 'Error occurs! Please try again!');
	// 	}
                  
        
 //    } 
