<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <!-- <script src="{{ asset('js/app.js') }}" defer></script> -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('connection/css/style.css') }}">
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ route('admin-dashboard') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item">
                                    <a class="nav-link" href="{{ route('route-list') }}">{{ __('Route List') }}</a>
                            </li>
                            <li class="nav-item">
                                    <a class="nav-link" href="{{ route('device-info') }}">{{ __('Device Information') }}</a>
                            </li>
                             <li class="nav-item">
                                    <a class="nav-link" href="{{ route('routeopertion') }}">{{ __('Route Action') }}</a>
                            </li>  
                            <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin-dashboard') }}">{{ __('User List') }}</a>
                            </li>                            
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ ucfirst(Auth::user()->name) }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
        <script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script> 
        <script src="{{ asset('connection/js/custom.js') }}"></script> 
        <script src="{{ asset('js/bootstrap.min.js') }}"></script> 
        <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>      
        <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
        <!-- For Data Table -->
<script type="text/javascript">
  $(document).ready(function() {
    $('#device_info').DataTable();
} );
</script>
<!-- For Delete -->
<script type="text/javascript">
function confirm_delete(id){
  var url="{{url('admin-dashboard/delete/')}}";
  var a='<a href="'+url+'/'+id+'" class="btn btn-primary">Confirm</a>';
  $("#delete_butt_id").html(a);
  $("#delete_confirm").modal();
} 
</script>
<!-- for user Active or Inactive -->
<script type="text/javascript">
$(document).ready(function() {
  $(".toggle-class").change(function()  {    
    var id = $(this).attr("data-id");    
    var id = id;
    if(confirm('Are you sure you want to Change Status')){
    $.ajax({
      type: "get",
      url: "{{route("status")}}",
      data: {id: id},
      success: function(data){
              console.log(data.success)
      }      
    });
  }
  else{
            location.reload();
        }
   });
  });
</script>  
<!-- Get tunnel ip in device Action Page -->
<script type="text/javascript">
   $('#device_serial_number').on('change',function () {   
    let deviceNumber = $(this).val();
       $.ajax({
           url: "{{ url('get-tunnel-id')}}",
           type: "get",
           data: {device_serial: deviceNumber} ,
           success: function (response) {                 
             $('#tunnel_ip').val(response['tunnel_ip'])
           },
       });
     });
</script> 
    </div>
</body>
</html>
