```php
<a id="all_deliver_done" class="delete btn btn-link" data-toggle="modal"> 
    <button id="" class="btn btn-primary" onclick="event.preventDefault()">All Delivery Done</button></a>


<!-- All Delivery Are Done -->
<div id="deliver_done_modal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">         
				<div class="modal-header">						
					<h4 class="modal-title">All Delivered items</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">					
					<p>Have you delivered all the items?</p>					
				</div>
				<div class="modal-footer">
					<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
               <button id="confirm" class="btn btn-primary">Confirm</button>
					<span id="delete_butt_id"></span>
				</div>			
		</div>
	</div>
</div>
<script>
/*
* All Deliver Are Done
*/
$('a#all_deliver_done').click(function(e){
    var anchor = this;
    $('#deliver_done_modal').modal('show');
    return false;
});

$('button#confirm').click(function(e){
   $('#deliver_done_modal').modal('hide');
   $('#loderBox').show();
   $.ajax({
      url: baseurl+'/allDeliverDone',
      type: 'POST',
           data: {_token: CSRF_TOKEN,
             getJobId:getJobId,
           },
      dataType: 'JSON',
      success:function(result){
         setTimeout(function () {
                $('#loderBox').hide();
            }, 2000);
         setTimeout(() => {
            toastr.success(result.message);
            setTimeout(() => {
              location.reload();
           },3000)
         },2000)
   }});
});
</script>
```
