<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\RouteOperation;
use App\WanInterface;
use DB;
use App\DeviceInfo;

class InterFaceController extends Controller
{
    public function index(Request $request)
    {	
      $interfaceinfo = DeviceInfo::all();

     // $q = $request->get('q'); 
      //$searchdeviceinfo = DeviceInfo::where( 'device_serial', 'LIKE', '%' . $q . '%' )->get();
      //$searchdeviceinfo = DB::table('tbl_device_info')->where("device_serial","LIKE", "%" . $q . "%")
      //->get();
      $main_array = [];
      foreach( $interfaceinfo as $interfaceinf){
        $interface_with_ip =  $interfaceinf->interface_with_ip;           
        if($interface_with_ip !== ""){
          $interface_with_ip1 = explode(',', $interface_with_ip);
          foreach($interface_with_ip1 as $interface_with_ip2){
            $interface_with_ip3 = explode('::',$interface_with_ip2);
             $a = array(
              'device_serial'=>  $interfaceinf->device_serial,
              'ip'  =>  $interface_with_ip3[0],
              'interface' => $interface_with_ip3[1]
             );
           $main_array [] =  $a;
          }
        }
      }
      return view('interface_details', compact('main_array')); 
	}

  public function indexWanInterface(){
        $wanintefaces = WanInterface::all();
        $showdeviceinfo = DeviceInfo::all();  
        return view('wan_interface', compact('wanintefaces','showdeviceinfo'));
  }

  public function wanInterfaceStore(Request $request){
    //  dd($request);
    $this->validate($request,[
      // 'device_serial_number'      => 'required',
      // 'wan_type'  => 'required',
        ]);
    try{
      DB::beginTransaction();
   
         $wanstore               = new WanInterface;
         $wanstore->serial_device     = trim($request->device_serial_number);
         $wanstore->configuration_type  = trim($request->wan_type);
         $wanstore->ip_address   = $request->ip_address;
         $wanstore->gateway  = $request->gateway;         
         $wanstore->netmask   = $request->netmask_value;         
         $wanstore->DNS_address   = $request->dns;         
         $wanstore->save();          
          
         DB::commit();
         return redirect('wan-interface')->with('success', 'Wan Interface Added Successfully');
   
       }catch(\Exception $e){
      DB::rollback();
      return redirect()->back()->with('error', 'Error occurs! Please try again!');
        }
  }

  public function getWebInterface(Request $request){
       // dd($request->id);
        $webinterface = WanInterface::where('id', $request->id)
       ->get(); 
     //  dd($routeoperation);
       return $webinterface;
      }


  public function WanInterfaceUpdate(request $request){
        $uwaninteface = WanInterface::where('id', $request['selectitem'])->first();       
        $uwaninteface->serial_device    = $request->get('device_serial_number1');
        $uwaninteface->configuration_type = $request->get('wan_type1');
        $uwaninteface->ip_address  = $request->get('ip_address1');
        $uwaninteface->netmask  = $request->get('netmask_value1');
        $uwaninteface->gateway  = $request->get('gateway1');
        $uwaninteface->DNS_address = $request->get('dns1');
        $uwaninteface->wan_flag = 0;
        $uwaninteface->update();        
        return redirect('wan-interface')->with('success', 'Wan Interface Update Successfully');
      }

}