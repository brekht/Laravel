<?php

/* Create by Xenial */
# ADMIN COMMENTS CONTROLLER

namespace app\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;

# Models
use App\Models\Comment;

# Requests
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CommentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('cabinet');
    }

    # :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

    # Вывод списка Комментариев
    public function index()
    {
        # От Модели, получаем все Комментарии (обрати внимание: опять используем сокращённую запись)
        $comments = (new Comment())->get();

        $params = [
            'active'    => 'Comments',
            'title'     => 'Comments',
            'comments' => $comments
        ];

        return view('cabinet.comments.show', $params);

    } # END index()

    # :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

    # Модерация Комментария
    public function acceptComment($id)
    {
        # "сделаем просто" от DB (не от Модели), обратимся к Таблице `comments`,
        # и обновим Поле, значением, которое данное Поле может принимать!
        \DB::table('comments')->where('id', $id)->update(['status' => true]);

        # Возвращаем пользователя на ту же страницу (возвращаем назад)
        return back()->with('success', trans('messages.cabinet.comments.moderation'));

    } # END acceptComment()

    # :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

    # Редактирование Комментария
    public function edit(int $id)
    {
        # Чтобы не создавать аналогичные Котроллеры для Cabinet, Admin и Root Admin,
        # запретим показ Комментариев для не их авторов (а в самом Шаблоне, мы соответствующие Комментарии не показываем)
        # Но это не относиться к Admin и Root Admin
        # ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        if(\Auth::user()->isAdmin == 0 && \Auth::user()->root == 0 && \Auth::user()->isConfirm == 1){
            if(\Auth::user()->id != _comment($id)->user_id){
                return redirect(route('comments'))->with('error', trans('messages.special.one'));
            }
        }
        # ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        $objComment = Comment::getInstance();

        # От Объекта Comment - ищём по Ключу $id, выбирая тем самым редактируемый Комментарий
        $objComment = $objComment->find($id);

        if(!$objComment) {            # Если данного Объекта нет (т.е. Комментарий не найден)
            return abort(404);  # тогда возвращаем 404 Ошибку
        }

        $params = [
            'active'    => 'Comments',
            'title'     => 'Comments Edit',
            'comment'   => $objComment,
        ];

        # в шаблон на редактирование, передаём:
        return view('cabinet.comments.edit', $params);

    } # END edit()

    # :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

    # Редактирование Комментария (Request)
    #   !!! В данном случае, мы не будем выносить Валидацию в отдельный Request - для наглядности !!!
    #   !!! и также - для наглядности, мы не будем выносить логику редактирования Комментария в Модель Comment !!!
    public function editRequest(Request $request, int $id)
    {
        #dd($request->all());

        # Валидируем данные в Контроллере
        try {
            $this->validate($request, [
                'commentedit' => 'required|max:255',
            ]);
        } catch (ValidationException $e) {
            return back()->with('error', trans('messages.cabinet.comments.validate'));
        }

        $objComment = Comment::getInstance();

        # От Объекта Comment - ищём по Ключу $id, выбирая тем самым редактируемый Комментарий
        $objComment = $objComment->find($id);

        # ActiveRecord (по Полю, обновляем Комментарий)
        # принимаем данные, записываем в Свойство Объекта
        $objComment->comment = $request->input('commentedit');


        # Сохраняем изменения, в БД, через Метод save(), и если save() нам возвращает true, значит у нас данные в БД обновились
        if ($objComment->save()) {
            return redirect()->route('comments')->with('success', trans('messages.cabinet.comments.edit'));
        }

        # ::: 'вряд ли мы часто будем попадать на данный return' :::
        # Иначе, возвращаем Пользователя на страницу редактирования, с выводом соответствующего сообщения
        return back()->with('error', trans('messages.cabinet.comments.errorEdit'));

    } # END editRequest()

    # :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

    # Удаление Комментария (Входящий параметр Request $request)
    public function delete(Request $request)
    {
        # Проверка на Ajax Запрос
        if($request->ajax()) {
            # принимаем id, приведём к числу
            $id = (int)$request->input('id');
            # создаём Объект от Модели Comment
            $objComment = Comment::getInstance();

            # от Объекта Модели, удаляем Комментарий (запись в Таблице) по WHERE условию
            # с помощью Метода where(), передав в него 1-м Параметром имя искомого Поля,
            # а 2-м Значением непосредственно id
            $objComment->where('id', $id)->delete();
        }
    } # END delete()

    # :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
}