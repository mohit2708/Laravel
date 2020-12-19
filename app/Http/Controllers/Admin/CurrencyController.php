<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Currency;
use Session;
use Helper; 
use DB;

class CurrencyController extends Controller
{
    
	/*
	* Currency List
	*/
    public function index(Request $request){
		
		$name = $request->get('name');
        try{
            $arrCurrency = Currency::select('currency_master.*');
									if($name){
										$arrCurrency->where('currency_name', 'like', '%'.$name.'%');
									}
			$arrCurrency = $arrCurrency->orderBy('id', 'desc')
									->paginate(10);
			
            return view('admin.currency.index', compact('arrCurrency'));

        }catch(\Exception $ex){ 
            return redirect()->back()->with('error', 'Error occurred. Please Try again!');
        }
    }
	
	/*
	* Currency Add Get Method
	*/
	public function add(){
		
		return view('admin.currency.add');
	}
	
	
	/*
	* Currency Store
	*/
	
    public function store(Request $request){
			
        $this->validate($request,[
            'currency_name'	=> 'required',
            'currency_sign'			=> 'required'
        ]);
		
		try{
			
			$currency 					= new Currency;
			$currency->currency_name 	= $request->currency_name;
			$currency->currency_sign 	= $request->currency_sign;
			$currency->is_active 		= 0;
			$currency->status			= 1;
			$currency->save();
			
            return redirect('admin/currency')->with('success', 'Currency added successfully');
			
        }catch(\Exception $e){
            return redirect()->back()->with('error', 'Error occurs! Please try again!');
            
        }
    }
	
	/*
	* Currency Edit
	*/
	
	public function edit($id){
		$dataCurrency = Currency::where('id', $id)->first();
		return view('admin.currency.edit', compact('dataCurrency'));
		
	}
	
	/*
	* Currency Update
	*/

    public function update(Request $request, $id){
		
		$this->validate($request,[
            'currency_name'		=> 'required',
            'currency_sign'		=> 'required'
        ]);

        try{
			
			$currency 					= Currency::find($id);
			$currency->currency_name 	= $request->currency_name;
			$currency->currency_sign 	= $request->currency_sign;
			$currency->status			= 1;
			$currency->save();
			
            return redirect('admin/currency')->with('success', 'Currency updated successfully');

		}catch(\Exception $e){
			return redirect()->back()->with('error', 'Error occurs! Please try again!');
		}
    }
	
	/*
	* Currency Delete
	*/
	public function delete($id){
		try{
			Currency::where('id', $id)->delete();	
			return redirect('admin/currency')->with('success', 'Currency deleted successfully!');	
		}
		catch (\Exception $ex) {
            return redirect()->back()->with('error', 'Error occurs! Please try again!');
        }
	}
}
