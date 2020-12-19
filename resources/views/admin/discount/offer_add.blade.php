@extends('layouts/admin/default')
@section('title', 'Add Offer')
@section('content')
<section class="content-header">
  <h1>
	Add Offer
	<!--small>Admin</small-->
  </h1>
  <ol class="breadcrumb">
	<li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">Add Offer</li>
  </ol>
</section>
<section class="content container-fluid">
<div class="row">
	@include('includes.notifications')`
        <!-- Left col -->
	<section class="col-lg-12">
	  <!-- Custom tabs (Charts with tabs)-->
	  <div class="nav-tabs-custom">
		<!-- Tabs within a box -->
		<ul class="nav nav-tabs pull-left">
		  <li class=""><a href="#">Discount Coupons</a></li>
		  <li class="active"><a href="{{url('admin/discount/offer')}}">Discount Offers</a></li>
		</ul>
		<div class="tab-content no-padding">
		  <!-- Morris chart - Sales -->
		  <div class="chart tab-pane active" style="position: relative; overflow: auto">
		  	<br>
			  <div class="col-md-12">
			  	<form action ="{{url('admin/discount/offer/store')}}" class="form-horizontal" id="validForm" method="POST">
						{!! csrf_field() !!}
						<div class="row">
							<div class="col-sm-4">
								<div class="form-group">
									<div class="col-sm-12">
										<label>Offer Name</label>
										<input type="text" name="offer_name" class="form-control" value="{{ Request::old('offer_name') }}" placeholder="Offer Name">
										@if ($errors->has('offer_name'))
											<div class="error small">{{ $errors->first('offer_name') }}</div>
										@endif
									</div>
								</div>
								
							</div>

							<div class="col-sm-4">
								<div class="form-group">
									<div class="col-sm-12">
										<label for="start Date">Start Date</label>
										<div class="input-group">
											<input type="text" name="start_date" class="form-control start-date" placeholder="Start Date" value="{{ Request::old('start_date') }}" />
											<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
											@if ($errors->has('start_date'))
												<div class="error small">{{ $errors->first('start_date') }}</div>
											@endif
										</div>
									</div>
								</div>
							</div>
							
							<div class="col-sm-4">
								<div class="form-group">
									<div class="col-sm-12">
									<label for="start Date">End Date</label>
									<div class="input-group">
										<input type="text" name="end_date" class="form-control end-date" placeholder="End Date" value="{{ Request::old('end_date') }}" />
										<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
										@if ($errors->has('end_date'))
											<div class="error small">{{ $errors->first('end_date') }}</div>
										@endif
									</div>
									</div>
								</div>
							</div>
							<div class="clearfix"></div>
							<div class="col-sm-4">
								<div class="form-group">
									<div class="col-sm-12">
										<label>Discount %</label>
										<input type="text" name="discount_percent" class="form-control" value="{{ Request::old('discount_percent') }}" placeholder="Discount %">
										@if ($errors->has('discount_percent'))
											<div class="error small">{{ $errors->first('discount_percent') }}</div>
										@endif
									</div>
								</div>
								
							</div>

							<div class="col-sm-4">
								<div class="form-group">
									<div class="col-sm-12">
										<label>Up To Discount</label>
										<input type="text" name="upto" class="form-control" value="{{ Request::old('upto') }}" placeholder="Up To Discount">
										@if ($errors->has('upto'))
											<div class="error small">{{ $errors->first('upto') }}</div>
										@endif
									</div>
								</div>
								
							</div>

							<div class="col-sm-4">
								<div class="form-group">
									<div class="col-sm-12">
										<label>Applied at Min Price</label>
										<input type="text" name="min_price" class="form-control" value="{{ Request::old('min_price') }}" placeholder="Price">
										@if ($errors->has('min_price'))
											<div class="error small">{{ $errors->first('min_price') }}</div>
										@endif
									</div>
								</div>
							</div>
							<div class="clearfix"></div>
							<div class="col-sm-4">
								<div class="form-group">
									<div class="col-sm-12">
										<label>Coupon Applied Per Person (U/1/2/3)</label>
										<input type="text" name="per_person" class="form-control" value="{{ Request::old('per_person') }}" placeholder="U/1/2/3">
										@if ($errors->has('per_person'))
											<div class="error small">{{ $errors->first('per_person') }}</div>
										@endif
									</div>
								</div>
							</div>
							
							<div class="col-sm-4">
								<div class="form-group">
									<div class="col-sm-12">
										<label>Maximum Person (U/1/2/3)</label>
										<input type="text" name="max_person" class="form-control" value="{{ Request::old('max_person') }}" placeholder="U/1/2/3">
										@if ($errors->has('max_person'))
											<div class="error small">{{ $errors->first('max_person') }}</div>
										@endif
									</div>
								</div>
							</div>

							<div class="col-sm-4">
								<div class="form-group">
									<div class="col-sm-12">
									<label class="fltrbtn-lab">Select Services</label>
									<select class="multiple" name="service[]" multiple="multiple">
										@foreach($arrServices as $service)
											<option value="{{$service->id}}" {{ (isset($infoDiscountOffer)) ? (in_array($service->id, DiscountController::getServicesIDOffer($infoDiscountOffer->offer_name))) ? 'selected' : '' : '' }}  >{{$service->service_name}}</option>
										@endforeach
									</select>
									@if ($errors->has('service'))
										<div class="error small">{{ $errors->first('service') }}</div>
									@endif
								</div>
								</div>
								
							</div>
							
							<div class="clearfix"></div>
							
							<div class="col-sm-12">
								<div class="form-group">
									<div class="col-sm-12">
										<label>Terms and Conditions</label>
										<textarea class="form-control" name="term_and_cond" placeholder="Terms and Conditions" rows="5">{{ Request::old('term_and_cond') }}</textarea>
										@if ($errors->has('term_and_cond'))
											<div class="error small">{{ $errors->first('term_and_cond') }}</div>
										@endif
									</div>
								</div>
								
							</div>
							
						</div>
						<div class="form-group">
							<div class="col-sm-12 text-right">
								<a href="{{ url('admin/discount/offer') }}"><button class="btn btn-danger" type="button">Cancel</button></a>
								<button class="btn btn-theme">Submit</button>
							</div>
						</div>
					</form>
		
			</div>

		  </div>
		
		</div>
	  </div>
	  <!-- /.nav-tabs-custom -->
	</section>
	<!-- /.Left col -->
  </div>
</section>
@endsection

@section('javascript')
<script type="text/javascript">
	$(document).ready(function() {
		$('.multiple').multiselect();
	});
</script>

<script type="text/javascript">
$('#validForm').validate({
	rules: {
		offer_name:{
			required : true
		},
		start_date:{
			required : true
		},
		end_date:{
			required : true
		},
		discount_percent:{
			required : true,
			number : true,
		},
		upto:{
			required : true,
			number : true,
		},
		min_price:{
			required : true,
			number : true,
		},
		per_person:{
			required : true,
			number : true,
		},
		max_person:{
			required : true,
			number : true,
		},
		service:{
			required : true,
		}
	}
});
</script>
<script type="text/javascript">
$(document).ready(function(){
  
    $(".start-date").datetimepicker({
    	format:'DD/MM/YYYY HH:mm'
    }).on('changeDate', function (selected) {
        var minDate = new Date(selected.date.valueOf());
        $('.end-date').datetimepicker('setStartDate', minDate);
    });
    
    $(".end-date").datetimepicker({
    	format:'DD/MM/YYYY HH:mm',
    }).on('changeDate', function (selected) {
        var minDate = new Date(selected.date.valueOf());
        $('.start-date').datetimepicker('setEndDate', minDate);
    });

});
</script>
@endsection