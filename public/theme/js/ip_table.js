$(document).ready(function(){  
    $(".destination, .source, .red1, .redmas, #rule_action_in_out_for, .rule_action_incom, .rule_action_inout").hide();
    $("#frules").on("change",function(){
        if (this.value == "IN-F") {

            $("#sin_interface, .rule_act, #rule_actionadr, #rule_action_in_out_for").show();

            $("#sout_interface, .destination, .source, .red1, .redmas, .rule_action_incom, .rule_action_inout").hide();

        }else if (this.value == "OUT-F") {

            $("#sout_interface, .rule_act, #rule_actionadr, #rule_action_in_out_for").show();

            $("#sin_interface, .destination, .source, .red1, .redmas, .rule_action_incom, .rule_action_inout").hide();

        }else if (this.value == "PRE-NAT") {

            $("#sin_interface, .destination, .red1").show();

            $("#sout_interface, .rule_act, .source, .redmas, #rule_action_in_out_for, .rule_action_incom, .rule_action_inout").hide();

        } else if (this.value == "POST-NAT") {

            $("#sin_interface, .rule_act, .destination, .red1, #rule_action_in_out_for, .rule_action_incom, .rule_action_inout").hide();

            $("#sout_interface, .source, .redmas").show();

        }else if(this.value == "FOR-F"){

            $("#sin_interface, #sout_interface, .rule_act, #rule_actionadr, #rule_action_in_out_for").show();

            $(".destination, .source, .red1, .redmas, .rule_action_incom, .rule_action_inout").hide();

        }else if(this.value == "IN-NAT"){

            $("#sin_interface, .rule_act, .rule_action_incom").show();

            $(".destination, .source, .red1, .redmas, #sout_interface, #rule_actionadr, #rule_action_in_out_for, .rule_action_inout").hide();

        }else if(this.value == "OUT-NAT"){

            $("#sout_interface, .rule_act, .rule_action_inout").show();

            $("#sin_interface, .destination, .source, .red1, .redmas, #rule_actionadr, .rule_action_incom").hide();

        }

        if (this.value == "IN-NAT") {
            $("#in_net_rule_accept").show();
        } else {
            $("#in_net_rule_accept").hide();
        }

        if (this.value == "OUT-NAT") {
            $("#out_net_rule_accept").show();
        } else {
            $("#out_net_rule_accept").hide();
        }
    });

    $("#original_destination_iP").on("change",function(){
        if (this.value == "Custom-IP") {
            $("#cidestination_ip").attr("readonly",false);
            $(".original_dest_label").text("Destination IP");
            $("#cidestination_ip").attr("placeholder","Destination IP");
            $("#cidestination_ip").val('');
        } else {
            $(".original_dest_label").text("Anywhere IP");
            $("#cidestination_ip").attr("placeholder","");
            $("#cidestination_ip").val('0.0.0.0/0');
            $("#cidestination_ip").attr("readonly",true);
        } 
    });
    // Original Destination Port
    // $("#original_destination_port").on("change",function(){
    //     if (this.value == "Custom-IP") {
    //         $("#odpdestination_ip").attr("readonly",false);
    //         $(".original_dest_port_label").text("Destination IP");
    //         $("#odpdestination_ip").attr("placeholder","Destination Port");
    //         $("#odpdestination_ip").val('');
    //     } else {
    //         $(".original_dest_port_label").text("Anywhere IP");
    //         $("#odpdestination_ip").attr("placeholder","");
    //         $("#odpdestination_ip").val('0.0.0.0/0');
    //         $("#odpdestination_ip").attr("readonly",true);
    //     } 
    // });
    // ORIGINAL SOURCE IP
    $("#original_source_ip").on("change",function(){
        if (this.value == "Custom-IP") {
            $("#cidestination_ip").attr("readonly",false);
            $(".src_ip_label").text("Source IP");
            $("#osidestination_ip").attr("placeholder","Source IP");
            $("#osidestination_ip").val('');
        } else {
            $(".src_ip_label").text("Anywhere IP");
            $("#osidestination_ip").attr("placeholder","");
            $("#osidestination_ip").val('0.0.0.0/0');
            $("#osidestination_ip").attr("readonly",true);
        } 
    });
    $("#protocol").on("change",function(){
        if (this.value == "tcp" || this.value == "udp") {
            $("#odpdestination_ip, #osportsource_ip").attr("readonly",false);
        }else if (this.value == "icmp"){
            $("#odpdestination_ip, #osportsource_ip").attr("readonly",true);
            $("#odpdestination_ip, #osportsource_ip").val('');
        }else{
            $("#odpdestination_ip, #osportsource_ip").attr("readonly",true);
            $("#odpdestination_ip, #osportsource_ip").val('');
        }

    });
    $("#t_dest_type").on("change",function(){
        if (this.value == "default" || this.value == "") {
            $("#trans_desti_add, #trans_desti_port").attr("readonly",true);
            $(".dnat_address, .dnat_redirect_port").show();
            $("#trans_desti_port, #trans_desti_add").val('');
        }else if (this.value == "DNAT") {
            $(".dnat_address, .dnat_redirect_port").show();
            $("#trans_desti_add").attr("readonly",false);
            $("#trans_desti_port")[0].reset();
        }else if (this.value == "dnat_redirect") {
            $(".dnat_address").hide();
            $(".dnat_redirect_port").show();
            $("#trans_desti_port").attr("readonly",true);
            $("#trans_desti_port").val('0.0.0.0/0');
        }else{
            $(".dnat_address").show();
            $(".dnat_redirect_port").hide();            
        }
    });

   $('#trans_desti_add').keyup(function(){
    if($(this).val() == ''){
        $("#trans_desti_port").attr("readonly", true);
        $("#trans_desti_port").val("");
    }
    else{
        $("#trans_desti_port").attr("readonly", false);
    }    
   });
// 
    $("#t_source_type").on("change",function(){        
        if (this.value == "default" || this.value == "") {
           $("#trans_source_add, #trans_source_port").attr("readonly",true); 
            $("#trans_source_add, #trans_source_port").val('');           
        }else if (this.value == "SNAT") {
            $("#trans_source_add").attr("readonly",false);
            $(".snat_address").show();
            $(".snat_redirect_port").show();
        }else{
            $("#trans_source_add, #trans_source_port").attr("readonly",true);
            $(".snat_address").show();
            $("#snat_redirect_port").show();
        }
    });

    $('#trans_source_add').keyup(function(){
    if($(this).val() == ''){
        $("#trans_source_port").attr("readonly", true);
        $("#trans_source_port").val("");
    }
    else{
        $("#trans_source_port").attr("readonly", false);
    }    
   });
// 
// 

        $("#ruleaction_incom").on("change",function(){        
        if (this.value == "" || this.value == "ACCEPT") {
           $("#incom_addressi, #incom_port1").attr("readonly",true); 
            $("#incom_addressi, #incom_port1").val('');           
        }else if (this.value == "SNAT") {
            $("#incom_addressi").attr("readonly",false);
            $("#incom_addressi, #incom_port1").show();

        }else{
            $("#incom_addressi, #incom_port1").attr("readonly",true);

        }
    });

    $('#incom_addressi').keyup(function(){
    if($(this).val() == ''){
        $("#incom_port1").attr("readonly", true);
        $("#incom_port1").val("");
    }
    else{
        $("#incom_port1").attr("readonly", false);
    }    
   });


// 
// 
 $("#ruleaction_inout").on("change",function(){        
        if (this.value == "" || this.value == "ACCEPT") {
           $("#inout_addressi, #inout_port1").attr("readonly",true); 
            $("#inout_addressi, #inout_port1").val('');           
        }else if (this.value == "DNAT") {
            $("#inout_addressi").attr("readonly",false);
            $("#inout_addressi, #inout_port1").show();

        }else{
            $("#inout_addressi, #inout_port1").attr("readonly",true);

        }
    });

    $('#inout_addressi').keyup(function(){
    if($(this).val() == ''){
        $("#inout_port1").attr("readonly", true);
        $("#inout_port1").val("");
    }
    else{
        $("#inout_port1").attr("readonly", false);
    }    
   });




    $("#device_serial_number").on("change",function(){
        if (this.value == "") {
            $("#frules").attr("disabled",true);
            $("#fiptables")[0].reset();
            $("#dsubmit").attr("disabled",true);
        }else {
            $("#frules").attr("disabled",false);
        }
    });
    $("#frules").on("change",function(){
        if (this.value == "") {
            // $("#dsubmit").attr("disabled",true);
                $("#add_delete").attr("disabled",true);
        }else{
            $("#add_delete").attr("disabled",false);
        }
    });






    $("#add_delete").on("change",function(){
        if (this.value == "") {
            $("#dsubmit").attr("disabled",true);
        }else {
            $("#dsubmit").attr("disabled",false);
        }
    });

    $(document).ready(function() {
    $("#layout_select").children('option:gt(0)').hide();
    $("#frules").change(function() {
        $("#layout_select").children('option').hide();
        $("#layout_select").children("option[id^=" + $(this).val() + "]").show()
        })
    })

});