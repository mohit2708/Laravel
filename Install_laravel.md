# Install Laravel

### Step 1:-
Download the Composer __https://getcomposer.org/download/__ <br>
Scree shot below:-<br>

![1](https://github.com/mohit2708/Laravel/blob/master/image/composer.gif)

### Step:-
Go to the directory<br>
c: (OR) d:<br>
cd xampp<br>
cd htdocs <br>
cd folder_name<br>

### Controler Create
```php
>> php artisan make:controller Auth/AdminController
```

### Create Model
```php
>> php artisan make:model Registration
```

### Database Migrate
```php
php artisan migrate
```

### Step:-
create Project by cmd<br>
```php
composer create-project laravel/laravel project_name(or)
composer create-project --prefer-dist laravel/laravel project_name
composer create-project --prefer-dist laravel/laravel:^7.0 project_name
```

### Ques: How to check laravel version?
```php
D:\xampp7.3\htdocs\mohit\test>php artisan --version
```

### Setup Database Credentials
```php
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=#Your database name
DB_USERNAME=root #Your database username
DB_PASSWORD=#Your database password
```

### Anchor Tag Redirect
```php
 <a href="{!! url()->current() !!}">Current path</a>
OR
     <a href="{!! url()->full() !!}">Full path</a>
OR
     <a href="{!! url('/books/news') !!}">Relative to root path</a>

OUTSIDE EXAMPLE:
OR
     <a href="{!! url('http://www.google.com') !!}">Path to google</a>
```
# CSS File Put
```php
Put your css files into the public folder like public/css/styles.css
<link href="{{ asset('css/styles.css') }}" rel="stylesheet" type="text/css" >
<script type="text/javascript" src="{{ asset('js/scripts.js') }}"></script>
```
# validation
```php
In Controller:-
---------------
 $this->validate($request,[
	'f_name' => 'required|max:255',
	'l_name' => 'required',
	'Email'  => 'required|unique:members',
	'Password' => 'required|min:8',
	],
	[
	'f_name.required' => 'Enter Your Name',
	'l_name.required' => 'Enter Your Last Name',
	'Email.unique'    => 'Sorry, This Email Address Is Already Used',
	'Password.min'    => 'Password Length Should Be More Than 8 Character',
   ]);
```
__In view.blade__
```php
Form tage sa upar:-
-------------------
@if (count($errors) > 0)
    <div class = "alert alert-danger">
         <ul>
              @foreach ($errors->all() as $error)
                 <li>{{ $error }}</li>
             @endforeach
          </ul>
     </div>
@endif
=======================
every field ke neeche:-
-----------------------
@if ($errors->has('f_name'))
	<span class="help-block" style="color:red;">
	<strong>{{ $errors->first('f_name') }}</strong>
	</span>
@endif
```

# Login & Signup
__Registation__
```php
======================web.php=========================
Route::get('register', 'Auth\RegisterController@register')->name('register');
Route::post('register', 'Auth\RegisterController@doRegister')->name('register');
===================RegisterController.php==========================
use App\User;
use Hash;
use Auth;

public function register()
	{
		return view('auth.signup');
	}
public function doRegister(Request $request)
	{
      $request->validate([
          'name' => 'required|string|max:255',
          'email' => 'required|string|email|max:255|unique:users',
         // 'password' => 'required|string|min:8|confirmed',
		 //'password' => 'required|min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'
		  'password' => [
            'required',
            'string',
            'min:8',             // must be at least 8 characters in length
			'confirmed',
            'regex:/[a-z]/',      // must contain at least one lowercase letter
            'regex:/[A-Z]/',      // must contain at least one uppercase letter
            'regex:/[0-9]/',      // must contain at least one digit
            'regex:/[@$!%*#?&]/', // must contain a special character
        ],
          'password_confirmation' => 'required',
      ],
	  [
		'password.regex' => 'Password must contain at least one number and one uppercase and lowercase letters and one special characters.',
	  ]
	  
	  );  

      User::create([
          'name' => $request->name,
          'email' => $request->email,
          'password' => Hash::make($request->password),
      ]);

      return redirect('login');
	}
=======================signup.blade.php=========================
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,700">
<title>Bootstrap Simple Registration Form</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<style>
body {
	color: #fff;
	background: #63738a;
	font-family: 'Roboto', sans-serif;
}
.form-control {
	height: 40px;
	box-shadow: none;
	color: #969fa4;
}
.form-control:focus {
	border-color: #5cb85c;
}
.form-control, .btn {        
	border-radius: 3px;
}
.signup-form {
	width: 450px;
	margin: 0 auto;
	padding: 30px 0;
  	font-size: 15px;
}
.signup-form h2 {
	color: #636363;
	margin: 0 0 15px;
	position: relative;
	text-align: center;
}
.signup-form h2:before, .signup-form h2:after {
	content: "";
	height: 2px;
	width: 30%;
	background: #d4d4d4;
	position: absolute;
	top: 50%;
	z-index: 2;
}	
.signup-form h2:before {
	left: 0;
}
.signup-form h2:after {
	right: 0;
}
.signup-form .hint-text {
	color: #999;
	margin-bottom: 30px;
	text-align: center;
}
.signup-form form {
	color: #999;
	border-radius: 3px;
	margin-bottom: 15px;
	background: #f2f3f7;
	box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
	padding: 30px;
}
.signup-form .form-group {
	margin-bottom: 20px;
}
.signup-form input[type="checkbox"] {
	margin-top: 3px;
}
.signup-form .btn {        
	font-size: 16px;
	font-weight: bold;		
	min-width: 140px;
	outline: none !important;
}
.signup-form .row div:first-child {
	padding-right: 10px;
}
.signup-form .row div:last-child {
	padding-left: 10px;
}    	
.signup-form a {
	color: #fff;
	text-decoration: underline;
}
.signup-form a:hover {
	text-decoration: none;
}
.signup-form form a {
	color: #5cb85c;
	text-decoration: none;
}	
.signup-form form a:hover {
	text-decoration: underline;
}  
</style>
</head>
<body>
<div class="signup-form">    
	<form method="POST" action="{{ route('register') }}">
		@csrf
		<h2>Register</h2>
		<p class="hint-text">Create your account. It's free and only takes a minute.</p>
		
		<div class="form-group">			
				<input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Name" required autocomplete="name" autofocus>

					@error('name')
					<span class="invalid-feedback" role="alert">
					<strong>{{ $message }}</strong>
					</span>
					@enderror			
		</div>
		
		<div class="form-group">			
				<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Email" required autocomplete="email">

				@error('email')
				<span class="invalid-feedback" role="alert">
				<strong>{{ $message }}</strong>
				</span>
				@enderror			
		</div>
		<div class="form-group">			
			<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="new-password">

			@error('password')
			<span class="invalid-feedback" role="alert">
			<strong>{{ $message }}</strong>
			</span>
			@enderror			
		</div>

		<div class="form-group ">			
			<input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required autocomplete="new-password">			
		</div>
		
		<!--
        <div class="form-group">
			<div class="row">
				<div class="col"><input type="text" class="form-control" name="first_name" placeholder="First Name" required="required"></div>
				<div class="col"><input type="text" class="form-control" name="last_name" placeholder="Last Name" required="required"></div>
			</div>        	
        </div>		
        <div class="form-group">
        	<input type="email" class="form-control" name="email" placeholder="Email" required="required">
        </div>
		
		<div class="form-group">
            <input type="password" class="form-control" name="password" placeholder="Password" required="required">
        </div>
		<div class="form-group">
            <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password" required="required">
        </div>
		        
        <div class="form-group">
			<label class="form-check-label"><input type="checkbox" required="required"> I accept the <a href="#">Terms of Use</a> &amp; <a href="#">Privacy Policy</a></label>
		</div>
		-->
		<div class="form-group">            
			<button type="submit" class="btn btn-success btn-lg btn-block">{{ __('Register') }}</button>
        </div>
    </form>
	<div class="text-center">Already have an account? <a href="{{ route('login') }}">Sign in</a></div>
</div>
</body>
</html>
```



### routes/web.php
```php
Route::get('/', 'Auth\RegisterController@create');
Route::post('register', 'Auth\RegisterController@insert');
```

### Create Controller
```php
D:\xampp7.3\htdocs\mohit\test>php artisan make:controller Auth/RegistrationController
```
__Controller
```php
<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Registration as User;
use DB;

class RegisterController extends Controller
{
    public function create()
    {
        return view('registration.create');
    }
    public function insert(Request $request)
    {
		      
        $formData=[
			'f_name'=>$request->input('f_name'),
			'l_name'=>$request->input('l_name'),
            'email'=>$request->input('email'),
            'password'=>$request->input('password'),            
            ];
      //User::insert($formData);
      //echo "insert succesfully";  
            try {
              User::insert($formData);
              return redirect("/");
            } catch(Exception $e) {
                    return redirect()->back()->with("error",$e);
            }    

    }
}
```

### Create Model
```php
<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $table = "user";
}
```

### Show list from database:-
__In Controler__
```laravel
use App\User;

public function index()
	{
		$users = User::all();
		return view('admin_deshboard', compact('users'));
	}
============================================================
use DB;

public function index()
{
   $users = DB::select('select * from student_details');
    return view('stud_view',['users'=>$users]);
}
```
__In View__
```laravel
<table border = "1">
  <tr>
	<td>Id</td>
	<td>First Name</td>
	<td>Last Name</td>
	<td>City Name</td>
	<td>Email</td>
  </tr>
@foreach ($users as $user)
  <tr>
	<td>{{ $user->id }}</td>
	<td>{{ $user->first_name }}</td>
	<td>{{ $user->last_name }}</td>
	<td>{{ $user->city_name }}</td>
	<td>{{ $user->email }}</td>
  </tr>
@endforeach
</table>
```
### Create view:- create.blade.php
```php
<form method="post" action="register">
    {{csrf_field()}}
	<label for="email">First Name</label>
    <input type="text" name="f_name" required>
	
	<label for="email">Last Name</label>
    <input type="text" name="l_name" required>
	
    <label for="email">Email Address</label>
    <input type="email" name="email" required>

    <label for="password">Password</label>
    <input type="password" minlength="8" name="password" required>

    <input class="pure-button pure-button-primary" type="submit" value="Register">
  </form>
```











