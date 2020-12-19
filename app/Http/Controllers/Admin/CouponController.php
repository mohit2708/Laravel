<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Coupon;
use App\Service;
use Session;
use Helper; 
use DB;

class CouponController extends Controller
{
    
	/*
	* Coupon List
	*/
	
    public function index(Request $request){
		
		$name = $request->get('name');
        try{
            $arrCoupon = Coupon::select('coupons.*');
									if($name){
										$arrCoupon->where('coupon_name', 'like', '%'.$name.'%');
									}
			$arrCoupon = $arrCoupon->orderBy('id', 'desc')
									->paginate(10);
			
            return view('admin.coupon.index', compact('arrCoupon'));

        }catch(\Exception $ex){ 
            return redirect()->back()->with('error', 'Error occurred. Please Try again!');
        }
    }
	
	/*
	* Coupons Add Get Method
	*/
	
	public function add(){
		
		return view('admin.coupon.add');
	}
	
	
	/*
	* Coupon Store
	*/
	
    public function store(Request $request){
			
        $this->validate($request,[
            'coupon_name'	=> 'required',
            'coupon_code'	=> 'required',
            'term_and_cond'	=> 'required',
        ]);
		
		try{
			
			$coupon 				= new Coupon;
			$coupon->coupon_name 	= $request->coupon_name;
			$coupon->coupon_code 	= $request->coupon_code;
			$coupon->term_and_cond 	= $request->term_and_cond;
			$coupon->status			= $request->status;
			$coupon->save();
			
            return redirect('admin/coupon')->with('success', 'Coupon added successfully');
			
        }catch(\Exception $e){
            return redirect()->back()->with('error', 'Error occurs! Please try again!');
            
        }
    }
	
	/*
	* Coupon Edit
	*/
	
	public function edit($id){
		
		$dataCoupon = Coupon::where('id', $id)->first();
		return view('admin.coupon.edit', compact('dataCoupon'));
		
	}
	
	/*
	* Coupon Update
	*/

    public function update(Request $request, $id){
		
		$this->validate($request,[
            'coupon_name'	=> 'required',
            'coupon_code'	=> 'required',
            'term_and_cond'	=> 'required',
        ]);

        try{
			
			$coupon 				= Coupon::find($id);
			$coupon->coupon_name 	= $request->coupon_name;
			$coupon->coupon_code 	= $request->coupon_code;
			$coupon->term_and_cond 	= $request->term_and_cond;
			$coupon->status			= $request->status;
			$coupon->save();
			
            return redirect('admin/coupon')->with('success', 'Coupon updated successfully');

		}catch(\Exception $e){
			return redirect()->back()->with('error', 'Error occurs! Please try again!');
		}
    }
	
	/*
	* Coupon Delete
	*/
	
	public function delete($id){
		
		try{
			Coupon::where('id', $id)->delete();	
			return redirect('admin/coupon')->with('success', 'Coupon deleted successfully!');	
		}
		catch (\Exception $ex) {
            return redirect()->back()->with('error', 'Error occurs! Please try again!');
        }
	}
	
	/*
	* Coupon Change Status
	*/
	
	public function status($id) {
		
        $id     = explode('_', $id);
        $db_id  = $id[0];
        $status = $id[1];
        $coupon = Coupon::find($db_id);
        if ($status == 1) {
            $changed_status = 0;
            $msg = 'Coupon inactive successfully!';
        }if ($status == 0) {
            $changed_status = 1;
            $msg = 'Coupon active successfully!';
        }

        try {
            $coupon = Coupon::find($db_id);
            $coupon->status = $changed_status;
            $coupon->save();
        } catch (\Illuminate\Database\QueryException $ex) {
            return redirect()->back()->with('error', 'Status updation failed. Please Try again!');
        }
			return redirect()->back()->with('success', $msg);
    }
}
