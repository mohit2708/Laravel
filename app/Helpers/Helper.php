<?php
namespace App\Helpers;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use DB;
use App\User;
use Auth;

class Helper
{
	protected static $redirectTo = Illuminate\Http\Request;


    public static function userDetails($id){

    	$user = DB::table('users')->select('name','photo', 'id')->where('id',$id)->first();
    	return $user;
    }
	
	
	public static function module_assign_list($role_id){

		
		$module_assign_list = DB::table('role_page_access')
								  ->select('module_master.id as module_id','module_master.module_title', 'module_master.icon','page_master.id as page_id','page_master.page_title' ,'page_master.slug')
								  ->join('page_master', 'page_master.id', '=', 'role_page_access.page_id')
								  ->join('module_master', 'page_master.module_id', '=', 'module_master.id')
								  ->where('module_master.role_id',$role_id)
								  ->where('module_master.show_on_menu', 1)
								  ->where('page_master.page_show_menu', 1)
								  ->orderBy('module_master.priority','asc')
								  ->get();
								  

		$module_assign=array();					  
		foreach($module_assign_list as $val)
		{
             $module_assign[$val->module_title][$val->page_title]['slug']=$val->slug;
			 $module_icon[$val->module_title]=$val->icon;
		}
		
		
		$data['sidebar'] = $module_assign;
		$data['icons'] 	 = $module_icon;
		return $data;
		
    }
	
	
	
	
	
	public static function page_access($role_id, $slug)
	{
		$page_access = DB::table('role_page_access')
							  ->join('page_master', 'page_master.id', '=', 'role_page_access.page_id')
							  ->where('role_page_access.role_id',$role_id)
							  ->where('page_master.slug',$slug)
							  ->get();
							  
		if(!$page_access->isEmpty()){
			return true;
		}else{
			return false;
		}
    }
	
	
	

    public static function userRoleName(){
        $id = Auth::user()->id;
        $query = User::with('userRole');
        $query->where('id',$id);
        $users = $query->get()->first();
        return $users;
    }
	
	public static function features_master(){
		
		$query = DB::table('features_master')->where('status',1)->get();
		return $query;
	}
    public static function facility_include_master(){
		
		$query = DB::table('facility_master')->where('status',1)->get();
		return $query;
	} 
	public static function get_city(){
		
		$query = DB::table('city')->where('status',1)->get();
		return $query;
	}
	public static function get_policy(){
		
		$query = DB::table('policy_master')->where('status',1)->get();
		return $query;
	}
	public static function get_dicount(){
		
		$query = DB::table('discount_offers')->where('status',1)->get();
		return $query;
	}



}
