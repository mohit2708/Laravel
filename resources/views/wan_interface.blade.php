@extends('layouts.app')
@extends('layouts.sidebar')
@extends('layouts.header')
@section('content')
<div class="main-content">
   <div class="section__content section__content--p30">
      <div class="container-fluid">
         <div class="row m-t-30">
            <div class="col-md-12">
               <!-- DATA TABLE-->
               <div class="title-bar">
               <h3 class="title-5">Wan Interface</h3>
               <a href="#addWanModal" class="btn btn-success" data-toggle="modal"><i class="fa fa-plus"></i><span>Add Wan Interface</span></a> 
            </div>              
                  <div class="table-title">
                     <div class="row">
                        <div class="col-sm-6">
                           @if ($message = Session::get('success'))
                           <div class="alert alert-success alert-block">
                              <button type="button" class="close" data-dismiss="alert">×</button> 
                              <strong>{{ $message }}</strong>
                           </div>
                           @endif
                           <br> 
                        </div>
                     </div>
                  </div>
                  <table class="table table-borderless table-data3 display nowrap" id="route-list" style="width:100%">
                     <thead>
                        <tr>
                           <th>Device Serial Number</th>
                           <th>Configuration Type</th>
                           <th>IP Address</th>
                           <th>Gateway</th>
                           <th>Netmask</th>
                           <th>DNS</th> 
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($wanintefaces as $waninteface)
                        <tr>
                           <td>{{$waninteface->serial_device}}</td>
                           <td>{{$waninteface->configuration_type}}</td>                           
                           <td>{{ $waninteface->ip_address === null ? "--" : $waninteface->ip_address}}</td>                           
                           <td>{{ $waninteface->gateway === null ? "--" : $waninteface->gateway}}</td>                           
                           <td>{{ $waninteface->netmask === null ? "--" : $waninteface->netmask}}</td>                           
                           <td>{{ $waninteface->DNS_address === null ? "--" : $waninteface->DNS_address}}</td>                           
                           <td><a href="#editWanModal" class="btn delete-btn wan_interface_edit" conid="{{$waninteface->id}}" data-toggle="modal"><span><i class="fa fa-edit"></i></span></a></td>                     
                        </tr>
                        @endforeach                              
                     </tbody>
                  </table>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- add Modal HTML -->
<div id="addWanModal" class="modal fade">
   <div class="modal-dialog">
      <div class="modal-content">
         <form action ="{{url('wan-interface/store')}}" method="POST">
            {!! csrf_field() !!}
            <div class="modal-header">
               <h4 class="modal-title">Add Wan Interface</h4>
               <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
               <div class="form-group">
                  <label>Device Serial Number</label>
                  <select class="form-control @error('network') is-invalid @enderror" id="device_serial_number" name="device_serial_number">
                     <option value="" disabled selected>-- Select Serial Number --</option>
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
               <div class="form-group">
                  <label>Wan Type</label>
                  <select class="form-control @error('network') is-invalid @enderror" id="wan_type" name="wan_type" disabled>
                     <option value="" selected>-- Select WAN Type --</option>
                     <option value="static">STATIC</option>
                     <option value="dhcp">DHCP</option>
                  </select>
                  @error('network')
                  <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                  </span>
                  @enderror
               </div>
               <div class="row">
               <div class="form-group col-sm-6">
                  <label>IP Address</label>
                  <input type="text" class="form-control @error('network') is-invalid @enderror" id="ip_address" name="ip_address" placeholder="Enter Your IP Address" readonly required/>
                  @error('ip_address')
                  <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                  </span>
                  @enderror
               </div>
               <div class="form-group col-sm-6">
                  <label>Getway</label>
                  <input type="text" class="form-control @error('gateway') is-invalid @enderror" id="gateway" name="gateway" placeholder="Gateway" readonly required/>
                  @error('gateway')
                  <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                  </span>
                  @enderror
               </div>
            </div>
            <div class="row">
               <div class="form-group col-sm-6">
                  <label>NetMask</label>
                  <input type="text" class="form-control @error('netmask_value') is-invalid @enderror" id="netmask_value" name="netmask_value" placeholder="NetMask Value" readonly required/>
                  @error('netmask_value')
                  <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                  </span>
                  @enderror
               </div>
               <div class="form-group col-sm-6">
                  <label>DNS</label>
                  <input type="text" class="form-control @error('dns') is-invalid @enderror" id="dns" name="dns" placeholder="DNS" readonly required/>
                  @error('dns')
                  <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                  </span>
                  @enderror
               </div>
            </div>
                        
            </div>
            <div class="modal-footer">
               <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">         
               <button type="submit" class="btn btn-primary btn-sm" id="dsubmit" disabled>Submit</button>
            </div>
         </form>
      </div>
   </div>
</div>
<!-- Edit Model -->
<div id="editWanModal" class="modal fade">
   <div class="modal-dialog">
      <div class="modal-content">
         <form method="POST" id="update-form" action ="{{ url('waninterface-update') }}">
            @csrf
            <input type="hidden" name="selectitem" id="selectitem" value=""> 
            <div class="modal-header">
               <h4 class="modal-title">Edit Wan Interface</h4>
               <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
               <div class="form-group">
                  <label>Device Serial Number</label>
                  <select class="form-control @error('network') is-invalid @enderror" id="device_serial_number1" name="device_serial_number1">
                     <option value="" disabled selected>-- Select Serial Number --</option>
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
               <div class="form-group">
                  <label>Wan Type</label>
                  <select class="form-control @error('network') is-invalid @enderror" id="wan_type1" name="wan_type1">
                     <option value="" selected>-- Select WAN Type --</option>
                     <option value="static">STATIC</option>
                     <option value="dhcp">DHCP</option>
                  </select>
                  @error('network')
                  <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                  </span>
                  @enderror
               </div>
               <div class="row">
               <div class="form-group col-sm-6">
                  <label>IP Address</label>
                  <input type="text" class="form-control @error('network') is-invalid @enderror" id="ip_address1" name="ip_address1" placeholder="Enter Your IP Address" value="" readonly>
                  @error('ip_address')
                  <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                  </span>
                  @enderror
               </div>
               <div class="form-group col-sm-6">
                  <label>Getway</label>
                  <input type="text" class="form-control @error('gateway') is-invalid @enderror" id="gateway1" name="gateway1" placeholder="Gateway" readonly>
                  @error('gateway')
                  <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                  </span>
                  @enderror
               </div>
            </div>
            <div class="row">
               <div class="form-group col-sm-6">
                  <label>NetMask</label>
                  <input type="text" class="form-control @error('netmask_value') is-invalid @enderror" id="netmask_value1" name="netmask_value1" placeholder="NetMask Value" readonly>
                  @error('netmask_value')
                  <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                  </span>
                  @enderror
               </div>
               <div class="form-group col-sm-6">
                  <label>DNS</label>
                  <input type="text" class="form-control @error('dns') is-invalid @enderror" id="dns1" name="dns1" placeholder="DNS" readonly>
                  @error('dns')
                  <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                  </span>
                  @enderror
               </div>
            </div>
                        
            </div>
            <div class="modal-footer">
               <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
               <input type="submit" id="update" class="btn btn-info" value="Update">
            </div>
         </form>
      </div>
   </div>
</div>

@endsection