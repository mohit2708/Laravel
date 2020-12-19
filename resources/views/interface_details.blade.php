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
                                <h3 class="title-5 m-b-35">InterFace Details</h3>
                              
                            <div class="table-title">
                             <div class="row">
                                <div class="col-sm-6">
                                 <!--   <form class="form-inline my-2 my-lg-0" action="{{url('interface-details')}}" method="GET">
                                  <input class="form-control" type="search" name="q" placeholder="Device Serial Number"> &nbsp;
                                  <button type="submit" class="btn btn-primary">Search</button>
                                 
                              </form><br>  -->
                              
                                </div>                                
                             </div>
                          </div>
                                    <table class="table table-borderless table-data3 display nowrap" id="interface_details">
                                        <thead>
                                            <tr>
                                                <th>Device Serial Number</th>
                                                <th>InterFace Name</th>
                                                <th>Interface IP</th>                                            
                                            </tr>
                                        </thead>
                                        <tbody>
                                          @foreach($main_array as $roulelist)
                                            <tr>
                                                <td>{{ $roulelist['device_serial'] }}</td>
                                                <td>{{ $roulelist['ip'] }}</td>
                                                <td>{{ $roulelist['interface'] }}</td></tr>
                                            @endforeach                                  
                                        </tbody>
                                    </table>
                              
                                <!-- END DATA TABLE-->
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>
@endsection