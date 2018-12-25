<?php

/* Create by Xenial */

namespace app\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
#use Illuminate\Validation\ValidationException;

# Models
use App\Models\Category;
#use App\Models\CategoryArticle;

# Requests
use App\Http\Requests\CategoryAddRequest;
use App\Http\Requests\CategoryEditRequest;

class CategoriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('cabinet');
    }

    # :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

    # Вывод всех Категорий
    public function index()
    {

        # Для вывода Категорий, нам соответственно понадобиться Модель. Создадим её
        #$objCategory = new Category();
        $objCategory = Category::getInstance();
        # От Объекта Модели используем Метод get(), возвращая все Категории (из Таблицы `categories`) в переменную, и ниже передаём во view()
        $categories = $objCategory->get();

        $params = [
            'active'        => 'Categories',
            'title'         => 'Categories',
            'categories'    => $categories,
        ];

        return view('cabinet.categories.show', $params);
    } # END index()

    # :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

    # Добавление Категорий (wew-форма)
    public function add()
    {
        $params = [
            'active'    => 'Categories',
            'title'     => 'Category Add',
        ];

        # возвращаем view с web-формой добавления
        return view('cabinet.categories.add', $params);
    } # END add()

    # Добавление Категорий (Request)
    # ------------------------------------------------------------
    # ››› php artisan make:request CategoryAddRequest ------------
    # ------------------------------------------------------------
    public function addRequest(/*Request*/CategoryAddRequest $request)
    {
        # Не забудь подключить :: use App\Http\Requests\CategoryAddRequest;

        #dd($request->all());

        # !ˇ Код Валидации в Контроллере - закомментирован, т.к. вынесен в отдельный Request 'CategoryRequest'

# ˇ Логика Валидации ---------------------------------------------------------------------------------------------------
#        # Используем 'быструю' валидацию в Контроллере (а не в Request)
#        # Хотя Валидацию лучше выносить в отдельные файлы Классов Request-ов
#        # Напомним, что так как Validation выбрасывает исключение, опишем try-catch
#        # "try -catch удобно применять, когда в блоке большое количество различных исключений
#        #  однако в нашем случае - исключение только 1-но, это ValidationException,
#        #  поэтому можно было ограничиться и if-ом (т.к. try-catch в 9-10 раз медленнее if-а)
#        #  но мы использовали try-catch, чтобы показать, как можно работать с Исключением,
#        #  например при той же валидации. Данный код будет закомментирован, и Валидация будет вынесена в отдельный Request
#        try {
#            # Валидируем входящие данные (основываясь на том, какие данные обязательны, а какие нет ($fillable Модели))
#            $this->validate($request, [
#                'title' => 'required|string|min:3|max:50',
#                # Поле web-формы заполняет Поле `desc` в Таблице `categories`. Данное поле является не обязательным,
#                # однако, мы можем дополнить validate() правилом для данного Поля Таблицы - как обязательное Поле к заполнению
#                # но ограничимся проверкой на максимальное количество в 100 символов
#                'description' => 'max:100'
#            ]);
#
#            # Также проверим, существует ли уже создаваемая Категория
#            try {
#                $this->validate($request, [
#                    'title' => 'unique:categories'
#                ]);
#            } catch (ValidationException $e) {
#                return back()->with('error', trans('messages.cabinet.categories.errorUnique'));
#            }
# ^ --------------------------------------------------------------------------------------------------------------------

            # ···································································

            # Определяем Модель (подключаем её в use) Создаём Объект данной Модели
            # $objCategory = new Category();
            $objCategory = Category::getInstance(); # Используем Singleton при создании Объекта Модели!

# ˇ Логика Добавления Категории ----------------------------------------------------------------------------------------
#            # Вызываем create(), принимаем данные и записываем в Объект Модели
#            $objCategory = $objCategory->create([
#                'title' => $request->input('title'),
#                'desc' => $request->input('description'),
#            ]);
# ^ --------------------------------------------------------------------------------------------------------------------

        # !^ Перенесём логику добавления в Модель, инициализировав там Метод addCategory(), передав $request как Параметр
            $objCategory = $objCategory->addCategoryModel($request);

            # Проверим, был ли создан Объект Модели
            if(is_object($objCategory)){
                # Редирект на Роут 'categories' в случае успеха
                return redirect()->route('categories')->with('success', trans('messages.cabinet.categories.add'));
            }

            # ::: 'вряд ли мы часто будем попадать на данный return' :::
            # Иначе возвращаем Пользователя обратно, и выводим сообщение о том, что Категория не добавлена
            return back()->with('error', trans('messages.cabinet.categories.errorAdd'));

            # ···································································

# ˇ Логика Валидации ---------------------------------------------------------------------------------------------------
#        } catch (ValidationException $e) {
#            # Если данные для добавляемой Категории - не валидны, мы попадаем в Exception
#            # и выводим сообщение, что Категория не добавлена
#            return back()->with('error', trans('messages.cabinet.categories.errorValidation'));
#        }
# ^ --------------------------------------------------------------------------------------------------------------------

    } # END addRequest()

    # :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

    # Редактирование Категорий (приведём явно к int входящий тип данных)
    # однако, мы в Роуте проверяем, что нам должны приходить только цифры,
    # соответственно проверка на int избыточна, но всё равно реализуем её
    public function edit(int $id)
    {
        # Чтобы не создавать аналогичные Котроллеры для Confirm и Admin, Root Admin,
        # запретим показ Категорий для не их авторов (а в самом Шаблоне, мы соответствующие Категории не показываем)
        # Но это не относиться к Admin и Root Admin
        # ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        if(\Auth::user()->isAdmin == 0 && \Auth::user()->root == 0 && \Auth::user()->isConfirm == 1){
            if(\Auth::user()->id != _category($id)->user_id){
                return redirect(route('categories'))->with('error', trans('messages.special.one'));
            }
        }
        # ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        # find($id) - искать по Ключу
        # мы берём Категорию, которую мы будем редактировать - Обращаясь от Модели к Методу find($id),
        # передавая id Категории (id приходит выше как Параметр).
        # т.е. ищём по Ключу id - нужную нам Категорию, и передаём её в переменную
        $category = Category::find($id);

        # Если данной Категории нет (она не была найдена / возвращена по id)
        if(!$category){
            # перенаправляем Пользователя на страницу 404 (мало ли кто-то подменил параметр в аресной строке)
            return abort(404);
        }

        $params = [
            'active'        => 'Categories',
            'title'         => 'Category Edit',
            'category'      => $category,
        ];

        # Если Категория есть, она будет передана в Шаблон
        return view('cabinet.categories.edit', $params);
    } # END edit()

    # Редактирование Категорий (Request)
    # ------------------------------------------------------------
    # ››› php artisan make:request CategoryEditRequest -----------
    # ------------------------------------------------------------
    # обрати внимание, что 2-м Параметром мы передаём id изменяемой Категории (параметр приходит автоматически)
    public function editRequest(CategoryEditRequest $request, int $id)
    {
        #dd($request->all());

        # ::: logic (проверка на редактирование, чтобы не переименовать Категорию в одноимённую, уже существующую) ::
        $objCategory = Category::getInstance();
        $result = $objCategory->authenticEditCategoryModel($request, $id);
        if($result==true){
            return back()->with('error', trans('messages.cabinet.categories.errorEditUnique'));
        }
        # ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

        $result/*$objCategory*/ = $objCategory->editCategoryModel($request, $id);

        #dd($objCategory);

        # При проверке, Метод save() вернёт нам TRUE или FALSE, т.е. если сохранение было успешным мы получим TRUE, иначе FALSE
        # Можно было для наглядности оставить Метод save() в Контроллере, однако работа с БД должна быть в Модели,
        # поэтому из Модели будем просто возвращать true или false

#        if($objCategory->save()){
#            return redirect()->route('categories')->with('success', trans('messages.cabinet.categories.edit'));
#        }

        if($result==true){
            return redirect()->route('categories')->with('success', trans('messages.cabinet.categories.edit'));
        }

        # ::: 'вряд ли мы часто будем попадать на данный return' :::
        # Иначе, возвращаем Пользователя обратно, с выводом соответствующего сообщения
        return back()->with('error', trans('messages.cabinet.categories.errorEdit'));

    } # END editRequest()

    # :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

    # Удаление Категорий (Входящий параметр Request $request)
    # После выполнения Ajax, по URL мы будем перенаправлены на Роут categories.delete
    public function delete(Request $request)
    {
        # Проверка на Ajax Запрос
        if($request->ajax()) {
            # принимаем id, приведём к числу
            $id = (int)$request->input('id');
            # создаём Объект от Модели Category
            $objCategory = Category::getInstance();
            $objCategory->deleteCategory($id);
        }
    } # END delete()

    # :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
}