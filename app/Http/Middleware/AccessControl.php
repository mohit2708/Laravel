<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AccessControl
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
        //return $next($request);
        // if(!Auth::guard('admin')->check()){
        //     return redirect('/login');
        // }
        // return $next($request);
        //return redirect("/login");

    }
}
