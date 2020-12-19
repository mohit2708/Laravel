@extends('layouts.app')
@extends('layouts.sidebar')
@extends('layouts.header')
@section('content')
<div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                     <div class="row m-t-30">
                            <div class="col-md-12">
                              <h3 class="title-5 m-b-35">Route Table</h3>
                                <!-- DATA TABLE-->
                                <div class="table-responsive m-b-40">
                                    <table class="table table-borderless table-data3" id="device-info">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Device Serial</th>
                                                <!-- <th>Tunnel IP</th> -->
                                                <th>Destination</th>
                                                <th>Gateway</th>
                                                <th>Genmask</th>
                                                 <th>Flags</th>
                                                 <th>Metric</th>
                                                 <th>Ref</th>
                                                 <th>T Use</th>
                                                 <th>I Face</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          @php $no = 1; @endphp
                                          @foreach($deviceinfos as $deviceinfo)
                                            <tr>
                                              <td>{{ $no++ }}</td>
                                              <td>{{$deviceinfo->device_serial}}</td>
                                              <!-- <td>{{$deviceinfo->tunnel_ip}}</td>       -->
                                              <td>{{$deviceinfo->destination}}</td>      
                                              <td>{{$deviceinfo->gateway}}</td>      
                                              <td>{{$deviceinfo->genmask}}</td>
                           <td>{{$deviceinfo->flags}}</td>
                           <td>{{$deviceinfo->metric}}</td>
                           <td>{{$deviceinfo->ref}}</td>
                           <td>{{$deviceinfo->t_use}}</td>
                           <td>{{$deviceinfo->iface}}</td>            
                                            </tr>
                                            @endforeach 
                                                                          
                                        </tbody>
                                    </table>
                                </div>
                                <!-- END DATA TABLE-->
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>
@endsection