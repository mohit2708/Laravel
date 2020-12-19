<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hash;
use DB;
use Session;
use App\Module;
use App\Aclpage;
use App\PageAccess;
use App\Aclmodule;
use App\Assign_module;
use App\Role;
class AclPageAccessController extends Controller
{
	
	/* 
	* Function to list index page with role listing
	*/
    public function index(Request $request){
		
			$arrRole = Role::get();
			
			
			$arrPageAccess = Module::select('module_master.*', 'page_master.id as page_id', 'page_title')
									->join('page_master','module_master.id','=','page_master.module_id')
									->orderBy('page_master.page_title','asc')
									->get();
			
			$arrModuleAccess = [];
			foreach ($arrPageAccess as $page_val) 
			{
				$arrModuleAccess[$page_val->module_title][] = [
							'module_title'   => $page_val->module_title,
							'module_id'      => $page_val->id,
							'page_id'     	 => $page_val->page_id,
							'page_title'     => $page_val->page_title,
				];
			}
			$arrModuleList = array();

			return view('admin.acl.page_access' ,compact('arrModuleAccess', 'arrRole', 'arrModuleList'));
	}

	/* 
	* Function to list index page with role selection and privilege selection
	*/
	public function edit(Request $request){
		
		$arrRole = Role::get();
		
		$pageaccess = PageAccess::join('page_master','role_page_access.page_id','=','page_master.id')
									->join('module_master','page_master.module_id','=','module_master.id')
									->where('role_page_access.role_id',$request->role_id)
									->where('module_master.role_id',$request->role_id)
									->orderBy('page_master.page_title','asc')
									->get();
		
		$arrModuleList = []; 
			
		foreach ($pageaccess as $page_val){
			$arrModuleList['module'][] 	= $page_val->module_id; 
			$arrModuleList['page'][] 	= $page_val->page_id;
			
		}
		$arrModuleList['role'] = $request->role_id;	
		
		if(empty($arrModuleList['module'])){
			$arrModuleList['module'][]	= 0; 
			$arrModuleList['page'][]	= 0; 
		}
		
		$pageaccess1 = Module::select('module_master.*', 'page_master.id as page_id', 'page_master.page_title')
								->join('page_master','module_master.id','=','page_master.module_id')
								->where('module_master.role_id',$request->role_id)
								->orderBy('page_master.page_title','asc')
								->get();
		
		$arrModuleAccess = []; 
		foreach ($pageaccess1 as $page_val1) 
		{
			$arrModuleAccess[$page_val1->module_title][] = [
						'module_title'   => $page_val1->module_title,
						'module_id'      => $page_val1->id,
						'page_id'     	 => $page_val1->page_id,
						'page_title'     => $page_val1->page_title,
			];
		}	
		
		return view('admin.acl.page_access')-> with(['arrModuleAccess' => $arrModuleAccess, 'arrRole' => $arrRole,'arrModuleList' => $arrModuleList]);
       
	}
	
	/* 
	* Function to store the privilege data
	*/
	public function store(Request $request){
		
		$role_id   		= $request->get('role');
		$arrPrivilege 	= $request->get('arrPrivilege');

		PageAccess::where('role_id', $role_id)->delete();
		
		if(!empty($arrPrivilege)){

			$insertData = array();
			$i = 0;

			foreach($arrPrivilege as $val){
				$insertData[$i]['role_id']		= $role_id;
				$insertData[$i]['page_id']	= $val;
				$i++;	 
			}
			
			$success = PageAccess::insert($insertData);
			if($success){
				return redirect('admin/acl/page_access')->with('success', 'Record saved successfully');
			}else{
			   return redirect('admin/acl/page_access')->with('error', 'Error occur! Please try again.');
			}
		 
		}else{
			return redirect('admin/acl/page_access')->with('error', 'Error occur ! Please try again.');
		}
       
    }
}
