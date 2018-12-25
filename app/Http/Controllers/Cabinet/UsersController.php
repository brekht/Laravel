<?php

/* Create by Xenial */

namespace app\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;

# Models
use App\Models\User;

use Illuminate\Support\Facades\Auth;

# Requests
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('root');
    }

    # :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

    public function index()
    {
        # Создаём Объект, и сразу выбираем все данные в переменную.
        # Данная строка кода могла быть разбита на 2-е строки,
        # где во 2-й строке (после создания Объекта) мы обращаемся к get() от созданного Объекта,
        # получая выборку всех данных из Таблицы `users`
        #
        # ⚑ В данном случае мы не будем использовать Singleton, т.к. Модель User - создана изначально,  ⚑
        # ⚑ и в данном случае постараемся не вмешиваться в логику Laravel,                              ⚑
        # ⚑ а также оставим для наглядности строку кода - в 2-а действия,                               ⚑
        # ⚑ по созданию Объекта и получению всей выборки данных                                         ⚑
        $users = (new User())->get();

        $params = [
            'active'    => 'Users',
            'title'     => 'Users',
            'users'     => $users
        ];

        return view('cabinet.users.show', $params);
    }

    # :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

    # Редактирование Прав Пользователей
    # (приведём явно к int входящий тип данных - id Пользователя)
    public function edit(int $id)
    {
        # Запретим изменять права доступа для Root-Admin для самого Root-Admin
        # ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        if(Auth::user()->root == 1 && Auth::user()->id==$id){
            
                return redirect(route('users'))->with('error', trans('messages.special.one'));
        }
        # ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        # ищём по Ключу $id, выбирая тем самым редактируемого Пользователя
        $user = (new User())->find($id);

        if(!is_object($user)) {         # Если данного Объекта нет (т.е. Пользователь не найден)
            return abort(404);    # тогда возвращаем 404 Ошибку
        }

        $params = [
            'active'    => 'Users',
            'title'     => 'User Rights Edit',
            'user'     => $user
        ];

        return view('cabinet.users.edit', $params);
    } # END edit()

    # :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

    # Редактирование Прав Пользователей (Request)
    public function editRequest(Request $request, int $id)
    {
        #dd($request->all());

        # От Модели User - ищём по Ключу, выбирая тем самым редактируемого Пользователя
        $objUser = User::find($id);


        if($request->input('rights') == NULL){

            return redirect()->route('users')->with('error', trans('messages.cabinet.users.default'));

        } else {
            # ActiveRecord
            # принимаем данные, записываем в Свойство Объекта
            $objUser->isAdmin = $request->input('rights');
        }

        # Сохраняем изменения, в БД, через Метод save(), и если save() нам возвращает true, значит у нас данные в БД обновились
        if ($objUser->save()) {
            # и в окончании, мы переадресовываем Пользователя на страницу Пользователей, и пишем, что Права Пользователя изменены
            return redirect()->route('users')->with('success', trans('messages.cabinet.users.edit'));
        }

        # ::: 'вряд ли мы часто будем попадать на данный return' :::
        # Иначе, возвращаем Пользователя на страницу изменения выбранного Прав Пользователя, с выводом соответствующего сообщения
        return back()->with('error', trans('messages.cabinet.users.errorEdit'));

    } # END editRequest()

    # :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

    # Блокировка / Разблокировать - Пользователя
    public function confirm(int $id)
    {
        $objUser = (new User())->find($id);

        if(!is_object($objUser)) {         # Если данного Объекта нет (т.е. Пользователь не найден)
            return abort(404);       # тогда возвращаем 404 Ошибку
        }

        # Разблокировать
        if($objUser->isConfirm == 1){

            $objUser->isConfirm = 0;

            if ($objUser->save()) {
                return redirect(route('users'))->with('success', trans('messages.cabinet.users.lock'));
            } else {
                return redirect(route('users'))->with('error', trans('messages.cabinet.users.lockError'));
            }
        }

        # Заблокировать
        if($objUser->isConfirm == 0){

            $objUser->isConfirm = 1;

            if ($objUser->save()) {
                return redirect(route('users'))->with('success', trans('messages.cabinet.users.unlock'));
            } else {
                return redirect(route('users'))->with('error', trans('messages.cabinet.users.unlockError'));
            }
        }

    } # END confirm()

    # :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

    # Удаление Пользователя (Входящий параметр Request $request)
    public function delete(Request $request)
    {
        # Проверка на Ajax Запрос
        if($request->ajax()) {
            # принимаем id, приведём к числу
            $id = (int)$request->input('id');

            # от Объекта Модели User, удаляем Пользователя (запись в Таблице) по WHERE условию
            # с помощью Метода where(), передав в него 1-м Параметром имя искомого Поля,
            # а 2-м Значением непосредственно id
            User::where('id', $id)->delete();
        }
    } # END delete()
}