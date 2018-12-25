<!-- Create by Xenial -->

@extends('layouts.cabinet')

@section('content')

    <h1>{{$title}}</h1>

    <a style="margin-bottom: 20px;" href="{{ route('articles.add') }}" class="btn btn-info">Добавить статью</a>

    <table class="table table-bordered">
        <tr>
            <th>#</th>
            <th>Наименование</th>
            <th>Автор</th>
            <th>Дата добавления</th>
            <th>Действия</th>
        </tr>

        @foreach($articles as $article)
            @if(Auth::user()->isAdmin == 0 && Auth::user()->root == 0 && Auth::user()->isConfirm == 1)
                @if(Auth::user()->id == $article->user_id)
                <tr>
                    <td>{{$article->id}}</td>
                    <td>{{$article->title}}</td>
                    <td>{{_user($article->user_id)->email}}</td>
                    <td>{{$article->created_at->format('d-m-Y H:i')}}</td>
                    <td>
                        <a href="{{ route('articles.edit', ['id' => $article->id]) }}">Редактировать</a> -
                        <a href="javascript:" class="delete" rel="{{$article->id}}">Удалить</a>
                    </td>
                </tr>
                @endif
            @else
                <tr>
                    <td>{{$article->id}}</td>
                    <td>{{$article->title}}</td>
                    <td>{{_user($article->user_id)->email}}</td>
                    <td>{{$article->created_at->format('d-m-Y H:i')}}</td>
                    <td>
                        <a href="{{ route('articles.edit', ['id' => $article->id]) }}">Редактировать</a> -
                        <a href="javascript:" class="delete" rel="{{$article->id}}">Удалить</a>
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
            $(".delete").on('click', function () {                              /* обращаемся к class: если событие 'click' - значит идём в безымянную функцию */
                if(confirm("Вы действительно хотите удалить эту Статью?"))      { /* (a) - по условию спросим пользователя, действительно ли он хочет удалить Статью */
                    /* let это Ecmascript 6 */let id=$(this).attr("rel");       /* получим в переменную значение удаляемой Статьи, по указанной в rel */
                    $.ajax({                                                    /* Блок Ajax */
                        type: "DELETE",                                         /* тип Ajax-Запроса: DELETE */
                        url: "{{ route('articles.delete') }}",                  /* URL на Роут удаления */
                        data: {_token:"{{csrf_token()}}", id:id},               /* data - это самое важное: во-первых у нас будет Токен csrf_token (уже не csrf_field() обратите внимание!) - т.е. мы у Laravel получаем Token на использование, передавая его в Свойство _token (то же самое, но без web-формы, т.к. у нас здесь её нет), и передаём id который мы приняли - в Свойство id */
                        complete: function () {                                 /* complete - означает, что действие выполниться всегда, когда завершилось действие, не зависимо от того, даже если действие завершилось ошибкой, будет выполнен complete / если действие было выполнено успешно, также будет выполнен complete */
                                                                                /* мы не будем сейчас отлавливать как завершилось действие, а будем сразу делать complete (обрати внимание, что мы в if, иначе мы не попали бы на complete) */
                            alertify.success('Статья удалена');                 /* воспользуемся напрямую alertify и выведем, что Статья удалена */

                            setTimeout(function() {
                                location.reload();                              /* перегрузим текущую страницу (через 2-е секунды, чтобы успеть прочитать вывод alertify) */
                            }, 2000);
                        }
                    });
                }else{                                                          /* иначе */
                    alertify.error('Удаление отменено');                        /* (b) - (воспользуемся напрямую alertify) выведем, что Удаление отменено */
                }
            })
        });
    </script>
@stop