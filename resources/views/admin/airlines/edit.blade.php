@extends('layouts/admin/default')
@section('title', 'Edit Airlines')
@section('content')
<section class="content-header">
  <h1>
	Airlines
	<!--small>Admin</small-->
  </h1>
  <ol class="breadcrumb">
	<li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">Edit Airlines</li>
  </ol>
</section>
<section class="content container-fluid">

     <div class="row">
       <div class="col-sm-12">
	   @include('includes.notifications')
			<div class="box box-info">
				<div class="box-header">
					<h3 class="box-title">Edit Airlines</h3>
				</div>
				<div class="box-body">
					<form action ="{{url('admin/master/airlines/update/'.$dataAirlines->id)}}" class="form-horizontal" id="validForm" method="POST" enctype="multipart/form-data">
						{!! csrf_field() !!}
						<div class="row">	
							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12">
										<label>Name</label>
										<input type="text" name="airlines_name" class="form-control" value="{{ $dataAirlines->airlines_name }}" placeholder="Feature Name">
										@if ($errors->has('airlines_name'))
											<div class="error small">{{ $errors->first('airlines_name') }}</div>
										@endif
									</div>
								</div>
								
							</div>

							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12">
										<label>Short Code</label>
										<input type="text" name="short_code" class="form-control" value="{{ $dataAirlines->short_code }}" placeholder="Short Code">
										@if ($errors->has('short_code'))
											<div class="error small">{{ $errors->first('short_code') }}</div>
										@endif
									</div>
								</div>
								
							</div>
							
							
							
							<div class="clearfix"></div>
							
							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-9">
										<label>Airline Logo</label>
										<input class="form-control" name="airlines_logo" type="file">
										@if ($errors->has('airlines_logo'))
											<div class="error small">{{ $errors->first('airlines_logo') }}</div>
										@endif
									</div>
									<div class="col-sm-3" style="margin-top: 20px;">
										@if($dataAirlines->airlines_logo)
										<img src="{{url('public/images/airlines/icon/'.$dataAirlines->airlines_logo)}}" height="50" width="50">
										@endif
									</div>
								</div>
							</div>
							
							
						</div>
						<div class="form-group">
							<div class="col-sm-12 text-right">
								<a href="{{ url('admin/master/airlines') }}"><button class="btn btn-danger" type="button">Cancel</button></a>
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
		airlines_name:{
			required : true,
		},
		airlines_logo:{
			required : true,
		},
		short_code:{
			required : true,
		}
	},
});
</script>
@endsection