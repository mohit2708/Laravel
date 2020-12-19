@extends('layouts/admin/default')
@section('title', 'Pages')
@section('content')
<section class="content-header">
  
  <h1>
	Package
	<!--small>Admin</small-->
  </h1>
  <ol class="breadcrumb">
	<li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">Package</li>
  </ol>
</section>
 @include('includes.notifications')
<section class="content container-fluid">

<div class="row">
       <div class="col-sm-12">
          <div class="box box-info">
            <div class="box-header">
              <h3 class="box-title">Package List </h3>
			  <a href="{{ url('admin/package') }}" class="btn btn-theme pull-right" title="Add Page">
				 <i class="fa fa-plus"></i>
				 <span>Add Package</span>
				</a>
            </div>
            <div class="box-body">

			<form action="{{ url('admin/package/list') }}" class="form-horizontal" method="GET">
				<div class="row marbt-lg">
					<div class="col-sm-3">
						<div class="form-group">
							<div class="col-sm-12">
								<label>Package Name</label>
                                                                <input type="text" name="package_name" class="form-control" value="{{ Request::get('package_name') }}" placeholder="Package Name">
							</div>
						</div>
					</div>
					
					
					<div class="col-sm-3">
					<br>
						<button class="btn btn-theme btnmin">Search</button>
						<a href="{{ url('admin/package/list') }}"><button class="btn btn-danger btnmin" type="button">Reset</button></a>
					</div>
				
				</div>
			</form>
			
			
			
		 <table class="table table-striped">
			<thead>
				<tr class="info">
					<th>#</th>
					<th style="text-align: center;">Package Name</th>
					<th style="text-align: center;">Duration</th>
					<th style="text-align: center;">Price</th>
					<th style="text-align: center;">Created Date</th>
					<th style="text-align: center;">Status</th>
                                        <th style="text-align: center;">Controls</th>
				</tr>
			</thead>
			
			<tbody> 
				@if(count($package)>0)
				<?php  $i =(($package->currentpage()-1)* $package->perpage() + 1); ?>
				@foreach($package as $pack)
					<tr>
						<td><?= $i++ ?></td>
						<td align="center">{{$pack->package_name}}</td>
						<td align="center">{{$pack->package_duration_day.' Days, '}}{{$pack->package_duration_day+1}} Night</td>
						<td align="center">{{$pack->price}}</td>
						<td align="center">{{date('F d, Y', strtotime($pack->created_at))}}</td>
                                                <td><a onclick="confirm_active('{{$pack->id.'_'.$pack->status}}')"  style="cursor:pointer;"  >{!!($pack->status=='1')?'<i class="fa fa-toggle-on" aria-hidden="true"></i><span class="text-success success">&nbsp;Active</span>' : '<i class="fa fa-toggle-off" aria-hidden="true"></i><span class="text-danger">&nbsp;Inactive</span>'!!}</a></td>
                                                <td align="center">
                                                    <a href="{{url('admin/package/edit/'.$pack->id)}}" class="btn btn-link" title='edit'><i class="fa fa-edit"></i></a>
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
	{{$package->links()}}
</div>
</div>

</div>
</div>
        
    <div id="active_confirm" class="modal fade" role="dialog">
	  <div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Do you Want to Change Status?</h4>
		  </div>
		  
		  <div class="modal-footer">
			
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			<span id="status_change_id"></span>
			
		  </div>
		</div>

	  </div>
</div>

</section>
@endsection
@section('javascript')
<script>
 function confirm_active(id){
     
	var url="{{url('admin/package/status/')}}";
	var a='<a href="'+url+'/'+id+'" class="btn btn-primary">Confirm</a>';
	$("#status_change_id").html(a);
	$("#active_confirm").modal();
}   
    
jQuery(function($) {
	$("#role").change(function(){
		var roleID = $(this).val();
		if(roleID){
			var token = "{{ csrf_token() }}";
			$.ajax({
				type: "POST",
				url: "{{URL::to('admin/acl/page/ajax')}}",
				data: {  '_token':token, id: roleID}	
			}).done(function(data){
				if(data){
					var obj = jQuery.parseJSON(data);
					var htmlOption = '<option value="">--Select--</option>';
					$.each(obj, function (index, value) {
						htmlOption += '<option value="'+value.id+'">'+value.module_title+'</option>';
						$('#module').html(htmlOption);
					});
					
				}else{
					$("#module").html('<option value="">--Select Role--</option>');
				}	
					
			});
		}else{
			$("#module").html('<option value="">--Select Role--</option>');
		}
	});
});
</script>
@endsection