<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Role;
use App\Module;
use App\BonusInfo;
use Session;
use Helper; 
use DB;

class BonusController extends Controller
{
    
	/*
	* Bonus List
	*/
	
    public function index(Request $request){
		
		$arrBonousInfo['referral'] = BonusInfo::where('type', 1)->first();
		$arrBonousInfo['travel'] = BonusInfo::where('type', 2)->first();

		return view('admin.bonus.index', compact('arrBonousInfo'));
      
    }
	
	/*
	* Referral Bonus Function
	*/
	
	public function referral(Request $request){
		
		BonusInfo::where('type', 1)->update(['point'=> $request->points]);
		return redirect()->back()->with('success', 'Referral bonus information update successfully...!!!');
		
	}
	
	/*
	* Travel Bonus Function
	*/
	
	public function travel(Request $request){
		
		BonusInfo::where('type', 2)->update(['discount'=> $request->discount, 'upto' => $request->upto]);
		return redirect()->back()->with('success', 'Travel bonus information update successfully...!!!');
		
	}

}
