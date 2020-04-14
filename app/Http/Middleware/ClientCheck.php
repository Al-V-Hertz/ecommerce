<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\URL;
use Auth;
use Closure;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
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
            if(Auth::user()->can('order item')){
                return $next($request);
            }
        }
        return redirect('/login'); 
    }
}
