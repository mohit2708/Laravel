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

### Create Project 
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

### Create Controller
```php
>> php artisan make:controller Auth/AdminController
```

### Create Model
```php
>> php artisan make:model Registration
```

### Create Middalware
```php
php artisan make:middleware AccessControl
```

### Database Migrate
```php
php artisan migrate
===============Specific Table Migration===========================
php artisan migrate --path=/database/migrations/fileName.php
```
__Jab Migrate Command Run Karte Hai to Some error aati hai
```php
app->providers->AppServiceProvider.php
============add code========
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

public function boot()
{
 Schema::defaultStringLength(191);
}
```

### Server Run
```php
php artisan serve
php artisan serve --port=1212
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


__Login__
```php
===================web.php=============================
Route::get('login', 'Auth\LoginController@login')->name('login');
Route::post('login', 'Auth\LoginController@doLogin');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/home', 'HomeController@home')->name('home');
==========================LoginController.php====================
public function login()
	{
		return view('auth.login');
	}
public function doLogin(Request $request) {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('home');
        }
        return redirect('login')->with('error', 'Oppes! You have entered invalid credentials');
    }
public function doLogin(Request $request)
    {
        $input = $request->all();

		$remember = ($request->get('remember')) ? true : false;
		$validate = Validator::make($input, [
			'email' 	=> 'required',
			'password' 	=> 'required'
		]);	
		
		if (!$validate->fails()){
			
			$userdata = array(
				'email'  	=> $request->get('email'),
				'password'  => $request->get('password')
			);
			
			if (Auth::attempt($userdata,$remember)) {
				$user = Auth::user();
				if($user->status == 0){
					Auth::logout();
					return Redirect::back()->with('error', 'Your account is not activated.');
				}
				if(($user->role_type == 'admin')){
					//updateLastLogin($user->id);		
					return redirect()->intended('admin-deshboard');
				}else{
					return redirect('home');
				}
			}else{
				return Redirect::back()->with('error', 'Incorrect username or password.');
			}
		}else{
			return Redirect::back()->with('error', 'Incorrect username or password.');
		}
}    
/*
Logout Function
*/
public function logout() {
	Auth::logout();
	//Auth::guard('admin')->logout();
	return redirect('login');
	}
=======================login.blade.php======================
<body>
	@if(session()->has('error'))
		<div class="alert alert-danger">
		{{ session()->get('error') }}
		</div>
	@endif
<div class="login-form">
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <h2 class="text-center">Log in</h2>
		<div class="form-group">		    
				<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Enter Your Email" required autocomplete="email" autofocus>

				@error('email')
				<span class="invalid-feedback" role="alert">
				<strong>{{ $message }}</strong>
				</span>
				@enderror			
		</div>

		<div class="form-group">		
			<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="current-password">

			@error('password')
			<span class="invalid-feedback" role="alert">
			<strong>{{ $message }}</strong>
			</span>
			@enderror		
		</div>
		
		<div class="clearfix">
			<input class="float-left form-check-label" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

			<label class="form-check-label" for="remember">
			{{ __('Remember Me') }}
			</label>
			<a href="/forget-password" class="float-right">Forgot Password?</a>
		</div>	

        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block">Log in</button>
        </div>
		
		<!--
        <div class="clearfix">
            <label class="float-left form-check-label"><input type="checkbox"> Remember me</label>
            <a href="#" class="float-right">Forgot Password?</a>
        </div>
		-->        
    </form>
    <p class="text-center"><a href="{{ route('register') }}">Create New Account</a></p>
</div>

```

__Admin Controller__
```php
=================web.php====================
Route::group(['middleware' => ['auth', 'admin']], function(){
Route::get('admin-deshboard', 'AdminController@adminDeshboard')->name('admin-deshboard');
});
Route::get('status', 'AdminController@status')->name('status');
====================AdminController.php===============================
class AdminController extends Controller
{	
	public function __construct()
	{
		$this->middleware('auth');
	}
    public function adminDeshboard(Request $request)
	{
		//$users = User::all();	//all user
		$users = User::where('id', '!=', 1)->get(); //admin user remove			
		return view('admin_deshboard', compact('users'));
	}
	public function status(Request $request){		
		$post = User::find($request->id);
		if($post->status == 1){
			$changestatus = 0;
		}
		else{ $changestatus = 1;
		}
		$post->status = $changestatus;
		$post->save();		
	}
}
======================admindeshboard.blade.php===========================
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
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
        
        <!-- <td class="toggle-class" alt="{{$user->id}}"><a href="#">@if($user->status == 1) Active @else Deactivate @endif</a></td> -->
        <td>
    <input data-id="{{$user->id}}" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" {{ $user->status ? 'checked' : '' }}>
        </td>
      </tr>
    @endforeach
    </tbody>
  </table>
</div>
/*
Ajax for status active or deactive
*/
<script type="text/javascript">
  $(document).ready(function() {
  $(".toggle-class").change(function()  {
    //alert('sagsd');
    var id = $(this).attr("data-id");
    //var status = $("#activitymessage").val();
    var id = id;
    $.ajax({
      type: "get",
      url: "{{route("status")}}",
      data: {id: id},
      success: function(data){
              console.log(data.success)
            }
      //       success: function(msg) {
      //   location.reload();
      // }
    });
   });
  });
</script>
```

__Admin Middalware for go to deshboard__
```php
===========================AdminMiddleware.php======================
class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::user()->role_type == 'admin'){
            return $next($request);
        }
        else{
            return redirect('home')->with('status', 'you are not admin');
        }
    }
}
============kernal.php===============
   protected $routeMiddleware = [
      'admin' => \App\Http\Middleware\AdminMiddleware::class,
    ];
===========================web.php=========================
Route::group(['middleware' => ['auth', 'admin']], function(){
Route::get('admin-deshboard', 'AdminController@adminDeshboard')->name('admin-deshboard');
});
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











