<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\RouteOperation;
use App\Connection;
use DB;
use App\DeviceInfo;

class RouteListController extends Controller
{
    public function index(Request $request)
    {	     
      $showdeviceinfo = DeviceInfo::orderBy('id', 'DESC')->get();
      $roulelists = RouteOperation::orderBy('id', 'DESC')->get();
      $q = $request->get('q');
        
      //$roulelists = DB::table('tbl_route_operation')

      // $roulelists = DB::table('tbl_route_tables_info as routeinfo')
      // ->select('routeinfo.*','operationroute.*','deviceinfo.device_serial','deviceinfo.id as deviceinfo_id')
      // ->join('tbl_device_info as deviceinfo', 'deviceinfo.id', '=','routeinfo.map_device_key')
      // ->join('tbl_route_operation as operationroute', 'operationroute.ip_address', '=','routeinfo.destination')
      //    ->orwhere('deviceinfo.device_serial','LIKE','%'.$q.'%')
      //    ->groupBy('operationroute.ip_address')
      //    ->get();  
      //    //dd($roulelists);
      //    //->paginate(2);       
      return view('route_list', compact('roulelists','showdeviceinfo')); 
         
	  }
      public function getOpertianRoute(Request $request){
       // dd($request->id);

        $routeoperation = RouteOperation::where('id', $request->id)
       ->get(); 
     //  dd($routeoperation);
       return $routeoperation;
      }

      public function OpertionUpdate(request $request){
        $routeopration = RouteOperation::where('id', $request['selectitem'])->first();       
        $routeopration->ip_address    = $request->get('ip_address1');
        $routeopration->device_serial = $request->get('device_serial_number1');
        $routeopration->network_type  = $request->get('network1');
        $routeopration->route_option  = $request->get('route_option1');
        $routeopration->netmask_value = $request->get('netmask_value1');
        $routeopration->route_flag = 0;
        $routeopration->update();        
        $msg=($request->get('route_option1') == 'Add')?'Route Information Added Successfully':'Route Information Deleted Successfully';
        return redirect('route-list')->with('success', $msg);
      }

}