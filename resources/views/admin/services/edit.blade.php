@extends('layouts/admin/default')
@section('title', 'Edit Service')
@section('content')
<section class="content-header">
  <h1>
	Service
	<!--small>Admin</small-->
  </h1>
  <ol class="breadcrumb">
	<li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">Edit Service</li>
  </ol>
</section>
<section class="content container-fluid">

     <div class="row">
       <div class="col-sm-12">
	   @include('includes.notifications')
			<div class="box box-info">
				<div class="box-header">
					<h3 class="box-title">Edit Service</h3>
				</div>
				<div class="box-body">
					<form action ="{{url('admin/service/update/'.$dataService->id)}}" class="form-horizontal" id="validForm" method="POST">
						{!! csrf_field() !!}
						<div class="row">
		
							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12">
										<label>Service Name</label>
										<input type="text" name="service_name" class="form-control" value="{{ $dataService->service_name }}" placeholder="Service Name">
										@if ($errors->has('service_name'))
											<div class="error small">{{ $errors->first('service_name') }}</div>
										@endif
									</div>
								</div>
								
							</div>
							
							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12">
										<label>Status</label>
										<select class="form-control" name="status">
											<option value="1" {{ ($dataService->status == 1) ? 'selected' : '' }} >Active</option>
											<option value="0" {{ ($dataService->status == 0) ? 'selected' : '' }} >Inactive</option>
										</select>
									</div>
								</div>
								
							</div>
							
							<div class="clearfix"></div>
							
							<div class="col-sm-12">
								<div class="form-group">
									<div class="col-sm-12">
										<label>Service Description</label>
										<textarea class="form-control" name="description" placeholder="Service Description" rows="5">{{ $dataService->description  }}</textarea>
										@if ($errors->has('description'))
											<div class="error small">{{ $errors->first('description') }}</div>
										@endif
									</div>
								</div>
								
							</div>
							
						</div>
						<div class="form-group">
							<div class="col-sm-12 text-right">
								<a href="{{ url('admin/service') }}"><button class="btn btn-danger" type="button">Cancel</button></a>
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
		service_name:{
			required : true,
		}
	},
});
</script>

@endsection