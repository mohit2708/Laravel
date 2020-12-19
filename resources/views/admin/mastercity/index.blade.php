@extends('layouts/admin/default')
@section('title', 'City')
@section('content')
<section class="content-header">
  <h1>
	City
	<!--small>Admin</small-->
  </h1>
  <ol class="breadcrumb">
	<li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">City</li>
  </ol>
</section>

<section class="content container-fluid">

<div class="row">
       <div class="col-sm-12">
          <div class="box box-info">
            <div class="box-header">
              <h3 class="box-title">City List </h3>
								<a href="{{ url('admin/master/city/add') }}" class="btn btn-theme pull-right" title="Add Service">
				 <i class="fa fa-plus"></i>
				 <span>Add City</span>
				</a>
				            </div>
            <div class="box-body">


			<form action="{{ url('admin/master/city') }}" class="form-horizontal" method="GET">
				<div class="row marbt-lg">
        <div class="col-sm-3">
            <div class="form-group">
              <div class="col-sm-12">
                <label>Country</label>
                <select class="form-control" name="country" id="country">
                  <option value="">--Select--</option>
                 @foreach($arrCountry as $country)
                        <option value="{{ $country->id }}" {{ (Request::get('country') == $country->id)? 'selected' : '' }} >{{ $country->name }}</option>
                      @endforeach
                </select>
              </div>
            </div>
          </div>
          <div class="col-sm-3">
            <div class="form-group">
              <div class="col-sm-12">
                <label>State</label>
                <select class="form-control" name="state" id="state">
                  <option value="">--Select--</option>
                
                </select>
              </div>
            </div>
          </div>
					<div class="col-sm-3">
						<div class="form-group">
							<div class="col-sm-12">
								<label>City Name</label>
								<input class="form-control" name="name" type="text" value="{{ Request::get('name') }}" placeholder="City Name">
							</div>
						</div>
					</div>
					<div class="col-sm-3 text-right fltrbtn">
						<label class="fltrbtn-lab">&nbsp;</label>
						<button class="btn btn-theme btnmin">Search</button>
						<a href="{{ url('admin/master/city') }}"><button class="btn btn-danger btnmin" type="button">Reset</button></a>
					</div>
				
				</div>
			</form>

			
						
		 <table class="table table-striped">
   <thead>
      <tr class="info">
         <th>#</th>
         <th>Country</th>
         <th>State</th>
         <th>City</th>        
         <th style="text-align: center;">Controls</th>
      </tr>
   </thead>
   <tbody>

@if(count($mastercity)>0)
<?php  $i =(($mastercity->currentpage()-1)* $mastercity->perpage() + 1); ?>
 @foreach($mastercity as $key => $city)	  
      <tr>
         <td> <?= $i++ ?></td>
         <td>{{$city->country_name}}</td>
          <td>{{$city->state_name}}</td>
         <td>{{$city->name}}</td>
         
         <td align="center">
            <a href="{{url('admin/master/city/edit/'.$city->id)}}" class="btn btn-link" title="Edit"><i class="fa fa-edit"></i></a>
           <a onclick="confirm_delete({{$city->id}});" class="btn btn-link" title='Delete'><i class="fa fa-trash"></i></a>
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
	
</div>
</div>
{{$mastercity->links()}}
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
  var url="{{url('admin/master/city/delete/')}}";
  var a='<a href="'+url+'/'+id+'" class="btn btn-primary">Confirm</a>';
  $("#delete_butt_id").html(a);
  $("#delete_confirm").modal();
} 
</script>
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
@endsection