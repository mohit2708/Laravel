@extends('layouts/admin/default')
@section('title', 'Discount Info')
@section('content')
<section class="content-header">
  <h1>
	Package
	<!--small>Admin</small-->
  </h1>
  <ol class="breadcrumb">
	<li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">Package</li>
  </ol>
</section>
<section class="content container-fluid">
<div class="row">
  @include('includes.notifications')
   
        <!-- Left col -->
	<div class="col-sm-12">

          <div class="box box-info">
          <div class="panel-body">
	<form action="{{url('admin/package/store')}}" class="form-horizontal" id="package-form" method="post" enctype="multipart/form-data">
		{!! csrf_field() !!}
		<div class="row">
			<div class="col-sm-4">
				<div class="form-group">
				<div class="col-sm-12">
				<label>Package Name</label>
					<input type="text" name="package_name" class="form-control" placeholder="Package Name">
				</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="form-group">
				<div class="col-sm-12">
				<label>Price</label>
					<input type="text" name="package_price" class="form-control" placeholder="Package Price">
				</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="form-group">
				<div class="col-sm-12">
				<label>Package Duration Day</label>
					<select class="form-control" id="package_duration_day" name="package_duration_day" onchange="getpackagenight(this.value);">
					@for($i=1;$i<=30;$i++)
					<option value="{{$i}}">{{$i}} Days</option>
					@endfor
					</select>
				</div>
				</div>
			</div>
			</div>
			<div class="row">
			<div class="col-sm-4">
				<div class="form-group">
				<div class="col-sm-12">
				<label>Package Duration Night</label>
					<input type="text" name="package_night" class="form-control" id="package_night" value="2 Night" readonly />
				</div>
				</div>
			</div>
			
			<div class="col-sm-4 multi-cont-sel">
			<div class="form-group">
				<div class="col-sm-12">
				<label>Package Feature</label>
				<select id="package-feature" multiple="multiple" name="package_feature[]">
					
					@foreach($features_master as $value) 
					<option value="{{$value->id}}">{{$value->feature_name}}</option>
					@endforeach
						
						
				</select>
			</div>
			</div>
			</div>
			<div class="col-sm-4">
			<div class="form-group">
				<div class="col-sm-12">
				<label>Package Policy</label>
				<select id="" class="form-control" name="included_policy">
					@foreach($policy as $value)
					<option value="{{$value->id}}">{{$value->policy_name}}</option>
					@endforeach
					
				</select>
				</div>
				</div>
			</div>
			</div>
			<div class="row">
			<div class="col-sm-4 multi-cont-sel">
				<div class="form-group">
				<div class="col-sm-12">
				<label>Facility Includes in package </label>
				<select id="included-servi" multiple="multiple" name="included_services[]">
					@foreach($facility_include_master as $value)
					<option value="{{$value->id}}">{{$value->facility_name}}</option>
					@endforeach
				</select>
			</div>
			</div>
			</div>
			<div class="col-sm-4">
				<div class="form-group">
				<div class="col-sm-12">
				<label>Discount</label>
				<select id="" class="form-control" name="included_discount">
					@foreach($discount as $value)
					<option value="{{$value->id}}">{{$value->offer_name}}</option>
					@endforeach
					
				</select>
			</div>
			</div>
			</div>

<div class="col-sm-4 multi-cont-sel" >
				<div class="form-group">
				<div class="col-sm-12">
				<label>Hotel included in package</label>
				<select id="hotal-package" multiple="multiple" name="hotel_package[]" >
					<option value="1">Standard</option>
					<option value="2">Deluxe</option>
					<option value="3">Premium</option>
				</select>
			</div>
			</div>
			</div>
			</div>
			<!-- <div class="row">
			<div class="col-sm-3 multi-cont-sel" >
				<div class="form-group">
				<div class="col-sm-12">
				<label>Hotel included in package</label>
				<select id="hotal-package" multiple="multiple" name="hotal_package[]" onchange="get_price();">
					<option value="1">Standard</option>
					<option value="2">Deluxe</option>
					<option value="3">Premium</option>
				</select>
			</div>
			</div>
			</div>
			<div class="col-sm-9">
					<div class="row">
			<div id="hotal_details">
				
			</div>
			</div>
				</div>
		</div> -->
		<div class="row">
			<div class="package_wrapper">
				<div class="location-group">
				<div class="col-sm-12"><h3 class="title_itanerary">Itinerary  <button type="button" class="btn btn-theme pull-right add-loc">+ Add</button></h3></div>
					<div class="col-sm-4"><div class="form-group">
				<div class="col-sm-12">
						<label>Location</label>
						<select id="" class="form-control" name="info[0][location]">
						<?php $city_option=""; $day=""; ?>
							@foreach($city as $value)
							<option value="{{$value->id}}">{{$value->name}}</option>
							<?php  $city_option .= '<option value="'.$value->id.'">'.$value->name.'</option>'; ?>
							@endforeach
						</select>
					</div>
					</div>
					</div>
					<div class="col-sm-4">
					<div class="form-group">
				<div class="col-sm-12">
						<label>Day</label>
						<select id="" class="form-control" name="info[0][location_day]">
							@for($i=1;$i<=30;$i++)
								<option value="{{$i}}">{{$i}} Days</option>
							<?php  $day .= '<option value="'.$i.'">'.$i.' Days </option>'; ?>
							@endfor
							
						</select>
					</div>
					</div>
					</div>
					<div class="col-sm-4">
					<div class="form-group">
				<div class="col-sm-12">
                      <label>Images</label>
                       <div class="input-group-file">
                           <input type="file" name="info[0][location_image][]" class="form-control" multiple>
                           <span><i class="fa fa-upload"></i></span>
                       </div>
                    </div>
                    </div>
                    </div>
				
					<div class="clearfix"></div>
					<div class="col-sm-12">
					<label class="fltrbtn-lab">Activity</label>
					    <textarea name="info[0][location_desc]" id="" cols="10" rows="5" class="form-control jqte-editor _resize "></textarea>
					</div>
				</div>
			</div>
	</div>
	<div class="form-group">
			<div class="col-sm-12">
				<h4>Package Description</h4>
				<textarea class="form-control jqte-editor required" name="description" rows="5" id="comment"></textarea>
			</div>
			</div>
				<div class="form-group">
			<div class="col-sm-2"><br>
				<label>Package Images</label>
				<div class="upload-grp">
		<input type="file" name="package_images[]" multiple="" id="package_images" onchange="makeFileList()">
					<span class="upload-icon"><i class="fa fa-upload" aria-hidden="true"></i></span>
				</div>
				<div class="upload-gallery">
               <ul></ul>
                </div>
			</div>
			</div>
			<div class="form-group">
			<div class="col-lg-4 pull-right">
			<div class="row">
			<div class="col-xs-6">
				<input type="submit" value="Save" class="btn btn-theme btn-block">
				</div>
					<div class="col-xs-6">
				<button type="button" class="btn btn-warning btn-block">Reset</button>
				</div>
				</div>
			</div>
			</div>
		
		</form>
	  <!-- Custom tabs (Charts with tabs)-->
	</div>
		
	  </div>
	  <!-- /.nav-tabs-custom -->

	 

	</div>
	<!-- /.Left col -->
	
  </div>

</section>


@endsection
@section('javascript')

<script type="text/javascript">
$(document).ready(function() {
	
    
    var max_fields      = 5; //maximum input boxes allowed
    var wrapper         = $(".package_wrapper"); //Fields wrapper
    var add_button      = $(".add-loc"); //Add button ID
   
    var x = 0; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
    	
        e.preventDefault();
        if(x < max_fields){ //max input box allowed

            x++; //text box increment
			
            $(wrapper).append('<div class="location-group"><button type="button" class="btn btn-danger btnclose_itnry remove-loc">x</button><div class="col-sm-4"><label>Location</label><select id="" class="form-control" name="info['+x+'][location]"><?php echo $city_option ?></select></div><div class="col-sm-4"><label>Day</label><select id="" class="form-control" name="info['+x+'][location_day]"><?php echo $day ?></select></div><div class="col-sm-4"><label>Images</label><div class="input-group-file"><input type="file" name="info['+x+'][location_image][]" class="form-control" multiple=""><span><i class="fa fa-upload"></i></span></div></div><div class="clearfix"></div><div class="col-md-12"><label class="fltrbtn-lab">Activity</label><textarea name="info['+x+'][location_desc]" cols="10" rows="5" class="form-control _resize jqte-editornew" id="jqet'+x+'"></textarea></div></div>'); //add input box
        }
$("#jqet"+x).jqte();
    });
   
    $(wrapper).on("click",".remove-loc", function(e){ //user click on remove text
        e.preventDefault(); $(this).parents('.location-group').remove(); x--;
    })
});
</script>


<script type="text/javascript">
	function getpackagenight(day){
		
		$("#package_night").val(parseInt(day)+1+" Night");
	}
	$(document).ready(function() {
	$('#Location, #package-feature, #hotel-included, #included-servi, #hotal-package').multiselect();
	});
	
	$("input[name$='optradio']").click(function() {
        var test = $(this).val();

        $("select.opt-dat").hide();
        $("#opt-dat" + test).show();
    });

    $("input[name$='optr-adio']").click(function() {
        var test = $(this).val();

        $("select.opt-dat").hide();
        $("#opt-dat" + test).show();
    });
</script>
<script>
$(document).ready(function(){
    $(".add-loc").click(function(){
		
    	var vTxt = $('.location-group').html();
        $(".location-group-two").append("<div class='listing'>"+vTxt+"</div>");
        $(".location-group-two .add-loc").hide();
        $(".location-group-two .remove-loc").show();
        $('.listing').on('click','.remove-loc',function(){
        $(this).parent().parent().remove();
        });
        
        
    });
    
    
    
});
function makeFileList(){
        var input = document.getElementById('package_images');
        for(var j=0; j<input.files.length;j++){
        var Txt = input.files[j].name;
        $('.upload-gallery > ul').append('<li>'+Txt+'<span class="delete"><i class="fa fa fa-trash"></i></span></li>');
        }  
    }    
    
</script>
<script type="text/javascript">
$('#validForm1').validate({
	rules: {
		points:{
			required : true,
			number : true,
		} 
	},
});
</script>
 <script>
    $(document).ready(function() {
        
        $('.jqte-editor').jqte();
        
        // create MultiSelect from select HTML element
        var required = $("#required").kendoMultiSelect().data("kendoMultiSelect");
        var optional = $("#optional").kendoMultiSelect({
            autoClose: false
        }).data("kendoMultiSelect");

        $("#get").click(function() {
            alert("Attendees:\n\nRequired: " + required.value() + "\nOptional: " + optional.value());
        });
    });
</script>

<script type="text/javascript">
$('#validForm2').validate({
	rules: {
		discount:{
			required : true,
		},
		upto:{
			required : true,
			number : true,
		} 
	},
});
// function get_price(){
	
//  var selO = document.getElementsByName('hotal_package[]')[0];
//     var selValues = [];
// 	var select='';
// 	var text;
// 	var c=0;
//     for(i=0; i < selO.length; i++){
		
//         if(selO.options[i].selected){
//             select += '<div class="col-sm-12"><h3>Standard</h3></div><div class="col-sm-6 multi-cont-sel" ><input type="hidden" value="'+selO.options[i].value+'" name="package_include['+c+'][hotel_type]" ><label>Hotel </label><select class="form-control" name="package_include['+c+'][hotel]"><option value="1">Hotal1</option><option value="2">Hotal2</option></select></div><div class="col-sm-6 multi-cont-sel" ><label>Hotal Price</label><input type="text" name="package_include['+c+'][price]" id="package_include'+c+'" class="form-control hotelprice" placeholder="Hotal Price" onkeyup="hideerromsg()" ><label id="hotal_eror'+c+'" class="hotal_ceror" style="display:none;color:red;" >This field is required.</label></div>';
// 	    c++;
			
//         }
// 	$("#hotal_details").html(select);
		
//     }
// }
$.validator.setDefaults({
      ignore: []
  });
$('#package-form').validate({


	rules: {
            package_name:{
			required : true,
		},
		package_price:{
			required : true,
			number : true,
		},
                package_duration_day:{
			required : true,
		},
                'package_feature[]': {
                         required: true
                },
                 included_policy:{
			required : true,
		},
                 'included_services[]': {
                         required: true
                },
                included_discount : {
			required : true,
		},
                'hotal_package[]': {
                         required: true
                },
                description:{
                    required: true
                },
                'package_images[]':{
                     required: true
                }
                
	},
        submitHandler: function () {

             var selO = document.getElementsByName('hotal_package[]')[0];
            var c=0;
            var d=0;
            
            for(i=0; i < selO.length; i++){
                
                if(selO.options[i].selected){
                   
                     if($('#package_include'+c).val()=="")
                     {
                       $('#hotal_eror'+c).show();
                      //return false;
                     } else {
                         d++;
                     } 
                  c++;
                 }
           
            } 
           if(c==d){
               $(this).form().submit();
           } else {
               return false;
           }
              
        },
        
});

$("._resize").rules("add", { 
    required:true,  
  });
function hideerromsg(){
    $(".hotal_ceror").hide();
}

</script>
@endsection