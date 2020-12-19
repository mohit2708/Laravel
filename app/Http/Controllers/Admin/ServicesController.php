<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Currency;
use App\Service;
use Session;
use Helper; 
use DB;

class ServicesController extends Controller
{
    
	/*
	* Services List
	*/
	
    public function index(Request $request){
		
		$name = $request->get('name');
        try{
            $arrService = Service::select('services.*');
									if($name){
										$arrService->where('service_name', 'like', '%'.$name.'%');
									}
			$arrService = $arrService->orderBy('id', 'desc')
									->paginate(10);
			
            return view('admin.services.index', compact('arrService'));

        }catch(\Exception $ex){ 
            return redirect()->back()->with('error', 'Error occurred. Please Try again!');
        }
    }
	
	/*
	* Service Add Get Method
	*/
	
	public function add(){
		
		return view('admin.services.add');
	}
	
	
	/*
	* Service Store
	*/
	
    public function store(Request $request){
			
        $this->validate($request,[
            'service_name'	=> 'required',
        ]);
		
		try{
			
			$service 				= new Service;
			$service->service_name 	= $request->service_name;
			$service->description 	= $request->description;
			$service->status		= $request->status;
			$service->save();
			
            return redirect('admin/service')->with('success', 'Service added successfully');
			
        }catch(\Exception $e){
            return redirect()->back()->with('error', 'Error occurs! Please try again!');
            
        }
    }
	
	/*
	* Service Edit
	*/
	
	public function edit($id){
		
		$dataService = Service::where('id', $id)->first();
		return view('admin.services.edit', compact('dataService'));
		
	}
	
	/*
	* Service Update
	*/

    public function update(Request $request, $id){
		
		$this->validate($request,[
            'service_name'	=> 'required',
        ]);

        try{
			
			$service 				= Service::find($id);
			$service->service_name 	= $request->service_name;
			$service->desription 	= $request->desription;
			$service->status		= $request->status;
			$service->save();
			
            return redirect('admin/service')->with('success', 'Service updated successfully');

		}catch(\Exception $e){
			return redirect()->back()->with('error', 'Error occurs! Please try again!');
		}
    }
	
	/*
	* Service Delete
	*/
	
	public function delete($id){
		
		try{
			Service::where('id', $id)->delete();	
			return redirect('admin/service')->with('success', 'Service deleted successfully!');	
		}
		catch (\Exception $ex) {
            return redirect()->back()->with('error', 'Error occurs! Please try again!');
        }
	}
	
	/*
	* Service Change Status
	*/
	
	public function status($id) {
		
        $id     = explode('_', $id);
        $db_id  = $id[0];
        $status = $id[1];
        $service = Service::find($db_id);
        if ($status == 1) {
            $changed_status = 0;
            $msg = 'Service inactive successfully!';
        }if ($status == 0) {
            $changed_status = 1;
            $msg = 'Service active successfully!';
        }

        try {
            $service = Service::find($db_id);
            $service->status = $changed_status;
            $service->save();
        } catch (\Illuminate\Database\QueryException $ex) {
            return redirect()->back()->with('error', 'Status updation failed. Please Try again!');
        }
			return redirect()->back()->with('success', $msg);
    }
}
