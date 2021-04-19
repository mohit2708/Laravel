@include('layouts.admin.header')
@include('layouts.admin.sidebar')
<div class="content-wrapper">
<section class="content-header">
   <h1>
      Employee
      <small>Employee List</small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li>Employee</li>
      <li>Employee List</li>
   </ol>
</section>
<section class="content">
	<div class="box">
            <!-- /.box-header -->
            <div class="box-body">
			@if ($message = Session::get('success'))
				<div class="alert alert-success alert-block">
					<button type="button" class="close" data-dismiss="alert">×</button> 
					<strong>{{ $message }}</strong>
				</div>
			@endif
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Email</th>
                  <th>Phone Number</th>
                  <th>Status</th>
                </tr>
                </thead>
                <tbody>
                @foreach($employee as $emp)
                <tr>
                  <td>{{$emp->f_name}}</td>
                  <td>{{$emp->l_name}}</td>
                  <td>{{$emp->email}}</td>
                  <td>{{$emp->phone_number}}</td>
                  <td><a href="{{url('admin/employee/edit/'.$emp->id)}}" class="btn btn-link" title="Edit"><i class="fa fa-edit"></i></a></a>
                  	  {{-- <a class="btn"><i class="fa fa-trash"></i></a> --}}
                      <a onclick="confirm_delete({{$emp->id}});" class="btn btn-link" title='Delete'><i class="fa fa-trash"></i></a>
                  </td>
                </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Email</th>
                  <th>Phone Number</th>
                  <th>Extra</th>
                </tr>
                </tfoot>
              </table>
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
</div>
@include('layouts.admin.footer')
<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>
<script type="text/javascript">
function confirm_delete(id){
  var url="{{url('admin/employee/delete/')}}";
  var a='<a href="'+url+'/'+id+'" class="btn btn-primary">Confirm</a>';
  $("#delete_butt_id").html(a);
  $("#delete_confirm").modal();
} 
</script>