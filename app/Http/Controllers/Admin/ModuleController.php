<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Role;
use App\Module;
use Session;
use Helper; 
use DB;

class ModuleController extends Controller
{
    
	/*
	* Module List
	*/
    public function index(Request $request){
		
		$arrRoles = Role::get();
		
		$role 		= $request->get('role');
		$title 		= $request->get('title');
		$showMenu 	= $request->get('show_on_menu');
        try{
            $arrModules = Module::select('module_master.*', 'role_title')
								->leftjoin('roles', 'roles.id', '=', 'module_master.role_id');
								if($role){
									$arrModules->where('role_id', $role);
								}
								if($title){
									$arrModules->where('module_title', 'like', '%'.$title.'%');
								}
								if($showMenu){
									$arrModules->where('show_on_menu', $showMenu);
								}
			$arrModules = $arrModules->orderBy('id', 'desc')->paginate(10);
			
            return view('admin.acl.module.index', compact('arrRoles', 'arrModules'));

        }catch(\Exception $ex){ 
            return redirect()->back()->with('error', 'Error occurred. Please Try again!');
        }
    }
	
	/*
	* Module Add Get Method
	*/
	public function add(){
		
		$arrRoles = Role::get();
		return view('admin.acl.module.add', compact('arrRoles'));
	}
	
	
	/*
	* Module Store
	*/
    public function store(Request $request){
			
        $this->validate($request,[
            'module_title'	=> 'required|min:3|max:100|Regex:/^[a-z-.]+( [a-z-.]+)*$/i',
            'role'			=> 'required|numeric',
            'icon'			=> 'required',
        ]);
		
		try{
			
			$module 				= new Module;
			$module->role_id 		= $request->role;
			$module->module_title 	= $request->module_title;
			$module->icon 			= $request->icon;
			$module->show_on_menu	= $request->show_on_menu;
			$module->priority		= $request->priority;
			$module->save();
			
            return redirect('admin/acl/module')->with('success', 'Module added successfully');
			
        }catch(\Exception $e){
            return redirect()->back()->with('error', 'Error occurs! Please try again!');
            
        }
    }
	
	/*
	* Module Edit
	*/
	
	public function edit($id){
		$dataModule = Module::where('id', $id)->first();
		$arrRoles = Role::get();
		return view('admin.acl.module.edit', compact('arrRoles', 'dataModule'));
		
	}

    public function update(Request $request, $id)
    {
		
		$this->validate($request,[
            'module_title'	=> 'required|min:3|max:100|Regex:/^[a-z-.]+( [a-z-.]+)*$/i',
            'role'			=> 'required|numeric',
            'icon'			=> 'required',
        ]);


        try{
			
			$module 				= Module::find($id);
			$module->role_id 		= $request->role;
			$module->module_title 	= $request->module_title;
			$module->icon 			= $request->icon;
			$module->show_on_menu	= $request->show_on_menu;
			$module->priority		= $request->priority;
			$module->save();
			
            return redirect('admin/acl/module')->with('success', 'Module updated successfully');

		}catch(\Exception $e){
			return redirect()->back()->with('error', 'Error occurs! Please try again!');
		}
                  
        
    }

}
