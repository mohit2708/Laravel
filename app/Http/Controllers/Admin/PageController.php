<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Module;
use App\Page;
use App\Role;
use Session;
use Helper; 
use DB;

class PageController extends Controller
{
    
	/*
	* Page List
	*/
    public function index(Request $request){
		
		$arrModule = Module::get();
		$arrRoles  = Role::get();
		
		$role 		= $request->get('role');
		$module 	= $request->get('module');
		$title 		= $request->get('title');
		$showMenu 	= $request->get('show_on_menu');
        try{
            $arrPages = Page::select('page_master.*', 'module_master.module_title', 'roles.role_title')
							->join('module_master','page_master.module_id','=','module_master.id')
							->join('roles','roles.id','=','page_master.role_id')
							->orderBy('page_master.id', 'desc');
							if($role){
								$arrPages->where('page_master.role_id', $role);
							}
							if($title){
								$arrPages->where('page_title', 'like', '%'.$title.'%');
							}
							if($module){
								$arrPages->where('module_id', $module);
							}
							if($showMenu){
								$arrPages->where('page_show_menu', $showMenu);
							}
			$arrPages = $arrPages->paginate(10);

            return view('admin.acl.page.index', compact('arrModule', 'arrRoles', 'arrPages'));

        }catch(\Exception $ex){ 
            return redirect()->back()->with('error', 'Error occurred. Please Try again!');
        }
    }
	
	/*
	* Page Add Get Method
	*/
	public function add(){
		$arrRoles 	= Role::get();
		$arrModule	= Module::get();
		return view('admin.acl.page.add', compact('arrModule', 'arrRoles'));
	}
	
	
	/*
	* Module Store
	*/
    public function store(Request $request){
			
        $this->validate($request,[
            'page_name'		=> 'required|min:3|max:100|Regex:/^[a-z-.]+( [a-z-.]+)*$/i',
            'role'			=> 'required',
            'module'		=> 'required',
            'slug'			=> 'required',
            'page_show'		=> 'required',
            'priority'		=> 'required|numeric'
        ]);
		
		try{
			
			$page 					= new Page;
			$page->role_id 			= $request->role;
			$page->module_id 		= $request->module;
			$page->page_title 		= $request->page_name;
			$page->slug		 		= $request->slug;
			$page->page_show_menu	= $request->page_show;
			$page->priority		 	= $request->priority;
			$page->save();
			
            return redirect('admin/acl/page')->with('success', 'Page added successfully');
			
        }catch(\Exception $e){
            return redirect()->back()->with('error', 'Error occurs! Please try again!');
            
        }
    }
	
	/*
	* Page Edit
	*/
	
	public function edit($id){
		
		$arrModule = Module::get();
		$arrRoles 	= Role::get();
		$dataPage = Page::where('id', $id)->first();
		
		return view('admin.acl.page.edit', compact('arrRoles', 'arrModule', 'dataPage'));
		
	}
	
	/*
	* Page Update
	*/
    public function update(Request $request, $id){
		
		  $this->validate($request,[
            'page_name'		=> 'required|min:3|max:100|Regex:/^[a-z-.]+( [a-z-.]+)*$/i',
            'role'			=> 'required',
            'module'		=> 'required',
            'slug'			=> 'required',
            'page_show'		=> 'required',
            'priority'		=> 'required|numeric'
        ]);


        try{
			
			$page 					= Page::find($id);
			$page->role_id 			= $request->role;
			$page->module_id 		= $request->module;
			$page->page_title 		= $request->page_name;
			$page->slug		 		= $request->slug;
			$page->page_show_menu	= $request->page_show;
			$page->priority		 	= $request->priority;
			$page->save();
			
            return redirect('admin/acl/page')->with('success', 'Page updated successfully');

		}catch(\Exception $e){
			return redirect()->back()->with('error', 'Error occurs! Please try again!');
		}
                  
        
    }
	
	/*
	* AJAX select modules from user
	*/
	
	public function ajaxRoleModule(Request $request){
		
		$input = $request->all();
		
		if(!empty($input)){
			
			$roleID = $request->get('id');
			
			$data = Module::select('id', 'module_title')
						->where('role_id', $roleID)
						->orderBy('module_title', 'asc')
						->get();
			
			return json_encode($data);
			
		}
		
	}
}
