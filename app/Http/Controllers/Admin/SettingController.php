<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Role;
use App\Currency;
use App\Setting;
use Session;
use Helper; 
use DB;

class SettingController extends Controller
{
    
	/*
	* Setting PAge
	*/
	
    public function setting(Request $request){
		
		$input = $request->all();
		
		if(!empty($input)){
			try{
				if($request->type == 'currency'){
					
					Currency::where('is_active', 1)->update(['is_active' => 0]);
					Currency::where('id', $request->currency)->update(['is_active' => 1]);
					return redirect()->back()->with('success', 'Setting updated successfully...');
					
				}elseif($request->type == 'points'){
					
					Setting::where('type', 'bonus_points')->update(['points' => $request->point, 'amount' => $request->amount]);
					return redirect()->back()->with('success', 'Setting updated successfully...');
					
				}
				return redirect()->back()->with('error', 'Error occurred. Please Try again!');
			}catch(\Exception $ex){ 
				return redirect()->back()->with('error', 'Error occurred. Please Try again!');
			}
		}
		
		$arrCurrency = Currency::where('status', 1)->get();
		$activeCurrency = Currency::where('is_active', 1)->first();
		$arrBonusInfo = Setting::where('type', 'bonus_points')->first();
        return view('admin.setting', compact('arrCurrency','arrBonusInfo', 'activeCurrency'));

    }

}
