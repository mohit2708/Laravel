@extends('layouts/admin/default')
@section('title', 'Discount Info')
@section('content')
<?php use \App\Http\Controllers\Admin\DiscountController; ?>
<section class="content-header">
  <h1>
	Discount Info
	<!--small>Admin</small-->
  </h1>
  <ol class="breadcrumb">
	<li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">Discount Info</li>
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
		  <li class="{{ (isset($infoDiscountOffer)) ? '' :'active' }}"><a href="#referral" data-toggle="tab">Discount Coupon</a></li>
		  <li class="{{ (isset($infoDiscountOffer)) ? 'active' : '' }}"><a href="#travel" data-toggle="tab">Offers</a></li>
		</ul>
		<div class="tab-content no-padding">
		  <!-- Morris chart - Sales -->
		  <div class="chart tab-pane {{ (isset($infoDiscountOffer)) ? '' :'active' }}" id="referral" style="position: relative; overflow: auto">
		  	<br />
			<div class="col-sm-12">
				 @if(isset($infoDiscountCoupon))
			  	  	<form action="{{url('admin/discount/coupon/update/'.$infoDiscountCoupon->coupon_id)}}" method="POST" id="validForm1">
			  	  	<input type="hidden" name="coupon" value="{{$infoDiscountCoupon->coupon_id}}">
			  	  @else
			  	  	 <form action="{{url('admin/discount/coupon')}}" method="POST" id="validForm1">
			  	  @endif
				
				  {!! csrf_field() !!}
				<div class="col-sm-2">
					<label class="fltrbtn-lab">Discount %</label>
					<div class="form-group">
					    <div class="input-group input-group-sm">
					        <div class="icon-addon addon-sm">
								<input type="text" class="form-control" name="discount_percent" placeholder="Discount %" value="{{ (isset($infoDiscountCoupon)) ? $infoDiscountCoupon->discount_percent : Request::old('discount_percent') }}"/>
								@if ($errors->has('discount_percent'))
									<div class="error small">{{ $errors->first('discount_percent') }}</div>
								@endif
					        </div>
					        <span class="input-group-addon">%</span>
					    </div>
					</div>
				</div>

				<div class="col-sm-2">
					<label for="">Up To Discount</label>
					<input type="text" class="form-control" name="upto" value="{{ (isset($infoDiscountCoupon)) ? $infoDiscountCoupon->upto : Request::old('upto') }}" placeholder="Up To Discount"/>
					@if ($errors->has('upto'))
						<div class="error small">{{ $errors->first('upto') }}</div>
					@endif
				</div>

				<div class="col-sm-2">
					<label class="fltrbtn-lab">Select Coupons</label>
					<select class="form-control" name=" {{ (isset($infoDiscountCoupon)) ? '' : 'coupon' }}" {{ (isset($infoDiscountCoupon)) ? 'disabled' : '' }} >
						<option value="">--Select--</option>
						@foreach($arrCoupons as $coupon)
							<option value="{{$coupon->id}}" {{ (isset($infoDiscountCoupon)) ? ($infoDiscountCoupon->coupon_id == $coupon->id) ? 'selected' : '' : '' }} >{{$coupon->coupon_name}}</option>
						@endforeach
					</select>
					@if ($errors->has('coupon'))
						<div class="error small">{{ $errors->first('coupon') }}</div>
					@endif
				</div>

				<div class="col-sm-2">
					<label class="fltrbtn-lab">Select Services</label>
					<select class="multiple" name="service[]" multiple="multiple">
						@foreach($arrServices as $service)
							<option value="{{$service->id}}" {{ (isset($infoDiscountCoupon)) ? (in_array($service->id, DiscountController::getServicesID($infoDiscountCoupon->coupon_id))) ? 'selected' : '' : '' }}  >{{$service->service_name}}</option>
						@endforeach
					</select>
					@if ($errors->has('service'))
						<div class="error small">{{ $errors->first('service') }}</div>
					@endif
				</div>

				<div class="col-sm-4 text-left">
					<div class="form-group custom-checkbox">
						<div class="col-md-6">
							<div class="form-group">
								<label for="start Date">Start Date</label>
								<div class="input-group">
	<input type="text" name="start_date" class="form-control start-date" placeholder="dd/mm/yyyy" value="{{ (isset($infoDiscountCoupon)) ? date('d-m-Y H:i:s', strtotime($infoDiscountCoupon->start_date)) : Request::old('start_date') }}" />
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
									@if ($errors->has('start_date'))
										<div class="error small">{{ $errors->first('start_date') }}</div>
									@endif
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="start Date">End Date</label>
								<div class="input-group">
									<input type="text" name="end_date" class="form-control end-date" placeholder="dd/mm/yyyy" value="{{ (isset($infoDiscountCoupon)) ? date('d-m-Y H:i:s', strtotime($infoDiscountCoupon->end_date)) : Request::old('end_date') }}" />
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
									@if ($errors->has('end_date'))
										<div class="error small">{{ $errors->first('end_date') }}</div>
									@endif
								</div>
							</div>
						</div>
					</div>
				</div>
				<a href="http://localhost/acl/admin/coupon/add" class="btn btn-theme pull-right" title="Add Coupon">
				 <i class="fa fa-plus"></i>
				 <span>Add Coupon</span>
				</a>
				<div class="col-sm-3">
					<label>&nbsp</label><br>
				  <div class="btn-group">
				  	  @if(isset($infoDiscountCoupon))
				  	  	 <button type="submit" class="btn btn-sm btn-theme btn-flat pull-left">Update</button>
				  	  	  <a href="{{ url('admin/discount') }}" class="btn btn-sm btn-danger btn-flat pull-left">Cancel</a>
				  	  @else
				  	  	 <button type="submit" class="btn btn-sm btn-theme btn-flat pull-left">Save</button>
				  	  	  <a href="{{ url('admin') }}" class="btn btn-sm btn-danger btn-flat pull-left">Cancel</a>
				  	  @endif
					</div>
				</div>
			  </form>
			</div>
			<div class="clearfix"></div>
			  <br>
			  <hr>
			  <div class="col-md-12">
			  <table class="table table-hover">
			  	<thead>
			  		<tr>
			  			<th>Coupon</th>
			  			<th>Service Name</th>
			  			<th>Discount(%)</th>
			  			<th>Up To Discount</th>
			  			<th>Start Date</th>
			  			<th>End Date</th>
			  			<th>Operation</th>
			  		</tr>
			  	</thead>
			  	<tbody>
			  		@foreach($arrDiscountCoupon as $discount_coupon)
			  		<tr>
			  			<td>{{$discount_coupon->coupon_name}}</td>
			  			<td>{{ DiscountController::getServicesCoupon($discount_coupon->coupon_id) }}</td>
			  			<td>{{$discount_coupon->discount_percent}} %</td>
			  			<td>{{$discount_coupon->upto}}</td>
			  			<td>{{ date('d-m-Y H:i:s', strtotime($discount_coupon->start_date))}}</td>
			  			<td>{{ date('d-m-Y H:i:s', strtotime($discount_coupon->end_date))}}</td>
			  			<td>
			  				<a href="{{url('admin/discount/coupon/edit/'.$discount_coupon->coupon_id)}}" class="btn btn-link" title="edit"><i class="fa fa-edit"></i></a>
			  				<a onclick="confirm_delete_coupon({{$discount_coupon->coupon_id}});" class="btn btn-link" title='Delete'><i class="fa fa-trash"></i></a>
			  			</td>
			  		</tr>
			  		@endforeach
			  	</tbody>

			  </table>
			</div>

		  </div>
		  <div class="chart tab-pane {{ (isset($infoDiscountOffer)) ? 'active' : '' }}" id="travel" style="position: relative;">
			<br>
			  
			  <div class="col-sm-12">
				 @if(isset($infoDiscountOffer))
			  	  	<form action="{{url('admin/discount/offer/update/'.$infoDiscountOffer->offer_name)}}" method="POST" id="validForm2">
			  	  @else
			  	  	 <form action="{{url('admin/discount/offer')}}" method="POST" id="validForm2">
			  	  @endif
				
				  {!! csrf_field() !!}

				<div class="col-sm-2">
					<label for="">Offer Name</label>
					<input type="text" class="form-control" name="offer_name" value="{{ (isset($infoDiscountOffer)) ? $infoDiscountOffer->offer_name : Request::old('offer_name') }}" placeholder="Offer Name"/ {{ (isset($infoDiscountOffer)) ? 'readonly' : '' }}>
					@if ($errors->has('offer_name'))
						<div class="error small">{{ $errors->first('offer_name') }}</div>
					@endif
				</div>

				<div class="col-sm-2">
					<label class="fltrbtn-lab">Discount %</label>
					<div class="form-group">
					    <div class="input-group input-group-sm">
					        <div class="icon-addon addon-sm">
								<input type="text" class="form-control" name="discount_percent" placeholder="Discount %" value="{{ (isset($infoDiscountOffer)) ? $infoDiscountOffer->discount_percent : Request::old('discount_percent') }}"/>
								@if ($errors->has('discount_percent'))
									<div class="error small">{{ $errors->first('discount_percent') }}</div>
								@endif
					        </div>
					        <span class="input-group-addon">%</span>
					    </div>
					</div>
				</div>

				<div class="col-sm-2">
					<label for="">Up To Discount</label>
					<input type="text" class="form-control" name="upto" value="{{ (isset($infoDiscountOffer)) ? $infoDiscountOffer->upto : Request::old('upto') }}" placeholder="Up To Discount"/>
					@if ($errors->has('upto'))
						<div class="error small">{{ $errors->first('upto') }}</div>
					@endif
				</div>

				<div class="col-sm-2">
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

				<div class="col-sm-4 text-left">
					<div class="form-group custom-checkbox">
						<div class="col-md-6">
							<div class="form-group">
								<label for="start Date">Start Date</label>
								<div class="input-group">
									<input type="text" name="start_date" class="form-control start-date" placeholder="dd/mm/yyyy" value="{{ (isset($infoDiscountOffer)) ? date('d-m-Y H:i:s', strtotime($infoDiscountOffer->start_date)) : Request::old('start_date') }}" />
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
									@if ($errors->has('start_date'))
										<div class="error small">{{ $errors->first('start_date') }}</div>
									@endif
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="start Date">End Date</label>
								<div class="input-group">
									<input type="text" name="end_date" class="form-control end-date" placeholder="dd/mm/yyyy" value="{{ (isset($infoDiscountOffer)) ? date('d-m-Y H:i:s', strtotime($infoDiscountOffer->end_date)) : Request::old('end_date') }}" />
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
									@if ($errors->has('end_date'))
										<div class="error small">{{ $errors->first('end_date') }}</div>
									@endif
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-12">
					<label class="fltrbtn-lab">Description</label>
					<textarea name="description" class="form-control" placeholder="Description">{{ (isset($infoDiscountOffer)) ?$infoDiscountOffer->description : Request::old('description') }}</textarea>
					@if ($errors->has('description'))
						<div class="error small">{{ $errors->first('description') }}</div>
					@endif
				</div>
				<div class="col-sm-3">
					<label>&nbsp</label><br>
				  <div class="btn-group">
				  	  @if(isset($infoDiscountOffer))
				  	  	 <button type="submit" class="btn btn-sm btn-theme btn-flat pull-left">Update</button>
				  	  	  <a href="{{ url('admin/discount') }}" class="btn btn-sm btn-danger btn-flat pull-left">Cancel</a>
				  	  @else
				  	  	 <button type="submit" class="btn btn-sm btn-theme btn-flat pull-left">Save</button>
				  	  	  <a href="{{ url('admin') }}" class="btn btn-sm btn-danger btn-flat pull-left">Cancel</a>
				  	  @endif
					</div>
				</div>
			  </form>
			</div>


			  <div class="clearfix"></div>
			  <br>
			  <hr>
			  <div class="col-md-12">
			  <table class="table table-hover">
			  	<thead>
			  		<tr>
			  			<th>Offer Name</th>
			  			<th>Service Name</th>
			  			<th>Discount(%)</th>
			  			<th>Up To Discount</th>
			  			<th>Start Date</th>
			  			<th>End Date</th>
			  			<th>Operation</th>
			  		</tr>
			  	</thead>
			  	<tbody>
			  		@foreach($arrDiscountOffer as $discount_offer)
			  		<tr>
			  			<td>{{$discount_offer->offer_name}}</td>
			  			<td>{{ DiscountController::getServicesOffer($discount_offer->offer_name) }}</td>
			  			<td>{{$discount_offer->discount_percent}} %</td>
			  			<td>{{$discount_offer->upto}}</td>
			  			<td>{{ date('d-m-Y H:i:s', strtotime($discount_offer->start_date))}}</td>
			  			<td>{{ date('d-m-Y H:i:s', strtotime($discount_offer->end_date))}}</td>
			  			<td>
			  				<a href="{{url('admin/discount/offer/edit/'.$discount_offer->offer_name)}}" class="btn btn-link" title="edit"><i class="fa fa-edit"></i></a>
			  				<a onclick="confirm_delete_offer('{{$discount_offer->offer_name}}');" class="btn btn-link" title='Delete'><i class="fa fa-trash"></i></a>
			  			</td>
			  		</tr>
			  		@endforeach
			  	</tbody>

			  </table>
			</div>

		  </div>
