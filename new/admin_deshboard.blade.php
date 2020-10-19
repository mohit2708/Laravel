@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>User List</h2>
  <p>table</p>            
  <table class="table table-hover">
    <thead>
      <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
      <tr>
        <td>{{$user->name}}</td>
        <td>{{$user->email}}</td>
        
        <td class="statusc" alt="{{$user->id}}"><a href="#">@if($user->status == 1) Active @else Deactivate @endif</a></td>
      </tr>
    @endforeach
    </tbody>
  </table>
</div>

</body>
</html>
<script type="text/javascript">
  $(document).ready(function() {
  $(".statusc").click(function()  {
    //alert('sagsd');
    var id = $(this).attr("alt");
    //var status = $("#activitymessage").val();
    var id = id;
    $.ajax({
      type: "get",
      url: "{{route("status")}}",
      data: {id: id},
      success: function(msg) {
        location.reload();

      }
    });
   });
  });
</script>
@endsection
