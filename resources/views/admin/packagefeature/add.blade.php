@extends('layouts/admin/default')
@section('title', 'Add Feature')
@section('content')
<section class="content-header">
  <h1>
 Features
	<!--small>Admin</small-->
  </h1>
  <ol class="breadcrumb">
	<li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">Add Featuers</li>
  </ol>
</section>


<section class="content container-fluid">
     <div class="row">
       <div class="col-sm-12">
	   @include('includes.notifications')
			<div class="box box-info">
				<div class="box-header">
					<h3 class="box-title">Add Features</h3>
				</div>
				<div class="box-body">
					<form action ="{{url('admin/package/feature/store')}}" class="form-horizontal" id="validForm" method="POST" enctype="multipart/form-data">
						{!! csrf_field() !!}
						<div class="row">
		
							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12">
										<label>Features Name</label>
										<input type="text" name="feature_name" class="form-control" value="{{Request::old('feature_name')}}" placeholder="Features Name">				@if ($errors->has('feature_name'))
											<div class="error small">{{ $errors->first('feature_name') }}</div>
										@endif						
									</div>
								</div>
								
							</div>
							
								<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12">
										<label>Icon</label>
										<input type="file" class="form-control" name="feature_img">
										@if ($errors->has('feature_img'))
											<div class="error small">{{ $errors->first('feature_img') }}</div>
										@endif									
									</div>
								</div>
								
							</div>
							
							<div class="clearfix"></div>
							
							<div class="col-sm-12">
								<div class="form-group">
									<div class="col-sm-12">
										<label>Features Description</label>
										<textarea class="form-control" name="description" placeholder="Features Description" rows="5"></textarea>
										@if ($errors->has('description'))
											<div class="error small">{{ $errors->first('description') }}</div>
										@endif
										
									</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-12 text-right">
								<a href="{{ url('admin/package/feature') }}"><button class="btn btn-danger" type="button">Cancel</button></a>
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
		feature_name:{
			required : true,
		}
	},
});
</script>
@endsection