<br>
<div class="clearfix"></div>


		</div>
	  </div>
	  <!-- /.nav-tabs-custom -->

	 

	</section>
	<!-- /.Left col -->
	
  </div>

</section>
<div id="delete_confirm" class="modal fade" role="dialog">
	  <div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Are you sure? You want to Delete!</h4>
		  </div>
		  
		  <div class="modal-footer">
		  
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			<span id="delete_butt_id"></span>
			
		  </div>
		</div>

	  </div>
</div>
@endsection

@section('javascript')
<script type="text/javascript">
	$(document).ready(function() {
		$('.multiple').multiselect();
	});
</script>
<script type="text/javascript">
function confirm_delete_coupon(id){
	var url="{{url('admin/discount/coupon/delete/')}}";
	var a='<a href="'+url+'/'+id+'" class="btn btn-primary">Confirm</a>';
	$("#delete_butt_id").html(a);
	$("#delete_confirm").modal();
}	
function confirm_delete_offer(id){
	var url="{{url('admin/discount/offer/delete/')}}";
	var a='<a href="'+url+'/'+id+'" class="btn btn-primary">Confirm</a>';
	$("#delete_butt_id").html(a);
	$("#delete_confirm").modal();
}	
</script>
<script type="text/javascript">
$('#validForm1').validate({
	rules: {
		discount_percent:{
			required : true,
			number : true,
		},
		upto:{
			required : true,
			number : true,
		},
		coupon:{
			required : true,
		},
		service:{
			required : true,
		},
		start_date:{
			required : true,
		},
		end_date:{
			required : true,
		},

	},
});
</script>
<script type="text/javascript">
$('#validForm2').validate({
	rules: {
		offer_name:{
			required : true,
		},
		discount_percent:{
			required : true,
			number : true,
		},
		upto:{
			required : true,
			number : true,
		},
		service:{
			required : true,
		},
		start_date:{
			required : true,
		},
		end_date:{
			required : true,
		},
	},
});
$(document).ready(function(){
  
    $(".start-date").datetimepicker({
    	format:'DD/MM/YYYY HH:mm:ss'
    }).on('changeDate', function (selected) {
        var minDate = new Date(selected.date.valueOf());
        $('.end-date').datetimepicker('setStartDate', minDate);
    });
    
    $(".end-date").datetimepicker({
    	format:'DD/MM/YYYY HH:mm:ss',
    }).on('changeDate', function (selected) {
        var minDate = new Date(selected.date.valueOf());
        $('.start-date').datetimepicker('setEndDate', minDate);
    });

});


</script>
@endsection