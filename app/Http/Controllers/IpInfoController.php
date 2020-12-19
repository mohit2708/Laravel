<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\IpOperation;
use App\DeviceInfo;
use App\IpRules;
use DB;

class IpInfoController extends Controller
{
    public function index(Request $request)
    {	
    	$iprules = IpRules::all();  
    	$ipopertion = IpOperation::all();
    	$showdeviceinfo = DeviceInfo::all(); 

    	$main_array = [];
	      foreach( $showdeviceinfo as $interfaceinf){
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
        return view('ip_table', compact('showdeviceinfo','main_array','iprules','ipopertion'));     
    }

    public function getIpOpertion(Request $request){
    	$getipoprtion = IpOperation::where('id', $request['ip_id'])->first();	 		
		 return $getipoprtion;
    }

    public function deleteIpOpertion(Request $request){

    	$ipopration = IpOperation::where('id', $request['selectitem'])->first();  

        $ipopration->add_delete    = $request->get('add_delete');
        $ipopration->ip_flag 	  = 0;

        $ipopration->update();        
        return redirect('ip-info')->with('success', 'Rule deleted successfully');
    }


    public function showIpRules(){
    	$iprules = IpRules::all();
        $spt = $dpt = $to_ip = $to_port = '--';                
    	$detail_value=[]; 
    	foreach($iprules as $key => $iprule){

           switch(trim($iprule->target)) {

              case 'ACCEPT':
              	$detail_value = $this->findRouteDetails($iprules[$key]->rule_details);
             	$iprule->osp=$detail_value['osp'];
             	$iprule->odp=$detail_value['odp'];
             	$iprule->tr_src_add=$detail_value['tr_add'];
             	$iprule->tr_src_port=$detail_value['tr_port'];
             	$iprule->tr_dest_add=$detail_value['tr_add'];
             	$iprule->tr_dest_port=$detail_value['tr_port'];
             	$iprules[$key] = $iprule;
             	//dd($iprule->spt);
                break;

              case 'SNAT':             
              	$detail_value = $this->findRouteDetails($iprules[$key]->rule_details);
	         	$iprule->osp=$detail_value['osp'];
	         	$iprule->odp=$detail_value['odp'];
	         	$iprule->tr_src_add=$detail_value['tr_add'];
	         	$iprule->tr_src_port=$detail_value['tr_port'];
	         	$iprule->tr_dest_add='--';
	         	$iprule->tr_dest_port='--';
              $iprules[$key] = $iprule;
              break;

              case 'DNAT' :             
              	$detail_value = $this->findRouteDetails($iprules[$key]->rule_details);
	         	$iprule->osp=$detail_value['osp'];
	         	$iprule->odp=$detail_value['odp'];
	         	$iprule->tr_src_add='--';
	         	$iprule->tr_src_port='--';
	         	$iprule->tr_dest_add=$detail_value['tr_add'];
	         	$iprule->tr_dest_port=$detail_value['tr_port'];
              	$iprules[$key] = $iprule;
              	break;


           }
            
        }
   		return view('ip_rules', compact('iprules'));

    }

    public static function findRouteDetails($rule) {
    	$osp=$odp=$tr_add=$tr_port="--";                            
	      if(strpos($rule, 'spt')) {      
	         $osp=explode(':', $rule)[1];	         
	      }else if(strpos($rule, 'dpt')) {      
	         $odp=explode(':', $rule)[1];
	      }else if(strpos($rule, 'to')) {      
	         $tr_add=explode(':', $rule)[0];
	         $tr_port=explode(':', $rule)[1];
	      } 
	      return array("osp"=>$osp,"odp"=>$odp,"tr_add"=>$tr_add,"tr_port"=>$tr_port); 		
   }

    public function IPStore(Request $request){
    	//dd($request->all());
		$this->validate($request,[
			'device_serial_number'	=> 'required',
			'frules'			=> 'required',
        ]);	

   		   $trans_desti_add = $request->trans_desti_add;
   		   $trans_desti_port = $request->trans_desti_port;   		   
   		   if($trans_desti_add && $trans_desti_port){
   		   		$desti_add_port = $trans_desti_add . ':' . $trans_desti_port;
   		   }else if($trans_desti_add != null){
   		   		$desti_add_port =$trans_desti_add;
   		   }else{
   		   		$desti_add_port =$trans_desti_port;
   		   }

   		   $inrule_desti_add = $request->incom_addressi;
   		   $inrule_desti_port = $request->incom_port1;
   		   if($inrule_desti_add && $inrule_desti_port){
   		   		$inrule_add_port = $inrule_desti_add . ':' . $inrule_desti_port;
   		   }else if($inrule_desti_add != null){
   		   		$inrule_add_port =$inrule_desti_add;
   		   }else{
   		   		$inrule_add_port =$inrule_desti_port;
   		   }



   		   $trans_source_add = $request->trans_source_add;
   		   $trans_source_port = $request->trans_source_port;
   		   if($trans_source_add && $trans_source_port){
   		   		$source_add_port = $trans_source_add.':'. $trans_source_port;
   		   }else{
   		   		$source_add_port = $trans_source_add;
   		   }

   		   $inout_source_add = $request->inout_addressi;
   		   $inout_source_port = $request->inout_port1;
   		   if($inout_source_add && $inout_source_port){
   		   		$inout_add_port = $inout_source_add.':'. $inout_source_port;
   		   }else{
   		   		$inout_add_port = $inout_source_add;
   		   }


   		   // $source_add_port = ($trans_source_add && $trans_source_port) ? $trans_source_add.':'. $trans_source_port :null;



		   $ipinfo         		  		= new IpOperation;		   
		   $ipinfo->device_serial  	  	= trim($request->device_serial_number);	//device Serial
		   $ipinfo->rule_type  	  		= $request->frules;					//Rules
		   $ipinfo->in_interface  		= ($request->in_interface == 'default')?null:$request->in_interface;			//In Interface
		   $ipinfo->out_interface   	= ($request->out_interface == 'default')?null:$request->out_interface;			//Out Interface 
		   $ipinfo->protocol   			= $request->protocol;				//Protocol
		   $ipinfo->orginal_desti_ip	= $request->cidestination_ip;		//orginal_desti_ip
		   $ipinfo->orginal_desti_port  = $request->odpdestination_ip;		//orginal_desti_port
		   $ipinfo->orginal_source_ip  	= $request->osidestination_ip;		//osidestination_ip
		   $ipinfo->orginal_source_port = $request->osportsource_ip;		//orginal_source_port

		   if(($request->ruleaction_in_out_for != '')){
		   	$ipinfo->rule_action   		= $request->ruleaction_in_out_for;
		   }elseif(($request->t_dest_type != '')){
		   	$ipinfo->rule_action   		= $request->t_dest_type;
		   }elseif(($request->t_source_type != '')){
				$ipinfo->rule_action   		= $request->t_source_type;
		   }elseif(($request->ruleaction_incom != '')){
		   		$ipinfo->rule_action   		= $request->ruleaction_incom;
		   }else{
		   	$ipinfo->rule_action = $request->ruleaction_inout;
		   }

		   if(($desti_add_port != '')){
		   	$ipinfo->translate_desti_address  = $desti_add_port;
		   }elseif($inrule_add_port != ''){
		   	$ipinfo->translate_desti_address  = $inrule_add_port;
		   }else{

		   }

		   if(($source_add_port != '')){
		   $ipinfo->translate_source_address = $source_add_port;	
		   }else{
		   	$ipinfo->translate_source_address = $inout_add_port;
		   }
				   



		   $ipinfo->redirect_port   	= $request->redirect_port;		   
		   //$ipinfo->masquerade_select   = $request->masquerade_port;
		   //$ipinfo->masquerade_port  	= $request->masquerade_port;			   
		   $ipinfo->add_delete   		= $request->add_delete;          
		   $ipinfo->save();
		  
		   return redirect('ip-info')->with('success', 'IP Information added successfully');
    
	}

	public function InterfaceAjax(Request $request){

		$showdeviceinfo = DeviceInfo::all();
    	$main_array = [];
	      foreach( $showdeviceinfo as $interfaceinf){
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
	      $device_serial=$request->device_serial;
	      $ip_value=[];
	      foreach($main_array as $key){
	      	if($key['device_serial']==$device_serial){
	      		$ip_value[]=$key['ip'];
	      	}
	      }
	    return $ip_value;
	}
    
}
