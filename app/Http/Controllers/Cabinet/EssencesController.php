<?php

/* Create by Xenial */

namespace app\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;

# Models
use App\Models\Essence;
use App\Models\ImgProperty;

# Requests
#use Illuminate\Http\Request;
use App\Http\Requests\EssencesRequest;

class EssencesController extends Controller
{
    public function __construct()
    {
        $this->middleware('cabinet');
    }

    # :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

    # Вывод Сущностей
    public function index()
    {
        $objEssence = Essence::getInstance();
        $essences = $objEssence->get();

        $params = [
            'active'    => 'Essences',
            'title'     => 'Essences',
            'essences'  => $essences,
        ];

        return view('cabinet.essences.show', $params);

    } # END index()

    # :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

    # Добавление Сущности (wew-форма)
    public function add()
    {
        $params = [
            'active'    => 'Essences',
            'title'     => 'Essence Add',
        ];

        return view('cabinet.essences.add', $params);

    } # END add()

    # :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

    # Добавление Сущности (Request)
    # ------------------------------------------------------------
    # ››› php artisan make:request EssencesRequest ---------------
    # ------------------------------------------------------------
    public function addRequest(EssencesRequest $request)
    {
        $author = \Auth::user()->id;

        $objEssence = Essence::getInstance();

        $objEssence = $objEssence->create([
            'name'          => $request->input('name'),
            'user_id'       => $author,
            'first_author'  => $author,
        ]);

        # если Объект не NULL, т.е. запись в Таблицу `essences` была успешной
        if(is_object($objEssence)){
            # перенаправляем на страницу Сущностей, с выводом соответствующего сообщения
            return redirect()->route('essences')->with('success', trans('messages.cabinet.essences.add'));
        }

        # ::: 'вряд ли мы часто будем попадать на данный return' :::
        # Иначе, возвращаем Пользователя обратно, и выводим сообщение, что 'Не удалось добавить сущность'
        return back()->with('error', trans('messages.cabinet.essences.errorAdd'));

    } # END addRequest()

    # :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

    # Редактирование Сущности
    public function edit(int $id)
    {
        # Чтобы не создавать аналогичные Котроллеры для Cabinet, Admin и Root Admin,
        # запретим показ Сущностей для не их авторов (а в самом Шаблоне, мы соответствующие Сущности не показываем)
        # Но это не относиться к Admin и Root Admin
        # ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        if(\Auth::user()->isAdmin == 0 && \Auth::user()->root == 0 && \Auth::user()->isConfirm == 1){
            if(\Auth::user()->id != _essence($id)->user_id){
                return redirect(route('essences'))->with('error', trans('messages.special.one'));
            }
        }
        # ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        $objEssence = Essence::getInstance();

        $objEssence = $objEssence->find($id);
        if(!$objEssence) {
            return abort(404);
        }

        $params = [
            'active'    => 'Essences',
            'title'     => 'Essence Edit',
            'essence'   => $objEssence
        ];

        # в шаблон на редактирование, передаём:
        return view('cabinet.essences.edit', $params);

    } # END edit()

    # :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

    # Редактирование Сущности (Request)
    # повторно используем созданную нами Валидацию, и также принимаем id Сущности
    public function editRequest(EssencesRequest $request, int $id)
    {
        $objEssence = Essence::getInstance();
        $objEssence = $objEssence->find($id);

        $objEssence->name = $request->input('name');
        $objEssence->user_id = \Auth::user()->id;

        # Сохраняем данные, которые изменяли
        if($objEssence->save()){
            return redirect()->route('essences')->with('success', trans('messages.cabinet.essences.edit'));
        }

        # ::: 'вряд ли мы часто будем попадать на данный return' :::
        # Иначе, возвращаем Пользователя обратно, с выводом соответствующего сообщения
        return back()->with('error', trans('messages.cabinet.essences.errorEdit'));

    } # END editRequest()

    # :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

    # Удаление Сущности (Входящие параметры: $id, $comparison)
    public function delete(int $id, $comparison)
    {
        # Проверка на замену Параметра (id) Сущности в адресной строке
        # Принимая $id (конвертируя в md5) и md5 - $comparison - и добавляя некое string значение
        # мы сравниваем эти 2-а Значения (в результате, чтобы пройти далее, bad user должен знать string добавляемое значение)
        # чтобы сравнения совпали
        if(md5($id).'abc' != $comparison.'abc')
        {
            return back()->with('error', trans('messages.special.one'));
        }
        # ·······································································

        # ·······································································
        # ·······································································
        # создаём Объект от Модели Essence
        $objEssence = Essence::getInstance();
        $objEssence = $objEssence->select('first_author')->where('id', $id)->get();

        # Проверка на Автора Сущности или Root-Администратора или Администратора
        # т.е. если Пользователь Root-Администратор или Администратор, а также isConfirm
        if(\Auth::user()->isAdmin == 1 && \Auth::user()->isConfirm == 1
            || \Auth::user()->root == 1 && \Auth::user()->isConfirm == 1
            || \Auth::user()->id == $objEssence[0]['first_author'])
        {
                    # Прежде чем очищать данные в БД ------------------------------------
                    # Получаем Объект
                    $objImgProperty = ImgProperty::getInstance();

                    # Выбираем по `essences_id`, т.к. нам приходит id - это essences_id, и essences_id Уникальное Значение
                    $objImgProperty = $objImgProperty->where('essences_id', '=', $id)->first();
                    # -------------------------------------------------------------------

                # создаём Объект от Модели Essence
                $objEssence = Essence::getInstance();

                # от Объекта Модели, удаляем Сущность (запись в Таблице) по WHERE условию
                # с помощью Метода where(), передав в него 1-м Параметром имя искомого Поля,
                # а 2-м Значением непосредственно id
                $result = $objEssence->where('id', $id)->delete();


                    # При удалении Сущности, также удаляються связанные записи ----------
                    # в Таблицах `num_property`, `desc_property` и `num_property`,
                    # т.к. эти Таблицы связаны Внешними Ключами с Таблицей `essences`
                    # Соответственно Свойства (num. desc, img) Сущности удаляються,
                    # но при этом, нужно реализовать физическое удаление Изображения,
                    # которое соответствует Свойству img данной удаляемой Сущности

                    # Получим имя изображения, которое соответствует сущности -----------
                    # Нужно учитывать, что Свойство img - может отсутствовать,
                    # соответственно физически изображения также не будет,
                    # и удалять будет нечего
                    if(!is_null($objImgProperty)) {
                        $removeImage = $objImgProperty->img;

                        # Физически удаляем картинку с Сервера
                        unlink(public_path() . '/images/' . $removeImage);

                    }
                    # -------------------------------------------------------------------

            if ($result==true) {
                return redirect(route('essences'))->with('success', trans('messages.cabinet.essences.delete'));
            }

            # ::: 'вряд ли мы часто будем попадать на данный return' :::
            # Иначе, возвращаем Пользователя обратно на страницу, с выводом соответствующего сообщения
            return back()->with('error', trans('messages.cabinet.essences.deleteError'));

        } else {
        # ·······································································
        # ·······································································
            return back()->with('error', trans('messages.special.one'));
        }

    } # END delete()

    # :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
}