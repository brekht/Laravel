<?php

/* Create by Xenial */

namespace app\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;

# Models
use App\Models\Essence;
use App\Models\FreeProperty;

# Requests
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class FreePropertiesController extends Controller
{
    public function __construct()
    {
        $this->middleware('cabinet');
    }

    # :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

    # Добавление Произвольного (Free) Свойства Сущности (принимает $id Сущности)
    public function add(int $id, $comparison)
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

        # Проверим, существует ли id Сущности, Свойство для которой мы хотим создать
        $objEssence = Essence::getInstance();

        $objEssence = $objEssence->find($id);   # От Объекта Essence - ищём по $id, выбирая тем самым Сущность, с которой работаем
        if(is_null($objEssence)) {              # Если данного Объекта нет (т.е. Сущность не найдена)
            return abort(404);            # тогда возвращаем 404 Страницу
        }

        # Иначе, Сущность с которой мы будем работать далее - найдена, и мы идём дальше...

        $params = [
            'active'    => 'Essences',
            'title'     => 'Free Property Add',
            'essenceId' => $id,
        ];

        return view('cabinet.freeproperties.add', $params);

    } # END add()

    # :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

    # Добавление Произвольного (Free) Свойства Сущности (Request) (принимает $id Сущности)
    public function addRequest(Request $request, int $id)
    {
        # Проверим, существует ли id Сущности, Свойство для которой мы создаём
        $objEssence = Essence::getInstance();

        $objEssence = $objEssence->find($id);   # От Объекта Essence - ищём по $id, выбирая тем самым Сущность, с которой работаем
        if(is_null($objEssence)) {              # Если данного Объекта нет (т.е. Сущность не найдена)
            return abort(404);            # тогда возвращаем 404 Страницу
        }

        # ·······································································

        # Валидируем данные в Контроллере
        try {

            $this->validate($request, [
                'col_prop' => 'min:3|max:100',
                'col_desc' => 'min:3|max:100',
            ]);

            # Валидация на повторяющиеся имена Свойств - при создании (при редактировании также есть подобная Валидация, но более точная)
            # Имена Свойств, а именно Поле `col_prop` не является уникальным!
            try {
                $this->validate($request, [
                    'col_prop' => 'unique:freeproperties',
                ]);
            } catch (ValidationException $e) {
                return back()->with('error', trans('messages.cabinet.freeproperties.validUnique'));
            }

        } catch (ValidationException $e) {
            return back()->with('error', trans('messages.cabinet.freeproperties.validError'));
        }

        # ·······································································

        $objFreeProperty = FreeProperty::getInstance();

        $objFreeProperty = $objFreeProperty->create([
            'col_prop'      => $request->input('col_prop'),
            'col_desc'      => $request->input('col_desc'),
            'essences_id'   => $id,
            'user_id'       => \Auth::user()->id,
            'first_author'  => \Auth::user()->id,
        ]);

        # если Объект не NULL, т.е. запись в Таблицу `freeproperties` была успешной
        if(is_object($objFreeProperty)){

            # перенаправляем на страницу Свойств сущности и выводим сообщение
            return redirect()->route('properties', ['id' => $id])->with('success', trans('messages.cabinet.freeproperties.add'));
        } # end IF

        # ::: 'вряд ли мы часто будем попадать на данный return' :::
        # Иначе, возвращаем Пользователя обратно, и выводим соответствующее сообщение
        return back()->with('error', trans('messages.cabinet.freeproperties.addError'));

    } # END addRequest()

    # :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

    # Редактирование Произвольного (Free) Свойства Сущности (принимает $id Сущности, и $prop_id Свойства)
    public function edit(int $id, int $prop_id, $comparison)
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

        # Проверим, существует ли id Сущности, Свойство для которой мы редактируем
        $objEssence = Essence::getInstance();

        # От Объекта Essence - ищём по $id, выбирая тем самым Сущность, с которой работаем
        /*$objEssence = $objEssence->where('id', '=', $id)->first();*/
        $objEssence = $objEssence->find($id);

        # Если в Таблице `essences` - Поле с передаваемым `id` Сущности нет,
        # переадресовываем Пользователя на страницу 404
        if(is_null($objEssence)){
            return abort(404);
        }

        # ·······································································

        $objFreeProperty = FreeProperty::getInstance();
        # Из Таблицы `freeproperties` выбираем по 'id' созданного Free Свойства, получаем Объект
        $freeProperty = $objFreeProperty->find($prop_id);

        # Если в Таблице `freeproperties` - Поле с передаваемым `prop_id` нет,
        # переадресовываем Пользователя на страницу 404
        if(is_null($freeProperty)){
            return abort(404);
        }

        # ·······································································

        $params = [
            'active'        => 'Essences',
            'title'         => 'Property Edit',
            'essenceId'     => $id,
            'objFreeProp'   => $freeProperty,
        ];

        return view('cabinet.freeproperties.edit', $params);

    } # END edit()

    # :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

    # Редактирование Произвольного (Free) Свойства Сущности (Request) (принимает $id Сущности, и $prop_id Свойства)
    public function editRequest(Request $request, int $id, int $prop_id)
    {
        # Проверим, существует ли id Сущности, Свойство для которой мы редактируем
        $objEssence = Essence::getInstance();

        # От Объекта Essence - ищём по $id, выбирая тем самым Сущность, с которой работаем
        $objEssence = $objEssence->find($id);

        # Если в Таблице `essences` - Поле с передаваемым `id` Сущности нет,
        # переадресовываем Пользователя на страницу 404
        if(is_null($objEssence)){
            return abort(404);
        }

        # ·······································································

        $objFreeProperty = FreeProperty::getInstance();
        # Из Таблицы `freeproperties` выбираем по 'id' созданного Free Свойства, получаем Объект
        $freeProperty = $objFreeProperty->find($prop_id);

        # Если в Таблице `freeproperties` - Поле с передаваемым `prop_id` нет,
        # переадресовываем Пользователя на страницу 404
        if(is_null($freeProperty)){
            return abort(404);
        }

        # ·······································································

        # Валидируем данные в Контроллере
        try {

            $this->validate($request, [
                'col_prop' => 'min:3|max:100',
                'col_desc' => 'min:3|max:100',
            ]);

        } catch (ValidationException $e) {

            return back()->with('error', trans('messages.cabinet.freeproperties.validError'));
        }

        # Проверка при редактировании - на уникальность имени Свободного Свойства (кроме самого изменяемого Свойства)
        foreach(FreeProperty::select('id','col_prop')->where('essences_id', '=', $id)->get() as $col_prop){

            if($request->input('col_prop') == $col_prop->col_prop && $freeProperty->id != $col_prop->id){
                return back()->with('error', trans('messages.cabinet.freeproperties.uniquePropError'));
            }
        }

        # ·······································································

        # ActiveRecord
        $freeProperty->col_prop = $request->input('col_prop');

        # ActiveRecord
        $freeProperty->col_desc = $request->input('col_desc');

        # ActiveRecord
        $freeProperty->user_id = \Auth::user()->id;


        # Сохраняем изменения, в БД, через Метод save(), и если save() нам возвращает true, значит у нас данные в БД обновились
        if ($freeProperty->save()) {

            return redirect()->route('properties', ['id' => $id])->with('success', trans('messages.cabinet.freeproperties.edit'));
        }

        # ::: 'вряд ли мы часто будем попадать на данный return' :::
        # Иначе, возвращаем Пользователя на страницу редактирования, с выводом соответствующего сообщения
        return back()->with('error', trans('messages.cabinet.freeproperties.editError'));
    } # END edit()

    # :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

    # Удаление Произвольного (Free) Свойства Сущности
    public function delete(int $id, int $prop_id, $comparison, $cmprsn)
    {
        # Проверка на замену Параметра (id) Сущности в адресной строке
        # Принимая $id (конвертируя в md5) и md5 - $comparison - и добавляя некое string значение
        # мы сравниваем эти 2-а Значения (в результате, чтобы пройти далее, bad user должен знать string добавляемое значение)
        # чтобы сравнения совпали
        if(md5($id).'abc' != $comparison.'abc')
        {
            return back()->with('error', trans('messages.special.one'));
        }
        if(md5($prop_id).'abc' != $cmprsn.'abc')
        {
            return back()->with('error', trans('messages.special.one'));
        }
        # ·······································································

        # ·······································································
        # ·······································································
        # создаём Объект от Модели Essence
        $objFreeProperty = FreeProperty::getInstance();
        #dd($prop_id);
        $objFreeProperty = $objFreeProperty->select('first_author')->where('id', $prop_id)->get();

        # Проверка на Автора Свойства или Root-Администратора или Администратора
        # т.е. если Пользователь Root-Администратор или Администратор, а также isConfirm
        if(\Auth::user()->isAdmin == 1 && \Auth::user()->isConfirm == 1
            || \Auth::user()->root == 1 && \Auth::user()->isConfirm == 1
            || \Auth::user()->id == $objFreeProperty[0]['first_author']) {


            $objFreeProperty = FreeProperty::getInstance();

            # от Объекта Модели, удаляем Свойство (запись в Таблице) по WHERE условию
            $objFreeProperty = $objFreeProperty->where('id', '=', $prop_id)->first();

            if ($objFreeProperty->delete()) {
                return redirect()->route('properties', ['id' => $id])->with('success', trans('messages.cabinet.freeproperties.delete'));
            }

            # ::: 'вряд ли мы часто будем попадать на данный return' :::
            # Иначе, возвращаем Пользователя обратно на страницу, с выводом соответствующего сообщения
            return back()->with('error', trans('messages.cabinet.freeproperties.deleteError'));

        } else {
            # ·······································································
            # ·······································································
            return back()->with('error', trans('messages.special.one'));
        }
    } # END delete()

    # :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

}