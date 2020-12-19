@extends('layouts.app')
@extends('layouts.sidebar')
@extends('layouts.header')
@section('content')

<div class="container-xl">
	<div class="table-responsive">
		<div class="table-wrapper">
			<div class="table-title">
				<div class="row">
					<div class="col-sm-6">
						<h2>Connection <b>List</b></h2>
					</div>
					 <div class="col-sm-6">
						<a href="javascript:void(0)" class="btn btn-success" id="new-customer" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Add New Connection</span></a>
					</div> 
				</div>
			</div>
			<table class="table table-striped table-hover">
				<thead>
					<tr>						
						<th>No.</th>
						<th>Destination</th>
						<th>Gateway</th>
						<th>Iface</th>					
                        <th>Device Serial Number</th>			                      
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
				@php $no = 1; @endphp
                @foreach($connections as $connection)
					<tr>
						<td>{{ $no++ }}</td>						
						<td>{{$connection->destination}}</td>
                        <td>{{$connection->gateway}}</td>
						<td>{{$connection->iface}}</td>					
						<td>{{$connection->device_serial}}</td>						
						<td>
							<a href="#editEmployeeModal" class="connection_edit" conid="{{ $connection->id}}" tblinfoid="{{ $connection->tbl_info_id}}" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
							<a onclick="confirm_delete({{$connection->id}});" class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>							
						</td>
					</tr>
                    @endforeach						
				</tbody>
			</table>
			<div class="clearfix">				
				<ul class="pagination">				
					<!-- <li class="page-item disabled"><a href="#">Previous</a></li>
					<li class="page-item"><a href="#" class="page-link">1</a></li>					
					<li class="page-item"><a href="#" class="page-link">Next</a></li> -->
				</ul>
			</div>
		</div>
	</div>        
</div>


<!-- Edit Modal HTML -->
<div id="editEmployeeModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="POST" action ="{{ url('connection/update', $connection->id )}}">
			@csrf
			<input type="hidden" name="selectitem" id="selectitem" value="">
			<input type="hidden" name="selecttblinfoitem" id="selecttblinfoitem" value="">
				<div class="modal-header">						
					<h4 class="modal-title">Edit List</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">					
					<div class="form-group">
						<label>Destination</label>
						<input type="text" id="destination" name="destination" value="{{$connection->destination}}" class="form-control" required>
					</div>
					<div class="form-group">
						<label>gateway</label>
						<input type="text" id="gateway" name="gateway" value="{{$connection->gateway}}" class="form-control" required>
					</div>			
						
					<div class="form-group">
						<label>I Face</label>
						<input type="text" id="iface" name="iface" value="{{$connection->tunnel_ip}}" class="form-control" required>
					</div>	
					<div class="form-group">
						<label>Device Serial</label>
						<input type="text" id="device_serial" name="device_serial" value="{{$connection->device_serial}}" class="form-control" required>
					</div>				
				</div>
				<div class="modal-footer">
					<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
					<input type="submit" id="update" class="btn btn-info" value="Save">
				</div>
			</form>
		</div>
	</div>
</div> 
  <!-- Delete Modal HTML -->
  <div id="delete_confirm" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">         
				<div class="modal-header">						
					<h4 class="modal-title">Delete Connection</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">					
					<p>Are you sure you want to delete these Records?</p>					
				</div>
				<div class="modal-footer">
					<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
					<span id="delete_butt_id"></span>
				</div>			
		</div>
	</div>
</div>
<!-- Add Modal HTML -->
<div class="modal fade" id="crud-modal" aria-hidden="true" >
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title" id="customerCrudModal"></h4>
</div>
<div class="modal-body">
<form name="custForm" action="{{ url('connection/store')}}" method="POST">
@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- <input type="hidden" name="cust_id" id="cust_id" > -->
@csrf
<div class="row">
<div class="col-xs-12 col-sm-12 col-md-12">
<div class="form-group">
<strong>Destination:</strong>
<input type="text" name="destination" id="destination" class="form-control @error('destination') is-invalid @enderror" onchange="validate()">
@error('destination')
<span class="invalid-feedback" role="alert">
<strong>{{ $message }}</strong>
</span>
@enderror
</div>
</div>
<div class="col-xs-12 col-sm-12 col-md-12">
<div class="form-group">
<strong>Gateway:</strong>
<input type="text" name="gateway" id="gateway" class="form-control" onchange="validate()" required>
@error('gateway')
<span class="invalid-feedback" role="alert">
<strong>{{ $message }}</strong>
</span>
@enderror
</div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12">
<div class="form-group">
<strong>IFace:</strong>
<input type="text" name="iface" id="iface" class="form-control" onchange="validate()" required>
</div>
</div>

<!-- <div class="col-xs-12 col-sm-12 col-md-12">
<div class="form-group">
<strong>Metric:</strong>
<input type="text" name="metric" id="metric" class="form-control" onchange="validate()" required>
</div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12">
<div class="form-group">
<strong>Tunnel IP:</strong>
<input type="text" name="tunnel_ip" id="tunnel_ip" class="form-control" onchange="validate()" required>
</div>
</div> -->

<div class="col-xs-12 col-sm-12 col-md-12">
<div class="form-group">
<strong>Device Serial:</strong>
	<select class="form-control" id="device_serial" name="device_serial">
			<option value="" disabled selected>-- Select Your Device--</option>
			@foreach($connections as $connection)
			<option value="{{$connection->device_serial}}">{{$connection->device_serial}}</option>
			@endforeach
	</select>
</div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 text-center">
<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
<button type="submit" id="btn-save" name="btnsave" class="btn btn-primary">Submit</button>
</div>
</div>
</form>
</div>
</div>
</div>
</div>



<!-- For validate Model -->
<script>
	@if (count($errors) > 0)
		$('#crud-modal').modal('show');
	@endif
</script>
<!-- For add -->
<script type="text/javascript">
$('#new-customer').click(function () {
$('#btn-save').val("create-customer");
$('#customer').trigger("reset");
$('#customerCrudModal').html("Add New Connection");
$('#crud-modal').modal('show');
});

/*
For Update
*/
$('.connection_edit').on('click',function () {
    var user_id = $(this).attr('conid');
	var tbl_info_id = $(this).attr('tblinfoid');	
	$('#editEmployeeModal').find('#selectitem').val(user_id);
	$('#editEmployeeModal').find('#selecttblinfoitem').val(tbl_info_id);
     $.ajax({
        url: "{{ url('getUserData')}}",
        type: "get",
        data: {user_id: user_id, tbl_info_id: tbl_info_id} ,
        success: function (response) {
          console.log(response); 		          
           $('#destination').val(response['destination']);
           $('#gateway').val(response['gateway']);
           $('#iface').val(response['iface']);
           //$('#metric').val(response['metric']);
		   //$('#tunnel_ip').val(response['tunnel_ip']);
		   $('#device_serial').val(response['device_serial']);
        },
    });
  });
/*
For Delete
*/
function confirm_delete(id){
  var url="{{url('connection-list/delete/')}}";  
  var a='<a href="'+url+'/'+id+'" class="btn btn-primary">Confirm</a>';
  $("#delete_butt_id").html(a);
  $("#delete_confirm").modal();
}
</script>
<!-- <script src="{{ asset('connection/js/custom.js') }}"></script> -->
@endsection