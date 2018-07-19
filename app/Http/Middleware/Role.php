<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Role
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
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->is_admin == 1) {
                return $next($request);
            } else {
                if($user->role ==1){
                    return $next($request);
                }
                else {
                    return redirect('/home');
                }
            }
        } else {
            return redirect('/login');
        }
    }
}
