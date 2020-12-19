/*
For Delete
*/
function confirm_delete(id){
    var url1 = window.location.origin + '/laravel_test/inform/public/';    
    var url= url1 + "connection-list/delete";
   //var url="{{url('connection-list/delete/')}}";
    var a='<a href="'+url+'/'+id+'" class="btn btn-primary">Confirm</a>';
    $("#delete_butt_id").html(a);
    $("#delete_confirm").modal();
  }