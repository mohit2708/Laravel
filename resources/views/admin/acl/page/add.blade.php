@extends('layouts/admin/default')
@section('title', 'Add Page/Button')
@section('content')
<section class="content-header">
  <h1>
	Page / Button
	<!--small>Admin</small-->
  </h1>
  <ol class="breadcrumb">
	<li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">Add Page/Button</li>
  </ol>
</section>
<section class="content container-fluid">

     <div class="row">
       <div class="col-sm-12">
	   @include('includes.notifications')
			<div class="box box-info">
				<div class="box-header">
					<h3 class="box-title">Add Module Page / Button</h3>
				</div>
				<div class="box-body">
					<form action ="{{url('admin/acl/page/store')}}" class="form-horizontal" id="validForm" method="POST">
						{!! csrf_field() !!}
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12">
										<label>Select Role</label>
										<select class="form-control" name="role" id="role">
											<option value="">--Select--</option>
											@foreach($arrRoles as $role)
												<option value="{{ $role->id }}">{{ $role->role_title }}</option>
											@endforeach
										</select>
										@if ($errors->has('role'))
											<div class="error small">{{ $errors->first('role') }}</div>
										@endif
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12">
										<label>Select Module</label>
										<select class="form-control" name="module" id="module">
											<option value="">--Select--</option>
											@foreach($arrModule as $module)
												<option value="{{ $module->id }}">{{ $module->module_title }}</option>
											@endforeach
										</select>
										@if ($errors->has('module'))
											<div class="error small">{{ $errors->first('module') }}</div>
										@endif
									</div>
								</div>
							</div>
							<div class="clearfix"></div>
							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12">
										<label>Page / Button Name</label>
										<input type="text" name="page_name" class="form-control" value="{{ Request::old('page_name') }}" placeholder="Page / Button Name">
										@if ($errors->has('page_name'))
											<div class="error small">{{ $errors->first('page_name') }}</div>
										@endif
									</div>
								</div>
								
							</div>
							
							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12">
										<label>Page Slug / Button Identifier</label>
										<input type="text" name="slug" class="form-control" value="{{ Request::old('slug') }}" placeholder="admin/modulename/page or button identifier">
										@if ($errors->has('slug'))
											<div class="error small">{{ $errors->first('slug') }}</div>
										@endif
									</div>
								</div>
								
							</div>
							<div class="clearfix"></div>
							
							
							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12">
										<label>Priority</label>
										<input type="text" name="priority" class="form-control" value="{{ Request::old('priority') }}" placeholder="Priority">
										@if ($errors->has('priority'))
											<div class="error small">{{ $errors->first('priority') }}</div>
										@endif
									</div>
								</div>
								
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12">
										<label>Show in Menu</label>
										<select class="form-control" name="page_show">
											<option value="1">Yes</option>
											<option value="2">No</option>
										</select>
										@if ($errors->has('page_show'))
											<div class="error small">{{ $errors->first('page_show') }}</div>
										@endif
									</div>
								</div>
							</div>
							
						</div>
						<div class="form-group">
							<div class="col-sm-12 text-right">
								<a href="{{ url('admin/acl/page') }}"><button class="btn btn-danger" type="button">Cancel</button></a>
								<button class="btn btn-theme">Submit</button>
							</div>
						</div>
					</form>
				</div>
			<!-- /.box-body -->
			</div>
        </div>
     </div>

    </section>
@endsection
@section('javascript')
<script type="text/javascript">
$('#validForm').validate({
	rules: {
			role:{
				required : true,
			},
			module:{
				required : true,
			},
			page_name:{
				required : true,
				minlength:3
			},
			slug:{
				required : true,
				minlength:3
			},
			page_show:{
				required : true,
			},
			priority:{
				required : true,
				number: true
			}
			
		},
});
</script>
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