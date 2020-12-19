<?php
	$module_list = Helper::module_assign_list(Auth::user()->role_id);
	//echo '<pre>';
	//print_r($module_list); die;
?>
 <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{ asset('public/assets/dist/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>Admin</p>
          <!-- Status -->
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <!-- search form (Optional) -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
              </button>
            </span>
        </div>
      </form>
      <!-- /.search form -->

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu" data-widget="tree">
        <!-- Optionally, you can add icons to the links -->
        <li class="{{ Request::segment(1) == 'admin'? (!Request::segment(2)) ? 'active' : '' :''}}"><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
		@foreach($module_list['sidebar'] as $key => $page)
		<?php //echo '<pre>'; print_r($page); die; ?>
			<?php
				$page_id = key($page); 
				$url = $page[$page_id]['slug'];
				$root_url=explode("/",$url);
				$segment_url=$root_url[1]; 
			?>	
			
			<li id="{{$page_id}}" class="treeview {{ Request::segment(2) === $segment_url?'active':''}}">
			  <a href="#">{!! $module_list['icons'][$key] !!} <span>{{$key}}</span>
				<span class="pull-right-container">
					<i class="fa fa-angle-left pull-right"></i>
				  </span>
			  </a>
			  <ul class="treeview-menu" >
			    @foreach($page as $key1 => $privilege)
					<li class="{{ ($privilege['slug'] == Request::path()) ? 'active' : '' }}"><a href="{{ url($privilege['slug'])}}"><i class="fa fa-check"></i>{{ucwords($key1)}}</a></li>
				@endforeach			   
			  </ul>
			</li>
		@endforeach	
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>