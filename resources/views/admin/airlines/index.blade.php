@extends('layouts/admin/default')
@section('title', 'Airlines')
@section('content')
<section class="content-header">
  <h1>
	Airlines
	<!--small>Admin</small-->
  </h1>
  <ol class="breadcrumb">
	<li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">Airlines</li>
  </ol>
</section>


<section class="content container-fluid">
@include('includes.notifications')
<div class="row">
       <div class="col-sm-12">
          <div class="box box-info">
            <div class="box-header">
              <h3 class="box-title">Airlines</h3>
								<a href="{{ url('admin/master/airlines/add') }}" class="btn btn-theme pull-right" title="Add Service">
				 <i class="fa fa-plus"></i>
				 <span>Add Airlines</span>
				</a>
				            </div>
            <div class="box-body">


			<form action="{{ url('admin/master/airlines') }}" class="form-horizontal" method="GET">
				<div class="row marbt-lg">
					<div class="col-sm-3">
						<div class="form-group">
							<div class="col-sm-12">
								<label>Airlines</label>
								<input class="form-control" name="name" type="text" value="{{ Request::get('name') }}" placeholder="Airlines">
							</div>
						</div>
					</div>
					<div class="col-sm-3 text-right fltrbtn">
						<label class="fltrbtn-lab">&nbsp;</label>
						<button class="btn btn-theme btnmin">Search</button>
						<a href="{{ url('admin/master/airlines') }}"><button class="btn btn-danger btnmin" type="button">Reset</button></a>
					</div>
				
				</div>
			</form>

			
						
		 <table class="table table-striped">
   <thead>
      <tr class="info">
         <th>#</th>
         <th>Airlines Name</th>
         <th>Short Code</th>
         
         <th style="text-align: center;">Controls</th>
      </tr>
   </thead>
   <tbody>

@if(count($arrAirlines)>0)
<?php  $i =(($arrAirlines->currentpage()-1)* $arrAirlines->perpage() + 1); ?>
 @foreach($arrAirlines as $key => $airlines)	  
      <tr>
         <td> <?= $i++ ?></td>
         <td>{{$airlines->airlines_name}}</td>
          <td>{{$airlines->short_code}}</td>
        
         
         <td align="center">
            <a href="{{url('admin/master/airlines/edit/'.$airlines->id)}}" class="btn btn-link" title="Edit"><i class="fa fa-edit"></i></a>
           <a onclick="confirm_delete({{$airlines->id}});" class="btn btn-link" title='Delete'><i class="fa fa-trash"></i></a>
         </td>

      </tr>
      
      @endforeach 
        @else
          <tr>
            <td colspan="10"><i>No Data Found</i></td>
          </tr>
        @endif 
   </tbody>
</table>
 
</div>
<div class="col-sm-12 text-center">
{{$arrAirlines->links()}}	
</div>
</div>

</div>
</div>


</section>

<div id="delete_confirm" class="modal fade" role="dialog">
    <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title">Are you sure? You want to Delete!</h4>
      </div>
      
      <div class="modal-footer">
      
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      <span id="delete_butt_id"></span>
      
      </div>
    </div>

    </div>
</div>
@endsection
@section('javascript')
<script type="text/javascript">
function confirm_delete(id){
  var url="{{url('admin/master/airlines/delete/')}}";
  var a='<a href="'+url+'/'+id+'" class="btn btn-primary">Confirm</a>';
  $("#delete_butt_id").html(a);
  $("#delete_confirm").modal();
} 
</script>
@endsection