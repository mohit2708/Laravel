$(document).ready(function(){  
    $("#wan_type").on("change",function(){
        if (this.value == "" || this.value == "dhcp") {
            $("#ip_address, #gateway, #netmask_value, #dns").attr("readonly",true);
            $("#ip_address, #gateway, #netmask_value, #dns").val("");
        }else if (this.value == "static"){
            $("#ip_address, #gateway, #netmask_value, #dns").attr("readonly",false);
        }else {
            $("#ip_address, #gateway, #netmask_value, #dns").attr("readonly",true);
        }
    });
    $("#device_serial_number").on("change",function(){
        if (this.value == "") {
            $("#wan_type").attr("disabled",true);
        }else {
            $("#wan_type").attr("disabled",false);
        }
    });
    $("#wan_type").on("change",function(){
        if (this.value == "") {
            $("#dsubmit").attr("disabled",true);
        }else {
            $("#dsubmit").attr("disabled",false);
        }
    });

    $("#wan_type1").on("change",function(){
        if (this.value == "" || this.value == "dhcp") {
            $("#ip_address1, #gateway1, #netmask_value1, #dns1").attr("readonly",true);
            $("#ip_address1, #gateway1, #netmask_value1, #dns1").val("");
        }else if (this.value == "static"){
            $("#ip_address1, #gateway1, #netmask_value1, #dns1").attr("readonly",false);
        }else {
            $("#ip_address1, #gateway1, #netmask_value1, #dns1").attr("readonly",true);
        }
    });


});