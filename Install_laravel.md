# Install Laravel

### Step 1:-
Download the Composer __https://getcomposer.org/download/__ <br>
Scree shot below:-<br>

![1](https://github.com/mohit2708/Laravel/blob/master/image/1-composer.jpg)
![2](https://github.com/mohit2708/Laravel/blob/master/image/2-composer.jpg)
![3](https://github.com/mohit2708/Laravel/blob/master/image/3-composer.jpg)
![4](https://github.com/mohit2708/Laravel/blob/master/image/4-composer.jpg)
![5](https://github.com/mohit2708/Laravel/blob/master/image/5-composer.jpg)
![6](https://github.com/mohit2708/Laravel/blob/master/image/6-composer.jpg)
![7](https://github.com/mohit2708/Laravel/blob/master/image/7-composer.jpg)

### Step 2:- 
Chek the composer install or not<br>

![8](https://github.com/mohit2708/Laravel/blob/master/image/8-composer.jpg)
![9](https://github.com/mohit2708/Laravel/blob/master/image/9-composer.jpg)

### Step 3:-
Go to the directory<br>
c: (OR) d:<br>
cd xampp<br>
cd htdocs <br>
cd folder_name<br>

### Step 4:-
create Project cmd<br>
```php
composer create-project laravel/laravel project_name
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

# Login & Signup

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
php artisan make:model Registration
```
```php
<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $table = "user";
}
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











