@extends('layouts/admin/default')
@section('title', 'Add Package Facility')
@section('content')
<section class="content-header">
  <h1>
	Package Facility
	<!--small>Admin</small-->
  </h1>
  <ol class="breadcrumb">
	<li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">Add Package Facility</li>
  </ol>
</section>

<section class="content container-fluid">
     <div class="row">
       <div class="col-sm-12">
	   @include('includes.notifications')
			<div class="box box-info">
				<div class="box-header">
					<h3 class="box-title">Add Facility</h3>
				</div>
				<div class="box-body">
					<form action ="{{url('admin/package/facility/store')}}" class="form-horizontal" id="validForm" method="POST" enctype="multipart/form-data">
						{!! csrf_field() !!}
						<div class="row">
		
							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12">
										<label>Name</label>
										<input type="text" name="facility_name" class="form-control" value="{{Request::old('facility_name')}}" placeholder="Facility Name">@if ($errors->has('facility_name'))
											<div class="error small">{{ $errors->first('facility_name') }}</div>
										@endif						
									</div>
								</div>
								
							</div>
							
								<div class="col-sm-6">
									<div class="form-group">
										<div class="col-sm-12">
											<label>Icon</label>
											<input type="file" class="form-control" name="facility_img">
											@if ($errors->has('facility_img'))
												<div class="error small">{{ $errors->first('facility_img') }}</div>
											@endif									
										</div>
									</div>
									
								</div>
							
							<div class="clearfix"></div>
							
							<div class="col-sm-12">
								<div class="form-group">
									<div class="col-sm-12">
										<label>Description</label>
										<textarea class="form-control" name="description" placeholder="Facility Description" rows="5"></textarea>
										@if ($errors->has('description'))
											<div class="error small">{{ $errors->first('description') }}</div>
										@endif
										
									</div>
								</div>
								
							</div>
							
						</div>
						<div class="form-group">
							<div class="col-sm-12 text-right">
								<a href="{{ url('admin/package/facility') }}"><button class="btn btn-danger" type="button">Cancel</button></a>
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
		facility_name:{
			required : true,
		}
	},
});
</script>

@endsection