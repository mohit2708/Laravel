<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\RouteOperation;
use App\DeviceInfo;
use DB;

class RouteOperationController extends Controller
{
    public function index(Request $request)
    {
        $showdeviceinfo = DeviceInfo::all();        
        return view('route_operation', compact('showdeviceinfo'));
        //select tunnel_ip from tbl_device_info where device_serial = "U758927";
	}

	// public function getTunnelIp(Request $request){
	// 	$data = DeviceInfo::where('device_serial',$request->device_serial)->first();
	// 	return $data;	
	// }
	
    public function routeStore(Request $request){
		$this->validate($request,[
			'ip_address'			=> 'required',
            'device_serial_number'	=> 'required',
			'network'				=> 'required',
			'route_option'			=> 'required',
			'netmask_value'			=> 'required',
        ]);
		try{
			DB::beginTransaction();
   
			   $routeinfo         		  = new RouteOperation;
			   $routeinfo->ip_address  	  = $request->ip_address;
			   $routeinfo->device_serial  = $request->device_serial_number;
			   $routeinfo->network_type   = $request->network;
			   $routeinfo->netmask_value  = $request->netmask_value;			   
			   $routeinfo->route_option   = $request->route_option;         
			   $routeinfo->save();
   
			   DB::commit();
			   return redirect('route-opertion')->with('success', 'Route Information added successfully');
   
		   }catch(\Exception $e){
			DB::rollback();
			return redirect()->back()->with('error', 'Error occurs! Please try again!');
   			}
	}

}