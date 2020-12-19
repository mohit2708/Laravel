@extends('layouts/admin/default')
@section('title', 'Currency')
@section('content')
<section class="content-header">
  <h1>
	Currency
	<!--small>Admin</small-->
  </h1>
  <ol class="breadcrumb">
	<li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">Currency</li>
  </ol>
</section>

<section class="content container-fluid">

<div class="row">
       <div class="col-sm-12">
          <div class="box box-info">
            <div class="box-header">
              <h3 class="box-title">Currency List </h3>
				@if(\Helper::page_access(Auth::user()->role_id, 'admin/currency/add'))
				<a href="{{ url('admin/currency/add') }}" class="btn btn-theme pull-right" title="Add Module">
				 <i class="fa fa-plus"></i>
				 <span>Add Currency</span>
				</a>
				@endif
            </div>
            <div class="box-body">

			<form action="{{ url('admin/currency') }}" class="form-horizontal" method="GET">
				<div class="row marbt-lg">
					<div class="col-sm-3">
						<div class="form-group">
							<div class="col-sm-12">
								<label>Currency Name</label>
								<input class="form-control" name="name" type="text" value="{{ Request::get('name') }}" placeholder="Currency Name" />
							</div>
						</div>
					</div>
					<div class="col-sm-3 text-right fltrbtn">
						<label class="fltrbtn-lab">&nbsp;</label>
						<button class="btn btn-theme btnmin">Search</button>
						<a href="{{ url('admin/currency') }}"><button class="btn btn-danger btnmin" type="button">Reset</button></a>
					</div>
				
				</div>
			</form>
			
			@include('includes.notifications')
			
		 <table class="table table-striped">
			<thead>
				<tr class="info">
					<th>#</th>
					<th>Currency Name</th>
					<th>Currency Sign</th>
					<th style="text-align: center;">Created At</th>
					<th style="text-align: center;">Controls</th>
				</tr>
			</thead>
			
			<tbody> 
				@if(count($arrCurrency)>0)
				<?php  $i =(($arrCurrency->currentpage()-1)* $arrCurrency->perpage() + 1); ?>
				@foreach($arrCurrency as $currency)
					<tr>
						<td><?= $i++ ?></td>
						<td>{{$currency->currency_name}}</td>
						<td>{{ $currency->currency_sign }}</td>
						<td align="center">{{date('F d, Y', strtotime($currency->created_at))}}</td>
						<td align="center">
						@if(\Helper::page_access(Auth::user()->role_id, 'admin/currency/edit'))
							<a href="{{url('admin/currency/edit/'.$currency->id)}}" class="btn btn-link" title='Edit'><i class="fa fa-edit"></i></a>
						@endif
						@if(\Helper::page_access(Auth::user()->role_id, 'admin/currency/delete'))
							<a onclick="confirm_delete({{$currency->id}});" class="btn btn-link" title='Delete'><i class="fa fa-trash"></i></a>
						@endif
						</td>
					</tr> 
				@endforeach 
				@else
					<tr>
						<td colspan="10"><i>No Data Found</i></td>
					</tr>
				@endif 
			</tbody>
		</table>
</div>
<div class="col-sm-12 text-center">
	{{$arrCurrency->links()}}
</div>
</div>

</div>
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
function confirm_delete(id){
	var url="{{url('admin/currency/delete/')}}";
	var a='<a href="'+url+'/'+id+'" class="btn btn-primary">Confirm</a>';
	$("#delete_butt_id").html(a);
	$("#delete_confirm").modal();
}	
</script>
@endsection