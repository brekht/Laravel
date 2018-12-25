<!-- Create by Xenial -->

@extends('layouts.cabinet')

@section('content')

    <h1>{{$title}}</h1>

    <!--Выводим ссылку на страницу добавления Категории (т.е. на страницу с web-формой)-->
    <a style="margin-bottom: 20px;" href="{{ route('categories.add') }}" class="btn btn-info">Добавить категорию</a>

    <table class="table table-bordered">
        <tr>
            <th>#</th>
            <th>Наименование</th>
            <th>Описание</th>
            <th>Дата добавления</th>
            <th>Действия</th>
        </tr>

        <!--Передаём $categories из Контроллера CategoriesController, action-а index() и принимаем $categories,
            а так как это массив, используем foreach, для получения отдельных данных-->
        @foreach($categories as $category)
            @if(Auth::user()->isAdmin == 0 && Auth::user()->root == 0 && Auth::user()->isConfirm == 1)
                @if(Auth::user()->id == $category->user_id)
                <tr>
                    <td>{{$category->id}}</td>
                    <td>{{$category->title}}</td>
                    <td>{{$category->desc}}</td>
                    <!--Далее нам понадобяться Мутоторы: за счёт инициализации Мутаторов в Модели,
                        т.е. когда мы данное Поле объявили как DATE, соответственно мы с данным Полем можем работать как с датой,
                        в частности использовать функцию format() из Библиотеки Carbon, указав нужный формат даты (и не используя функции PHP)-->
                    <td>{{$category->created_at->format('d-m-Y H:i')}}</td>
                    <td>
                        <!--ссылка Редактировать (обратите внимание, на какой Роут она ссылается, и что данный Роут принимает Параметр)-->
                        <a href="{{ route('categories.edit', ['id' => $category->id]) }}">Редактировать</a> -

                <!--используем Ajax, передавая Параметр для удаления:
                    обрати внимание, что Роут не описан, но описан JS, в котором ниже как раз
                    и вызывается Роут на удаление (в параметре url ajax-jquery), посредством Ajax
                        При удалении с помощью Ajax, мы в качестве ссылки указываем 'javascript:',
                        указываем class="delete", по которому мы будем искать DOM элемент, с которого произошёл action
                        плюс, в rel="" нам нужно хранить id, т.к. он нам понадобиться для указания, какую Категорию удалять-->
                        <a href="javascript:" class="delete" rel="{{$category->id}}">Удалить</a>
                    </td>
                </tr>
                @endif
            @else
                <tr>
                    <td>{{$category->id}}</td>
                    <td>{{$category->title}}</td>
                    <td>{{$category->desc}}</td>
                    <td>{{$category->created_at->format('d-m-Y H:i')}}</td>
                    <td>
                        <a href="{{ route('categories.edit', ['id' => $category->id]) }}">Редактировать</a> -
                        <a href="javascript:" class="delete" rel="{{$category->id}}">Удалить</a>
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
                if(confirm("Вы действительно хотите удалить эту Категорию?")) { /* (a) - по условию спросим пользователя, действительно ли он хочет удалить Категорию */
                    /* let это Ecmascript 6 */let id=$(this).attr("rel");       /* получим в переменную значение удаляемой Категории, по указанной в rel */
                    $.ajax({                                                    /* Блок Ajax */
                        type: "DELETE",                                         /* тип Ajax-Запроса: DELETE */
                        url: "{{ route('categories.delete') }}",                /* URL на Роут удаления */
                        data: {_token:"{{csrf_token()}}", id:id},               /* data - это самое важное: во-первых у нас будет Токен csrf_token (уже не csrf_field() обратите внимание!) - т.е. мы у Laravel получаем Token на использование, передавая его в Свойство _token (то же самое, но без web-формы, т.к. у нас здесь её нет), и передаём id который мы приняли - в Свойство id */
                        complete: function () {                                 /* complete - означает, что действие выполниться всегда, когда завершилось действие, не зависимо от того, даже если действие завершилось ошибкой, будет выполнен complete / если действие было выполнено успешно, также будет выполнен complete */
                                                                                /* мы не будем сейчас отлавливать как завершилось действие, а будем сразу делать complete (обрати внимание, что мы в if, иначе мы не попали бы на complete) */
                            /* alertify.success('Категория удалена'); */        /* воспользуемся напрямую alertify и выведем, что Категория удалена */

                            /* setTimeout(function() {  */
                                location.reload();                              /* перегрузим текущую страницу (через 2-е секунды, чтобы успеть прочитать вывод alertify) */
                            /* }, 2000);                */
                        }
                    });
                }else{                                                          /* иначе */
                    alertify.error('Удаление отменено');                        /* (b) - (воспользуемся напрямую alertify) выведем, что Удаление отменено */
                }
            })
        });
    </script>
@stop