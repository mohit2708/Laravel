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
                                <h3 class="title-5 m-b-35">User List</h3>
                                <div class="table-responsive m-b-40">
                                    <table class="table table-borderless table-data3">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Date</th>
                                                <th>status</th>                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                          @foreach($users as $user)
                                            <tr>
                                                <td>{{ucfirst($user->name)}}</td>
                                                <td>{{$user->email}}</td>
                                                <td>{{date('F d, Y', strtotime($user->created_at))}}</td>
                                                <td class="process"><input data-id="{{$user->id}}" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" {{ $user->status ? 'checked' : '' }}></td>
                                                
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