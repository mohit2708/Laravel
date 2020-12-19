@extends('layouts/admin/default')
@section('title', 'Edit Currency')
@section('content')
<section class="content-header">
  <h1>
	Currency
	<!--small>Admin</small-->
  </h1>
  <ol class="breadcrumb">
	<li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">Edit Currency</li>
  </ol>
</section>
<section class="content container-fluid">

     <div class="row">
       <div class="col-sm-12">
	   @include('includes.notifications')
			<div class="box box-info">
				<div class="box-header">
					<h3 class="box-title">Edit Currency</h3>
				</div>
				<div class="box-body">
					<form action ="{{url('admin/currency/update/'.$dataCurrency->id)}}" class="form-horizontal" id="validForm" method="POST">
						{!! csrf_field() !!}
						<div class="row">
		
							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12">
										<label>Currency Name</label>
										<input type="text" name="currency_name" class="form-control" value="{{ $dataCurrency->currency_name }}" placeholder="Currency Name">
										@if ($errors->has('currency_name'))
											<div class="error small">{{ $errors->first('currency_name') }}</div>
										@endif
									</div>
								</div>
								
							</div>
							
							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12">
										<label>Currency Sign</label>
										<input type="text" name="currency_sign" class="form-control" value="{{ $dataCurrency->currency_sign }}" placeholder="Currency Sign">
										@if ($errors->has('currency_sign'))
											<div class="error small">{{ $errors->first('currency_sign') }}</div>
										@endif
									</div>
								</div>
							</div>
							
							<div class="clearfix"></div>
							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12">
										<label>Status</label>
										<select class="form-control" name="status">
											<option value="1" {{ ($dataCurrency->status == 1) ? 'selected' : '' }} >Active</option>
											<option value="0" {{ ($dataCurrency->status == 0) ? 'selected' : '' }} >Inactive</option>
										</select>
									</div>
								</div>
								
							</div>
							
						</div>
						<div class="form-group">
							<div class="col-sm-12 text-right">
								<a href="{{ url('admin/currency') }}"><button class="btn btn-danger" type="button">Cancel</button></a>
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
		currency_name:{
			required : true,
		},
		currency_sign:{
			required : true,
		}
	},
});
</script>
@endsection