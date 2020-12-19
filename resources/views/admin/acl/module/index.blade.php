@extends('layouts/admin/default')
@section('title', 'Modules')
@section('content')
<section class="content-header">
  <h1>
	Modules
	<!--small>Admin</small-->
  </h1>
  <ol class="breadcrumb">
	<li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">Modules</li>
  </ol>
</section>

<section class="content container-fluid">

<div class="row">
       <div class="col-sm-12">
          <div class="box box-info">
            <div class="box-header">
              <h3 class="box-title">Module List </h3>
				@if(\Helper::page_access(Auth::user()->role_id, 'admin/acl/module/add'))
				<a href="{{ url('admin/acl/module/add') }}" class="btn btn-theme pull-right" title="Add Module">
				 <i class="fa fa-plus"></i>
				 <span>Add Module</span>
				</a>
				@endif
            </div>
            <div class="box-body">

			<form action="{{ url('admin/acl/module') }}" class="form-horizontal" method="GET">
				<div class="row marbt-lg">
					<div class="col-sm-3">
						<div class="form-group">
							<div class="col-sm-12">
								<label>Role</label>
								<select class="form-control" name="role">
									<option value="">--Select--</option>
									@foreach($arrRoles as $role)
										<option value="{{ $role->id }}" {{ (Request::get('role') == $role->id)? 'selected' : '' }} >{{ $role->role_title }}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
							<div class="col-sm-12">
								<label>Title</label>
								<input class="form-control" name="title" type="text" value="{{ Request::get('title') }}" placeholder="Title" />
							</div>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
							<div class="col-sm-12">
								<label>Show in Menu</label>
								<select class="form-control" name="show_on_menu">
									<option value="">--Select--</option>
									<option value="1" {{ (Request::get('show_on_menu') == 1)? 'selected' : '' }} >Yes</option>
									<option value="2" {{ (Request::get('show_on_menu') == 2)? 'selected' : '' }} >No</option>
								</select>
							</div>
						</div>
					</div>
					<div class="col-sm-3 text-right fltrbtn">
						<label class="fltrbtn-lab">&nbsp;</label>
						<button class="btn btn-theme btnmin">Search</button>
						<a href="{{ url('admin/acl/module') }}"><button class="btn btn-danger btnmin" type="button">Reset</button></a>
					</div>
				
				</div>
			</form>
			
			@include('includes.notifications')
			
		 <table class="table table-striped">
			<thead>
				<tr class="info">
					<th>#</th>
					<th>Role</th>
					<th>Module Title</th>
					<th style="text-align: center;">Show in Menu</th>
					<th style="text-align: center;">Created At</th>
					<th style="text-align: center;">Controls</th>
				</tr>
			</thead>
			
			<tbody> 
				@if(count($arrModules)>0)
				<?php  $i =(($arrModules->currentpage()-1)* $arrModules->perpage() + 1); ?>
				@foreach($arrModules as $module)
					<tr>
						<td><?= $i++ ?></td>
						<td>{{$module->role_title}}</td>
						<td>{!! $module->icon !!}&nbsp;{{$module->module_title}}</td>
						<td style="text-align: center;">{!!($module->show_on_menu == 1) ? '<span class="label label-success">Yes</span>' : '<span class="label label-warning">No</span>'!!}</td>
						<td align="center">{{date('F d, Y', strtotime($module->created_at))}}</td>
						<td align="center">
						@if(\Helper::page_access(Auth::user()->role_id, 'admin/acl/module/edit'))
							<a href="{{url('admin/acl/module/edit/'.$module->id)}}" class="btn btn-link" title='edit'><i class="fa fa-edit"></i></a>
						@endif
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
	{{$arrModules->links()}}
</div>
</div>

</div>
</div>


</section>
@endsection