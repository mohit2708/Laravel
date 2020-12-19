<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>911Inform-LGLA | SigunUp</title>
  <meta name="description" content="">
  <meta name="author" content="">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('registaion/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('registaion/css/responsive.css') }}">
</head>
<body>
<section class="loginSec">     
     <div class="logincontainer  h-100">
     <div class="align-items-center d-md-flex h-100">
     	<div class="log50left">
     		<div>
     			<div class="logSec">
     				<img src="{{ asset('registaion/images/logo.png') }}" class="img-fluid">

     				<div class="logoContent">
     					<h2>Already Account! </h2>
     					<p>Lorem Ipsum is simply dummy text of the printing and 
							typesetting industry Lorem Ipsum has been the
							industry's standard dummy</p>
						
						<div class="regBtn">
							<a href="{{ route('login') }}"><button class="btn"> Log in </button></a>
						</div>
     				</div>
     			</div>	
     		</div>
     	</div>
     	<div class="log50right">
     		<div class="SignupForm">
     			<div class="formTitle">
     				<h1>Sing up</h1>
     				<p>Give us some of your information to<br/> 
get access </p>
     			</div>    
	<form method="POST" action="{{ route('register') }}">
		@csrf
	<div class="row">
		<div class="col-md-12 ">
			<div class="form-group has-search">
				<label>Name </label>
				<span class="form-control-feedback"><img src="{{ asset('registaion/images/user.png') }}"></span>
				<input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Name" required autocomplete="name" autofocus>

					@error('name')
					<span class="invalid-feedback" role="alert">
					<strong>{{ $message }}</strong>
					</span>
					@enderror 
				</div>
		</div>
		<div class="col-md-12 ">
			<div class="form-group has-search">
				<label>Email </label>
				<span class="form-control-feedback"><img src="{{ asset('registaion/images/email.png') }}"></span>
				<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Email" required autocomplete="email">

				@error('email')
				<span class="invalid-feedback" role="alert">
				<strong>{{ $message }}</strong>
				</span>
				@enderror
				</div>
		</div>
		<div class="col-md-12 ">
			<div class="form-group has-search">
				<label>Password  </label>
				<span class="form-control-feedback"><img src="{{ asset('registaion/images/pass.png') }}"></span>
				<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="new-password">

				@error('password')
				<span class="invalid-feedback" role="alert">
				<strong>{{ $message }}</strong>
				</span>
				@enderror
				</div>
		</div>
		<div class="col-md-12">
			<div class="form-group has-search">
				<label>Confirm Password  </label>
				<span class="form-control-feedback"><img src="{{ asset('registaion/images/pass.png') }}"></span>
				<input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required autocomplete="new-password">
				</div>
		</div>
		<div class="col-md-12 mt-2 mb-2 text-center">
			<div class="Logbtn">
				<button  class="btn">{{ __('Sing up') }}</button>
			</div>
		</div>
	</div>
	</form>
	</div>
     	</div>
     </div>
   </div>
	 
	</section>
	<script src="{{ asset('registaion/js/jquery.min.js') }}"></script>
  <script src="{{ asset('registaion/js/popper.min.js') }}"></script>
  <script src="{{ asset('registaion/js/bootstrap.min.js') }}"></script>
	</body>
</html>