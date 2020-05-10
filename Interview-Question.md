# Laravel interview questions

### Table of Contents

| No. | Questions |
|:----:| ---------
|1  | [What is Laravel?](#Ques-What-is-Laravel) |


**[⬆ Back to Top](#table-of-contents)**
### Ques. What is Laravel?
Laravel is free open source “PHP framework” based on MVC design pattern. It is created by Taylor Otwell. Laravel provides expressive and elegant syntax that helps in creating a wonderful web application easily and quickly.

**[⬆ Back to Top](#table-of-contents)**
### Ques. What are pros and cons of using Laravel Framework?
###### Pros of using Laravel Framework
1. Laravel framework has in-built lightweight blade template engine to speed up compiling task and create layouts with dynamic content easily.<br>
2. Hassles code reusability.<br>
3. Eloquent ORM with PHP active record implementation<br>
4. Built in command line tool “Artisan” for creating a code skeleton , database structure and build their migration<br>


```
  Cons of using laravel Framework 1. Development process requires you to work with standards and should have real understanding of programming 2. Laravel is new framework and composer is not so strong in compare to npm (for node.js), ruby gems and python pip. 3. Development in laravel is not so fast in compare to ruby on rails. 4. Laravel is lightweight so it has less inbuilt support in compare to django and rails. But this problem can be solved by integrating third party tools, but for large and very custom websites it may be a tedious task
Q2.
 0
Explain Events in laravel ? Posted by Sharad Jaiswal An event is an action or occurrence recognized by a program that may be handled by the program or code. Laravel events provides a simple observer implementation, that allowing you to subscribe and listen for various events/actions that occur in your application.
All Event classes are generally stored in the app/Events directory, while their listeners are stored in app/Listeners of your application.
Q3.
 0
Explain validations in laravel? Posted by Sharad Jaiswal In Programming validations are a handy way to ensure that your data is always in a clean and expected format before it gets into your database. Laravel provides several different ways to validate your application incoming data.By default Laravel’s base controller class uses a ValidatesRequests trait which provides a convenient method to validate all incoming HTTP requests coming from client.You can also validate data in laravel by creating Form Request. click here read more about data validations in Laravel.
Q4.
 0
How to install laravel via composer ? Posted by Sharad Jaiswal You can install Laravel via composer by running below command.
composer create-project laravel/laravel your-project-name version 
Also Read Core PHP Interview Questions and Answers for 2018
Q5.
 0
List some features of laravel 5.0 ? Posted by Sharad Jaiswal Inbuilt CRSF (cross-site request forgery ) Protection. Inbuilt paginations Reverse Routing Query builder Route caching Database Migration IOC (Inverse of Control) Container Or service container.
Q6.
 0
What is PHP artisan. List out some artisan commands ? Posted by Sharad Jaiswal PHP artisan is the command line interface/tool included with Laravel. It provides a number of helpful commands that can help you while you build your application easily. Here are the list of some artisan command:
php artisan list php artisan help
Q7.
 0
ONLINE INTERVIEW QUESTIONS 
php artisan tinker php artisan make php artisan –versian php artisan make model model_name php artisan make controller controller_name
List some default packages provided by Laravel 5.6 ? Posted by Sharad Jaiswal Below are list of some ofcial/ default packages provided by Laravel 5.6
Cashier Envoy Passport Scout Socialite Horizon
Q8.
 0
What are named routes in Laravel? Posted by Sharad Jaiswal Named routing is another amazing feature of Laravel framework. Named routes allow referring to routes when generating redirects or Urls more comfortably. You can specify named routes by chaining the name method onto the route denition:
Route::get('user/profile', function () {     // })->name('profile');  
You can specify route names for controller actions:
Route::get('user/profile', 'UserController@showProfile')->name('profile'); 
Once you have assigned a name to your routes, you may use the route's name when generating URLs or redirects via the global route function:
// Generating URLs... $url = route('profile'); // Generating Redirects... return redirect()->route('profile'); 
Q9.
 0
What is database migration. How to create migration via artisan ? Posted by Sharad Jaiswal Migrations are like version control for your database, that’s allow your team to easily modify and share the application’s database schema. Migrations are typically paired with Laravel’s schema builder to easily build your application’s database schema.
Use below commands to create migration data via artisan.
// creating Migration php artisan make:migration create_users_table
Q10.
 0
What are service providers ? Posted by Sharad Jaiswal Service Providers are central place where all laravel application is bootstrapped . Your application as well all Laravel core services are also bootstrapped by service providers. All service providers extend the Illuminate\Support\ServiceProvider class. Most service providers contain a register and a boot method. Within the register method, you should only bind things into the service container. You should never attempt to register any event listeners, routes, or any other piece of functionality within the register method. You can read more about service provider from here
Q11.
 0
Explain Laravel’s service container ? Posted by Sharad Jaiswal
Q12.
 0
ONLINE INTERVIEW QUESTIONS 
One of the most powerful feature of Laravel is its Service Container. It is a powerful tool for resolving class dependencies and performing dependency injection in Laravel. Dependency injection is a fancy phrase that essentially means class dependencies are “injected” into the class via the constructor or, in some cases, “setter” methods.
What is composer ? Posted by Sharad Jaiswal Composer is a tool for managing dependency in PHP. It allows you to declare the libraries on which your project depends on and will manage (install/update) them for you. Laravel utilizes Composer to manage its dependencies.
Q13.
 0
What is dependency injection in Laravel ? Posted by Sharad Jaiswal In software engineering, dependency injection is a technique whereby one object supplies the dependencies of another object. A dependency is an object that can be used (a service). An injection is the passing of a dependency to a dependent object (a client) that would use it. The service is made part of the client’s state.[1] Passing the service to the client, rather than allowing a client to build or nd the service, is the fundamental requirement of the pattern. https://en.wikipedia.org/wiki/Dependency_injection You can do dependency injection via Constructor, setter and property injection.
Q14.
 0
What are Laravel Contract’s ? Posted by Sharad Jaiswal Laravel’s Contracts are nothing but a set of interfaces that dene the core services provided by the Laravel framework. Read more about laravel Contract’s
Q15.
 0
Explain Facades in Laravel ? Posted by Sharad Jaiswal Laravel Facades provides a static like an interface to classes that are available in the application’s service container. Laravel self-ships with many facades which provide access to almost all features of Laravel ’s. Laravel facades serve as “static proxies” to underlying classes in the service container and provide benets of a terse, expressive syntax while maintaining more testability and exibility than traditional static methods of classes. All of Laravel’s facades are dened in the Illuminate\Support\Facades namespace. You can easily access a facade like so: 
use Illuminate\Support\Facades\Cache;  
Route::get('/cache', function () {     return Cache::get('key'); }); 
Q16.
 0
What are Laravel eloquent? Posted by Sharad Jaiswal Laravel’s Eloquent ORM is simple Active Record implementation for working with your database. Laravel provide many different ways to interact with your database, Eloquent is most notable of them. Each database table has a corresponding “Model” which is used to interact with that table. Models allow you to query for data in your tables, as well as insert new records into the table.
Below is sample usage for querying and inserting new records in Database with Eloquent. 
// Querying or finding records from products table where tag is 'new' $products= Product::where('tag','new'); // Inserting new record   $product =new Product;  $product->title="Iphone 7";  $product->price="$700";  $product->tag='iphone';  $product->save(); 
Q17.
 0
How to enable query log in Laravel ? Posted by Sharad Jaiswal
Q18.
 0
ONLINE INTERVIEW QUESTIONS 
Use the enableQueryLog method to enable query log in Laravel 
DB::connection()->enableQueryLog();  You can get array of the executed queries by using getQueryLog method: $queries = DB::getQueryLog(); 
What is reverse routing in Laravel? Posted by Sharad Jaiswal Laravel reverse routing is generating URL's based on route declarations. Reverse routing makes your application so much more exible. It denes a relationship between links and Laravel routes. When a link is created by using names of existing routes, appropriate Uri's are created automatically by Laravel. Here is an example of reverse routing.
// route declaration
Route::get(‘login’, ‘users@login’);
Using reverse routing we can create a link to it and pass in any parameters that we have dened. Optional parameters, if not supplied, are removed from the generated link.
{{ HTML::link_to_action('users@login') }} 
It will automatically generate an Url like http://xyz.com/login in view.
Q19.
 0
How to turn off CRSF protection for specic route in Laravel? Posted by Sharad Jaiswal To turn off CRSF protection in Laravel add following codes in “app/Http/Middleware/VerifyCsrfToken.php”
  //add an array of Routes to skip CSRF check private $exceptUrls = ['controller/route1', 'controller/route2'];  //modify this function public function handle($request, Closure $next) {  //add this condition foreach($this->exceptUrls as $route) {  if ($request->is($route)) {   return $next($request);  } } return parent::handle($request, $next); } 
Q20.
 0
What are traits in Laravel? Posted by Sharad Jaiswal PHP Traits are simply a group of methods that you want include within another class. A Trait, like an abstract class cannot be instantiated by itself.Trait are created to reduce the limitations of single inheritance in PHP by enabling a developer to reuse sets of methods freely in several independent classes living in different class hierarchies.
Here is an example of trait.
trait Sharable {     public function share($item)   {     return 'share this item';   }   } 
You could then include this Trait within other classes like this:
Q21.
 0
ONLINE INTERVIEW QUESTIONS 
 class Post {     use Sharable;   }   class Comment {     use Sharable;   } 
Now if you were to create new objects out of these classes you would nd that they both have the share() method available: 
$post = new Post; echo $post->share(''); // 'share this item'    $comment = new Comment; echo $comment->share(''); // 'share this item' 
Does Laravel support caching? Posted by Sharad Jaiswal Yes, Laravel supports popular caching backends like Memcached and Redis. By default, Laravel is congured to use the le cache driver, which stores the serialized, cached objects in the le system.For large projects, it is recommended to use Memcached or Redis.
Q22.
 0
Explain Laravel’s Middleware? Posted by Sharad Jaiswal As the name suggests, Middleware acts as a middleman between request and response. It is a type of ltering mechanism. For example, Laravel includes a middleware that veries whether the user of the application is authenticated or not. If the user is authenticated, he will be redirected to the home page otherwise, he will be redirected to the login page.
There are two types of Middleware in Laravel. Global Middleware: will run on every HTTP request of the application. Route Middleware: will be assigned to a specic route. Read more about Laravel middlewares
Q23.
 0
What is Lumen? Posted by Sharad Jaiswal Lumen is PHP micro-framework that built on Laravel’s top components.It is created by Taylor Otwell. It is perfect option for building Laravel based micro-services and fast REST API’s. It’s one of the fastest micro-frameworks available. You can install Lumen using composer by running below command
composer create-project --prefer-dist laravel/lumen blog
Q24.
 0
Explain Bundles in Laravel? Posted by Sharad Jaiswal In Laravel, bundles are also called packages.Packages are the primary way to extend the functionality of Laravel. Packages might be anything from a great way to work with dates like Carbon, or an entire BDD testing framework like Behat.In Laravel, you can create your custom packages too.You can read more about packages from here
Q25.
 0
How to use custom table in Laravel Modal ? Posted by Sharad Jaiswal You can use custom table in Laravel by overriding protected $table property of Eloquent.
Q26.
 0
ONLINE INTERVIEW QUESTIONS 
 Below is sample uses  
class User extends Eloquent{  protected $table="my_user_table";  
} 
List types of relationships available in Laravel Eloquent? Posted by Sharad Jaiswal Below are types of relationships supported by Laravel Eloquent ORM.
One To One One To Many One To Many (Inverse) Many To Many Has Many Through Polymorphic Relations Many To Many Polymorphic Relations You can read more about relationships in Laravel Eloquent from here
Q27.
 0
Why are migrations necessary? Posted by Sharad Jaiswal Migrations are necessary because:
Without migrations, database consistency when sharing an app is almost impossible, especially as more and more people collaborate on the web app. Your production database needs to be synced as well.
Q28.
 0
Provide System requirements for installation of Laravel framework ? Posted by Sharad Jaiswal In order to install Laravel, make sure your server meets the following requirements:
PHP >= 7.1.3 OpenSSL PHP Extension PDO PHP Extension Mbstring PHP Extension Tokenizer PHP Extension XML PHP Extension Ctype PHP Extension JSON PHP Extension
Q29.
 0
List some Aggregates methods provided by query builder in Laravel ? Posted by Sharad Jaiswal count() max() min() avg() sum() Also Read Laravel 5 interview questions 2018
Q30.
 0
ONLINE INTERVIEW QUESTIONS 
Also Read Related Laravel interview questions
```
