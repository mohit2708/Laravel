@extends('layouts/admin/default')
@section('title', 'Add City')
@section('content')
<section class="content-header">
  <h1>
	City
	<!--small>Admin</small-->
  </h1>
  <ol class="breadcrumb">
	<li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">Add City</li>
  </ol>
</section>


<section class="content container-fluid">
     <div class="row">
       <div class="col-sm-12">
	   @include('includes.notifications')
			<div class="box box-info">
				<div class="box-header">
					<h3 class="box-title">Add City</h3>
				</div>
				<div class="box-body">
					<form action ="{{url('admin/master/city/store')}}" class="form-horizontal" id="validForm" method="POST" enctype="multipart/form-data">
						{!! csrf_field() !!}
						<div class="row">
		
							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12">
										<label>Select country</label>
										<select class="form-control" name="country" id="country">
											<option value="">--Select--</option>
											@foreach($arrCountry as $country)
												<option value="{{ $country->id }}" {{ (Request::get('country') == $country->id)? 'selected' : '' }} >{{ $country->name }}</option>
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
											
										</select>											
									</div>
								</div>
								
							</div>
							
							<div class="clearfix"></div>

							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12">
										<label>City</label>
										<input class="form-control" name="master_city" type="text" value="" placeholder="Enter Your City">
																
									</div>
								</div>								
							</div>

							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12">
										<label>City Image</label>
										<input class="form-control" name="city_image" type="file" value="">
										@if ($errors->has('city_image'))
											<div class="error small">{{ $errors->first('city_image') }}</div>
										@endif						
									</div>
								</div>								
							</div>
							
							<div class="col-sm-12">
								<div class="form-group">
									<div class="col-sm-12">
										<label>Description</label>
										<textarea class="form-control" name="city_description" placeholder="Description" rows="5"></textarea>
										@if ($errors->has('description'))
											<div class="error small">{{ $errors->first('description') }}</div>
										@endif
										
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
		city_image:{
			required : true,
		},
		city_description:{
			required : true,
		}
	},
});
</script>

@endsection