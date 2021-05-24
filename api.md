## Api Create using JWT authentication
__https://blog.pusher.com/laravel-jwt/__

**Step1:-**  Installing the jwt-auth package.
```php
composer require tymon/jwt-auth
```

**Step2:-**  Head to the __config/app.php file__ and add JWT providers and aliases as follows.
```php
  'providers' => [
  ….
  'TymonJWTAuthProvidersJWTAuthServiceProvider',
  ],
  'aliases' => [
  ….
  'JWTAuth' => 'TymonJWTAuthFacadesJWTAuth',
  'JWTFactory' => 'TymonJWTAuthFacadesJWTFactory',
  ],
```
**Step3:-**  JWT using the following command.
```php
php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"

php artisan jwt:secret
```

**Routes Create:**  routes/api.php
```php
Route::post('/login', 'Api\LoginController@login');
Route::post('/register', 'Api\LoginController@register');
```

**We need to make the User model implement JWT. Open app/User.php file and replace the content with this:**
```php
<?php

    namespace App;

    use Illuminate\Notifications\Notifiable;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Tymon\JWTAuth\Contracts\JWTSubject;

    class User extends Authenticatable implements JWTSubject
    {
        use Notifiable;

        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'name', 'email', 'password',
        ];

        /**
         * The attributes that should be hidden for arrays.
         *
         * @var array
         */
        protected $hidden = [
            'password', 'remember_token',
        ];

        public function getJWTIdentifier()
        {
            return $this->getKey();
        }
        public function getJWTCustomClaims()
        {
            return [];
        }
    }
```

**Create Control-**
```php
<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;




class LoginController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $credentials = $request->only('email', 'password');
        $loginDetails = User::where('email',$credentials['email']) -> first();

        try {
             if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        }catch (JWTException $e) {
          return response()->json(['error' => 'could_not_create_token'], 500);
        }
        $loginDetails['token'] = $token;
        return response()->json(compact('loginDetails'));
    }


    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:6',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create(array_merge(
                    $validator->validated(),
                    ['password' => bcrypt($request->password)]
                ));
                //   $user = User::create([
                //   'name' => $request->name,
                //   'email' => $request->email,
                //   'password' => bcrypt($request->password),
                // ]);

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }


    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        auth()->logout();

        return response()->json(['message' => 'User successfully signed out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        return $this->createNewToken(auth()->refresh());
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile() {
        return response()->json(auth()->user());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }
}

```

**Api Hit In Postman:**
```php
http://localhost/chetu/lfbag_user/user_fbag/api/login
body->formdata
email     xxxxx
password  xxxxx
http://localhost/chetu/lfbag_user/user_fbag/api/register
body->formdata
name
email
password
password_confirmation
age
```




