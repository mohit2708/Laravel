@include('layouts.admin.header')
@include('layouts.admin.sidebar')
<div class="content-wrapper">
<section class="content-header">
   <h1>
      Employee
      <small>Add Employee</small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li>Edit Employee</li>
   </ol>
</section>
<!-- Main content -->
<section class="content">
   <div class="box box-primary">
      <form action ="{{url('admin/employee/update/'.$dataEmployee->id)}}" method="POST" enctype="multipart/form-data">
		{!! csrf_field() !!}
         <div class="box-body">
            <div class="row">
               <div class="col-md-6">
                  <div class="form-group">
                     <label>First Name</label>
                     <input type="text" class="form-control" id="fname" name="fname" placeholder="First Name" value="{{$dataEmployee->f_name}}">
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="form-group">
                     <label>Last Name</label>
                     <input type="text" class="form-control" id="lname" name="lname" placeholder="Last Name" value="{{$dataEmployee->l_name}}">
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-6">
                  <div class="form-group">
                     <label>Email</label>
                     <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{$dataEmployee->email}}">
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="form-group">
                     <label>Phone Number</label>
                     <input type="text" class="form-control" id="pnumber" name="pnumber" placeholder="Phone Numbe" value="{{$dataEmployee->phone_number}}">
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-12 text-right">
                  <a href="{{ url('admin/employee') }}"><button class="btn btn-danger" type="button">Cancel</button></a>
            <button type="submit" class="btn btn-primary">Update</button>
               </div>
            </div>
        {{--     <div class="form-group">
               <label for="exampleInputFile">File input</label>
               <input type="file" id="exampleInputFile">
               <p class="help-block">Only Upload image</p>
            </div> --}}
         </div>
      </form>
</section>
</div>
@include('layouts.admin.footer')