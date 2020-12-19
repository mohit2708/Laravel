@if (isset($success))
	<br/> 
<div class="alert alert-success">
    <button type="button" class="close" data-dismiss="alert"></button>
    <strong>Success!</strong>&nbsp;
		{!! $success !!}.
</div>
@endif

@if (($message = Session::get('success'))||($message = Session::get('success_req')))
	<br/>
<div class="alert alert-success">
    <button type="button" class="close" data-dismiss="alert"></button>
    <strong>Success!</strong>&nbsp;
	@if(is_array($message))
        @foreach ($message as $m)
            {!! $m !!}
        @endforeach
    @else
        {!! $message !!}
    @endif
</div>
@endif

@if ($message = Session::get('error'))
	<br/>
<div class="alert alert-danger">
	<button class="close" data-dismiss="alert"></button>
	<strong>Warning!</strong>&nbsp;
	@if(is_array($message))
		@foreach ($message as $m)
			{!! $m !!}
		@endforeach
	@else
		{!! $message !!}
	@endif
</div>
@endif

@if ($message = Session::get('warning'))
	<br/>
<div class="alert alert-danger">
	<button class="close" data-dismiss="alert"></button>
	<strong>Warning!</strong>&nbsp;
	@if(is_array($message))
		@foreach ($message as $m)
			{!! $m !!}
		@endforeach
	@else
		{!! $message !!}
	@endif
</div>
@endif

@if ($message = Session::get('info'))
	<br/>
<div class="alert alert-info">
	<button class="close" data-dismiss="alert"></button>
	<strong>Info!</strong>&nbsp;
	@if(is_array($message))
		@foreach ($message as $m)
			{!! $m !!}
		@endforeach
	@else
		{!! $message !!}
	@endif
</div>
@endif

 {{--    Error Display--}}
        @if($errors->any())
        <ul class="alert">
            @foreach($errors->all() as $error)
            <li style="color:red;"><b>{{ $error }}</b></li>
            @endforeach
        </ul>
        @endif
    {{--    Error Display ends--}}