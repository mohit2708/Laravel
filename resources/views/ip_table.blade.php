@extends('layouts.app')
@extends('layouts.sidebar')
@extends('layouts.header')
@section('content')
<div class="main-content">
   <div class="section__content section__content--p30">
      <div class="container-fluid">
         <div class="row m-t-30">
            <div class="col-lg-12">
              <div class="title-bar">
               <h3 class="title-5">IP Table</h3>
               <a href="#addIPModal" class="btn btn-success" data-toggle="modal"><i class="fa fa-plus"></i> <span>Add New Rule</span></a>  
</div>
               @if ($message = Session::get('success'))
               <div class="alert alert-success alert-block">
                  <button type="button" class="close" data-dismiss="alert">×</button> 
                  <strong>{{ $message }}</strong>
               </div>
               @endif
               <div class="table-responsive m-b-40">
              
                  <table class="table table-borderless table-data3 display nowrap" id="ip_tables" style="width:100%">
                     <thead>
                        <tr>
                           <th>Device Serial Number</th>
                           <th>Rule Type</th>                           
                           <th>In Interface</th>
                           <th>Out Interface</th>
                           <th>Protocol</th>
                           <th>Orginal Destination IP</th>
                           <th>Orginal Destination Port</th>
                           <th>Orginal Source IP</th>
                           <th>Orginal Source Port</th>                        
                           <th>Rule Action</th>
                           <th>Translate Destination Address</th>
                           <th>Translate Source Address</th>
                           <th>Add/Delete</th>                  
                           <th>Action</th>                           
                        </tr>
                     </thead>
                     <tbody>
                         @foreach($ipopertion as $ipoper)
                          @if($ipoper->add_delete != 'DELETE')
                        <tr>
                           <td>{{$ipoper->device_serial}}</td>
                           <td>{{$ipoper->rule_type}}</td>                          
                           <td>{{ $ipoper->in_interface === null ? "--" : $ipoper->in_interface}}</td>
                        <td>{{ $ipoper->out_interface === null ? "--" : $ipoper->out_interface}}</td>
                        <td>{{ $ipoper->protocol === null ? "--" : $ipoper->protocol}}</td>
                        <td>{{ $ipoper->orginal_desti_ip === null ? "--" : $ipoper->orginal_desti_ip}}</td>
                        <td>{{ $ipoper->orginal_desti_port === null ? "--" : $ipoper->orginal_desti_port}}</td>
 <td>{{ $ipoper->orginal_source_ip === null ? "--" : $ipoper->orginal_source_ip}}</td>
 <td>{{ $ipoper->orginal_source_port === null ? "--" : $ipoper->orginal_source_port}}</td>
 <td>{{ $ipoper->rule_action === null ? "--" : $ipoper->rule_action}}</td>
 <td>{{ $ipoper->translate_desti_address === null ? "--" : $ipoper->translate_desti_address}}</td>
 <td>{{ $ipoper->translate_source_address === null ? "--" : $ipoper->translate_source_address}}</td>
                           <td>{{$ipoper->add_delete}}</td>
                           <td><a href="#editIPModal" class="btn delete-btn ip_edit {{ ($ipoper->add_delete == 'DELETE')? 'disabled':'asd' }}" conid="{{$ipoper->id}}" data-toggle="modal"><span><i class="fa fa-trash"></i></span></a></td>                       
                        </tr>
                        @endif
                        @endforeach
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- Add Moduel -->
<div id="addIPModal" class="modal fade">
   <div class="modal-dialog">
      <div class="modal-content">
         <form action ="{{url('ip-info/store')}}" method="POST" id="fiptables">
            {!! csrf_field() !!}
            <input type="hidden" name="selectitem" id="selectitem" value="">
            <div class="modal-header">
               <h4 class="modal-title">Add New Rule</h4>
               <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                                <label>Device Serial Number</label>
                                <select class="form-control @error('network') is-invalid @enderror" id="device_serial_number" name="device_serial_number">
                                   <option value="">-- Select Device Number --</option>
                                   @foreach($showdeviceinfo as $dinfo)
                                   <option value="{{$dinfo->device_serial}}">{{$dinfo->device_serial}}</option>
                                   @endforeach  
                                </select>
                                @error('device_serial_number')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                        </div>
                    </div>
                   <div class="col-sm-6">
                        <div class="form-group">
                          <label>Rules Type</label>
                      <select class="form-control @error('network') is-invalid @enderror" id="frules" name="frules" disabled><!-- onchange="ShowHideDiv(this);" -->
                         <option value="" selected>-- Select Your Rule --</option>
                         <option id="IN-F" value="IN-F">InComing Traffic</option>
                         <option id="OUT-F" value="OUT-F">OutGoing Traffic</option>
                         <option id="FOR-F" value="FOR-F">Forword Traffic</option>
                         <option id="PRE-NAT" value="PRE-NAT">Pre Routing Using NAT Table</option>
                         <option id="POST-NAT" value="POST-NAT">Post Routing Using NAT Table</option>
                         <option id="IN-NAT" value="IN-NAT">Incoming Rule For NAT Table</option>
                         <option id="OUT-NAT" value="OUT-NAT">Outgoing Rule For NAT Table</option>
                      </select>                  
                       </div>
                   </div>
               </div>
               <div class="row">
                   <div class="col-sm-12">   
                       <div class="form-group" id="sin_interface">
                            <label>In Interface</label>
                            <select class="form-control @error('network') is-invalid @enderror" id="in_interface" name="in_interface">
                                <option value="" disabled selected>-- Select Interface --</option>
                            </select>                
                       </div>
                   </div>
                   <div class="col-sm-12">
                       <div class="form-group" id="sout_interface" style="display: none;">
                            <label>Out Interface</label>
                            <select class="form-control @error('network') is-invalid @enderror" id="out_interface" name="out_interface">
                                <option value="" disabled selected>-- Select Interface --</option>
                                
                            </select>                
                       </div>
                   </div> 
                </div>
               <div class="row">
                   <div class="col-sm-12">            
                       <div class="form-group">
                            <label>Protocol</label>
                            <select class="form-control" id="protocol" name="protocol">
                                <option value="" selected>-- Select Protocol --</option>
                                <option value="tcp">TCP</option>
                                <option value="udp">UDP</option>
                                <option value="icmp">ICMP</option>    
                            </select>                
                       </div>
                   </div>
               </div>
                <div class="row">
                   <div class="col-sm-6">
                      <div class="form-group">
                         <label>Original Destination IP</label>
                         <select class="form-control" 
                            id="original_destination_iP" name="original_destination_iP">
                            <option value="" selected>-- Select Destination IP --</option>
                            <option value="Custom-IP" selected>Custom IP</option>
                            <option value="anywhere">AnyWhere</option>
                         </select>
                      </div>
                   </div>
                   <div class="col-sm-6">
                      <div class="form-group" id="odipdip">
                         <label class="original_dest_label">Destination IP</label>
                         <!-- <input type="text" class="form-control" id="cidestination_ip" name="cidestination_ip" placeholder="Enter Your Destination IP" value="{{ old('netmask_value') }}"> -->  
                         <input type="text" class="form-control" id="cidestination_ip" name="cidestination_ip" placeholder="Destination IP" value="">             
                      </div>
                      <!-- <div class="form-group" id="odianyip" style="display: none;">
                        <label>Anywhere IP</label>
                        <input type="text" class="form-control @error('odipanywhere_ip') is-invalid @enderror" id="odipanywhere_ip" name="odipanywhere_ip" value="0.0.0.0/0" readonly>                
                      </div> -->
                   </div>
                </div> 
                <!-- Original Destination Port -->
                <div class="row">
                   <!-- <div class="col-sm-6">
                        <div class="form-group">
                        <label>Original Destination Port</label>
                            <select class="form-control" 
                            id="original_destination_port" name="original_destination_port">
                                <option value="" selected>-- Select Destination Port --</option>
                                <option value="Custom-IP" selected>Custom Port</option>
                                <option value="anywhere">AnyWhere</option>
                            </select>                
                        </div>
                   </div> -->
                   <div class="col-sm-12">
                      <div class="form-group" id="odportdestip">
                         <label class="original_dest_port_label">Destination Port</label>
                         <input type="text" class="form-control" id="odpdestination_ip" name="odpdestination_ip" placeholder="Destination Port" value="" readonly>                
                      </div>
                      <!-- <div class="form-group" id="odportanyip" style="display: none;">
                        <label>Anywhere Port</label>
                        <input type="text" class="form-control @error('odanywhere_ip') is-invalid @enderror" id="odanywhere_ip" name="odanywhere_ip" value="0.0.0.0/0" readonly>                
                      </div> -->
                   </div>
                </div>
                <!-- ORIGINAL SOURCE IP -->
                <div class="row">
                   <div class="col-sm-6">
                        <div class="form-group">
                            <label>Original Source IP</label>
                            <select class="form-control" 
                            id="original_source_ip" name="original_source_ip">
                                <option value="">-- Select Source IP --</option>
                                <option value="Custom-IP" selected>Custom IP</option>
                                <option value="anywhere">AnyWhere</option>
                            </select>                
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group" id="osipdestip">
                             <label class="src_ip_label">Source IP</label>
                             <input type="text" class="form-control" id="osidestination_ip" name="osidestination_ip" placeholder="Source IP" value="">                
                        </div>
                    </div>
                </div>
                <!-- ORIGINAL SOURCE PORT -->
                <div class="row">
                   <!-- <div class="col-sm-6">
                        <div class="form-group">
                            <label>Original Source Port</label>
                            <select class="form-control" 
                            id="original_source_port" name="original_source_port">
                                <option value="" selected>-- Select Destination Port --</option>
                                <option value="Custom-IP">Custom Port</option>
                                <option value="anywhere">AnyWhere</option>
                            </select>                
                        </div>
                    </div> -->
                    <div class="col-sm-12">
                        <div class="form-group" id="osportdestip">
                             <label>Source Port</label>
                             <input type="text" class="form-control" id="osportsource_ip" name="osportsource_ip" placeholder="Source Port" value="" readonly>                
                        </div>
                    </div>
                    <div class="col-sm-12">   
                       <div class="form-group" id="rule_action_in_out_for">
                            <label>Rules Action</label>
                            <select class="form-control" id="ruleaction_in_out_for" name="ruleaction_in_out_for">
                                <option value="" selected>-- Select Your Action --</option>
                                <option value="ACCEPT">ACCEPT</option>
                                <option value="DROP">DROP</option>
                                <option value="REJECT">REJECT</option>
                            </select>                
                       </div>
                    </div>
                </div>
                <div class="row rule_action_incom">
                  <div class="col-sm-6">
                    <div class="form-group">
                            <label>Rules Action in</label>
                            <select class="form-control" id="ruleaction_incom" name="ruleaction_incom">
                                <option value="" selected>-- Select Your Action --</option>
                                <option value="ACCEPT">ACCEPT</option>  
                             <option value="SNAT">SNAT</option>
                             <option value="">NULL</option>
                            </select>                
                       </div>
                  </div>
                  <!--  -->
                   <div class="col-sm-3">
                        <div class="form-group incom_address">
                             <label>Destination IP</label>
                             <input readonly type="text" class="form-control" id="incom_addressi" name="incom_addressi" placeholder="Destination IP">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group incom_port">
                             <label>Destination Port</label>
                             <input readonly type="text" class="form-control" id="incom_port1" name="incom_port1" placeholder="Destination Port">       
                        </div>
                    </div>
                </div>
                <!-- Rule Action Out -->
                <div class="row rule_action_inout">
                  <div class="col-sm-6">
                    <div class="form-group">
                            <label>Rules Action Out</label>
                            <select class="form-control" id="ruleaction_inout" name="ruleaction_inout">
                                <option value="" selected>-- Select Your Action --</option>
                                <option value="ACCEPT">ACCEPT</option>  
                             <option value="DNAT">DNAT</option>
                             <option value="">NULL</option>
                            </select>                
                       </div>
                  </div>
                  <!--  -->
                   <div class="col-sm-3">
                        <div class="form-group inout_address">
                             <label>Destination IP</label>
                             <input readonly type="text" class="form-control" id="inout_addressi" name="inout_addressi" placeholder="Destination IP">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group inout_port">
                             <label>Destination Port</label>
                             <input readonly type="text" class="form-control" id="inout_port1" name="inout_port1" placeholder="Destination Port">       
                        </div>
                    </div>
                </div>


                


                <div class="row destination">
                    <div class="col-sm-6">
                        <label>Translated Destination</label>
                          <select class="form-control" id="t_dest_type" name="t_dest_type">
                             <option value="">-- Select Destination --</option>
                             <option value="DNAT">DNAT</option>    
                             <option value="">NULL</option>
                             <!-- <option value="dnat_redirect">Redirect</option>                    -->
                          </select>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group dnat_address">
                             <label>Destination IP</label>
                             <input readonly type="text" class="form-control" id="trans_desti_add" name="trans_desti_add" placeholder="Translated Destination IP">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group dnat_redirect_port">
                             <label>Destination Port</label>
                             <input readonly type="text" class="form-control" id="trans_desti_port" name="trans_desti_port" placeholder="Translated Destination Port">       
                        </div>
                    </div>
                </div>
                <div class="row source">
                    <div class="col-sm-6">
                        <label>Translated Source</label>
                          <select class="form-control" id="t_source_type" name="t_source_type">
                             <option value="">-- Select Source --</option>
                             <option value="SNAT">SNAT</option>
                             <option value="">NULL</option>    
                             <!-- <option value="snat_redirect">Redirect</option>                    -->
                          </select>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group snat_address">
                             <label>Source IP</label>
                             <input readonly type="text" class="form-control" id="trans_source_add" name="trans_source_add" placeholder="Translated Source Address">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group snat_redirect_port">
                             <label>Source Port</label>
                             <input readonly type="text" class="form-control" id="trans_source_port" name="trans_source_port" placeholder="Translated Source Port">                
                        </div>
                    </div>
                </div>
                <div class="row red1">
                    <!-- <div class="col-sm-6">
                      <div class="form-group">
                         <label>Redirect</label>
                         <select class="form-control" 
                            id="redirect_port" name="redirect_port">
                            <option value="" selected>-- Select Redirect Port --</option>
                            <option value="yes">Yes</option>
                            <option value="yes_with_port">Yes With Port</option>
                         </select>
                      </div>
                    </div> -->
                    <!-- <div class="col-sm-6">
                      <div class="form-group" id="odipdip">
                         <label class="yes_with_port_label">Yes With Port</label>
                         <input type="text" class="form-control" id="yes_w_port" name="yes_w_port" placeholder="Yes With Port" value="">             
                      </div>
                    </div> -->
                    <!-- <div class="col-sm-12">
                        <div class="form-group">
                          <label>Redirect</label>
                          <input type="text" class="form-control" id="redirect_port" name="redirect_port" placeholder="Redirect Port">                 
                        </div>
                    </div> -->
                </div>
               <!--  <div class="row redmas">
                    <div class="col-sm-12">
                        <div class="form-group">
                          <label>Masquerade</label>
                          <input type="text" class="form-control" id="masquerade_port" name="masquerade_port" placeholder="Masquerade Port">                  
                        </div>
                    </div>
                </div> -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                          <label>Add/ Delete</label>
                          <select class="form-control" id="add_delete" name="add_delete" disabled> 
                            <option value="" selected>-- Select Add/Delete --</option>  
                            <option value="ADD">ADD</option>
                            <option value="DELETE">DELETE</option>
                          </select>                  
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
               <button type="submit" id="dsubmit" class="btn btn-primary btn-sm" disabled>Submit</button>
               <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>
            </div>
         </form>
      </div>
   </div>
