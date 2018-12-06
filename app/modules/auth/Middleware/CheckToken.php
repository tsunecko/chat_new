<?php

namespace App\modules\auth\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

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
        /*if($request->header('Authorization')){
            $token = explode(' ', $request->header('Authorization'));
            $user = User::where('api_token', $token[1])->first();
        }*/

        if(Auth::guard('api')->check()) {
            return $next($request);
        }

        return response()->json(['Not a valid API request.']);
    }
}
