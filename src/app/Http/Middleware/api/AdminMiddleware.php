<?php

namespace App\Http\Middleware\api;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
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
        $role = Auth::user()->ltk_id;
        if ($role == 1 || $role == 2) {
            return $next($request);
        }
        return response()->json(['message' => 'Khong phai admin']);

    }
}
