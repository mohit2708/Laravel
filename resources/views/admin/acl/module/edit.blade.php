@extends('layouts/admin/default')
@section('title', 'Edit Module')
@section('content')
<section class="content-header">
  <h1>
	Module
	<!--small>Admin</small-->
  </h1>
  <ol class="breadcrumb">
	<li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">Edit Module</li>
  </ol>
</section>
<section class="content container-fluid">

     <div class="row">
       <div class="col-sm-12">
	   @include('includes.notifications')
			<div class="box box-info">
				<div class="box-header">
					<h3 class="box-title">Edit Module</h3>
				</div>
				<div class="box-body">
					<form action ="{{url('admin/acl/module/update/'.$dataModule->id)}}" class="form-horizontal" id="validForm" method="POST">
						{!! csrf_field() !!}
						<div class="row">

							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12">
										<label>Select Role</label>
										<select class="form-control" name="role">
											<option value="">--Select--</option>
											@foreach($arrRoles as $role)
											<option value="{{ $role->id }}" {{ ($dataModule->role_id == $role->id) ? 'selected' : '' }}>{{ $role->role_title }}</option>
											@endforeach
										</select>
									</div>
								</div>
								
							</div>
							
							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12">
										<label>Module Title</label>
										<input type="text" name="module_title" class="form-control" value="{{ $dataModule->module_title }}" placeholder="Module Title">
										@if ($errors->has('module_title'))
											<div class="error small">{{ $errors->first('module_title') }}</div>
										@endif
									</div>
								</div>
								
							</div>
							<div class="clearfix"></div>
							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12">
										<label>Icon</label>
										<input type="text" name="icon" class="form-control" value="{{ $dataModule->icon }}" placeholder="Icon">
										@if ($errors->has('icon'))
											<div class="error small">{{ $errors->first('icon') }}</div>
										@endif
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12">
										<label>Priority</label>
										<input type="text" name="priority" class="form-control" value="{{ $dataModule->priority }}" placeholder="Priority">
										@if ($errors->has('priority'))
											<div class="error small">{{ $errors->first('priority') }}</div>
										@endif
									</div>
								</div>
							</div>
							<div class="clearfix"></div>
							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12">
										<label>Show in Menubar</label>
										<select class="form-control" name="show_on_menu">
											<option value="1" {{ ($dataModule->show_on_menu == 1) ? 'selected' : '' }} >Yes</option>
											<option value="2" {{ ($dataModule->show_on_menu == 2) ? 'selected' : '' }} >No</option>
										</select>
									</div>
								</div>
								
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-12 text-right">
								<a href="{{ url('admin/acl/module') }}"><button class="btn btn-danger" type="button">Cancel</button></a>
								<button class="btn btn-theme">Update</button>
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
		module_title:{
			required : true,
			minlength:3
		},
		icon:{
			required : true,
		},
		priority:{
			required : true,
			number : true,
		} 
	},
});
</script>
@endsection