<!-- Create by Xenial -->

@extends('layouts.cabinet')

@section('content')

    <h1>{{$title}}</h1>

    <table class="table table-bordered">
        <tr>
            <th>#</th>
            <th>Статья</th>
            <th>Автор</th>
            <th>Комментарий</th>
            <th>Статус</th>
            <th>Дата добавления</th>
            <th>Действия</th>
        </tr>

        <!--
            Выберем все Комментарии, какие есть
            обрати внимание, что здесь не используется например orderBy() или where()
            для разделения комментариев, например старые или новые (возможно это реализуем в дальнейшем)
        -->
        @foreach($comments as $comment)
            @if(Auth::user()->isAdmin == 0 && Auth::user()->root == 0 && Auth::user()->isConfirm == 1)
                @if(Auth::user()->id == $comment->user_id)
                <tr>
                    <td>{{$comment->id}}</td>
                    <td>{{_article($comment->article_id)->title}}</td>
                    <td>{{_user($comment->user_id)->email}}</td>
                    <td>{{$comment->comment}}</td>
                    <td>@if($comment->status) Активен @else На модерации @endif</td>
                    <td>{{ $comment->created_at->format('d-m-Y H:i') }}</td>
                    <td>
                        <a href="{{ route('comments.edit', ['id' => $comment->id]) }}">Редактировать</a> -
                        <a href="javascript:" class="delete" rel="{{$comment->id}}">Удалить</a>
                    </td>
                </tr>
                @endif
            @else
                <tr>
                    <td>{{$comment->id}}</td>

                    <!--
                        Обрати внимание, что здесь мы тоже используем Хелпер _article(),
                        он выводит Статью по Полю 'article_id' из Таблицы `comments`
                        т.е. обращаемся от полученного Объекта к `title` (см. описание Хелпера)
                    -->
                    <td>{{_article($comment->article_id)->title}}</td>
                    <!--
                        Пользователя также выводим через созданный ранее глобальный Хелпер _user()
                    -->
                    <td>{{_user($comment->user_id)->email}}</td>
                    <td>{{$comment->comment}}</td>

                    <!-- Если статус 1 (true) - указываем 'Активен', иначе, даём ссылку на Роут 'comment.accepted' для активации модерации, передавая id Комментария -->
                    <td>@if($comment->status) Активен @else На модерации <br><a href="{{ route('comments.accepted', ['id' => $comment->id]) }}">Одобрить</a> @endif</td>

                    <td>{{ $comment->created_at->format('d-m-Y H:i') }}</td>

                    <td>
                        <a href="{{ route('comments.edit', ['id' => $comment->id]) }}">Редактировать</a> -
                        <a href="javascript:" class="delete" rel="{{$comment->id}}">Удалить</a>
                    </td>
                </tr>
            @endif
        @endforeach
    </table>

@stop

<!--
т.к. блок с JS ниже, это section, и он будет встраиваться в ведущий Шаблон views/layouts/cabinet.blade.php,
соответственно в данном ведущем шаблоне, нам нужно через yield подключить эту секцию как yield(js) по имени данной секции
-->
@section('js')
    <!-- Наша задача, это отловить событие при Клике по ссылке 'Удалить', у нас на эту ссылку стоит class="delete" -->
    <script>
        $(function () {
            $(".delete").on('click', function () {                                  /* обращаемся к class: если событие 'click' - значит идём в безымянную функцию */
                if(confirm("Вы действительно хотите удалить этот Комментарий")) {   /* (a) - по условию спросим пользователя, действительно ли он хочет удалить Комментарий */
                    /* let это Ecmascript 6 */let id=$(this).attr("rel");           /* получим в переменную значение удаляемого Комментария, по указанному id в rel */
                    $.ajax({                                                        /* Блок Ajax */
                        type: "DELETE",                                             /* тип Ajax-Запроса: DELETE */
                        url: "{{ route('comments.delete') }}",                      /* URL на Роут удаления */
                        data: {_token:"{{csrf_token()}}", id:id},                   /* data - это самое важное: во-первых у нас будет Токен csrf_token (уже не csrf_field() обратите внимание!) - т.е. мы у Laravel получаем Token на использование, передавая его в Свойство _token (то же самое, но без web-формы, т.к. у нас здесь её нет), и передаём id который мы приняли - в Свойство id */
                        complete: function () {                                     /* complete - означает, что действие выполниться всегда, когда завершилось действие, не зависимо от того, даже если действие завершилось ошибкой, будет выполнен complete / если действие было выполнено успешно, также будет выполнен complete */
                                                                                    /* мы не будем сейчас отлавливать как завершилось действие, а будем сразу делать complete (обрати внимание, что мы в if, иначе мы не попали бы на complete) */
                            alertify.success('Комментарий удален');                 /* воспользуемся напрямую alertify и выведем, что Комментарий удалён */

                            setTimeout(function() {
                                location.reload();                                  /* перегрузим текущую страницу (через 2-е секунды, чтобы успеть прочитать вывод alertify) */
                            }, 2000);
                        }
                    });
                }else{                                                              /* иначе */
                    alertify.error('Удаление отменено');                            /* (b) - (воспользуемся напрямую alertify) выведем, что Удаление отменено */
                }
            })
        });
    </script>
@stop