@include('admin.includes.header')
@include('admin.includes.sidebar')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         Employee Add
      </h1>
      <ol class="breadcrumb">
         <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
         <li class="active">Employee</li>
      </ol>
   </section>
   <!-- Main content -->
   <section class="content">
      <div class="row">
         <div class="col-md-12">
            <div class="box box-primary">
{{--            <div class="box-header with-border">
                  <h3 class="box-title">Employee List</h3>
               </div> --}}

				@if(session()->has('success'))
				<div class="alert alert-success alert-dismissible">
				  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				  <strong>Success!</strong> {{ session()->get('success') }}
				</div>
				@endif
               <form action = "{{ url('/employee/store') }}" method = "post">
               	<input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                  <div class="box-body">
                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>First Name</label>
                              <input type="text" class="form-control" id="fname" name="fname" placeholder="Enter Your First Name" value="{{Request::old('fname')}}">
                              @if ($errors->has('fname')) <p style="color:red;">{{ $errors->first('fname') }}</p> @endif
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Last Name</label>
                              <input type="text" class="form-control" id="lname" name="lname" placeholder="Enter Your Last Name" value="{{Request::old('lname')}}">
                              @if ($errors->has('lname')) <p style="color:red;">{{ $errors->first('lname') }}</p> @endif

                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Email address</label>
                              <input type="email" class="form-control" id="emp_email" name="emp_email" placeholder="Enter Your Email" value="{{Request::old('emp_email')}}">
                              @if ($errors->has('emp_email')) <p style="color:red;">{{ $errors->first('emp_email') }}</p> @endif
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Mobile Number</label>
                              <input type="number" class="form-control" id="mnumber" name="mnumber" placeholder="Enter Your Number" value="{{Request::old('mnumber')}}">
                              @if ($errors->has('mnumber')) <p style="color:red;">{{ $errors->first('mnumber') }}</p> @endif
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Gender</label>
                              <div class="radio">
                                 <label><input type="radio" id="male" name="gender" value="male" value="{{Request::old('gender')}}">Male</label>&nbsp;&nbsp;
                                 <label><input type="radio" id="female" name="gender" value="female" value="{{Request::old('gender')}}">Female</label>
                                 @if ($errors->has('gender')) <p style="color:red;">{{ $errors->first('gender') }}</p> @endif
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Language</label>
                              <div class="checkbox">
                                 <label><input type="checkbox" name="language[]" value="hindi">Hindi</label>&nbsp;&nbsp;
                                 <label><input type="checkbox" name="language[]" value="english">English</label>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-4">
                           <div class="form-group">
                              <label>Country</label>
                              <select class="form-control">
                                 <option>option 1</option>
                                 <option>option 2</option>
                                 <option>option 3</option>
                                 <option>option 4</option>
                                 <option>option 5</option>
                              </select>
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group">
                              <label>State</label>
                              <select class="form-control">
                              <option>option 1</option>
                              <option>option 2</option>
                              <option>option 3</option>
                              <option>option 4</option>
                              <option>option 5</option>
                              </select>
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group">
                              <label>City</label>
                              <select class="form-control">
                              <option>option 1</option>
                              <option>option 2</option>
                              <option>option 3</option>
                              <option>option 4</option>
                              <option>option 5</option>
                              </select>
                           </div>
                        </div>
                     </div>




                     {{--  --}}



                     <div class="form-group">
                        <label for="exampleInputFile">File input</label>
                        <input type="file" id="exampleInputFile">
                        <p class="help-block">Example block-level help text here.</p>
                     </div>
                  </div>
                  <!-- /.box-body -->
                  <div class="box-footer">
                     <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
               </form>
            </div>
         </div>
      </div>
      <!-- /.row -->
   </section>
   <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@include('admin.includes.footer')

<style type="text/css">
/* Remove arrow in input type number */

/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
-webkit-appearance: none;
margin: 0;
}

/* Firefox */
input[type=number] {
-moz-appearance: textfield;
}
</style>

{{-- @foreach($posts as $post)
                            <tr>
                                <td>{{ $post->name }}</td>

                                <td>
                                    @foreach($post->category as $value)
                                        {{$value}},
                                    @endforeach
                                </td>
                                <td>{{ $post->description }}</td>
                            </tr>
                            @endforeach --}}