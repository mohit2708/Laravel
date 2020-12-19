@extends('layouts/admin/default')
@section('title', 'Add Policy')
@section('content')
<section class="content-header">
  <h1>
	Package Policy
	<!--small>Admin</small-->
  </h1>
  <ol class="breadcrumb">
	<li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">Add Package Policy</li>
  </ol>
</section>


<section class="content container-fluid">
     <div class="row">
       <div class="col-sm-12">
	   @include('includes.notifications')
			<div class="box box-info">
				<div class="box-header">
					<h3 class="box-title">Add Package Policy</h3>
				</div>
				<div class="box-body">
					<form action ="{{url('admin/package/policy/store')}}" class="form-horizontal" id="validForm" method="POST" enctype="multipart/form-data">
						{!! csrf_field() !!}
						<div class="row">
		
							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12">
										<label>Name</label>
										<input type="text" name="policy_name" class="form-control" value="{{Request::old('policy_name')}}" placeholder="Policy Name">				@if ($errors->has('policy_name'))
											<div class="error small">{{ $errors->first('policy_name') }}</div>
										@endif						
									</div>
								</div>
							</div>
								<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12">
										<label>Icon</label>
										<input class="form-control" name="policy_img" type="file">
										@if ($errors->has('policy_img'))
											<div class="error small">{{ $errors->first('policy_img') }}</div>
										@endif									
									</div>
								</div>
								
							</div>
							
							<div class="clearfix"></div>
							
							<div class="col-sm-12">
								<div class="form-group">
									<div class="col-sm-12">
										<label>Description</label>
										<textarea class="form-control" name="description" placeholder="Package Policy Description" rows="5"></textarea>
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