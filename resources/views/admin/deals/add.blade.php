@extends('layouts/admin/default')
@section('title', 'Add Deals')
@section('content')
<section class="content-header">
  <h1>
	Deals
	<!--small>Admin</small-->
  </h1>
  <ol class="breadcrumb">
	<li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">Add Deals</li>
  </ol>
</section>


<section class="content container-fluid">
     <div class="row">
       <div class="col-sm-12">
	   @include('includes.notifications')
			<div class="box box-info">
				<div class="box-header">
					<h3 class="box-title">Add Deals</h3>
				</div>
				<div class="box-body">
					<form action ="{{url('admin/deals/store')}}" class="form-horizontal" id="validForm" method="POST" method="POST" enctype="multipart/form-data">
						{!! csrf_field() !!}
						<div class="row">
		
							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12">
										<label>Name</label>
										<input type="text" name="deals_name" class="form-control" value="{{Request::old('deals_name')}}" placeholder="Deals Name">				
										@if ($errors->has('deals_name'))
											<div class="error small">{{ $errors->first('deals_name') }}</div>
										@endif						
									</div>
								</div>
								
							</div>
							
								<div class="col-sm-6">
									<div class="form-group">
										<div class="col-sm-12">
											<label>Flight Count</label>
											<input type="text" name="flight_count" class="form-control" value="{{Request::old('icon')}}" placeholder="Flight Count">	
											@if ($errors->has('flight_count'))
												<div class="error small">{{ $errors->first('flight_count') }}</div>
											@endif									
										</div>
									</div>
								
								</div>
								
								<div class="col-sm-6">
									<div class="form-group">
										<div class="col-sm-12">
											<label>Flight From</label>
											<input type="text" name="flight_from" class="form-control" value="{{Request::old('icon')}}" placeholder="Flight From">	
											@if ($errors->has('flight_from'))
												<div class="error small">{{ $errors->first('flight_from') }}</div>
											@endif									
										</div>
									</div>
								
								</div>
								
								<div class="col-sm-6">
									<div class="form-group">
										<div class="col-sm-12">
											<label>Flight To</label>
											<input type="text" name="flight_to" class="form-control" value="{{Request::old('icon')}}" placeholder="Flight To">	
											@if ($errors->has('flight_to'))
												<div class="error small">{{ $errors->first('flight_to') }}</div>
											@endif									
										</div>
									</div>
								
								</div>
							
							<div class="clearfix"></div>
							
							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12">
										<label>Image</label>
										<input class="form-control" name="deals_image" type="file" value="">
											@if ($errors->has('deals_image'))
											<div class="error small">{{ $errors->first('deals_image') }}</div>
										@endif					
									</div>
								</div>								
							</div>
							
							<div class="col-sm-12">
								<div class="form-group">
									<div class="col-sm-12">
										<label>Description</label>
										<textarea class="form-control" name="description" placeholder="Deals Description...." rows="5"></textarea>
										@if ($errors->has('description'))
											<div class="error small">{{ $errors->first('description') }}</div>
										@endif
																				
									</div>
								</div>
								
							</div>
							
						</div>
						<div class="form-group">
							<div class="col-sm-12 text-right">
								<a href="{{ url('admin/deals') }}"><button class="btn btn-danger" type="button">Cancel</button></a>
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
		deals_name:{
			required : true,
		},
		flight_count:{
			required : true,
		},
		flight_from:{
			required : true,
		},
		flight_to:{
			required : true,
		},
		deals_image:{
			required : true,
		},
		description:{
			required : true,
		}
	},
});
</script>

@endsection