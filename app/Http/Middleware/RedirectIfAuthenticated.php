<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        # Если Пользователь Авторизован - редирект на Роут account
        if (Auth::guard($guard)->check()) {
            return redirect('account');
        }

        # Если Пользователь не авторизован, продолжаем Запрос дальше
        return $next($request);
    }
}
