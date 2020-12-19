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
               <h3 class="title-5">Route List</h3>
               <a href="#addEmployeeModal" class="btn btn-success" data-toggle="modal"><i class="fa fa-plus"></i><span>Add New Route</span></a> 
            </div>              
                  <div class="table-title">
                     <div class="row">
                        <div class="col-sm-6">
                          <!--  <form class="form-inline my-2 my-lg-0" action="{{url('route-list')}}" method="GET">
                              <input class="form-control" type="search" name="q" placeholder="Device Serial Number"> &nbsp;
                              <button type="submit" class="btn btn-primary">Search</button>
                           </form> -->
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
                           <th>IP Address</th>
                           <th>Network Type</th>
                           <th>Route Option</th>
                           <th>Netmask Value</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($roulelists as $roulelist)
                        @if($roulelist->route_option != 'Delete')
                        <tr>
                           <td>{{$roulelist->device_serial}}</td>
                           <td>{{$roulelist->ip_address}}</td>
                           <td>{{$roulelist->network_type}}</td>
                           <td>{{$roulelist->route_option}}</td>
                           <td>{{$roulelist->netmask_value}}</td>

                           <td><a href="#editEmployeeModal" class="btn delete-btn route_opertion_edit {{ ($roulelist->route_option == 'Delete')? 'disabled':'asd' }}" conid="{{$roulelist->id}}" data-toggle="modal"><span><i class="fa fa-trash"></i></span></a></td>
                        </tr>
                        @endif
                        @endforeach                                  
                     </tbody>
                  </table>
               
               <!-- END DATA TABLE-->
            </div>
         </div>
      </div>
   </div>
</div>

<!-- add Modal HTML -->
<div id="addEmployeeModal" class="modal fade">
   <div class="modal-dialog">
      <div class="modal-content">
         <form action ="{{url('route-opertion/store')}}" method="POST">
            {!! csrf_field() !!}
            <div class="modal-header">
               <h4 class="modal-title">Add New Route</h4>
               <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
               <div class="form-group">
                  <label>IP Address</label>
                  <input type="text" class="form-control @error('network') is-invalid @enderror" id="ip_address" name="ip_address" placeholder="Enter Your IP Address" value="{{ old('ip_address') }}">
                  @error('ip_address')
                  <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                  </span>
                  @enderror
               </div>
               <div class="form-group">
                  <label>NetMask</label>
                  <input type="text" class="form-control @error('netmask_value') is-invalid @enderror" id="netmask_value" name="netmask_value" placeholder="Ex: 8 OR 16 OR 24 OR 32" value="{{ old('netmask_value') }}">
                  @error('netmask_value')
                  <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                  </span>
                  @enderror
               </div>
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
                  <label>Network</label>
                  <select class="form-control @error('network') is-invalid @enderror" id="network" name="network">
                     <option value="" disabled selected>-- Select Network --</option>
                     <option value="LTE">LTE</option>
                     <option value="WAN">WAN</option>
                  </select>
                  @error('network')
                  <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                  </span>
                  @enderror
               </div>
               <div class="form-group">
                  <label>Route Option</label>
                  <select class="form-control @error('route_option') is-invalid @enderror" id="route_option" name="route_option">
                     <option value="" disabled selected>-- Select Route Option --</option>
                     <option value="Add">Add</option>
                     <option value="Delete">Delete</option>
                  </select>
                  @error('route_option')
                  <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                  </span>
                  @enderror
               </div>
               <!-- <div class="form-group">
                  <label>Phone</label>
                  <input type="text" class="form-control" required>
                  </div> -->          
            </div>
            <div class="modal-footer">
               <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">         
               <button type="submit" class="btn btn-primary btn-sm">Submit</button>
            </div>
         </form>
      </div>
   </div>
</div>
<!-- Edit Model -->
<div id="editEmployeeModal" class="modal fade">
   <div class="modal-dialog">
      <div class="modal-content">
         <form method="POST" action ="{{ url('operation-update') }}">
            @csrf
            <input type="hidden" name="selectitem" id="selectitem" value=""> 
            <div class="modal-header">
               <h4 class="modal-title">Delete Route</h4>
               <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
               <div class="form-group">
                  <label>IP</label>
                  <input type="text" id="ip_address1" name="ip_address1" value="" class="form-control" required readonly>
               </div>
               <div class="form-group">
                  <label>NetMask Value </label>
                  <input type="text" id="netmask_value1" name="netmask_value1" value="" class="form-control" required readonly>
               </div>
               <div class="form-group">
                  <label>Device Serial Number</label>
                  <input type="text" class="form-control" id="device_serial_number1" name="device_serial_number1" value="" readonly="readonly">


                 <!--  <select class="form-control" id="device_serial_number1" name="device_serial_number1" readonly>
                     <option value="" disabled selected>-- Select Serial Number --</option>
                     @foreach($showdeviceinfo as $dinfo)
                     <option value="{{$dinfo->device_serial}}">{{$dinfo->device_serial}}</option>
                     @endforeach
                  </select> -->
               </div>
               <div class="form-group">
                  <label>Network</label>
                  <input type="text" class="form-control" id="network1" name="network1" value="" readonly="readonly">

                 <!--  <select class="form-control @error('network') is-invalid @enderror" id="network1" name="network1" readonly>
                     <option value="" disabled selected>-- Select Network --</option>
                     <option value="LTE">LTE</option>
                     <option value="WAN">WAN</option>
                  </select> -->
               </div>
               <div class="form-group">
                  <label>Route Option</label>
                  <select class="form-control @error('route_option') is-invalid @enderror" id="route_option1" name="route_option1" >
                     <!-- <option value="" disabled selected>-- Select Route Option --</option> -->
                     <!-- <option value="Add">Add</option> -->
                     <option value="Delete" selected>Delete</option>
                  </select>
               </div>
            </div>
            <div class="modal-footer">
               <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
               <input type="submit" id="update" class="btn btn-info" value="Delete">
            </div>
         </form>
      </div>
   </div>
</div>
@endsection