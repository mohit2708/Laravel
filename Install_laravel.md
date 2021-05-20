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

# Create Project 
```php
composer create-project laravel/laravel project_name(or)
composer create-project --prefer-dist laravel/laravel project_name
composer create-project --prefer-dist laravel/laravel:^7.0 project_name
```

### Ques: How to check laravel version?
```php
D:\xampp7.3\htdocs\mohit\test>php artisan --version
```

### Server Run
```php
php artisan serve
php artisan serve --port=1212
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
# Database Migrate

__All Excecute file__
```php
php artisan migrate
```

__Excute File__
```php
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


__Create migrate file__
```php
php artisan make:migration create_table_name_table
```
```
$table->increments('id');
$table->integer('baarcode')->nullable();
$table->string('field_name', 255)->nullable();  
$table->enum('status',[0,1])->default(0);
$table->timestamps();
```
### Add Field in a table
```
php artisan make:migration add_field_to_table_name_table
```
```
public function up()
{
	Schema::table('comment', function (Blueprint $table) {
		$table->integer("paid")->unsigned();
		$table->string('test', 255)->nullable();
		$table->text('note')->nullable();
	});
}
public function down()
{
	Schema::table('comment', function (Blueprint $table) {
			$table->dropColumn(['paid', 'test', 'note']);
	});
}
```
# Create Seeder
```php
php artisan make:seeder CountriesTableSeeder
```
```php
<?php
use Illuminate\Database\Seeder;
class CountriesTableSeeder extends Seeder
{
public function run()
{
	DB::table('countries')->delete();
	$countries = array(
		array('id' => 1,'code' => 'AF' ,'name' => "Afghanistan",'phonecode' => 93),
		array('id' => 246,'code' => 'ZW','name' => "Zimbabwe",'phonecode' => 263),
		);
		DB::table('countries')->insert($countries);
	}
}
```
__Execute Seeder__
```php
php artisan db:seed --class=CountriesTableSeeder
```

# auth command for 7
* composer require laravel/ui "^2.0"
* php artisan ui bootstrap --auth

### For Email

lesssecureapps
https://myaccount.google.com/lesssecureapps?pli=1&rapt=AEjHL4NWTPE5D77AVhWCCcaMo9Kx-wK5qNPeHrcgsfDXis4MZc2QWmUs5i3Fgv8QjaMHo8UuzjtMsAUg3Py94zQ6dOqqHlZH8g

```
========env file======================
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=digiscript.jamaica@gmail.com
MAIL_PASSWORD=Chetu@123
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=digiscript.jamaica@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

# Create Controller
```php
>> php artisan make:controller Auth/AdminController
```

# Create Model
```php
>> php artisan make:model Registration
```

# Create Middalware
```php
php artisan make:middleware AccessControl
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
```php
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
```php
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

### Ques. How to redirect http to https?
**In .htacess file**

```
<IfModule mod_rewrite.c>
    # Redirect everything to https
    RewriteEngine On
    RewriteCond %{HTTPS} off [OR]
    RewriteCond %{HTTP_HOST} ^www\. [NC]
    RewriteCond %{HTTP_HOST} ^(?:www\.)?(.+)$ [NC]
    RewriteRule ^ https://%1%{REQUEST_URI} [L,NE,R=301]
</IfModule>
```

### Add custom field on registraion time
__Ceate Migration File__
php artisan make:migration add_fields_to_users
```php
public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('username')->after('password')->unique()->nullable();
        $table->string('gender', 15)->after('username')->nullable();
        $table->bigInteger('mobile_no')->after('bio')->nullable();
        $table->string('image')->after('mobile_no')->nullable();
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['username', 'gender', 'age', 'bio', 'mobile_no', 'image']);
    });
}
```
* php artisan migrate
* php artisan migrate --path=/database/migrations/fileName.php

Go to __resources/auth/register.blade.php__ and edit the registration form by adding the below HTML code
```php
<label>Phone</label>
<div class="col-md-6">
<input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" required >
@error('phone')
<span class="invalid-feedback" role="alert">
<strong>{{ $message }}</strong>
</span>
@enderror
</div>
```

Open __RegisterController.php__ controller found in __app/Http/Controllers/Auth__, and modify the validator. It will look like this.
```php
protected function validator(array $data)
{
return Validator::make($data, [
'name' => ['required', 'string', 'max:255'],
'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
'password' => ['required', 'string', 'min:8', 'confirmed'],
'phone' => ['required', 'numeric', 'min:11']
]);
}

After this, scroll down in the same file and modify the create function. It will look like

protected function create(array $data)
{
return User::create([
'name' => $data['name'],
'email' => $data['email'],
'password' => Hash::make($data['password']),
'phone' => $data['phone']
]);
}
```

file open __app/User.php__ and add ‘phone’ field in the $fillable property and save the file.
```php
protected $fillable = [
'name', 'email', 'password','phone',
];
```









