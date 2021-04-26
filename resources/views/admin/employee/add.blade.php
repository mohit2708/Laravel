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
      <li>Employee</li>
   </ol>
</section>
<!-- Main content -->
<section class="content">
   <div class="box box-primary">
      <form action ="{{url('admin/employee/store')}}" method="POST">
         {!! csrf_field() !!}
         <div class="box-body">
            <div class="row">
               <div class="col-md-6">
                  <div class="form-group">
                     <label>First Name</label>
                     <input type="text" class="form-control" id="fname" name="fname" placeholder="First Name" value="{{Request::old('fname')}}">
                     @if ($errors->has('fname'))
                     <div class="error" style="color: red;">{{ $errors->first('fname') }}</div>
                     @endif                  
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="form-group">
                     <label>Last Name</label>
                     <input type="text" class="form-control" id="lname" name="lname" placeholder="Last Name" value="{{Request::old('lname')}}">
                     @if ($errors->has('lname'))
                     <div class="error" style="color: red;">{{ $errors->first('lname') }}</div>
                     @endif
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-6">
                  <div class="form-group">
                     <label>Email</label>
                     <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{Request::old('email')}}">
                     @if ($errors->has('email'))
                     <div class="error" style="color: red;">{{ $errors->first('email') }}</div>
                     @endif
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="form-group">
                     <label>Phone Number</label>
                     <input type="text" class="form-control" id="pnumber" name="pnumber" placeholder="Phone Numbe" value="{{Request::old('pnumber')}}">
                     @if ($errors->has('pnumber'))
                     <div class="error" style="color: red;">{{ $errors->first('pnumber') }}</div>
                     @endif
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-4">
                  <div class="form-group">
                     <label>Country</label>
                     <select id="country-dd" class="form-control select2" style="width: 100%;">
                        <option selected="selected">-- Select Your Contry --</option>
                        @foreach($countries as $country)
                        <option value="{{$country->id}}">{{$country->country_name}}</option>
                        @endforeach
                     </select>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="form-group">
                     <label>State</label>
                     {{-- <select id="state-dd" class="form-control select2" style="width: 100%;">
                        <option selected="selected">-- Select Your State --</option>
                        <option>Alaska</option>                        
                     </select> --}}
                     <select id="state-dd" class="form-control">
                        <option selected="selected">-- Select Your State --</option>
                        </select>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="form-group">
                     <label>City</label>
                     <select id="city-dd" class="form-control select2" style="width: 100%;">
                        <option selected="selected">-- Select Your City --</option>
                        <option>Alaska</option>                        
                     </select>
                  </div>
               </div>
            </div>
            <div class="form-group">
               <label for="exampleInputFile">File input</label>
               <input type="file" id="exampleInputFile">
               <p class="help-block">Only Upload image</p>
            </div>
         </div>
         <div class="box-footer">
            <button type="submit" class="btn btn-primary pull-right">Submit</button>
         </div>
      </form>
</section>
</div>
@include('layouts.admin.footer')
   <script>
        $(document).ready(function () {
            $('#country-dd').on('change', function () {
                var idCountry = this.value;                
                $("#state-dd").html('');
                $.ajax({
                    url: "{{url('/ajax/state/')}}",
                    type: "POST",
                    data: {
                        country_id: idCountry,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (result) {
                     console.log(result);
                        $('#state-dd').html('<option value="">-- Select State --</option>');
                        $.each(result.states, function (key, value) {
                            $("#state-dd").append('<option value="' + value
                                .id + '">' + value.name + '</option>');
                        });
                        $('#city-dd').html('<option value="">Select City</option>');
                    }
                });
            });
            $('#state-dd').on('change', function () {
                var idState = this.value;
                $("#city-dd").html('');
                $.ajax({
                    url: "{{url('')}}",
                    type: "POST",
                    data: {
                        state_id: idState,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (res) {
                        $('#city-dd').html('<option value="">-- Select City-- </option>');
                        $.each(res.cities, function (key, value) {
                            $("#city-dd").append('<option value="' + value
                                .id + '">' + value.name + '</option>');
                        });
                    }
                });
            });
        });

    </script>