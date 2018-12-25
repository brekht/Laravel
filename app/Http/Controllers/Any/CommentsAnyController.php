<?php

/* Create by Xenial */

namespace app\Http\Controllers\Any;

use App\Http\Controllers\Controller;

# Models
use App\Models\Comment;

# Requests
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CommentsAnyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    # :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

    # Добавление Комментария (!!! В данном случае, мы не будем выносить Валидацию в отдельный Request - для наглядности !!!)
    public function addComment(Request $request)
    {
        #dd($request->all());

        # Валидируем данные в Контроллере
        try {
            $this->validate($request, [
                'comment' => 'required|string|min:2|max:255',
                'article_id' => 'required|integer',
            ]);
        } catch (ValidationException $e) {
            return back()->with('error', trans('messages.any.comments.validate'));
        }

        # принимая Комментарий с web-формы, у данного поля тип textarea, и name="comment"
        $comment = $request->input('comment');

        # принимая `article_id` с web-формы, type="hidden" в web-форме, у которой name="article_id"
        $article_id = (int)$request->input('article_id');

        # "Пользователя мы получаем автоматически при авторизации" ~ или можно так: \Auth::user()->id
        $user_id = auth()->user()->id;

        # Создаём Объект Модели Comment
        $objComment = new Comment();

        # (!!! В данном случае, мы не будем выносить логику по добавлению данных в БД в Модель Comment - для наглядности !!!)

        # Записываем данные в Таблицу `comments` (а Поле `status` у нас default(false) ~ его Значение изменяем в CommentsController)
        $objComment = $objComment->create([
            'article_id' => $article_id,
            'user_id' => $user_id,
            'comment' => $comment
        ]);

        # "... если операция добавления данных в Таблицу - прошла успешно, то $objComment - будет содержать Объект (уже добавленный),
        # а если не будет содержать Объект, соответственно данные не будут добавлены в Таблицу, в этом случае $objComment - будет содержать NULL !"
        if($objComment) {
            # Если данные были добавлены - возвращаем Пользователя на страницу Статьи,
            # где в случае положительной Модерации Комментария - данный Комментарий будет показан
            # и уведомляем Пользователя о том, что Комментарий добавлен, но должен пройти модерацию
            return back()->with('success', trans('messages.any.comments.add'));
        }

        # ::: 'вряд ли мы часто будем попадать на данный return' :::
        # Иначе, если данные не добавлены, также возвращаем Пользователя обратно и уведомляем его об не успешном добавлении
        return back()->with('error', trans('messages.any.comments.errorAdd'));

    } # END addComment()

    # :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
}