<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class AdminMiddleware
{
	
	 /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
		$user = $this->auth->user();
		if($user){
			if(($user->role_id == 1)){
				/*if(\Request::path() == 'admin'){
					return $next($request);
				}
				if(\Helper::page_access($user->role_id, \Request::path())){*/
					return $next($request);
				/*}else{
					return redirect('admin');
				}*/
				
				
			}else{
			   return redirect('/');
			}
        }else {
            return redirect('/');
        } 

    }
}
