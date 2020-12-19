@extends('layouts/admin/default')
@section('title', 'Discount Offer')
@section('content')
<?php use \App\Http\Controllers\Admin\DiscountController; ?>
<section class="content-header">
  <h1>
	Discount Offer
	<!--small>Admin</small-->
  </h1>
  <ol class="breadcrumb">
	<li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">Discount Offer</li>
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
		  <li class=""><a href="{{url('admin/discount/coupon')}}">Discount Coupons</a></li>
		  <li class="active"><a href="#">Discount Offers</a></li>
		</ul>
		<div class="tab-content no-padding">
		  <!-- Morris chart - Sales -->
		  <div class="chart tab-pane active" style="position: relative; overflow: auto">
			<div class="clearfix"></div>
			<div class="col-sm-12">
			  	<form action="{{url('admin/discount/offer')}}" method="GET">

				<div class="col-sm-2">
					<label for="">Offer Name</label>
					<input type="text" class="form-control" name="offer_name" value="{{ Request::old('offer_name') }}" placeholder="Offer Name"/ >
				</div>

				<div class="col-sm-3">
					<label>&nbsp</label><br>
				  	<div class="btn-group">
				  	  	 <button type="submit" class="btn btn-sm btn-theme btn-flat pull-left">Filter</button>
				  	  	  <a href="{{ url('admin/discount/offer') }}" class="btn btn-sm btn-danger btn-flat pull-left">Reset</a>
					</div>
				</div>
			  </form>
			</div>
			<div class="col-md-12">
				<a href="{{url('admin/discount/offer/add')}}" class="btn btn-theme pull-right" title="Add Coupon">
					<i class="fa fa-plus"></i>
					<span>Add Offer</span>
				</a>
			</div>
			  <hr>
			  <div class="col-md-12">
			  <table class="table table-hover">
			  	<thead>
			  		<tr>
			  			<th>#</th>
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
			  			<td>1</td>
			  			<td>{{$discount_offer->offer_name}}</td>
			  			<td>{{ DiscountController::getServicesOffer($discount_offer->id) }}</td>
			  			<td>{{$discount_offer->discount_percent}} %</td>
			  			<td>{{$discount_offer->upto}}</td>
			  			<td>{{ date('d-m-Y H:i', strtotime($discount_offer->start_date))}}</td>
			  			<td>{{ date('d-m-Y H:i', strtotime($discount_offer->end_date))}}</td>
			  			<td>
			  				<a href="{{url('admin/discount/offer/edit/'.$discount_offer->id)}}" class="btn btn-link" title="edit"><i class="fa fa-edit"></i></a>
			  				<a onclick="confirm_delete({{$discount_offer->id}});" class="btn btn-link" title='Delete'><i class="fa fa-trash"></i></a>
			  			</td>
			  		</tr>
			  		@endforeach
			  	</tbody>

			  </table>
			</div>

		  </div>

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
function confirm_delete(id){
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