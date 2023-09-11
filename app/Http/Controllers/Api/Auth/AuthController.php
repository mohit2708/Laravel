<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Validator;
use JWTAuth;

class AuthController extends Controller
{
    // https://www.positronx.io/laravel-jwt-authentication-tutorial-user-login-signup-api/
    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request) {
        // dd('asfdsa');
        $validator = Validator::make($request->all(), [
            'first_name'    => 'required|string|between:2,100',
            'last_name'     => 'required|string|between:2,100',
            'phone'         => 'nullable|max:20',
            'email'         => 'required|string|email|max:100|unique:users',
            'password'      => 'required|string|min:6',
        ]);
        if($validator->fails()){
            return response()->json(['error' => $validator->errors()->toJson(), 'status' => 400], 400);
        }
        $user = User::create(array_merge(
                    $validator->validated(),
                    ['password' => bcrypt($request->password)]
                ));
        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user,
            'status' => 200
        ], 200);
    }
    /**
     * User Login.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $loginDetails = User::where('email',$credentials['email'])->first();

        //valid credential
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|string|min:6|max:50'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages(), 'status' => 442], 422);
        }

        //Request is validated
        //Creat token
        try {
            // $token = Auth::attempt($credentials);
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                	'success' => false,
                	'message' => 'Login credentials are invalid.',
                	'status' => 401
                ], 401);
            }
            //Token created, return with success response and jwt token
            $loginDetails['success'] = true;
            $loginDetails['token'] = $token;
            return response()->json([
                'loginDetails' => $loginDetails,
                'status' => 200
            ]);
            
        } catch (JWTException $e) {
    	return $credentials;
            return response()->json([
                'success' => false,
                'message' => 'Could not create token.',
                'status' => 500
            ], 500);
        }        
 		
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function logout(Request $request)
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
