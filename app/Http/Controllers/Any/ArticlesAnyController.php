<?php

/* Create by Xenial */

namespace app\Http\Controllers\Any;

use App\Http\Controllers\Controller;
use App\Models\Article;

class ArticlesAnyController extends Controller
{
    # :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

    # Вывод списка Статей
    public function index()
    {
        # Создаём Объект Модели Article
        $objArticle = Article::getInstance();

        $objArticle = $objArticle->get();      # Выбираем все Сущности
        # Если данных нет, выборки не произойдёт, и мы не получим содержимое в Объект
        if(count($objArticle)==0){
            # В этом случае, присвоим null, чтобы отследить это значение в шаблоне
            $articles = null;

        } else {

            # Повторно создаём Объект Модели Article
            $objArticle = Article::getInstance();

            # Выбрать все статьи - отсортируем по id: последние Статьи в начале, и выведем их по 10 на страницу
            # $articles = $objArticle->orderBy('id', 'desc')->paginate(10);
            $articles = $objArticle->orderBy('id', 'desc')->paginate(5);

        }

        $params = [
            'page' => 'list',
            'articles' => $articles,
        ];

        # передадим в Шаблон, подготовленные на вывод Статьи
        return view('any.articles.articlesCatalog', $params);
    } # END index()

    # :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

    # Вывод отдельной Статьи (напомним, что в данном случае, slug мы не используем)
    public function showArticle(int $id, $slug)
    {
        # Получаем статью (выборка из БД по Ключу)
        $objArticle = Article::find($id);
        if(!$objArticle) {
            # если id не найден, то выбрасываем HTTP исключение, заканчивая Запрос, и возвращая 404
            return abort(404);
        }

        # Смотрим Объект Комментария
        # dd($objArticle->comments);

        # получаем Объект Комментария, т.е. сами данные Комментария
        # $comments = $objArticle->comments;

        # Метод comments() - это не Метод, а Коллекция Объекта $objArticle (Свойство / см . dd() выше)
        # мы получаем в переменную $comments - все комментарии, у которых status == 1,
        # и после того, как мы от Свойства 'comments' указали круглые скобки,
        # мы можем над Коллекцией Объектов в Свойстве comments,
        # с данной Коллекцией проводить операции разного рода
        # ›››››› Обратие внимание, что в Таблице `articles` нет Поля `comments`
        # ›››››› но Поле нам возвращается, за счёт указания Связи в Модели Article (Пользовательский comments() Метод)!
        $comments = $objArticle->comments()->where('status', 1)->get();

        # Смотрим результат работы с Коллекцией
        # dd($comments);

        $params = [
            'page' => 'article',
            'article' => $objArticle,
            'comments' => $comments,
        ];

        # передаём Статьи, которые прошли Модерацию
        return view('any.articles.article', $params);

    } # END showArticle()

    # :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
}