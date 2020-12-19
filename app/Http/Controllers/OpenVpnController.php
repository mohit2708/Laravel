<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Mail\FileDownloaded;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use File;
use App\OpenVpnConfig;
use App\DeviceInfo;

class OpenVpnController extends Controller
{
    public function index(Request $request)
    {	
      $showdeviceinfo = DeviceInfo::all();        
      $openvpninfo = OpenVpnConfig::all();        
      return view('open_vpn', compact('showdeviceinfo','openvpninfo'));     
    }

    public function exportData(Request $request)
    { 
      $this->validate($request,[          
          'device_serial_number'  => 'required',  
          'description'  => 'required',        
        ]);

      $dsname = $request->input('device_serial_number');   

      $data = $request->description;
      $fileName = $dsname . '.conf'; 
      $filepath = File::put(public_path('/device_serial_files/'.$fileName),$data);
      //return Response::download(public_path('/device_serial_files/'.$fileName));
      $filepath = '/device_serial_files/'.$fileName;


      $vpningo = new OpenVpnConfig;
      $checkfile = OpenVpnConfig::where('serial_device', '=', $request->input('device_serial_number'))->first();      
      $test = empty( $checkfile );
      if ($test ) {
          $vpningo->serial_device       = trim($request->input('device_serial_number'));
          $vpningo->openvpn_config_file = trim($filepath);
          $vpningo->save();
      }else{          
          $vpningo = OpenVpnConfig::where('serial_device', $request['device_serial_number'])->first();
          $vpningo->openvpn_flag = 0;
          $vpningo->update();
      }
      
      return redirect('open-vpn')->with('success', 'File Download successfully');
  }

}