</div>

<!-- Edit Model -->
<div id="editIPModal" class="modal fade">
   <div class="modal-dialog">
      <div class="modal-content">
         <form action ="{{url('ipoperation-delete')}}" method="POST" id="fiptables">
            {!! csrf_field() !!}
            <input type="hidden" name="selectitem" id="selectitem" value="">
            <div class="modal-header">
               <h4 class="modal-title">Delete Rule</h4>
               <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                                <label>Device Serial Number</label>
                                <input type="text" class="form-control" id="device_serial_number" name="device_serial_number" value="" readonly="readonly">
                        </div>
                    </div>
                   <div class="col-sm-6">
                        <div class="form-group">
                          <label>Rules Type</label>
                          <input type="text" class="form-control" id="frules" name="frules" value="" readonly="readonly">              
                       </div>
                   </div>
               </div>
               <div class="row">
                   <div class="col-sm-6">   
                       <div class="form-group" id="sin_interface">
                            <label>In Interface</label>
                            <input type="text" class="form-control" id="in_interface" name="in_interface" value="" readonly="readonly">      
                       </div>
                   </div>
                   <div class="col-sm-6">
                       <div class="form-group" id="sout_interface">
                            <label>Out Interface</label>
                            <input type="text" class="form-control" id="out_interface" name="out_interface" value="" readonly="readonly">                                   
                       </div>
                   </div> 
                </div>
               <div class="row">
                   <div class="col-sm-12">            
                       <div class="form-group">
                            <label>Protocol</label>
                            <input type="text" class="form-control" id="protocol" name="protocol" value="" readonly="readonly">               
                       </div>
                   </div>               </div>
                <div class="row">
                   <div class="col-sm-6">            
                       <div class="form-group">
                            <label>Original Destination IP</label>
                            <input type="text" class="form-control" id="cidestination_ip" name="cidestination_ip" value="" readonly="readonly">               
                       </div>
                   </div>
                   <div class="col-sm-6">
                      <div class="form-group">
                         <label>Original Destination Port</label>
                         <input type="text" class="form-control" id="cidestination_port" name="cidestination_port" value="" readonly="readonly">
                      </div>
                   </div>
                </div> 
                <!-- Original Destination Port -->
                <div class="row">
                   <div class="col-sm-6">
                      <div class="form-group" id="odipdip">
                         <label>Original Source IP</label> 
                         <input type="text" class="form-control" id="cidestination_ip1" name="cidestination_ip1" placeholder="" value="" readonly="readonly">             
                      </div>
                   </div>
                   <div class="col-sm-6">
                      <div class="form-group" id="odportdestip">
                         <label>Original Source Port</label>
                         <input type="text" class="form-control" id="odpdestination_port" name="odpdestination_port" placeholder="" value="" readonly="readonly">                
                      </div>
                   </div>
                    <div class="col-sm-12">
                        <div class="form-group" id="rule_actionadr1">
                          <label>Rules Action</label>
                           <input type="text" class="form-control" id="layout_select" name="layout_select" placeholder="" value="" readonly="readonly">                                          
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                          <label>Action</label>
                          <input type="text" class="form-control" id="add_delete" name="add_delete" placeholder="" value="DELETE" readonly="readonly">
                          <!-- <select class="form-control" id="add_delete" name="add_delete"> 
                            <option value="DELETE">DELETE</option>
                          </select>  -->                 
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
               <button type="submit" id="dsubmit" class="btn btn-primary btn-sm">Delete</button>
               <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>
            </div>
         </form>
      </div>
   </div>
</div>




@endsection