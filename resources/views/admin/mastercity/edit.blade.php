@extends('layouts/admin/default')
@section('title', 'Edit City')
@section('content')
<section class="content-header">
  <h1>
	City
	<!--small>Admin</small-->
  </h1>
  <ol class="breadcrumb">
	<li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">Edit City</li>
  </ol>
</section>
<section class="content container-fluid">
<?php 
#echo '</pre>';
#print_r($dataMastercity->toArray());
#die();
?>
     <div class="row">
       <div class="col-sm-12">
	   @include('includes.notifications')
			<div class="box box-info">
				<div class="box-header">
					<h3 class="box-title">Edit City</h3>
				</div>
				<div class="box-body">
					<form action ="{{url('admin/master/city/update/'.$dataMastercity->id)}}" class="form-horizontal" id="validForm" method="POST" enctype="multipart/form-data">
						{!! csrf_field() !!}
						<div class="row">							
											<input type="hidden" name="cityoldimage" value="{{$dataMastercity->city_image}}" >
							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12">
										<label>Select country</label>
										<select class="form-control" name="country" id="country">
											<option value="">--Select--</option>

											@foreach($arrCountry as $country)
										<option value="{{ $country->id }}" {{($dataMastercity->country_id == $country->id) ? 'selected' : '' }} >{{ $country->name }}</option>
											@endforeach
										</select>	

																
									</div>
								</div>								
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12">
										<label>Select State</label>
										<select class="form-control" name="state" id="state">
											<option value="">--Select--</option>
											@foreach($arrState as $state)
										<option value="{{ $state->id }}" {{($dataMastercity->state_id == $state->id) ? 'selected' : '' }} >{{ $state->name }}</option>
											@endforeach				
										</select>				
																
									</div>
								</div>								
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12">
										<label>City Name</label>
										<input type="text" name="City_name" class="form-control" value="{{ $dataMastercity->name }}" placeholder="Feature Name">
										
									</div>
								</div>								
							</div>

							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12">
										<label>City Image</label>
										<img src="{{url('public/images/city/'.$dataMastercity->city_image)}}" height="150" width="150">
										<input class="form-control" name="city_image" type="file" value="{{ $dataMastercity->city_image }}"">
																
									</div>
								</div>								
							</div>
							
							
							
							
							<div class="clearfix"></div>
							
							<div class="col-sm-12">
								<div class="form-group">
									<div class="col-sm-12">
										<label>Description</label>
										<textarea class="form-control" name="city_description" placeholder="Feature Description" rows="5">{{ $dataMastercity->description  }}</textarea>
										
									</div>
								</div>
								
							</div>
							
						</div>
						<div class="form-group">
							<div class="col-sm-12 text-right">
								<a href="{{ url('admin/master/city') }}"><button class="btn btn-danger" type="button">Cancel</button></a>
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

<script>
jQuery(function($) {
	$("#country").change(function(){
		var countryID = $(this).val();
		if(countryID){
			var token = "{{ csrf_token() }}";
			$.ajax({
				type: "POST",
				url: "{{URL::to('admin/master/city/ajax')}}",
				data: {  '_token':token, id: countryID}	
			}).done(function(data){
				if(data){
					var obj = jQuery.parseJSON(data);
					var htmlOption = '<option value="">--Select--</option>';
					$.each(obj, function (index, value) {
						htmlOption += '<option value="'+value.id+'">'+value.name+'</option>';
						$('#state').html(htmlOption);
					});
					
				}else{
					$("#state").html('<option value="">--Select--</option>');
				}	
					
			});
		}else{
			$("#state").html('<option value="">--Select--</option>');
		}
	});
});
</script>
<script type="text/javascript">

$('#validForm').validate({
	rules: {
		country:{
			required : true,
		},
		state:{
			required : true,
		},
		master_city:{
			required : true,
		},
		
		city_description:{
			required : true,
		}
	},
});
</script>
@endsection