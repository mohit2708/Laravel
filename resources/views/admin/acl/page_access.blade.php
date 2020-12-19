@extends('layouts/admin/default')
@section('title', 'Dashboard')
@section('content')
<section class="content-header">
<ol class="breadcrumb">
	<li><a href="{{ url('admin') }}"><i class="fa fa-home"></i></a></li>
	<li class="active">Page Access</li>
</ol>
  <h1>
	ACL Management
  </h1>
</section>

<!-- Main content -->
<section class="content container-fluid">
<div class="row">

<div class="col-sm-12">
  <div class="panel">
    <div class="panel-body">
	@include('includes.notifications')
	<div class="row martn">
		<form method="post" action="{{url('admin/acl/page_access/edit')}}" class="form-horizontal" id="role_form"> 
		{{csrf_field()}}   
		<input type="hidden" name="role_id" id="role_id" value=" ">
		</form>
		<form method="post" action="{{url('admin/acl/page_access/store')}}" class="form-horizontal"> 
	  <div class="col-sm-7 text-left" style="margin-bottom:10px;">
		
		{{csrf_field()}} 
		  <div class="form-group">
			<div class="col-sm-12">
			  <select name="role" class="form-control" id="role">
				<option>Select Role</option>
				@foreach($arrRole as $rolevalue)
				<?php $selectedVal = ''; ?>
				@if(!empty($arrModuleList)) 
					@if($arrModuleList['role']==$rolevalue['id'])
						<?php $selectedVal = 'selected'; ?>
					@endif
				@endif
				
				<option value="{{ $rolevalue->id }}" {{$selectedVal}} >{{ $rolevalue->role_title }}</option>
				@endforeach
			  </select>
			</div>
		  </div>

		
	  </div>
	  <!-- /.box-header -->
	</div>

	<div class="prevlge">
		<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
		<?php $i = 1; ?>
		@foreach($arrModuleAccess as $key => $module_val)
			<div class="panel panel-default">
				<div class="panel-heading" role="tab">
					<h4 class="panel-title">
					<?php $fullChecked = ''; ?>
					@if(!empty($arrModuleList))
						@if(in_array($module_val[0]['module_id'],$arrModuleList['module']))
							<?php $fullChecked = 'checked'; ?>
						@endif
					@endif
					   <label class="checkbox-inline newcheckbox">
							 <input type="checkbox" class="page_name_ass1" {{ $fullChecked }}><span></span>
						</label> 
						   <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_{{$i}}" aria-expanded="true">
							<i class="more-less glyphicon glyphicon-plus"></i>
						   {{ $key }} 
							</a>
					</h4>
				</div>
				<div id="collapse_{{$i}}" class="panel-collapse collapse" role="tabpanel">
					<div class="panel-body">
					<ul class="in-aclist">
					@foreach($module_val as $key1 => $page)
					<?php $innerChecked = ''; ?>
					@if(!empty($arrModuleList))
						@if(in_array($page['page_id'],$arrModuleList['page']))
							<?php $innerChecked = 'checked'; ?>
						@endif
					@endif
					<div class="col-sm-3">
					<li style="list-style: none;">
					   <label class="checkbox newcheckbox">
						  <input type="checkbox" name="arrPrivilege[]" class="module_page" value="{{$page['page_id']}}" {{ $innerChecked }}><span>{{$page['page_title']}}  </span>
					   </label>  
					</li>
					</div>
					@endforeach
					
					</ul>
					</div>
				</div>
			</div>
		<?php $i++; ?>
		@endforeach	
		</div><!-- panel-group -->
	</div><!-- container -->
	@if(!empty($arrModuleList))
		<div class="panel-body">
			<div class="row">
				<div class="col-sm-4 col-sm-offset-4">
					<input type="submit" class="btn btn-block btn-theme btn-lg" id="page_access_submit" name="submit" value="Submit">
				</div>
			</div>
		</div>
	@endif
	
    </div>
  </div>
</div>
</div>
</form>

    </section>
@endsection
@section('javascript')
<script>
$(document).ready(function(){
	$(".prevlge .panel-title").on('click','a',function(){
		$(this).find("i").toggleClass('fa fa-minus');
	});
	$("#page_access_submit").click(function(){
		var role=$("#role").val();
		if(role==""){
			alert("Please Select Role");
			return false; 
		}    
	});

	$("#role").change(function(){
		$("#role_id").val($(this).val());
		$("#role_form").submit();    
	});
			
	$(".page_name_ass1").change(function(){
		if ($(this).is(':checked')) {
			$(this).closest('.panel').find('.in-aclist input:checkbox').prop('checked',true);
		}else{
			$(this).closest('.panel').find('.in-aclist input:checkbox').prop('checked',false);
		}   
	});	
}); 
</script>
@endsection