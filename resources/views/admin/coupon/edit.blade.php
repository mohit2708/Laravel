@extends('layouts/admin/default')
@section('title', 'Edit Coupon')
@section('content')
<section class="content-header">
  <h1>
	Coupon
	<!--small>Admin</small-->
  </h1>
  <ol class="breadcrumb">
	<li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">Edit Coupon</li>
  </ol>
</section>
<section class="content container-fluid">

     <div class="row">
       <div class="col-sm-12">
	   @include('includes.notifications')
			<div class="box box-info">
				<div class="box-header">
					<h3 class="box-title">Edit Coupon</h3>
				</div>
				<div class="box-body">
					<form action ="{{url('admin/coupon/update/'.$dataCoupon->id)}}" class="form-horizontal" id="validForm" method="POST">
						{!! csrf_field() !!}
						<div class="row">
		
							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12">
										<label>Coupon Name</label>
										<input type="text" name="coupon_name" class="form-control" value="{{ $dataCoupon->coupon_name }}" placeholder="Coupon Name">
										@if ($errors->has('coupon_name'))
											<div class="error small">{{ $errors->first('coupon_name') }}</div>
										@endif
									</div>
								</div>
								
							</div>
							
							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12 input-group">
										<label>Coupon Code</label>
										<input type="text" name="coupon_code" class="form-control" value="{{ $dataCoupon->coupon_code }}" placeholder="Coupon Code" rel="gp" data-size="32" data-character-set="a-z,A-Z,0-9,#" readonly="readonly">
										<span class="input-group-btn"><button type="button" class="btn btn-default btn-lg getNewPass"><span class="fa fa-refresh"></span></button></span>
										@if ($errors->has('coupon_code'))
											<div class="error small">{{ $errors->first('coupon_code') }}</div>
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
											<option value="1" {{ ($dataCoupon->status == 1) ? 'selected' : '' }} >Active</option>
											<option value="0" {{ ($dataCoupon->status == 0) ? 'selected' : '' }} >Inactive</option>
										</select>
									</div>
								</div>
								
							</div>
							
							<div class="clearfix"></div>
							
							<div class="col-sm-12">
								<div class="form-group">
									<div class="col-sm-12">
										<label>Terms and Conditions</label>
										<textarea class="form-control" name="term_and_cond" placeholder="Terms and Conditions" rows="5">{{ $dataCoupon->term_and_cond }}</textarea>
										@if ($errors->has('term_and_cond'))
											<div class="error small">{{ $errors->first('term_and_cond') }}</div>
										@endif
									</div>
								</div>
								
							</div>
							
						</div>
						<div class="form-group">
							<div class="col-sm-12 text-right">
								<a href="{{ url('admin/coupon') }}"><button class="btn btn-danger" type="button">Cancel</button></a>
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
		coupon_name:{
			required : true,
		},
		coupon_code:{
			required : true,
		},
		expire_date:{
			required : true,
		},
		term_and_cond:{
			required : true,
		}
	},
});
</script>

@endsection