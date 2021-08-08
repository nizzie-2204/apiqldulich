<?php

namespace App\Http\Middleware\api;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminSystemMiddleware
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
        if (Auth::user()->ltk_id != 1) {
            return response()->json(['message' => 'Khong phai admin he thong']);
        }
        return $next($request);
    }
}
