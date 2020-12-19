@extends('layouts.app')
@extends('layouts.sidebar')
@extends('layouts.header')
@section('content')
<div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                           <div class="row m-t-30">
                              <div class="col-lg-12">
                                <h3 class="title-5 m-b-35">Route Action</h3>
                                <div class="card">                                    
                                    <div class="card-body card-block">
                                    <form action ="{{url('route-opertion/store')}}" method="POST">
                                    {!! csrf_field() !!}
                                       @if ($message = Session::get('success'))
                                       <div class="alert alert-success alert-block">
                                          <button type="button" class="close" data-dismiss="alert">×</button> 
                                          <strong>{{ $message }}</strong>
                                       </div>
                                       @endif 
                                    <div class="card-body card-block">
                                       <div class="row">
                                          <div class="col-lg-6">
                                             <div class="form-group">
                                                  <label for="company" class=" form-control-label">IP Address</label>
                                                  <input type="text" class="form-control @error('network') is-invalid @enderror" id="ip_address" name="ip_address" placeholder="Enter Your IP Address" value="{{ old('ip_address') }}">
                                                   @error('ip_address')
                                                   <span class="invalid-feedback" role="alert">
                                                   <strong>{{ $message }}</strong>
                                                   </span>
                                                   @enderror
                                             </div>
                                          </div>
                                          <div class="col-lg-6">
                                             <div class="form-group">
                                                  <label for="company" class=" form-control-label">NetMask</label>
                                                  <input type="text" class="form-control @error('netmask_value') is-invalid @enderror" id="netmask_value" name="netmask_value" placeholder="NetMask Value" value="{{ old('netmask_value') }}">
                                                   @error('netmask_value')
                                                   <span class="invalid-feedback" role="alert">
                                                   <strong>{{ $message }}</strong>
                                                   </span>
                                                   @enderror
                                             </div>
                                          </div>
                                          <div class="col-lg-6">
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
                                          </div>
                                          <!-- <div class="col-lg-6">
                                             <div class="form-group">
                                                <label>Tunnel IP</label>
                                                <input type="text" class="form-control" id="tunnel_ip" name="tunnel_ip" readonly>
                                             </div>
                                          </div> -->
                                          <div class="col-lg-6">
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
                                          </div>
                                          <div class="col-lg-6">
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
                                          </div>
                                       </div>                        
                                    </div>
                                    <div class="form-actions form-group">
                                       <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                                    </div>
                                 </form>
                              </div>
                                </div>
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>
@endsection