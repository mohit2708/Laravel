@extends('layouts/admin/default')

@section('title', 'Setting')

@section('content')

<section class="content-header">

  <h1>

	Setting

	<!--small>Admin</small-->

  </h1>

  <ol class="breadcrumb">

	<li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>

	<li class="active">Setting</li>

  </ol>

</section>

<section class="content setting container-fluid">


<div class="col-sm-12"> @include('includes.notifications')</div>
  <div class="col-sm-6">

  

	  <div class="panel panel-default">

		 <div class="panel-heading">

				<h4>Currency</h4>

		 </div>

		 <div class="panel-body">

			

			 <form action="{{ url('admin/setting') }}" method="POST">

				{!! csrf_field() !!}

			 <input type="hidden" name="type" value="currency">

			  <div class="input-group">

			  <select class="form-control" name="currency">

				@foreach($arrCurrency as $currency)

					<option value="{{ $currency->id }}" {{ ($currency->is_active == 1) ? 'selected' : '' }}>{{ $currency->currency_name }} ({{ $currency->currency_sign }})</option>

				@endforeach

			  </select>

				<span class="input-group-btn">

				  <button class="btn btn-theme" type="submit"> Save </button>

				</span>

			  </div>          

			</form>

		 </div>

	 </div>
</div>
	 <div class="col-sm-6">

	 <div class="panel panel-default">

		 <div class="panel-heading">

				<h4>Points Information</h4>

		 </div>

		 <div class="panel-body">

			

			 <form action="{{ url('admin/setting') }}" method="POST">

				{!! csrf_field() !!}

			 <input type="hidden" name="type" value="points">

			 	<div class="form-group" style="width: 45%;vertical-align: top;float: left;">
				    <div class="input-group input-group-sm">
				        <div class="icon-addon addon-sm">
				            <input type="text" name="point" value="{{$arrBonusInfo->points}}" class="form-control" placeholder="Discount Coupon">
				        </div>
				        <span class="input-group-addon"><i class="fa fa-fw fa-gift"></i> Points</span>
				    </div>
				</div>


			  
				<p class="equl"> = </p>

				<div class="form-group" style="width: 48%;float: left;">
				    <div class="input-group input-group-sm">
				        <div class="icon-addon addon-sm">
				            <input type="text" name="amount" value="{{$arrBonusInfo->amount}}" class="form-control" placeholder="Discount Coupon">
				        </div>
				        <span class="input-group-addon">{{ $activeCurrency->currency_sign }}</span>
				        <span class="input-group-btn">

						  <button class="btn btn-theme" type="submit"> Save </button>

						</span>
				    </div>
				</div>

			  <!-- <div class="input-group" >
				<input type="text" name="amount" value="{{$arrBonusInfo->amount}}" class="form-control">
				<span class="doll-rup"></span>

				

			  </div> -->          

			</form>

		 </div>

	 </div>

  </div>





</section>

@endsection