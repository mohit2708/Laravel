@extends('layouts/admin/default')
@section('title', 'Pages')
@section('content')
<section class="content-header">
  <h1>
	Pages
	<!--small>Admin</small-->
  </h1>
  <ol class="breadcrumb">
	<li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">Pages</li>
  </ol>
</section>

<section class="content container-fluid">

<div class="row">
       <div class="col-sm-12">
          <div class="box box-info">
            <div class="box-header">
              <h3 class="box-title">Page List </h3>
			  <a href="{{ url('admin/acl/page/add') }}" class="btn btn-theme pull-right" title="Add Page">
				 <i class="fa fa-plus"></i>
				 <span>Add Page</span>
				</a>
            </div>
            <div class="box-body">

			<form action="{{ url('admin/acl/page') }}" class="form-horizontal" method="GET">
				<div class="row marbt-lg">
					<div class="col-sm-3">
						<div class="form-group">
							<div class="col-sm-12">
								<label>Role</label>
								<select class="form-control" name="role" id="role">
									<option value="">--Select--</option>
									@foreach($arrRoles as $role)
										<option value="{{ $role->id }}" {{ (Request::get('role') == $role->id)? 'selected' : '' }} >{{ $role->role_title }}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>
					
					<div class="col-sm-3">
						<div class="form-group">
							<div class="col-sm-12">
								<label>Module</label>
								<select class="form-control" name="module" id="module">
								<option value="">--Select--</option>
									@foreach($arrModule as $module)
										<option value="{{ $module->id }}" {{ (Request::get('module') == $module->id) ? 'selected' : '' }} >{{ $module->module_title }}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>
				
					<div class="col-sm-3">
						<div class="form-group">
							<div class="col-sm-12">
								<label>Page Title / Button Name</label>
								<input class="form-control" name="title" type="text" value="{{ Request::get('title') }}" placeholder="Title" />
							</div>
						</div>
					</div>
					
					<div class="col-sm-3">
						<div class="form-group">
							<div class="col-sm-12">
								<label>Show in Menu</label>
								<select class="form-control" name="show_on_menu">
									<option value="">--Select--</option>
									<option value="1" {{ (Request::get('show_on_menu') == 1)? 'selected' : '' }} >Yes</option>
									<option value="2" {{ (Request::get('show_on_menu') == 2)? 'selected' : '' }} >No</option>
								</select>
							</div>
						</div>
					</div>
					
					<div class="col-sm-3 text-right fltrbtn">
					
						<button class="btn btn-theme btnmin">Search</button>
						<a href="{{ url('admin/acl/page') }}"><button class="btn btn-danger btnmin" type="button">Reset</button></a>
					</div>
				
				</div>
			</form>
			
			@include('includes.notifications')
			
		 <table class="table table-striped">
			<thead>
				<tr class="info">
					<th>#</th>
					<th style="text-align: center;">Role</th>
					<th style="text-align: center;">Module Name</th>
					<th style="text-align: center;">Page Title / Button</th>
					<th style="text-align: center;">Show in Menu</th>
					<th style="text-align: center;">Created Date</th>
					<th style="text-align: center;">Controls</th>
				</tr>
			</thead>
			
			<tbody> 
				@if(count($arrPages)>0)
				<?php  $i =(($arrPages->currentpage()-1)* $arrPages->perpage() + 1); ?>
				@foreach($arrPages as $page)
					<tr>
						<td><?= $i++ ?></td>
						<td align="center">{{$page->role_title}}</td>
						<td align="center">{{$page->module_title}}</td>
						<td align="center">{{$page->page_title}}</td>
						<td align="center">{!!($page->page_show_menu == 1) ? '<span class="label label-success">Yes</span>' : '<span class="label label-warning">No</span>'!!}</td>
						<td align="center">{{date('F d, Y', strtotime($page->created_at))}}</td>
						<td align="center">
						<a href="{{url('admin/acl/page/edit/'.$page->id)}}" class="btn btn-link" title='edit'><i class="fa fa-edit"></i></a>
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
	{{$arrPages->links()}}
</div>
</div>

</div>
</div>


</section>
@endsection
@section('javascript')
<script>
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