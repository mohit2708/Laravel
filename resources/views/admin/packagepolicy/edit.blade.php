@extends('layouts/admin/default')
@section('title', 'Edit Policy')
@section('content')
<section class="content-header">
  <h1>
	Package Policy
	<!--small>Admin</small-->
  </h1>
  <ol class="breadcrumb">
	<li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">Edit Package Policy</li>
  </ol>
</section>
<section class="content container-fluid">

     <div class="row">
       <div class="col-sm-12">
	   @include('includes.notifications')
			<div class="box box-info">
				<div class="box-header">
					<h3 class="box-title">Edit Package Policy</h3>
				</div>
				<div class="box-body">
					<form action ="{{url('admin/package/policy/update/'.$dataFeaturepolicy->id)}}" class="form-horizontal" id="validForm" method="POST" enctype="multipart/form-data">
						{!! csrf_field() !!}
						<div class="row">
							<input type="hidden" name="policyoldimage" value="{{$dataFeaturepolicy->icon}}" >
							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12">
										<label>Name</label>
										<input type="text" name="policy_name" class="form-control" value="{{$dataFeaturepolicy->policy_name}}" placeholder="Policy Name">
										@if ($errors->has('policy_name'))
											<div class="error small">{{ $errors->first('policy_name') }}</div>
										@endif
									</div>
								</div>
								
							</div>

							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-9">
										<label>Feature Icon</label>
										<input class="form-control" name="policy_img" type="file">
										@if ($errors->has('policy_img'))
											<div class="error small">{{ $errors->first('policy_img') }}</div>
										@endif
									</div>
									<div class="col-sm-3" style="margin-top: 20px;">
										@if($dataFeaturepolicy->policy_img)
										<img src="{{url('public/images/package_policy/icon/'.$dataFeaturepolicy->policy_img)}}" height="50" width="50">
										@endif
									</div>
								</div>
							</div>
							
							
							
							<div class="clearfix"></div>
							
							<div class="col-sm-12">
								<div class="form-group">
									<div class="col-sm-12">
										<label>Description</label>
										<textarea class="form-control" name="description" placeholder="Package Description" rows="5">{{$dataFeaturepolicy->description}}</textarea>
										@if ($errors->has('description'))
											<div class="error small">{{ $errors->first('description') }}</div>
										@endif
									</div>
								</div>
								
							</div>
							
						</div>
						<div class="form-group">
							<div class="col-sm-12 text-right">
								<a href="{{ url('admin/package/policy') }}"><button class="btn btn-danger" type="button">Cancel</button></a>
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
		policy_name:{
			required : true,
		}

	},
});
</script>

@endsection