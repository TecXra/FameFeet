<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
// use Auth;
use Cache;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            User::where('id', Auth::user()->id)
                  ->update(['is_online' => true]);
        }
        return $next($request);
    }
}
