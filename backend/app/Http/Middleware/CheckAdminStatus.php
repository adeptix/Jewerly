<?php

namespace App\Http\Middleware;

use Closure;

class CheckAdminStatus
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
        if (!auth()->check()) {
            return response()->json([
                'message' => 'Вы не авторизованы'
            ], 401);
        }

        if (!auth()->user()->isAdmin) {
            return response()->json([
                'message' => 'У вас нет доступа'
            ], 403);
        }

        return $next($request);
    }
}
