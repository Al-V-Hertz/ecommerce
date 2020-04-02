<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\URL;
use Auth;
use Closure;

class ClientCheck
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
        if(Auth::check()){
            if(Auth::user()->user_type == "client"){
                return $next($request);
            }
        }
        return redirect('/login'); 
    }
}
