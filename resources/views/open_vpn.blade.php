@extends('layouts.app')
@extends('layouts.sidebar')
@extends('layouts.header')
@section('content')

<div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                           <div class="row m-t-30">
                              <div class="col-lg-12">
                                <h3 class="title-5 m-b-20">Open VPN</h3>


<!-- <input type="file">  -->


                                  @if ($message = Session::get('success'))
                                <div class="alert alert-success alert-block">
                                  <button type="button" class="close" data-dismiss="alert">×</button> 
                                        <strong>{{ $message }}</strong>
                                </div>
                                @endif

                                <div class="vpn-form">
                                <form method="POST" action="{{ url('export-file') }}" enctype="multipart/form-data" name="exportform">
                                {!! csrf_field() !!}
                                  <div class="row">
                                    <div class="col-md-6">   
                                      <div class="form-group">
                                        <label>Device Serial Number</label>
                                        <select class="form-control @error('device_serial_number') is-invalid @enderror" id="device_serial_number" name="device_serial_number">
                                           <option value="" disabled selected>-- Select Serial Number --</option>
                                           @foreach($showdeviceinfo as $dinfo)
                                           <option value="{{$dinfo->device_serial}}">{{$dinfo->device_serial}}</option>
                                           @endforeach
                                        </select>
                                        <span class="invalid-feedback" role="alert"></span>                                        
                                         @error('device_serial_number')
                                          <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                      </div>
                                    </div>
                                    <div class="col-md-3">
                                      <a class="add-icon" href="#"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                                    </div>
                                  </div>  
                                  <div class="row text-append">
                                    <div class="col-md-6">
                                    <div class="custom-file mb-3">
                                      <input type="file" class="custom-file-input" id="upload_file" name="filename">
                                      <label class="custom-file-label" id="upload_file_test" for="upload_file">Choose file</label>
                                    </div>
                                    <div class="form-group">
                                      <textarea class="form-control" name="description" id="description" placeholder=" OpenVPN File Configuration..."></textarea>
</div>
                                      <span class="invalid-feedbacktext" role="alert"></span>

                                       <button type="submit" class="btn btn-info" id="exp_button">File Export</button>
                                    </div>
                                   
                                  </div>
                                </form>
</div>






                                <!-- Start Listing  -->
                                <h3 class="title-5 m-b-20">List Of OpenVPN</h3>
                                    <table class="table table-borderless table-data3">
                                        <thead>
                                            <tr>
                                                <th>Device Serial Number</th>
                                                <th>Config File Path</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                         @foreach($openvpninfo as $vpninfo)                       
                                            <tr>
                                                <td>{{$vpninfo->serial_device}}</td>
                                                <td>{{$vpninfo->openvpn_config_file}}</td>
                                                <!-- <td><?php echo base_path(); ?>{{$vpninfo->openvpn_config_file}}</td> -->

                                                <td><a href="{{$vpninfo->openvpn_config_file}}" download><i class="fas fa-download"></i></a></td>
              
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <!-- End Listing  -->
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>


@endsection