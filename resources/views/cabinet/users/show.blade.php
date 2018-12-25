<!-- Create by Xenial -->

@extends('layouts.cabinet')

@section('content')

    <h1>{{$title}}</h1>

    <table class="table table-bordered">
        <tr>
            <th>#</th>
            <th>E-mail</th>
            <th>Роль</th>
            <th>Статус</th>
            <th>Дата регистрации</th>
            <th>Действия</th>
        </tr>

        @foreach($users as $user)
            <tr>
                <td>{{$user->id}}</td>
                <td>{{$user->email}}</td>
                <!--Проверка: Admin или Пользователь-->
                <td>
                    @if($user->root) Root :@endif
                    @if($user->isAdmin)Администратор @else Пользователь @endif
                </td>

                <td>
                    @if(!$user->root)
                        @if($user->isConfirm == 1)
                            <span style="color: #22b07b">Активен</span>
                        @else
                            <span style="color: #ff2f3e">Заблокирован</span>
                        @endif
                    @endif
                </td>

                <td>{{$user->created_at->format('d.m.Y H:i')}}</td>

                @if(!$user->root)
                <td>
                    <a href="{{ route('users.edit', ['id' => $user->id]) }}">Изменить права</a> -

                    @if($user->isConfirm == 1)
                        <i><a href="{{ route('users.confirm', ['id' => $user->id]) }}">Заблокировать</a></i> -
                    @else
                        <i><a href="{{ route('users.confirm', ['id' => $user->id]) }}">Разблокировать</a></i> -
                    @endif

                    <a href="javascript:" class="delete" rel="{{$user->id}}">Удалить</a>
                </td>
                @endif
            </tr>
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
                if(confirm("Вы действительно хотите удалить этого Пользователя?")) {/* (a) - по условию спросим пользователя, действительно ли он хочет удалить Пользователя */
                    /* let это Ecmascript 6 */let id=$(this).attr("rel");           /* получим в переменную значение удаляемого Пользователя, указанной в rel */
                    $.ajax({                                                        /* Блок Ajax */
                        type: "DELETE",                                             /* тип Ajax-Запроса: DELETE */
                        url: "{{ route('users.delete') }}",                         /* URL на Роут удаления */
                        data: {_token:"{{csrf_token()}}", id:id},                   /* data - это самое важное: во-первых у нас будет Токен csrf_token (уже не csrf_field() обратите внимание!) - т.е. мы у Laravel получаем Token на использование, передавая его в Свойство _token (то же самое, но без web-формы, т.к. у нас здесь её нет), и передаём id который мы приняли - в Свойство id */
                        complete: function () {                                     /* complete - означает, что действие выполниться всегда, когда завершилось действие, не зависимо от того, даже если действие завершилось ошибкой, будет выполнен complete / если действие было выполнено успешно, также будет выполнен complete */
                                                                                    /* мы не будем сейчас отлавливать как завершилось действие, а будем сразу делать complete (обрати внимание, что мы в if, иначе мы не попали бы на complete) */
                            alertify.success('Пользователь удален');                /* воспользуемся напрямую alertify и выведем, что Пользователь удален */

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