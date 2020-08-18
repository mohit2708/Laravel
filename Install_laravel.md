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

# Login & Signup

### Step 1:-

Create Controller
```php
D:\xampp7.3\htdocs\mohit\test>php artisan make:controller Auth/RegistrationController
```
```php
<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    //
}
```











