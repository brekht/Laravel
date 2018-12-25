<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

use Illuminate\Http\Request; /* ⚑ */

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    #protected $redirectTo = '/home';
    protected $redirectTo = 'account';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /* ⚑
     * --------------------------------------------------------------------------
     * Переопределим register() из Трейта RegistersUsers.php
     * --------------------------------------------------------------------------
     *
     *
     *
     *
     */
    # :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        #dd($request); /* смотрим, какие данные пришли */

        try {
            # отлавливаем исключение, т.к. Метод validator() - возвращает Exception, в итоге если произошла Ошибка, мы её отлавливаем
            # Валидируем данные, возвращаемые от Request
            $this->validator($request->all())->validate();

        } catch(\Exception $e) {
            # в данном catch блоке нужно вывести валидационное сообщение, это будет показано alertify
            #return back()->with('error', $e->getMessage());
            return back()->with('error', trans('messages.register.error'));
        }

        # Если валидация прошла успешно, принимаем данные

        # используя input() от $request - получаем входящие данные из нашего Запроса
        $email = $request->input('email');
        $password = $request->input('password');

        # в тернарном операторе (if), смотрим, если 'remember' есть, тогда true
        $isAuth = $request->has('remember') ? true : false;

        # Создаёт Пользователя, и возвращает его Объект (передаём Массив исходя из того, что create() Метод принимает, ориентируясь на Свойство $fillable Модели User)
        # Метод create() - описан ниже (... событие можно отловить / или проверять на instanceof User)
        $objUser = $this->create(['email' => $email, 'password' => $password]);

        # Проверим: создался Объект Класса User или нет - т.к. Пользователь может не создасться, а мы далее будем его авторизовать, что вызовет Ошибку
        if(!($objUser instanceof User)){
            # перенаправить обратно, и вывести сообщение
            return back()->with('error', trans('messages.register.noobject'));
        }

        if($isAuth){ # если true - значит Авторизуем Пользователя
            $this->guard()->login($objUser);

            # После авторизации Пользователя, направляем на указанный (именнованный) Роут, и выводим сообщение
            # (не совсем правильно писать текст сообщения прямо в коде, лучше выносить в отдельные языковые файлы)
            return redirect(route('account'))->with('success', trans('messages.register.success'));
        } else {
            # Иначе, если Пользователь не выбрал Авторизацию при Регистрации, переправим его на Login
            return redirect(route('login'))->with('success', trans('messages.register.success'));
        }
    }
    # :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            #'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:128|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            #'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
}
