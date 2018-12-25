<?php

/* Create by Xenial ~ artisan */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Root
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
        if(Auth::user()->root == 0){

            # переадресовываем на Акаунт Пользователя (без Прав Администратора) (или можно переадресовать на страницу 404)
            return redirect(route('account'))->with('error', trans('messages.special.one'));
        }

        # Если Пользователь Подтверждён - продолжаем Запрос дальше
        return $next($request);
    }
}
