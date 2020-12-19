<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\RouteOperation;
use App\Connection;
use DB;

class DeviceInfoController extends Controller
{
    public function index(Request $request)
    {
        $deviceinfos = DB::table('tbl_route_tables_info as routeinfo')
       ->select('routeinfo.*','deviceinfo.device_serial','deviceinfo.tunnel_ip','deviceinfo.id as deviceinfo_id')->join('tbl_device_info as deviceinfo', 'deviceinfo.id', '=','routeinfo.map_device_key')
           ->get();          
		return view('device_info', compact('deviceinfos'));       
         
	}

}