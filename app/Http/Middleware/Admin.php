<?php

/* Create by Xenial ~ artisan */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Admin
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
        # Проверяем через Фасад Auth::user() (если не Root) ~ обрати внимание, что подключен: use Illuminate\Support\Facades\Auth;
        if(Auth::user()->isAdmin == 0){

            # переадресовываем на Акаунт Пользователя (без Прав Администратора) (или можно переадресовать на страницу 404)
            return redirect(route('account'));
        }

        # Если Пользователь Подтверждён - продолжаем Запрос дальше
        return $next($request);
    }
}
