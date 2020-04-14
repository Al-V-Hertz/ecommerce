<?php

namespace App\Http\Middleware;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Closure;
use Auth;

class RoleCheck
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
            if(Auth::user()->hasanyrole(Role::all()->pluck('name')->flatten())){
                return $next($request);
            }
        }
        return $next($request);
    }
}
