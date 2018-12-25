<?php

/* Create by Xenial */

namespace app\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;

# Models
use App\Models\Essence;
use App\Models\NumProperty;
use App\Models\DescProperty;
use App\Models\ImgProperty;
use App\Models\FreeProperty;

# Requests
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PropertiesController extends Controller
{
    public function __construct()
    {
        $this->middleware('cabinet');
    }

    # :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

    # Вывод Свойств Сущностей (принимает id Сущности, и передав данный id в Шаблон, на основе этого мы получаем Свойства к конкретной Сущности)
    public function show(int $id)
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

        # ·······································································

        # Проверка на входящий id сущности
        $objEssence = Essence::getInstance();

        $objEssence = $objEssence->find($id);
        if(!$objEssence) {
            return abort(404);
        }

        # ·······································································

        # Объект Num
        $objNumProperty  = NumProperty::getInstance();
        $numProperty  = $objNumProperty->where('essences_id', '=', $id)->first();
        if(is_null($numProperty)){
            # Получаем Объект Повторно
            $numProperty = NumProperty::getInstance();
        }

        # Объект Desc
        $objDescProperty = DescProperty::getInstance();
        $descProperty = $objDescProperty->where('essences_id', '=', $id)->first();
        if(is_null($descProperty)){
            # Получаем Объект Повторно
            $descProperty = DescProperty::getInstance();
        }

        # Объект Img
        $objImgProperty  = ImgProperty::getInstance();
        $imgProperty  = $objImgProperty->where('essences_id', '=', $id)->first();
        if(is_null($imgProperty)){
            # Получаем Объект Повторно
            $imgProperty = ImgProperty::getInstance();
        }

        # Объект Free Property
        $objFreeProperty  = FreeProperty::getInstance();
        # Выберем все записи из Таблицы `freeproperties`, где `essence_id` это id сущности, с которой мы работаем
        $freeProperty  = $objFreeProperty->where('essences_id', '=', $id)->get();
        if(is_null($freeProperty)){
            # Получаем Объект Повторно
            $freeProperty = FreeProperty::getInstance();
        }

        $params = [
            'active'        => 'Essences',
            'title'         => 'Properties',
            'essenceId'     => $id,
            'numObj'        => $numProperty,
            'descObj'       => $descProperty,
            'imgObj'        => $imgProperty,
            'freePropObj'   => $freeProperty,
            'comparison'    => md5($id),        /* md5 id сущности, для дальнейшей проверки при проходе на редактируемое свойство сущности */
        ];

        return view('cabinet.properties.show', $params);

    } # END show()

    # :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    # :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    # :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    # :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    # :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

    # Редактирование Свойства Num
    public function editNum(int $id, $comparison)
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

        $objNumProperty = NumProperty::getInstance();
        # Из Таблицы `num_property` выбираем по Уникальному 'essences_id', получаем Объект
        $objNumProperty = $objNumProperty->where('essences_id', '=', $id)->first();

        # Если в Таблице `num_property` - Поле `essences_id` ещё не имеет значение,
        # т.е. записи Свойства ещё не происходило, значит выборка вернёт NULL,
        # мы не сможем работать с конкретным Объектом, поэтому получаем Объект Повторно
        if(is_null($objNumProperty)){
            # Получаем Объект Повторно
            $objNumProperty = NumProperty::getInstance();
        }

        $params = [
            'active'    => 'Essences',
            'title'     => 'Num Property Edit',
            'essenceId' => $id,
            'num'       => $objNumProperty->num,
        ];

        return view('cabinet.properties.num.edit', $params);

    } # END editNum()

    # :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

    # Редактирование Свойства Num (Request)
    public function editNumRequest(Request $request, int $id)
    {
        # Валидация в Контроллере

        # Если это не число или null
        if(!is_numeric($request->input('num')) || $request->input('num') == NULL){
            return back()->with('error', trans('messages.cabinet.properties.numValidError'));
        }

        # Если число отрицательное
        if($request->input('num') < 0){
            return back()->with('error', trans('messages.cabinet.properties.numValidError'));
        }

        try {

            $this->validate($request, [ /* ****                 */
                'num' => 'min:1|max:4', /* 32765 = 5 symbols    */
            ]);

        } catch (ValidationException $e) {

            return back()->with('error', trans('messages.cabinet.properties.numValidError'));
        }

        # ·······································································

        # Получаем Объект
        $objNumProperty = NumProperty::getInstance();

        # Выбираем по `essences_id`, т.к. нам приходит id - это essences_id, и essences_id Уникальное Значение
        $objNumProperty = $objNumProperty->where('essences_id', '=', $id)->first();

        # · · ·

        # Узнаем, было ли уже добавление Значения num или ещё нет
        $saved = (is_null($objNumProperty) || $objNumProperty->num == null) ? null : 1;

        # · · ·

        # Если в Таблице `num_property` - Поле `essences_id` ещё не имеет значение,
        # т.е. записи Свойства ещё не происходило, значит выборка вернёт NULL,
        # мы не сможем работать с конкретным Объектом, поэтому получаем Объект Повторно
        if(is_null($objNumProperty)){
            # Получаем Объект Повторно
            $objNumProperty = NumProperty::getInstance();
        }

        # ActiveRecord
        $objNumProperty->num = $request->input('num');

        # ActiveRecord
        if($objNumProperty->essences_id == NULL){
            $objNumProperty->essences_id = $id;
        }

        # ActiveRecord
        $objNumProperty->user_id = \Auth::user()->id;

        # ActiveRecord
        if($objNumProperty->first_author == NULL){
            $objNumProperty->first_author = \Auth::user()->id;
        }

        # Save
        if ($objNumProperty->save()) {

            if($saved == null){
                return redirect()->route('properties', ['id' => $id])->with('success', trans('messages.cabinet.properties.numAdd'));
            } else {
                return redirect()->route('properties', ['id' => $id])->with('success', trans('messages.cabinet.properties.numAddChange'));
            }
        }

        # ::: 'вряд ли мы часто будем попадать на данный return' :::
        # Иначе, возвращаем Пользователя на страницу редактирования, с выводом соответствующего сообщения
        return back()->with('error', trans('messages.cabinet.properties.numAddError'));

    } # END editNumRequest()

    # :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

    # Очистить Значение Свойства Num (Входящий параметр Request $request)
    public function clearNum(Request $request)
    {
        # Проверка на Ajax Запрос
        if($request->ajax()) {
            # принимаем id, приведём к числу
            $id = (int)$request->input('id');

            # Получаем Объект
            $objNumProperty = NumProperty::getInstance();

            # Из Таблицы `num_property` выбираем по `essences_id`, т.к. нам приходит id - это essences_id, и essences_id Уникальное Значение
            $objNumProperty = $objNumProperty->where('essences_id', '=', $id)->first();


                # Если в Таблице `num_property` - Поле `essences_id` ещё не имеет значение,
                # т.е. записи Свойства ещё не происходило, значит выборка вернёт NULL,
                # мы не сможем работать с конкретным Объектом, соответственно, очищать нечего!
                # Перенаправим пользователя обратно, и выведем соответствующее сообщение
                if(is_null($objNumProperty)){
                    return back()->with('error', trans('messages.cabinet.properties.numIsClear'));
                }


            if ($objNumProperty->delete()) {
                return redirect()->route('properties', ['id' => $id])->with('success', trans('messages.cabinet.properties.numClear'));
            }

            # ::: 'вряд ли мы часто будем попадать на данный return' :::
            # Иначе, возвращаем Пользователя обратно на страницу, с выводом соответствующего сообщения
            return back()->with('error', trans('messages.cabinet.properties.numClearError'));
        }

    } # END clearNum()

    # :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    # :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    # :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    # :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    # :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

    # Редактирование Свойства Desc
    public function editDesc(int $id, $comparison)
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

        $objDescProperty = DescProperty::getInstance();
        # Из Таблицы `desc_property` выбираем по Уникальному 'essences_id', получаем Объект
        $objDescProperty = $objDescProperty->where('essences_id', '=', $id)->first();

        # Если в Таблице `desc_property` - Поле `essences_id` ещё не имеет значение,
        # т.е. записи Свойства ещё не происходило, значит выборка вернёт NULL,
        # мы не сможем работать с конкретным Объектом, поэтому получаем Объект Повторно
        if(is_null($objDescProperty)){
            # Получаем Объект Повторно
            $objDescProperty = DescProperty::getInstance();
        }

        $params = [
            'active' => 'Essences',
            'title' => 'Desc Property Edit',
            'essenceId' => $id,
            'desc' => $objDescProperty->desc,
        ];

        return view('cabinet.properties.desc.edit', $params);

    } # END editDesc()

    # :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

    # Редактирование Свойства Desc (Request)
    public function editDescRequest(Request $request, int $id)
    {

        # Если это null
        if($request->input('desc') == NULL){
            return back()->with('error', trans('messages.cabinet.properties.descValidError'));
        }

        try {

            $this->validate($request, [
                'desc' => 'min:3|max:100',
            ]);

        } catch (ValidationException $e) {

            return back()->with('error', trans('messages.cabinet.properties.descValidError'));
        }

        # ·······································································

        # Получаем Объект
        $objDescProperty = DescProperty::getInstance();

        # Выбираем по `essences_id`, т.к. нам приходит id - это essences_id, и essences_id Уникальное Значение
        $objDescProperty = $objDescProperty->where('essences_id', '=', $id)->first();

        # · · ·

        # Узнаем, было ли уже добавление Значения desc или ещё нет
        $saved = (is_null($objDescProperty) || $objDescProperty->desc == null) ? null : 1;

        # · · ·

        # Если в Таблице `desc_property` - Поле `essences_id` ещё не имеет значение,
        # т.е. записи Свойства ещё не происходило, значит выборка вернёт NULL,
        # мы не сможем работать с конкретным Объектом, поэтому получаем Объект Повторно
        if(is_null($objDescProperty)){
            # Получаем Объект Повторно
            $objDescProperty = DescProperty::getInstance();
        }

        # ActiveRecord
        $objDescProperty->desc = $request->input('desc');

        # ActiveRecord
        if($objDescProperty->essences_id == NULL){
            $objDescProperty->essences_id = $id;
        }

        # ActiveRecord
        $objDescProperty->user_id = \Auth::user()->id;

        # ActiveRecord
        if($objDescProperty->first_author == NULL){
            $objDescProperty->first_author = \Auth::user()->id;
        }

        # Save
        if ($objDescProperty->save()) {

            if($saved == null){
                return redirect()->route('properties', ['id' => $id])->with('success', trans('messages.cabinet.properties.descAdd'));
            } else {
                return redirect()->route('properties', ['id' => $id])->with('success', trans('messages.cabinet.properties.descAddChange'));
            }
        }

        # ::: 'вряд ли мы часто будем попадать на данный return' :::
        # Иначе, возвращаем Пользователя на страницу редактирования, с выводом соответствующего сообщения
        return back()->with('error', trans('messages.cabinet.properties.descAddError'));

    } # END editDescRequest()

    # :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

    # Очистить Значение Свойства Desc (Входящий параметр Request $request)
    public function clearDesc(Request $request)
    {
        # Проверка на Ajax Запрос
        if($request->ajax()) {
            # принимаем id, приведём к числу
            $id = (int)$request->input('id');

            # Получаем Объект
            $objDescProperty = DescProperty::getInstance();

            # Из Таблицы `desc_property` выбираем по `essences_id`, т.к. нам приходит id - это essences_id, и essences_id Уникальное Значение
            $objDescProperty = $objDescProperty->where('essences_id', '=', $id)->first();


                # Если в Таблице `desc_property` - Поле `essences_id` ещё не имеет значение,
                # т.е. записи Свойства ещё не происходило, значит выборка вернёт NULL,
                # мы не сможем работать с конкретным Объектом, соответственно, очищать нечего!
                # Перенаправим Пользователя обратно, и выведем соответствующее сообщение
                if(is_null($objDescProperty)){
                    return back()->with('error', trans('messages.cabinet.properties.descIsClear'));
                }


            if ($objDescProperty->delete()) {
                return redirect()->route('properties', ['id' => $id])->with('success', trans('messages.cabinet.properties.descClear'));
            }

            # ::: 'вряд ли мы часто будем попадать на данный return' :::
            # Иначе, возвращаем Пользователя обратно на страницу, с выводом соответствующего сообщения
            return back()->with('error', trans('messages.cabinet.properties.descClearError'));
        }

    } # END clearDesc()

    # :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    # :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    # :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    # :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    # :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

    # Загрузка Изображения - как Свойства Img (Request)
    public function uploadImgRequest(Request $request, int $id, $comparison)
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

        if($request->isMethod('post')){

            # Проверка: загружается ли файл, т.е. выбран ли он
            if($request->hasFile('image')) {

                # Принимаем Request
                $file = $request->file('image');

                # -------------------------------
                /*
                    # Имя файла ››› 4D7E935A32D5-23.gif
                        echo 'File Name: ' . $file->getClientOriginalName() , '<br>';

                    # Расширение файла ››› gif
                        echo 'File Extension: ' . $file->getClientOriginalExtension() , '<br>';

                    # Фактический путь к файлу ››› /tmp/phpZxDy59
                        echo 'File Real Path: ' . $file->getRealPath() , '<br>';

                    # Размер файла ››› 226373
                        echo 'File Size: ' . $file->getSize() , '<br>';

                    # Mime-тип файла ››› image/gif ››› image/png ››› image/jpeg
                         echo 'File Mime Type: ' . $file->getMimeType();

                    die;
                */
                # -------------------------------

                # Если загружаемый файл не gif, не png и не jpeg, тогда back() и соответствующее уведомление Пользователю
                if( $file->getMimeType() == 'image/gif' ||
                    $file->getMimeType() == 'image/png' ||
                    $file->getMimeType() == 'image/jpeg')
                {

                } else {
                    return back()->with('error', trans('messages.cabinet.properties.imgValidError'));
                }

                # Инициализируем переменную, которая будет хранить имя загружаемого изображения,
                # т.к. имя будет генерирповаться автоматически, и будет длинной 25 символов
                # Создание рандомного имени - выполняет хелпер _randImgName(), а также добавляем расширение файла
                $image_name = _randImgName().'.'.$file->getClientOriginalExtension();

            } else {

                return back()->with('error', trans('messages.cabinet.properties.imgNoSelected'));
            }

        } # end if($request->isMethod('post')){

        # ----------------------------------------------------------------------------

        # После, фактически, валидации (проверки на тип: изображение)
        # есть смысл провести ещё одну проверку на уникальное сгенерированное имя для изображения,
        # однако, данная валидация условна, т.к. в хелпере, после того, как имя сгенерировано,
        # мы проверяем его на уникальность - в результате повторяющееся имя не сможет быть сгенерировано!

        # ----------------------------------------------------------------------------

        # Далее, запишем данные в БД, и созраним изображение

        # Получаем Объект
        $objImgProperty = ImgProperty::getInstance();

        # Выбираем по `essences_id`, т.к. нам приходит id - это essences_id, и essences_id Уникальное Значение
        $objImgProperty = $objImgProperty->where('essences_id', '=', $id)->first();

        # Получим имя изображения, которое соответствует сущности # # #
        if(!is_null($objImgProperty)) {
            $removeImage = $objImgProperty->img;
        }
        # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #

        # · · ·

        # Узнаем, было ли уже добавление Значения img или ещё нет (загружалась ли картинка или нет)
        $saved = (is_null($objImgProperty) || $objImgProperty->img == null) ? null : 1;

        # · · ·

        # Если в Таблице `img_property` - Поле `essences_id` ещё не имеет значение,
        # т.е. записи Свойства ещё не происходило, значит выборка вернёт NULL,
        # мы не сможем работать с конкретным Объектом, поэтому получаем Объект Повторно
        if(is_null($objImgProperty)){
            # Получаем Объект Повторно
            $objImgProperty = ImgProperty::getInstance();
        }

        # ActiveRecord
        $objImgProperty->img = $image_name;

        # ActiveRecord
        if($objImgProperty->essences_id == NULL){
            $objImgProperty->essences_id = $id;
        }

        # ActiveRecord
        $objImgProperty->user_id = \Auth::user()->id;

        # ActiveRecord
        if($objImgProperty->first_author == NULL){
            $objImgProperty->first_author = \Auth::user()->id;
        }

        # Upload (Перемещаем загруженный файл и присваиваем ему имя, которое мы генерировали выше)
        if ($file->move(public_path() . '/images/', $image_name)) {

            # Save
            if ($objImgProperty->save()) {

                if($saved == null){
                    # Изображение добавлено 1-й раз
                    return redirect()->route('properties', ['id' => $id])->with('success', trans('messages.cabinet.properties.imgAdd'));
                } else {

                    # Физически удаляем картинку с Сервера # # # # # # # # # #
                    unlink(public_path() . '/images/' . $removeImage);
                    # # # # # # # # # # # # # # # # # # # # # # # # # # # # #

                    # Изображение измененено
                    return redirect()->route('properties', ['id' => $id])->with('success', trans('messages.cabinet.properties.imgAddChange'));
                }
            }
        }
        # ::: 'вряд ли мы часто будем попадать на данный return' :::
        # Иначе, возвращаем Пользователя на страницу редактирования, с выводом соответствующего сообщения
        return back()->with('error', trans('messages.cabinet.properties.imgAddError'));

    } # END uploadImgRequest()

    # :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

    # Очистить Значение Свойства Img (Входящий параметр Request $request)
    # через Удаление соответствующей записи из БД `img_property`
    # и физическое удаление самого изображения с сервера
    public function clearImg(Request $request)
    {
        # Проверка на Ajax Запрос
        if($request->ajax()) {
            # принимаем id, приведём к числу
            $id = (int)$request->input('id');

            # Получаем Объект
            $objImgProperty = ImgProperty::getInstance();

            # Из Таблицы `img_property` выбираем по `essences_id`, т.к. нам приходит id - это essences_id, и essences_id Уникальное Значение
            $objImgProperty = $objImgProperty->where('essences_id', '=', $id)->first();

            # Получим имя изображения, которое соответствует сущности # # #
            if(!is_null($objImgProperty)) {
                $removeImage = $objImgProperty->img;
            }
            # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #


                # Если в Таблице `img_property` - Поле `essences_id` ещё не имеет значение,
                # т.е. записи Свойства ещё не происходило, значит выборка вернёт NULL,
                # мы не сможем работать с конкретным Объектом, соответственно, очищать нечего!
                # Перенаправим Пользователя обратно, и выведем соответствующее сообщение
                if(is_null($objImgProperty)){
                    return back()->with('error', trans('messages.cabinet.properties.imgIsClear'));
                }


            if ($objImgProperty->delete()) {

                # Физически удаляем картинку с Сервера # # # # # # # # # #
                unlink(public_path() . '/images/' . $removeImage);
                # # # # # # # # # # # # # # # # # # # # # # # # # # # # #

                return redirect()->route('properties', ['id' => $id])->with('success', trans('messages.cabinet.properties.imgClear'));
            }

            # ::: 'вряд ли мы часто будем попадать на данный return' :::
            # Иначе, возвращаем Пользователя обратно на страницу, с выводом соответствующего сообщения
            return back()->with('error', trans('messages.cabinet.properties.imgClearError'));
        }
    } # END clearImg()

    # :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

}