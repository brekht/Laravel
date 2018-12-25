<?php

/* Create by Xenial ~ artisan */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Cabinet
{
    # для того, чтобы подключить данный middleware к соответствующему Роуту,
    # данный middleware нужно Зарегистрировать в Kernel.php в Свойстве $routeMiddleware

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        # Проверяем через Фасад Auth::user() (если не Confirm) ~ обрати внимание, что подключен: use Illuminate\Support\Facades\Auth;
        if(Auth::user()->isConfirm == 0 && Auth::user()->root != 1){

            # переадресовываем на Акаунт Пользователя (без Прав Администратора) (или можно переадресовать на страницу 404)
            return redirect(route('account'))->with('error', trans('messages.special.two'));
        }

        # Если Пользователь Подтверждён - продолжаем Запрос дальше
        return $next($request);
    }
}
