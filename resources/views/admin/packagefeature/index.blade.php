@extends('layouts/admin/default')
@section('title', 'Features')
@section('content')
<section class="content-header">
  <h1>
	Features
	<!--small>Admin</small-->
  </h1>
  <ol class="breadcrumb">
	<li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">Features</li>
  </ol>
</section>

<section class="content container-fluid">
@include('includes.notifications')
<div class="row">
       <div class="col-sm-12">
          <div class="box box-info">
            <div class="box-header">
              <h3 class="box-title">Features</h3>
								<a href="{{ url('admin/package/feature/add') }}" class="btn btn-theme pull-right" title="Add Service">
				 <i class="fa fa-plus"></i>
				 <span>Add Feature</span>
				</a>
				            </div>
      <div class="box-body">
			<form action="{{ url('admin/package/feature') }}" class="form-horizontal" method="GET">
				<div class="row marbt-lg">
					<div class="col-sm-3">
						<div class="form-group">
							<div class="col-sm-12">
								<label>Feature Name</label>
								<input class="form-control" name="name" type="text" value="{{ Request::get('name') }}" placeholder="Features Name">
							</div>
						</div>
					</div>
					<div class="col-sm-3 text-right fltrbtn">
						<label class="fltrbtn-lab">&nbsp;</label>
						<button class="btn btn-theme btnmin">Search</button>
						<a href="{{ url('admin/package/feature') }}"><button class="btn btn-danger btnmin" type="button">Reset</button></a>
					</div>
				
				</div>
			</form>

			
						
		 <table class="table table-striped">
     <thead>
        <tr class="info">
           <th>#</th>
           <th>Name</th>
           <th>Description</th>        
           <th>Status</th>        
           <th style="text-align: center;">Controls</th>
        </tr>
     </thead>
   <tbody>

    @if(count($arrFeatures)>0)
    <?php  $i =(($arrFeatures->currentpage()-1)* $arrFeatures->perpage() + 1); ?>
     @foreach($arrFeatures as $key => $feature)	  
          <tr>
             <td> <?= $i++ ?></td>
             <td>{{$feature->feature_name}}</td>
             <td>{{$feature->description}}</td>
               <td><a onclick="confirm_active('{{$feature->id.'_'.$feature->status}}')"  style="cursor:pointer;"  >{!!($feature->status=='1')?'<i class="fa fa-toggle-on" aria-hidden="true"></i><span class="text-success success">&nbsp;Active</span>' : '<i class="fa fa-toggle-off" aria-hidden="true"></i><span class="text-danger">&nbsp;Inactive</span>'!!}</a></td>
             <td align="center">
                <a href="{{url('admin/package/feature/edit/'.$feature->id)}}" class="btn btn-link" title="Edit"><i class="fa fa-edit"></i></a>
              
               <a onclick="confirm_delete({{$feature->id}});" class="btn btn-link" title='Delete'><i class="fa fa-trash"></i></a>
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
    	{{$arrFeatures->links()}}
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
<div id="active_confirm" class="modal fade" role="dialog">
	  <div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Do you Want to Change Status?</h4>
		  </div>
		  
		  <div class="modal-footer">
			
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			<span id="status_change_id"></span>
			
		  </div>
		</div>

	  </div>
</div>



@endsection
@section('javascript')
<script type="text/javascript">
function confirm_delete(id){
  var url="{{url('admin/package/feature/delete/')}}";
  var a='<a href="'+url+'/'+id+'" class="btn btn-primary">Confirm</a>';
  $("#delete_butt_id").html(a);
  $("#delete_confirm").modal();
} 
function confirm_active(id){
	var url="{{url('admin/package/feature/status/')}}";
	var a='<a href="'+url+'/'+id+'" class="btn btn-primary">Confirm</a>';
	$("#status_change_id").html(a);
	$("#active_confirm").modal();
}
</script>
@endsection