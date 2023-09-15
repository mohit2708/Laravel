<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use JWTAuth;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function loginbkp(Request $request){
    	$validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (! $token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->createNewToken($token);
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
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }


    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $loginDetails = User::where('email',$credentials['email'])->first();

        //valid credential
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|string|min:6|max:50'
        ]);
        
        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }

        //Request is validated
        //Crean token
        
        try {
            // $token = Auth::attempt($credentials);
            
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json([
                	'success' => false,
                	'message' => 'Login credentials are invalid.',
                ], 400);
            }
            
        } catch (JWTException $e) {
    	return $credentials;
            return response()->json([
                	'success' => false,
                	'message' => 'Could not create token.',
                ], 500);
        }
        
 		//Token created, return with success response and jwt token
        $loginDetails['success'] = true;
        $loginDetails['token'] = $token;
        return response()->json([
            'loginDetails' => $loginDetails,
        ]);
    }

    // bkp
    // public $token = true;

    public function loginb(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $loginDetails = User::where('email',$credentials['email']) -> first();

        //valid credential
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|string|min:6|max:50'
        ]);
        
        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        //Request is validated
        //Crean token
        
        try {
            // $token = Auth::attempt($credentials);
            
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json([
                	'success' => false,
                	'message' => 'Login credentials are invalid.',
                ], 400);
            }
            
        } catch (JWTException $e) {
    	return $credentials;
            return response()->json([
                	'success' => false,
                	'message' => 'Could not create token.',
                ], 500);
        }
        
 		//Token created, return with success response and jwt token
        $loginDetails['success'] = true;
        $loginDetails['token'] = $token;
        return response()->json([
            'loginDetails' => $loginDetails,
        ]);
    }



    public function logoutb(Request $request)
    {
      
        try {
            // auth()->logout();
            
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json([
                'success' => true,
                'message' => 'User has been logged out'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, user cannot be logged out'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function changePassword(Request $request){
        $user = Auth::user();
        $input = $request->all();
        // $userid = Auth::guard('api')->user()->id;
        $rules = array(
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        );
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            $arr = array("status" => 400, "message" => $validator->errors()->first(), "data" => array());
        } else {
            try {
                if ((Hash::check(request('old_password'), Auth::user()->password)) == false) {
                    $arr = array("status" => 400, "message" => "Check your old password.", "data" => array());
                } else if ((Hash::check(request('new_password'), Auth::user()->password)) == true) {
                    $arr = array("status" => 400, "message" => "Please enter a password which is not similar then current password.", "data" => array());
                } else {
                    User::where('id', $user->id)->update(['password' => Hash::make($input['new_password'])]);
                    $arr = array("status" => 200, "message" => "Password updated successfully.", "data" => array());
                }
            } catch (\Exception $ex) {
                if (isset($ex->errorInfo[2])) {
                    $msg = $ex->errorInfo[2];
                } else {
                    $msg = $ex->getMessage();
                }
                $arr = array("status" => 400, "message" => $msg, "data" => array());
            }
        }
        return \Response::json($arr);
    }



    public function forgot_password(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
            'email' => 'required|email',
        ]);
        
        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        $user = DB::table('users')->where('email', '=', $request->email)
                ->first();
            
        if (isset($user) < 1) {
            return response()->json([
                'status' => false,
                'status_code' => '400',
                'message' => "Email does not exist!",
            ], 201);
        }

        $credentials = request()->validate(['email' => 'required|email']);

        Password::sendResetLink($credentials);

        return response()->json([
            'status' => true,
            'status_code' => '200',
            'message' => "A reset link has been sent to your email address..",
        ], 200);

        die();


        try {
            //Check if the user exists start
            $user = DB::table('users')->where('email', '=', $request->email)
                ->first();
            
            if (isset($user) < 1) {
                return response()->json([
                    'status' => false,
                    'status_code' => '400',
                    'message' => "Email does not exist!",
                ], 201);
            }
            //Check if the user exists end

            // $submit_forget_password = new UserService();
            $forget_password = $this->submitForgetPasswordForm($request);
            if($forget_password  == 1){
                return response()->json([
                    'status' => true,
                    'status_code' => '200',
                    'message' => "A reset link has been sent to your email address..",
                ], 200);
            }else{
                return response()->json([
                    'status' => false,
                    'status_code' => '400',
                    'message' => $forget_password,
                ], 400);
            }
        } catch (\Exception $e) {
            // \Log::info(Config::get('custom.log.forgetPassword'), ['message' => $e->getMessage()]);
            return response()->json([
                'status' => false,
                'status_code' => '400',
                'message' => "Somting went Wrong!",
            ], 400);
        }



    }



    public function resetPassword(Request $request)
    {
        $email = $request->email;
        $token = $request->token;
        
        $validator = Validator::make($request->all(), [ 
            'email' => 'required',
            'token' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } 
        // dd($request->all());

        try {
            // $reset_password = $this->resetPasswordFunction($request);
            $updatePassword = DB::table('password_resets')->where([
                'email' => $request->email,
                'token' => $request->token
                ])->first();
            // dd($updatePassword);
            if($updatePassword != null){
                // dd('hello');
                $user = User::where('email', $request->email)->update(['password' => Hash::make($request->password)]);
                $emty_reset_password = DB::table('password_resets')->where(['email'=> $request->email])->delete();
                if($emty_reset_password){
                    return response()->json([
                        'status' => true,
                        'status_code' => '200',
                        'message' => "Password Changed Successfully!",
                    ], 201);
                }
            }
            return response()->json([
                'status' => false,
                'status_code' => '400',
                'message' => "Invalid token.",
            ], 400); 
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'status_code' => '400',
                'message' => "Somting went Wrong!",
            ], 400);
        }
    }


     /**
     * User forget password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function submitForgetPasswordForm(Request $request)
    {
        // $check_verify = User::where('email', $request->email)->first();
        // dd($check_verify->is_verify);
        // if($check_verify->is_verify === "1"){
            try
            {
                $randomNumber = Str::random(60);
                // $randomNumber = mt_rand(100000, 999999);
                // dd($randomNumber);
                DB::table('password_resets')->insert([
                    'email' => $request->email, 
                    'token' => $randomNumber, 
                    'created_at' => Carbon::now()
                    ]);
                $data = ['token' => $randomNumber];
                $toEmail = $request->email;
                // dd($request->email);
            //    Mail::to($request->email)->send(new ResetPassword($data));
            //    return $mail;

                $mail =  Mail::send('mail.api.reset_password', ['data' => $data], function($message) use ($toEmail) {
                $message->to($toEmail, 'Idaho Traffic Control')
                ->subject('Change Password');
                });
                return 1;
            }catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'status_code' => '400',
                    'message' => "Somting went Wrong!",
                ], 400);
            }
            
            
        // }
    }





}
