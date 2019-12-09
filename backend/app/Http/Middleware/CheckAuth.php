<?php

namespace App\Http\Middleware;

use Closure;

class CheckAuth
{

    public function handle($request, Closure $next)
    {

        if (!auth()->check()) {
            return response()->json([
                'message' => 'Вы не авторизованы'
            ], 401);
        }

        return $next($request);
    }
}
