<?php

/* Create by Xenial */

namespace app\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;

# Models
use App\Models\Category;
use App\Models\Article;
#use App\Models\CategoryArticle;

# Requests
use Illuminate\Http\Request;
use App\Http\Requests\ArticleRequest;

class ArticlesController extends Controller
{
    public function __construct()
    {
        $this->middleware('cabinet');
    }

    # :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

    # Вывод Статей
    public function index()
    {

        $objArticle = Article::getInstance();
        $articles = $objArticle->get();

        $params = [
            'active'    => 'Articles',
            'title'     => 'Articles',
            'articles'  => $articles,
        ];

        return view('cabinet.articles.show', $params);

    } # END index()

    # :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

    # Добавление Статей (wew-форма)
    public function add()
    {
        $objCategory = Category::getInstance();
        # Выбираем все Категории
        $categories = $objCategory->get();

        #dd($categories);

        $params = [
            'active'    => 'Articles',
            'title'     => 'Article Add',
            'categories'  => $categories,
        ];

        return view('cabinet.articles.add', $params);
    } # END add()

    # :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

    # Добавление Статей (Request)
    # ------------------------------------------------------------
    # ››› php artisan make:request ArticleRequest ----------------
    # ------------------------------------------------------------
    public function addRequest(ArticleRequest $request)
    {
        $objArticle = Article::getInstance();
        $objArticle = $objArticle->addArticleModel($request);

        # если Объект не NULL, т.е. запись в Таблицу `articles` была успешной
        if(is_object($objArticle)){

            $objArticle->addCategoryArticleModel($request, $objArticle);

            # перенаправляем на страницу Статей, с выводом соответствующего сообщения
            return redirect()->route('articles')->with('success', trans('messages.cabinet.articles.add'));
        } # end IF

        # ::: 'вряд ли мы часто будем попадать на данный return' :::
        # Иначе, возвращаем Пользователя обратно, и выводим сообщение, что 'Не удалось добавить статью'
        return back()->with('error', trans('messages.cabinet.articles.errorAdd'));

    } # END addRequest()

    # :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

    # Редактирование Статей
    # (приведём явно к int входящий тип данных - id редактируемой Статьи)
    public function edit(int $id)
    {
        # Чтобы не создавать аналогичные Котроллеры для Confirm и Admin, Root Admin,
        # запретим показ Статей для не их авторов (а в самом Шаблоне, мы соответствующие Статьи не показываем)
        # Но это не относиться к Admin и Root Admin
        # ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        if(\Auth::user()->isAdmin == 0 && \Auth::user()->root == 0 && \Auth::user()->isConfirm == 1){
            if(\Auth::user()->id != _article($id)->user_id){
                return redirect(route('articles'))->with('error', trans('messages.special.one'));
            }
        }
        # ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        $objArticle = Article::getInstance();
        $arrayData = $objArticle->editArticleModel($id);

        if($arrayData=='404'){
            # возвращаем 404 Ошибку
            return abort(404);
        }

        $params = [
            'active'        => 'Articles',
            'title'         => 'Article Edit',
            'categories'    => $arrayData['categories'],     # все Категории (Объект со Свойствами)
            'article'       => $arrayData['objArticle'],     # выбранная Статья
            'arrCategories' => $arrayData['arrCategories']   # Массив изначально выбранных id Категорий к Статье
        ];

        # в шаблон на редактирование, передаём:
        return view('cabinet.articles.edit', $params);

    } # END edit()

    # :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

    # Редактирование Статей (Request)
    # повторно используем созданную нами Валидацию, и также принимаем id Статьи
    public function editRequest(ArticleRequest $request, int $id)
    {
        #dd($request->all());

        $objArticle = Article::getInstance();
        $result = $objArticle->editArticleModelRequest($request, $id);

        if($result==true) {
            # и в окончании, мы переадресовываем Пользователя на страницу Статей, и пишем, что Статья успешно обновлена
            return redirect()->route('articles')->with('success', trans('messages.cabinet.articles.edit'));
        } else {

            # ::: 'вряд ли мы часто будем попадать на данный return' :::
            # Иначе, возвращаем Пользователя на страницу редактирования, с выводом соответствующего сообщения
            return back()->with('error', trans('messages.cabinet.articles.errorEdit'));
        }

    } # END editRequest()

    # :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

    # Удаление Статей (Входящий параметр Request $request)
    public function delete(Request $request)
    {
        # Проверка на Ajax Запрос
        if($request->ajax()) {
            # принимаем id, приведём к числу
            $id = (int)$request->input('id');
            # создаём Объект от Модели Article
            $objArticle = Article::getInstance();

            # от Объекта Модели, удаляем Статью (запись в Таблице) по WHERE условию
            # с помощью Метода where(), передав в него 1-м Параметром имя искомого Поля,
            # а 2-м Значением непосредственно id
            $objArticle->where('id', $id)->delete();
        }
    } # END delete()

    # :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
}