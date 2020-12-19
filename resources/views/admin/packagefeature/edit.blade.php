@extends('layouts/admin/default')
@section('title', 'Edit Feature')
@section('content')
<section class="content-header">
  <h1>
	Feature
	<!--small>Admin</small-->
  </h1>
  <ol class="breadcrumb">
	<li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">Edit Feature</li>
  </ol>
</section>
<section class="content container-fluid">

     <div class="row">
       <div class="col-sm-12">
	   @include('includes.notifications')
			<div class="box box-info">
				<div class="box-header">
					<h3 class="box-title">Edit Feature</h3>
				</div>
				<div class="box-body">
					<form action ="{{url('admin/package/feature/update/'.$dataFeature->id)}}" class="form-horizontal" id="validForm" method="POST" enctype="multipart/form-data">
						{!! csrf_field() !!}
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12">
										<label>Feature Name</label>
										<input type="text" name="feature_name" class="form-control" value="{{ $dataFeature->feature_name }}" placeholder="Feature Name">
										@if ($errors->has('feature_name'))
											<div class="error small">{{ $errors->first('feature_name') }}</div>
										@endif
									</div>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-9">
										<label>Feature Icon</label>
										<input class="form-control" name="feature_img" type="file" value="{{ $dataFeature->icon }}"">
										@if ($errors->has('feature_img'))
											<div class="error small">{{ $errors->first('feature_img') }}</div>
										@endif
									</div>
									<div class="col-sm-3" style="margin-top: 20px;">
										@if($dataFeature->feature_img)
										<img src="{{url('public/images/package_feature/icon/'.$dataFeature->feature_img)}}" height="50" width="50">
										@endif
									</div>
								</div>
							</div>
							
							<div class="clearfix"></div>
							
							<div class="col-sm-12">
								<div class="form-group">
									<div class="col-sm-12">
										<label>Feature Description</label>
										<textarea class="form-control" name="description" placeholder="Feature Description" rows="5">{{ $dataFeature->description  }}</textarea>
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