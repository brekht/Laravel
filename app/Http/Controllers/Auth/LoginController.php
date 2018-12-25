<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = 'account';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /* ⚑
     * --------------------------------------------------------------------------
     * Переопределим login() из Трейта AuthenticatesUsers.php
     * --------------------------------------------------------------------------
     * Переопределим logout() из Трейта AuthenticatesUsers.php
     * --------------------------------------------------------------------------
     *
     *
     */
    # :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request) # Трейт переопределён из AuthenticatesUsers
    {
        #dd($request); /* смотрим, какие данные пришли */

        # описывается схожая логика, как и в AuthenticatesUsers
        try{
            # указываем правила валидации
            $this->validate($request, [
                'email' => 'required|min:3|max:128',
                'password' => 'required|min:6'
            ]);

            # Проверяем, установлено ли поле 'запомнить'. если да, тогда в переменную получим 1-цу
            $remember = $request->has('remember') ? true : false;

            # Используем фасад Auth (не забудь подключить его): 1-й Параметр: данные по которым будем авторизоваться; 2-м параметром принимается remember
            if(Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')], $remember))
            {   # если авторизация успешна, redirect на Роут 'account'. И выводим сообщение, из созданного нами пользовательского языкового файла
                return redirect(route('account'))->with('success', trans('messages.auth.success'));
            }

            # Иначе, возвращаем пользователя назад, т.е. если авторизация не успешна
            return back()->with('error', trans('messages.auth.error'));

        } catch (ValidationException $e) {
            # в случае не авторизации - пишем в Лог
            # \Log::error($e->getMessage()); # при использовании - нужно подключить namespace
            # не обязательно, да и не нужно и безопаснее выводить Exception как вывод, достаточно простого сообщения
            return back()->with('error', trans('messages.auth.error'));
        }
    }

    # :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        #return redirect('/');
        return redirect(route('login'))->with('success', trans('messages.logout.success')); /* ⚑ */
    }

    # :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
}
