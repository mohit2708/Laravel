<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Connection;
use App\DeviceInfo;
use App\DeviceInformation;
use Illuminate\Database\QueryException;
use DB;

class ConnectionController extends Controller
{
    public function index(Request $request)
	{ 			
		$connections = DB::table('tbl_route_tables_info as tr' )
		->select('tr.*','tbl_info.tunnel_ip','tbl_info.device_serial','tbl_info.id as tbl_info_id' )
		->join('tbl_device_info as tbl_info', 'tbl_info.route_id', '=','tr.id')
		->get();	
	
		return view('connection_list', compact('connections'));
	}
	
	public function store(Request $request)
	{
		$request->validate([
		'destination' => 'required',
		'gateway' 	  => 'required',		
		],
		[
			'destination.required' => 'The destination field is required.',
			'gateway.required'     => 'gateway',
		]);

		$post = new Connection;
		$post->destination = $request->input('destination');
		$post->gateway     = $request->input('gateway');
		$post->iface     = $request->input('iface');
		//$post->metric      = $request->input('metric');
		$post->save();

		$deviceInfo                 = new DeviceInfo;
		$deviceInfo->route_id		= $post->id;
		$deviceInfo->tunnel_ip   	= $request->tunnel_ip;
		$deviceInfo->device_serial  = $request->device_serial;
		$deviceInfo->save();
		
		return redirect('connection-list')->with('success', 'Connection updated successfully');	
	}

	public function getUserData(Request $request)
    {
		// $Connection = Connection::find($request['user_id']);
		// return $Connection;	
		 $Connection = Connection::join('tbl_device_info','tbl_device_info.route_id','=','tbl_route_tables_info.id')
		 ->select('tbl_device_info.*', 'tbl_route_tables_info.*')->where('tbl_route_tables_info.id', $request['user_id'])->first();		 		
		 return $Connection;			
	}

	public function update(Request $request, $id)
	{  	
		$connection = Connection::find($request->get('selectitem'));
		$connection->destination   = $request->get('destination');
		$connection->gateway  	   = $request->get('gateway');
		$connection->genmask  	   = $request->get('genmask');
		$connection->metric   	   = $request->get('metric');
		$connection->update();

		$diveceinfo = DeviceInfo::where('id', $request->selecttblinfoitem)->first();
		if(isset($diveceinfo)){
		  $diveceinfo->tunnel_ip = $request->get('tunnel_ip');
		  $diveceinfo->device_serial = $request->get('device_serial');
		  $diveceinfo->save();
		}  
		
		return redirect('connection-list')->with('success', 'Connection updated successfully');	
	}

	public function delete($id){		
		Connection::where('id', $id)->delete();	
		DeviceInfo::where('route_id', $id)->delete();
		return redirect('connection-list')->with('success', 'Connection deleted successfully!');	
	}

	/*
		Addon Work
	*/
	public function demoindex(){
		$demos = DeviceInfo::all();		
		return view('demo', compact('demos'));
	}
	public function demoStore(Request $request){
		$this->validate($request,[
            'device_serial_number'	=> 'required',
			'network'				=> 'required',
			'route_option'			=> 'required',
        ]);
		try{
			DB::beginTransaction();
   
			   $devicen         		= new DeviceInformation;
			   $devicen->serial_number  = $request->device_serial_number;
			   $devicen->network  		= $request->network; 
			   $devicen->route  		= $request->route_option;         
			   $devicen->save();
   
			   DB::commit();
			   return redirect('demo')->with('success', 'Device Information added successfully');
   
		   }catch(\Exception $e){
			DB::rollback();
			return redirect()->back()->with('error', 'Error occurs! Please try again!');
   			}
	}
}
