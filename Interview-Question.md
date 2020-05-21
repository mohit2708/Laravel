# Laravel interview questions

### Table of Contents

| No. | Questions |
|:----:| ---------
|1  | [What is Laravel?](#Ques-What-is-Laravel) |
|   | [What are pros and cons of using Laravel Framework?](#Ques-What-is-Laravel) |

**[⬆ Back to Top](#table-of-contents)**
### Ques. What is Laravel?
* Laravel is free open source “PHP framework” based on MVC design pattern.
* It is created by __Taylor Otwell__. 
* Laravel provides expressive and elegant syntax that helps in creating a wonderful web application easily and quickly.
* The first version of laravel is released on 9 June 2011.
* The latest version of Laravel is 7.0. It released on 3rd March 2020.

**[⬆ Back to Top](#table-of-contents)**
### Ques. What is the Features of Laravel?
* Eloquent ORM
* Query builder available
* Reverse Routing
* Restful Controllers
* Migration
* Database Seeding
* Autamatic Pagination
* Unit Testing
* Homestead

**[⬆ Back to Top](#table-of-contents)**
### Ques. What are pros and cons of using Laravel Framework?
###### Pros of using Laravel Framework
1. Laravel framework has in-built lightweight blade template engine to speed up compiling task and create layouts with dynamic content easily.<br>
2. Hassles code reusability.<br>
3. Eloquent ORM with PHP active record implementation<br>
4. Built in command line tool “Artisan” for creating a code skeleton , database structure and build their migration

###### Cons of using laravel Framework 
1. Development process requires you to work with standards and should have real understanding of programming<br>
2. Laravel is new framework and composer is not so strong in compare to npm (for node.js), ruby gems and python pip.<br>
3. Development in laravel is not so fast in compare to ruby on rails.<br>
4. Laravel is lightweight so it has less inbuilt support in compare to django and rails. But this problem can be solved by integrating third party tools, but for large and very custom websites it may be a tedious task.

**[⬆ Back to Top](#table-of-contents)**
### Ques.What are the steps to install Laravel with composer?
Laravel installation steps:-
* Download composer from https://getcomposer.org/download (if you don’t have a composer on your system)
* Open cmd
* Goto your htdocs folder.
* C:\xampp\htdocs> composer create-project laravel/laravel projectname
OR<br>
If you install some particular version, then you can use<br>
composer create-project laravel/laravel project name "5.6"<br>
If you did not mention any particular version, then it will install with the latest version.

**[⬆ Back to Top](#table-of-contents)**
### Ques. Explain Events in laravel?
An event is an action or occurrence recognized by a program that may be handled by the program or code. Laravel events provides a simple observer implementation, that allowing you to subscribe and listen for various events/actions that occur in your application.<br>
All Event classes are generally stored in the app/Events directory, while their listeners are stored in app/Listeners of your application.

**[⬆ Back to Top](#table-of-contents)**
### Ques. Explain validations in laravel? 
In Programming validations are a handy way to ensure that your data is always in a clean and expected format before it gets into your database. <br>Laravel provides several different ways to validate your application incoming data.By default Laravel’s base controller class uses a __ValidatesRequests trait__ which provides a convenient method to validate all incoming HTTP requests coming from client.You can also validate data in laravel by creating Form Request.
```php
Laravel validation Example

$validatedData = $request->validate([
    'name' => 'required|max:255',
    'username' => 'required|alpha_num',
    'age' => 'required|numeric',
  ]);
```

**[⬆ Back to Top](#table-of-contents)**
### Ques. How to install laravel via composer?
You can install Laravel via composer by running below command.
```php
composer create-project laravel/laravel your-project-name version 
```

**[⬆ Back to Top](#table-of-contents)**
### Ques. List some features of laravel 5.0? 
* Inbuilt CRSF (cross-site request forgery ) Protection.
* Inbuilt paginations
* Reverse Routing 
* Query builder 
* Route caching 
* Database Migration
* IOC (Inverse of Control) Container Or service container.

**[⬆ Back to Top](#table-of-contents)**
### Ques. What is PHP artisan. List out some artisan commands?
PHP artisan is the command line interface/tool included with Laravel. It provides a number of helpful commands that can help you while you build your application easily. Here are the list of some artisan commands:-<br>
* php artisan list
* php artisan help
* php artisan tinker
* php artisan make
* php artisan -versian
* php artisan make model model_name
* php artisan make controller controller_name

**[⬆ Back to Top](#table-of-contents)**
### Ques. List Some default packages provided by Laravel 5.6?
* Cashier 
* Envoy
* Passport
* Scout 
* Socialite 
* Horizon

**[⬆ Back to Top](#table-of-contents)**
### Ques. What are named routes in Laravel?
Named routing is another amazing feature of Laravel framework. Named routes allow referring to routes when generating redirects or Urls more comfortably. <br>You can specify named routes by chaining the name method onto the route denition:
```php
Route::get('user/profile', function () {
     // 
})->name('profile');  
```

You can specify route names for controller actions:
```php
Route::get('user/profile', 'UserController@showProfile')->name('profile'); 
```

Once you have assigned a name to your routes, you may use the route's name when generating URLs or redirects via the global route function:
```php
// Generating URLs... 
	$url = route('profile'); 
// Generating Redirects... 
	return redirect()->route('profile'); 
```

**[⬆ Back to Top](#table-of-contents)**
### Ques. What is database migration. How to create migration via artisan?
Migrations are like version control for your database, that’s allow your team to easily modify and share the application’s database schema. Migrations are typically paired with Laravel’s schema builder to easily build your application’s database schema.<br>
Use below commands to create migration data via artisan.
```
// creating Migration 
php artisan make:migration create_users_table
```

**[⬆ Back to Top](#table-of-contents)**
### Ques. What are service providers? 
Service Providers are central place where all laravel application is bootstrapped . Your application as well all Laravel core services are also bootstrapped by service providers.<br> All service providers extend the Illuminate\Support\ServiceProvider class. Most service providers contain a register and a boot method. Within the register method, you should only bind things into the service container. You should never attempt to register any event listeners, routes, or any other piece of functionality within the register method.

**[⬆ Back to Top](#table-of-contents)**
### Ques. Explain Laravel’s service container? 
One of the most powerful feature of Laravel is its Service Container. It is a powerful tool for resolving class dependencies and performing dependency injection in Laravel.<br> __Dependency injection__ is a fancy phrase that essentially means class dependencies are “injected” into the class via the constructor or, in some cases, “setter” methods.

**[⬆ Back to Top](#table-of-contents)**
### Ques. What is composer?
Composer is a tool for managing dependency in PHP. It allows you to declare the libraries on which your project depends on and will manage (install/update) them for you.<br> Laravel utilizes Composer to manage its dependencies.

**[⬆ Back to Top](#table-of-contents)**
### Ques. What is dependency injection in Laravel? 
In software engineering, dependency injection is a technique whereby one object supplies the dependencies of another object. A dependency is an object that can be used (a service). An injection is the passing of a dependency to a dependent object (a client) that would use it. The service is made part of the client’s state.[1] Passing the service to the client, rather than allowing a client to build or nd the service, is the fundamental requirement of the pattern.<br>
You can do dependency injection via Constructor, setter and property injection.

**[⬆ Back to Top](#table-of-contents)**
### Ques. What are Laravel Contract’s?
Laravel’s Contracts are nothing but a set of interfaces that dene the core services provided by the Laravel framework.

**[⬆ Back to Top](#table-of-contents)**
### Ques. Explain Facades in Laravel?
Laravel Facades provides a static like an interface to classes that are available in the application’s service container. Laravel self-ships with many facades which provide access to almost all features of Laravel ’s. Laravel facades serve as “static proxies” to underlying classes in the service container and provide benets of a terse, expressive syntax while maintaining more testability and exibility than traditional static methods of classes. All of Laravel’s facades are dened in the Illuminate\Support\Facades namespace. You can easily access a facade like so: 
```php
use Illuminate\Support\Facades\Cache;
Route::get('/cache', function () {   
  return Cache::get('key'); 
  }); 
```

**[⬆ Back to Top](#table-of-contents)**
### Ques. What are Laravel eloquent? 
Laravel’s Eloquent ORM is simple Active Record implementation for working with your database. Laravel provide many different ways to interact with your database, Eloquent is most notable of them. Each database table has a corresponding “Model” which is used to interact with that table. Models allow you to query for data in your tables, as well as insert new records into the table.<br>
Below is sample usage for querying and inserting new records in Database with Eloquent. 
```php
// Querying or finding records from products table where tag is 'new' 
$products= Product::where('tag','new'); 
// Inserting new record
$product =new Product; 
$product->title="Iphone 7"; 
$product->price="$700"; 
$product->tag='iphone';  
$product->save(); 
```

**[⬆ Back to Top](#table-of-contents)**
### Ques. How to enable query log in Laravel?
Use the enableQueryLog method to enable query log in Laravel
```laravel
DB::connection()->enableQueryLog(); 
You can get array of the executed queries by using getQueryLog method: 
$queries = DB::getQueryLog(); 
```

**[⬆ Back to Top](#table-of-contents)**
### Ques. What is reverse routing in Laravel?
Laravel reverse routing is generating URL's based on route declarations. Reverse routing makes your application so much more exible. It denes a relationship between links and Laravel routes. When a link is created by using names of existing routes, appropriate Uri's are created automatically by Laravel. Here is an example of reverse routing.<br>
// route declaration<br>
Route::get(‘login’, ‘users@login’);<br>
Using reverse routing we can create a link to it and pass in any parameters that we have dened. Optional parameters, if not supplied, are removed from the generated link.<br>
{{ HTML::link_to_action('users@login') }} <br>
It will automatically generate an Url like http://xyz.com/login in view.

**[⬆ Back to Top](#table-of-contents)**
### Ques. How to turn off CRSF protection for specic route in Laravel?
To turn off CRSF protection in Laravel add following codes in “app/Http/Middleware/VerifyCsrfToken.php”
```laravel
//add an array of Routes to skip CSRF check 
private $exceptUrls = ['controller/route1', 'controller/route2'];  
//modify this function 
public function handle($request, Closure $next) { 
//add this condition foreach($this->exceptUrls as $route) {  
if ($request->is($route)) {   
return $next($request);  
} } 
return parent::handle($request, $next); 
} 
```

**[⬆ Back to Top](#table-of-contents)**
### Ques. What are traits in Laravel? 
PHP Traits are simply a group of methods that you want include within another class. A Trait, like an abstract class cannot be instantiated by itself.Trait are created to reduce the limitations of single inheritance in PHP by enabling a developer to reuse sets of methods freely in several independent classes living in different class hierarchies.<br>

Here is an example of trait.
```laravel
trait Sharable {     
public function share($item)   
{     
   return 'share this item';   
} } 
```
You could then include this Trait within other classes like this:
```laravel
class Post {     
  use Sharable;   
 }  
class Comment {     
use Sharable;   
} 
```
Now if you were to create new objects out of these classes you would nd that they both have the share() method available: 
```laravel
$post = new Post; 
echo $post->share(''); // 'share this item'    
$comment = new Comment; 
echo $comment->share(''); // 'share this item' 
```

**[⬆ Back to Top](#table-of-contents)**
### Ques. Does Laravel support caching?
Yes, Laravel supports popular caching backends like Memcached and Redis. <br>By default, Laravel is congured to use the le cache driver, which stores the serialized, cached objects in the le system.For large projects, it is recommended to use Memcached or Redis.

**[⬆ Back to Top](#table-of-contents)**
### Ques. Explain Laravel’s Middleware?
As the name suggests, Middleware acts as a middleman between request and response. It is a type of ltering mechanism. For example, Laravel includes a middleware that veries whether the user of the application is authenticated or not. If the user is authenticated, he will be redirected to the home page otherwise, he will be redirected to the login page.<br>
There are two types of Middleware in Laravel. <br>
Global Middleware: will run on every HTTP request of the application. <br>
Route Middleware: will be assigned to a specic route.

**[⬆ Back to Top](#table-of-contents)**
### Ques. What is Lumen?
Lumen is PHP micro-framework that built on Laravel’s top components.It is created by Taylor Otwell. It is perfect option for building Laravel based micro-services and fast REST API’s. It’s one of the fastest micro-frameworks available.<br> You can install Lumen using composer by running below command
```laravel
composer create-project --prefer-dist laravel/lumen blog
```

**[⬆ Back to Top](#table-of-contents)**
### Ques. Explain Bundles in Laravel?
In Laravel, bundles are also called packages.Packages are the primary way to extend the functionality of Laravel. Packages might be anything from a great way to work with dates like Carbon, or an entire BDD testing framework like Behat.In Laravel, you can create your custom packages too.

**[⬆ Back to Top](#table-of-contents)**
### Ques. How to use custom table in Laravel Modal?
You can use custom table in Laravel by overriding protected $table property of Eloquent.
```laravel
class User extends Eloquent{  
   protected $table="my_user_table";  
} 
```

**[⬆ Back to Top](#table-of-contents)**
### Ques. List types of relationships available in Laravel Eloquent? 
Below are types of relationships supported by Laravel Eloquent ORM.
* One To One 
* One To Many 
* One To Many (Inverse) 
* Many To Many
* Has Many Through
* Polymorphic Relations 
* Many To Many Polymorphic Relations

**[⬆ Back to Top](#table-of-contents)**
### Ques. Why are migrations necessary? 
Migrations are necessary because:<br>
* Without migrations, database consistency when sharing an app is almost impossible, especially as more and more people collaborate on the web app. 
* Your production database needs to be synced as well.

**[⬆ Back to Top](#table-of-contents)**
### Ques. Provide System requirements for installation of Laravel framework?
In order to install Laravel, make sure your server meets the following requirements:
* PHP >= 7.1.3 
* OpenSSL PHP Extension 
* PDO PHP Extension 
* Mbstring PHP Extension
* Tokenizer PHP Extension 
* XML PHP Extension
* Ctype PHP Extension
* JSON PHP Extension

**[⬆ Back to Top](#table-of-contents)**
### Ques. List some Aggregates methods provided by query builder in Laravel?
* count() 
* max() 
* min() 
* avg() 
* sum()

**[⬆ Back to Top](#table-of-contents)**
### Ques.


