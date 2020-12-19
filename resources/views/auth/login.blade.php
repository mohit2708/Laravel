<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>911Inform-LGLA | Login</title>
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
                    <img src="{{ asset('theme/images/icon/911inform.png') }}" class="img-fluid">

                    <div class="logoContent">
                        <h2>Create Account </h2>
                        <p>911 Inform</p>
                        
                        <div class="regBtn">
                            <a href="{{ route('register') }}"><button class="btn"> Registration </button></a>
                        </div>
                    </div>
                </div>  
            </div>
        </div>
        <div class="log50right">
            <div class="loginForm">
                <div class="formTitle">
                    @if(session()->has('error'))
                        <div class="alert alert-danger">
                        {{ session()->get('error') }}
                        </div>
                    @endif
                    <h1>Login</h1>
                    <p>Log in with your data you exerted during<br/>
your registration </p>
                </div>

    <form method="POST" action="{{ route('login') }}">      
        @csrf
    <div class="row">
            <div class="col-md-12 ">
                <div class="form-group has-search">
                <label>Email </label>
                <span class="form-control-feedback"><img src="{{ asset('registaion/images/email.png') }}"></span>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Enter Your Email" required autocomplete="email" autofocus>
                @error('email')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
                @enderror
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group has-search">
                    <label>Password </label>
                    <span class="form-control-feedback"><img src="{{ asset('registaion/images/pass.png') }}"></span>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="current-password">
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    </div>
            </div>
            <div class="col-md-6">
                <div class="custom-control custom-checkbox">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">
                {{ __('Remember Me') }}
                </label>
                </div>
            </div>
            <div class="col-md-6 text-right">
                @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">Forgot password?</a>
                @endif
            </div>
            <div class="col-md-12 mt-5 text-center">
                <div class="Logbtn">
                    <button  class="btn">Login <img src="{{ asset('registaion/images/loginicon.png') }}"></button>
                </div>
            </div>          
    </div>          
    </form>
    
    </div>
        </div>
     </div>
   </div>
     
    </section>
    <!---- Login page end ----->
  <script src="js/jquery-3.5.1.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/popper.min.js"></script>
</body>
</html>
