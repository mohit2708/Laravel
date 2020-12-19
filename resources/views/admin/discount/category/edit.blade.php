@extends('layouts/admin/default')
@section('title', 'Edit Discount Category')
@section('content')
<section class="content-header">
  <h1>
	Discount Category
	<!--small>Admin</small-->
  </h1>
  <ol class="breadcrumb">
	<li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">Edit Discount Category</li>
  </ol>
</section>
<section class="content container-fluid">

     <div class="row">
       <div class="col-sm-12">
	   @include('includes.notifications')
			<div class="box box-info">
				<div class="box-header">
					<h3 class="box-title">Edit Discount Category</h3>
				</div>
				<div class="box-body">
					<form action ="{{url('admin/discount/category/update/'.$dataDiscountCat->id)}}" class="form-horizontal" id="validForm" method="POST" enctype="multipart/form-data">
						{!! csrf_field() !!}
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12">
										<label>Category Name</label>
										<input type="text" name="category_name" class="form-control" value="{{ $dataDiscountCat->category_name }}" placeholder="Category Name">
										@if ($errors->has('category_name'))
											<div class="error small">{{ $errors->first('category_name') }}</div>
										@endif
									</div>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-9">
										<label>Image</label>
										<input class="form-control" name="category_img" type="file" value="{{ $dataDiscountCat->category_img }}"">
										@if ($errors->has('category_img'))
											<div class="error small">{{ $errors->first('category_img') }}</div>
										@endif
									</div>
									<div class="col-sm-3" style="margin-top: 20px;">
										@if($dataDiscountCat->category_img)
										<img src="{{url('public/images/discount_category/icon/'.$dataDiscountCat->category_img)}}" height="50" width="50">
										@endif
									</div>
								</div>
							</div>
							
							<div class="clearfix"></div>
							
							<div class="col-sm-12">
								<div class="form-group">
									<div class="col-sm-12">
										<label>Feature Description</label>
										<textarea class="form-control" name="description" placeholder="Feature Description" rows="5">{{ $dataDiscountCat->description  }}</textarea>
										@if ($errors->has('description'))
											<div class="error small">{{ $errors->first('description') }}</div>
										@endif
									</div>
								</div>
								
							</div>
							
						</div>
						<div class="form-group">
							<div class="col-sm-12 text-right">
								<a href="{{ url('admin/discount/category') }}"><button class="btn btn-danger" type="button">Cancel</button></a>
								<button class="btn btn-theme">Submit</button>
							</div>
						</div>
					</form>
				</div>
			<!-- /.box-body -->
			</div>
        </div>
     </div>

    </section>
@endsection
@section('javascript')
<script type="text/javascript">
$('#validForm').validate({
	rules: {
		category_name:{
			required : true,
		}
	},
});
</script>
@endsection