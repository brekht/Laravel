<?php

/* Create by Xenial ~ artisan */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    # ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    # т.к. логика по добавлению данных - теперь будет в Модели, есть смысл использовать Singleton
    # чтобы не создавать Объект Модели постоянно, а использовать только 1-н единственный Объект в CategoriesController
    static $_instance;

    public static function getInstance() {
        if(!(self::$_instance instanceof self))
            self::$_instance = new self();
        return self::$_instance;
    }

    private function __clone() {}
    # ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

    # ···································································

    protected $table = 'categories';
    protected $primaryKey = 'id';

    # 'что мы будем массово заполнять'
    protected $fillable = [
        'title', 'desc', 'user_id',
    ];

    protected $dates = [
        'created_at', 'updated_at'
    ];

    # ···································································

    # Перенос Логики в Модель, только ради того чтобы Методы get(),find()
    # находились в Модели - не имеет смысла, т.к. создавать 'обёртку' на данные
    # Методы - как отдельный Метод, инициализируя его в Модели, и вызывая в
    # Контроллере, создаст фактически ту же самую ситуацию, что и
    # непосредственно прямой вызов get(),find()

    # Однако, если логика по работе с Моделью больше чем 2-е строки кода,
    # напримере Методов create() и save() - тогда есть смысл вынести код в Модель.

    # Если мы совмещаем Методы get(),find() - с другим логически связанным кодом,
    # есть смысл также вынести логику в Модель

    # "Правильнее, вынести Запись в БД в Модель"

    # ···································································

    public function addCategoryModel($request)
    {
        # Вызываем create(), принимаем данные и записываем в Объект Модели
        $objCategory = $this->create([
            'title' => $request->input('title'),
            'desc' => $request->input('description'),
            'user_id' => \Auth::user()->id
        ]);

        return $objCategory;
    }

    # ···································································

    # My User Method
    # (проверка на редактирование, чтобы не переименовать Категорию в одноимённую, уже существующую)
    public function authenticEditCategoryModel($request, $id)
    {
        # От Объекта Модели используем Метод get(), возвращая все Категории (из Таблицы `categories`) в переменную
        $categories = $this->get();

        # Возвращаем title редактируемой Категории (данные из web-формы)
        $title = $request->input('title');

        # Перебираем Категории, а именно все title -
        foreach($categories as $category){
            # - сравнивая с введённым title редактируемой Категории, при условии что это не текущая редактируемая Категория
            if($category->title == $title && $category->id != $id){
                return true;
            }
        }
    }

    # ···································································

    public function editCategoryModel($request, $id)
    {
        # Выбираем Категорию, которую мы будем редактировать
        #$objCategory = Category::find($id);
        $objCategory = $this->find($id);

        # ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
        # Обновим мы её с помощью Объекта ActiveRecord
        # (ActiveRecord - это Шаблон Проектирования) а именно, что из себя представляет ActiveRecord в Laravel:

        # от Объекта Модели, полученного по id, мы можем напрямую обратиться к Свойствам:
        # обращаемся к Свойству title (записывая в него), и присваиваем выборку от Request
        # получая входящие данные через input(), обращаясь к Полю 'title' в Параметре
        $objCategory->title = $request->input('title');
        # то же самое и с Полем 'description'
        $objCategory->desc = $request->input('description');
        # и с Полем 'user_id'
        $objCategory->user_id = \Auth::user()->id;

        # ! Стоит сказать несколько слов про ActiveRecord: мы не любим ActiveRecord - потому что он не годится для крупных проектов!
        # ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

        # Сохраняем данные, которые изменяли
        if($objCategory->save()){
            return true;
        }
    }

    # ···································································

    public function deleteCategory($id)
    {
        # ···································································
        # создаём Объект от Модели CategoryArticle
        $objCategoryArticle = CategoryArticle::getInstance();

        # От Объекта Модели используем Метод get(), возвращая все Категории (из Таблицы `category_articles`) в переменную
        $categoryArticle = $objCategoryArticle->get();

        # В цикле проверим - перед удалением Категории, используется ли данная удаляемая Категория
        # в Таблице `category_articles`, как Внешний Ключ, т.е. проверим,
        # используется ли удаляемая Категория в отдельной Статье
        # Перебираем Категории, а именно все title -
        foreach($categoryArticle as $category){
            if($category->category_id == $id){
                return back()->with('error', trans('messages.cabinet.categories.fkConstraint'));
            }
        }
        # ···································································

        # от Объекта Модели, удаляем Категорию (запись в Таблице) по WHERE условию
        # с помощью Метода where(), передав в него 1-м Параметром имя искомого Поля,
        # а 2-м Значением непосредственно id
        $this->where('id', $id)->delete();
        return back()->with('success', trans('messages.cabinet.categories.delete'));
    }
}
