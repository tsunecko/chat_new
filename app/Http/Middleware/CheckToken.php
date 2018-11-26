<?php

namespace App\Http\Middleware;

use App\Helpers\Helper;
use Closure;
use App\User;

class CheckToken
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
        if (User::where('token', Helper::getToken($request))->exists()) {
            return $next($request);
        }

        return response()->json(['wrong_token']);
    }
}
