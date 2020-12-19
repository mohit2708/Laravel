@extends('layouts/admin/default')
@section('title', 'Bonus Info')
@section('content')
<section class="content-header">
  <h1>
	Bonus Info
	<!--small>Admin</small-->
  </h1>
  <ol class="breadcrumb">
	<li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">Bonus Info</li>
  </ol>
</section>
<section class="content container-fluid">
<div class="row">
  @include('includes.notifications')

        <!-- Left col -->
	<section class="col-lg-12 connectedSortable">
	  <!-- Custom tabs (Charts with tabs)-->
	  <div class="nav-tabs-custom">
		<!-- Tabs within a box -->
		<ul class="nav nav-tabs pull-left">
		  <li class="active"><a href="#referral" data-toggle="tab">Referral</a></li>
		  <li><a href="#travel" data-toggle="tab">Travel</a></li>
		</ul>
		<div class="tab-content no-padding">
		  <!-- Morris chart - Sales -->
		  <div class="chart tab-pane active" id="referral" style="position: relative;"><br>
			<div class="col-sm-12">
			  <form action="{{url('admin/bonus/referral')}}" method="POST" id="validForm1">
				  {!! csrf_field() !!}
				<div class="col-sm-2 text-center p-0 cus-bg">
				  <label><i class="fa fa-fw fa-gift"></i> Bonus Points</label>
				</div>
				<div class="col-sm-3">
				  <div class="form-group">
					<input type="text" name="points" id="points" value="{{ $arrBonousInfo['referral']->point }}" class="form-control">
				  </div>
				</div>
				<div class="col-sm-3 text-center">
				  <p class="tot-points"><span id="show_point">{{ $arrBonousInfo['referral']->point }}</span> Points</p>
				</div>
				<div class="col-sm-3">
				  <div class="btn-group"> 
					  <button type="submit" class="btn btn-sm btn-theme btn-flat pull-left">Save</button>
					  <a href="{{ url('admin') }}" class="btn btn-sm btn-danger btn-flat pull-left">Cancel</a>
				  </div>
				</div>
			  </form>
			</div>
		  </div>
		  <div class="chart tab-pane" id="travel" style="position: relative;">
			<br>
			  <div class="col-sm-12">
				<form action="{{url('admin/bonus/travel')}}" method="POST" id="validForm2">
					{!! csrf_field() !!}
				  <div class="col-sm-3">
					 <label>Bonus %</label>
					<div class="form-group">
					  <select class="form-control" name="discount" id="sel1">
					  @for($i=0; $i<=100; $i++)
						 <option value="{{$i}}" {{ ($arrBonousInfo['travel']->discount == $i)? 'selected' : '' }}>{{$i}} %</option>
					  @endfor
					  </select>
					</div>
				  </div>
				  <div class="col-sm-3">
					<label>Up To Bonus</label>
					<div class="form-group">
					  <input class="form-control" type="text" name="upto" value="{{ $arrBonousInfo['travel']->upto }}" placeholder = "Up To Amount">
					</div>
				  </div>
				  <!--div class="col-sm-3">
					<label>Exp</label>
					<div class="form-group">
					  <select class="form-control">
						<option>No Exp</option>
						<option>1</option>
						<option>2</option>
						<option>3</option>
					  </select>
					</div>
				  </div-->
				  <div class="col-sm-3">
					<label>&nbsp</label><br>
					<div class="btn-group"> 
						<button type="submit" class="btn btn-sm btn-theme btn-flat pull-left">Save</button>
						<a href="{{ url('admin') }}" class="btn btn-sm btn-danger btn-flat pull-left">Cancel</a>
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
$('#validForm1').validate({
	rules: {
		points:{
			required : true,
			number : true,
		} 
	},
});
</script>
<script type="text/javascript">
$('#validForm2').validate({
	rules: {
		discount:{
			required : true,
		},
		upto:{
			required : true,
			number : true,
		} 
	},
});
</script><script type="text/javascript">jQuery(function($) {	$("#points").keyup(function(){		if($(this).val()){			$("#show_point").html($(this).val());		}else{			$("#show_point").html('0');		}	});	});</script>
@endsection