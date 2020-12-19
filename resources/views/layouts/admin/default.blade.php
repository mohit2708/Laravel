<!DOCTYPE html>

<html>
	@include('includes.admin.head')
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <!-- Main Header -->
  @include('includes.admin.header')
  <!-- Left side column. contains the logo and sidebar -->
  @include('includes.admin.sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- Main content -->
		@yield('content')
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
@include('includes.admin.footer')
  <!-- Control Sidebar -->
  
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
  immediately after the control sidebar -->
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 3 -->
<script src="{{ asset('public/assets/plugins/jquery/dist/jquery.min.js')}}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('public/assets/plugins/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('public/assets/dist/js/adminlte.min.js')}}"></script>
<script src="{{ asset('public/assets/dist/js/jquery.validate.min.js')}}"></script>
<script src="{{ asset('public/assets/dist/js/bootstrap-multiselect.min.js')}}"></script>
<script src="{{ asset('public/assets/dist/js/random-generator.js')}}"></script>



<!-- <script src="{{ asset('public/assets/dist/js/jquery.min.js')}}"></script> -->
  <script src="{{ asset('public/assets/dist/js/kendo.all.min.js')}}"></script>
  <script src="{{ asset('public/js/jquery-te-1.4.0.min.js')}}"></script>
  
	@yield('javascript_links', '')
	@yield('styles', '')
	
	@yield('javascript')
	<script type="text/javascript">
		$(document).ready(function(){
			
		});
	</script>
<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. -->
</body>
</html>