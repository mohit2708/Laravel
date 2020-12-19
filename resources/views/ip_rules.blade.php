@extends('layouts.app')
@extends('layouts.sidebar')
@extends('layouts.header')
@section('content')
<div class="main-content">
   <div class="section__content section__content--p30">
      <div class="container-fluid">
         <div class="row m-t-30">
            <div class="col-lg-12">
               <h3 class="title-5 m-b-35">IP Rules</h3>
             
               <div class="table-responsive m-b-40">

                  <table class="table table-borderless table-data3 display nowrap" id="ip_tables">
                     <thead>
                        <tr>
                           <th>Device Serial Number</th>
                           <th>Chain Type</th>                           
                           <th>Target</th>
                           <th>Protocol</th>
                           <th>In Interface</th>
                           <th>Out Interface</th>
                           <th>Source Address</th>
                           <th>Destination Address</th>
                           <th>Route Details</th>
                           <th>Original Source Port</th>
                           <th>Original Destination Port</th>
                           <th>Translated Source Address</th> 
                           <th>Translated source Port</th>
                           <th>Translated destination Address</th>
                           <th>Translated destination Port</th>
                        </tr>
                     </thead>
                     <tbody>
                         @foreach($iprules as $iprule)
                        <tr>
                           <td>{{$iprule->device_serial}}</td>
                           <td>{{$iprule->chain_type}}</td>                          
                           <td>{{$iprule->target}}</td>
                           <td>{{$iprule->protocol}}</td>
                           <td>{{$iprule->in_interface}}</td>
                           <td>{{$iprule->out_interface}}</td>
                           <td>{{$iprule->source_address}}</td>
                           <td>{{$iprule->destination_address}}</td>
                           <td>{{$iprule->rule_details}}</td>
                           <td>{{$iprule->osp}}</td>
                           <td>{{$iprule->odp}}</td>
                           <td>{{$iprule->tr_src_add}}</td>
                           <td>{{$iprule->tr_src_port}}</td>
                           <td>{{$iprule->tr_dest_add}}</td>
                           <td>{{$iprule->tr_dest_port}}</td>

                                                      
                        </tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection