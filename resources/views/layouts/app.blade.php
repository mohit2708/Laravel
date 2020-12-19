<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <!-- Title Page-->
    <title>911Inform</title>

    <!-- Fontfaces CSS-->
    <link href="{{ asset('theme/css/font-face.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('theme/vendor/font-awesome-4.7/css/font-awesome.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('theme/vendor/font-awesome-5/css/fontawesome-all.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('theme/vendor/mdi-font/css/material-design-iconic-font.min.css') }}" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="{{ asset('theme/vendor/bootstrap-4.1/bootstrap.min.css') }}" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="{{ asset('theme/vendor/animsition/animsition.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('theme/vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('theme/vendor/wow/animate.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('theme/vendor/css-hamburgers/hamburgers.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('theme/vendor/slick/slick.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('theme/vendor/select2/select2.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('theme/vendor/perfect-scrollbar/perfect-scrollbar.css') }}" rel="stylesheet" media="all">

    <!-- Main CSS-->
   
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">

<link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/3.3.2/css/fixedColumns.bootstrap4.min.css">
 <link href="{{ asset('theme/css/theme.css') }}" rel="stylesheet" media="all">
</head>

<body class="animslition">
    <div class="page-wrapper">
        <!-- HEADER MOBILE-->
        
        <!-- END HEADER MOBILE-->

        <!-- MENU SIDEBAR-->
        
        <!-- END MENU SIDEBAR-->

        <!-- PAGE CONTAINER-->
        <div class="page-container">
            <!-- HEADER DESKTOP-->
            
            
@yield('content')
            
            
      </div>   
    </div>

    <!-- Jquery JS-->
    <script src="{{ asset('theme/vendor/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('theme/vendor/bootstrap-4.1/bootstrap.min.js') }}"></script>
    <!-- Bootstrap JS-->
    <script src="{{ asset('theme/vendor/bootstrap-4.1/popper.min.js') }}"></script>
    <!-- Vendor JS       -->
    <script src="{{ asset('theme/vendor/slick/slick.min.js') }}">
    </script>
    <script src="{{ asset('theme/vendor/wow/wow.min.js') }}"></script>
    <script src="{{ asset('theme/vendor/animsition/animsition.min.js') }}"></script>
    <script src="{{ asset('theme/vendor/bootstrap-progressbar/bootstrap-progressbar.min.js') }}">
    </script>
    <script src="{{ asset('theme/vendor/counter-up/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('theme/vendor/counter-up/jquery.counterup.min.js') }}">
    </script>
    <script src="{{ asset('theme/vendor/circle-progress/circle-progress.min.js') }}"></script>
    <script src="{{ asset('theme/vendor/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('theme/vendor/chartjs/Chart.bundle.min.js') }}"></script>
    <script src="{{ asset('theme/vendor/select2/select2.min.js') }}"></script>

    <!-- Main JS-->
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script src="{{ asset('theme/js/main.js') }}"></script>
    <script src="{{ asset('theme/js/ip_table.js') }}"></script>
    <script src="{{ asset('theme/js/wan_interface.js') }}"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>



    <script type="text/javascript">


/*
Wan Interface Get Data
*/

    $('.wan_interface_edit').on('click',function () {
        $(this).attr('');
        var id = $(this).attr('conid');
        //alert(id);
      $('#editWanModal').find('#selectitem').val(id);
         $.ajax({
            url: "{{route("waninterface-data")}}",
            type: "get",
            data: {id: id} ,
            success: function (response) {  
               let obj = JSON.parse(JSON.stringify(response));
                console.log(obj);
               $("#editWanModal").find('#device_serial_number1').val(obj[0]['serial_device']);         
               $("#editWanModal").find('#wan_type1').val(obj[0]['configuration_type']);         
               $("#editWanModal").find('#ip_address1').val(obj[0]['ip_address']);
               $("#editWanModal").find('#gateway1').val(response[0]['gateway']);               
               $("#editWanModal").find('#netmask_value1').val(response[0]['netmask']);
               $("#editWanModal").find('#dns1').val(response[0]['DNS_address']);

               const ip_address = response[0]['ip_address']
               const gateway = response[0]['gateway']
               const netmask = response[0]['netmask']
               const DNS_address = response[0]['DNS_address']
               if(ip_address ==null || gateway ==null || netmask ==null || DNS_address ==null){
                  $('#ip_address1').attr("readonly",true);
                  $('#gateway1').attr("readonly",true);
                  $('#netmask_value1').attr("readonly",true);
                  $('#dns1').attr("readonly",true);
               }else{
                  $('#ip_address1').attr("readonly",false);
                  $('#gateway1').attr("readonly",false);
                  $('#netmask_value1').attr("readonly",false);
                  $('#dns1').attr("readonly",false);
               }
            },
        });
      });

/*
Ip Rules Update
*/
$('.ip_edit').on('click',function () {
    var ip_id = $(this).attr('conid'); 
    $('#editIPModal').find('#selectitem').val(ip_id);
     $.ajax({
        url: "{{ url('get-ip-opertion')}}",
        type: "get",
        data: {ip_id: ip_id} ,
        success: function (response) {
         // console.log(response); 
          let obj = JSON.parse(JSON.stringify(response)); 
          //console.log("check", response['device_serial']);  
          console.log(obj.device_serial);        

          $("#editIPModal").find("#device_serial_number").val(obj['device_serial']);          
          $("#editIPModal").find("#frules").val(obj['rule_type']);
          $("#editIPModal").find("#in_interface").val((obj['in_interface'] != "")?obj['in_interface']:'NULL');
          $("#editIPModal").find("#out_interface").val((obj['out_interface'] != "")?obj['out_interface']:null);
          $("#editIPModal").find("#protocol").val(obj['protocol']);
          $("#editIPModal").find("#cidestination_ip").val(obj['orginal_desti_ip']);
          $("#editIPModal").find("#cidestination_port").val(obj['orginal_desti_port']);
          $("#editIPModal").find("#cidestination_ip1").val(obj['orginal_source_ip']);
          $("#editIPModal").find("#odpdestination_port").val(obj['orginal_source_port']);
          $("#editIPModal").find("#layout_select").val(obj['rule_action']);

          //$("#add_delete").val(obj['add_delete']);
    

        },
    });
  });


/*
Route Opertion Update
*/

    $('.route_opertion_edit').on('click',function () {
        $(this).attr('');
        var id = $(this).attr('conid');
        //console.log(ip_address);
      $('#editEmployeeModal').find('#selectitem').val(id);
         $.ajax({
            url: "{{route("operation-data")}}",
            type: "get",
            data: {id: id} ,
            success: function (response) {  
               let obj = JSON.parse(JSON.stringify(response));
                console.log(obj);
               $('#ip_address1').val(obj[0]['ip_address']);         
               $('#netmask_value1').val(response[0]['netmask_value']);               
               $('#device_serial_number1').val(response[0]['device_serial']);
               $('#network1').val(response[0]['network_type']);
               //$('#route_option1').val(response[0]['route_option']);
            },
        });
      });
    </script>

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

 $('#device_serial_number').on('change',function(){
        var dev_num = $(this).val();    
        if(dev_num){
            $.ajax({
               type:"GET",
               url:"{{url('ip-info/ajaxinterface')}}?device_serial="+dev_num,
               // data: {dev_num: dev_num},
               success:function(res){  
               console.log(res);
               let option_val='';
               let option_tag='<option value="default">-- Select Interface --</option>';
                if(res){
                    $("#in_interface, #out_interface").empty();
                    $.each(res,function(key,value){
                        option_val=option_val+'<option value="'+value+'">'+value+'</option>';
                    }); 
                     $("#in_interface, #out_interface").html(option_tag+option_val);             
                }else{
                   $("#in_interface, #out_interface").empty();
                }
               }
            });
        }else{
            $("#in_interface, #out_interface").empty();
        }        
   });

// 
    @if (count($errors) > 0)
    $('#addEmployeeModal').modal('show');
    @endif
    </script>
    
</body>

</html>
<!-- end document-->
