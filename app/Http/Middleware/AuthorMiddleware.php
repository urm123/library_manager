<?php

namespace App\Http\Middleware;

use App\Constants\AppConstant;
use Closure;
use Auth;

class AuthorMiddleware
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
        if(auth::check() && Auth::user()->role_id == AppConstant::AUTHOR_ROLE){
           return $next($request);
        } else {
           return redirect()->route('login');
        }
    }
}
