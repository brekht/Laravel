<!-- Create by Xenial -->

@extends('layouts.cabinet')

@section('content')

    <h1>Essence {{_essence($essenceId)->name}}: {{$title}}</h1>

    <div class="alphaA">
        <div class="alphaB"></div>

        <div class="alphaC">
            <h5  class="h5Standard">Стандартные Свойства</h5>
        </div>
    </div>

    <table class="table table-bordered" style="border: silver 2px solid">

        <tr class="bgcA">
            <th class="widthS280">Количество</th>
            <th class="alpha100">Автор</th>
            <th class="alpha100">First Author</th>
            <th class="alpha130">Добавление</th>
            <th class="alpha130">Изменение</th>
            <th class="alpha210">Действия</th>
        </tr>

        <tr>
            <td class="colorS">{{$numObj->num}}</td>
            <td class="bgcA">
                            @if($numObj->user_id)
                                {{_user($numObj->user_id)->email}}
                            @endif
            </td>
            <td class="bgcA">
                            @if($numObj->first_author)
                                {{_user($numObj->first_author)->email}}
                            @endif
            </td>
            <td class="bgcA">{{$numObj->created_at}}</td>
            <td class="bgcA">{{$numObj->updated_at}}</td>
            <td class="bgcA">

                <div class="alphaE">
                    <a class="btn btn-info" style="width: 150px" href="{{ route('properties.editNum', ['id' => $essenceId, 'comparison' => $comparison]) }}">Редактировать</a>
                </div>
                <div class="alphaE">
                    <a class="btn btn-danger" style="width: 150px" href="javascript:" id="clearNum" rel="{{$essenceId}}">Очистить</a>
                </div>

            </td>
        </tr>

        <tr class="bgcA">
            <th class="colorS">Описание</th>
            <th class="alphaD">Автор</th>
            <th class="alphaD">First Author</th>
            <th class="alphaD">Добавление</th>
            <th class="alphaD">Изменение</th>
            <th class="alphaD">Действия</th>
        </tr>

        <tr>
            <td class="colorS">{{$descObj->desc}}</td>
            <td class="bgcA">
                            @if($descObj->user_id)
                                {{_user($descObj->user_id)->email}}
                            @endif
            </td>
            <td class="bgcA">
                            @if($descObj->first_author)
                                {{_user($descObj->first_author)->email}}
                            @endif
            </td>
            <td class="bgcA">{{$descObj->created_at}}</td>
            <td class="bgcA">{{$descObj->updated_at}}</td>
            <td class="bgcA">

                <div class="alphaE">
                    <a class="btn btn-info" style="width: 150px" href="{{ route('properties.editDesc', ['id' => $essenceId, 'comparison' => $comparison]) }}">Редактировать</a>
                </div>
                <div class="alphaE">
                    <a class="btn btn-danger" style="width: 150px" href="javascript:" id="clearDesc" rel="{{$essenceId}}">Очистить</a>
                </div>

            </td>
        </tr>

        <tr class="bgcA">
            <th class="colorS">Изображение</th>
            <th class="alphaD">Автор</th>
            <th class="alphaD">First Author</th>
            <th class="alphaD">Добавление</th>
            <th class="alphaD">Изменение</th>
            <th class="alphaD">Действия</th>
        </tr>

        <tr style="height: 175px">
            <td>
                <img class="card-img-top" src="{{ asset('images/'.$imgObj->img) }}" alt="" style="width: 150px">
            </td>
            <td class="bgcA">
                            @if($imgObj->user_id)
                                {{_user($imgObj->user_id)->email}}
                            @endif
            </td>
            <td class="bgcA">
                            @if($imgObj->first_author)
                                {{_user($imgObj->first_author)->email}}
                            @endif
            </td>
            <td class="bgcA">{{$imgObj->created_at}}</td>
            <td class="bgcA">{{$imgObj->updated_at}}</td>
            <td class="bgcA">

                <div class="alphaF">
                    <form method="post" action="{{ route('properties.uploadImg', ['id' => $essenceId, 'comparison' => $comparison]) }}" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <input type="file" name="image" style="width:1px;margin-bottom:5px;font-size:11px">

                        <div style="clear:both"></div><!--Clear-->
                        <button type="submit" class="btn btn-success" style="cursor: pointer">Загрузить</button>
                    </form>
                </div>

                <div class="alphaE">
                    <a class="btn btn-danger" style="width: 150px" href="javascript:" id="clearImg" rel="{{$essenceId}}">Очистить</a>
                </div>

            </td>
        </tr>

    </table>




    <div class="alphaA">
        <div class="alphaB">
            <a href="{{ route('freeproperties.add', ['id' => $essenceId, 'comparison' => $comparison]) }}" class="btn btn-info" style="margin-bottom: 5px">+ Add free property to Essence</a>
        </div>

        <div class="alphaC">
            <h5 class="h5Free">Свободные Свойства</h5>
        </div>
    </div>

    @foreach($freePropObj as $freeProperty)

        <table class="table table-bordered" style="border: silver 2px solid">

            <tr class="bgcA">
                <th class="widthF280">
                                    @if($freeProperty->col_prop)
                                        {{$freeProperty->col_prop}}
                                    @endif
                </th>
                <th class="alpha100">Автор</th>
                <th class="alpha100">First Author</th>
                <th class="alpha130">Добавление</th>
                <th class="alpha130">Изменение</th>
                <th class="alpha210">Действия</th>
            </tr>

            <tr>
                <td class="colorF">
                                    @if($freeProperty->col_desc)
                                        {{$freeProperty->col_desc}}
                                    @endif
                </td>
                <td class="bgcA">
                                    @if($freeProperty->user_id)
                                        {{_user($freeProperty->user_id)->email}}
                                    @endif
                </td>
                <td class="bgcA">
                                    @if($freeProperty->first_author)
                                        {{_user($freeProperty->first_author)->email}}
                                    @endif
                </td>
                <td class="bgcA">{{$freeProperty->created_at}}</td>
                <td class="bgcA">{{$freeProperty->updated_at}}</td>
                <td class="bgcA">

                    <div class="alphaE">
                        <a class="btn btn-info" style="width: 150px" href="{{ route('freeproperties.edit', ['id' => $essenceId, 'prop_id' => $freeProperty->id, 'comparison' => $comparison]) }}">Редактировать</a>
                    </div>
                    <div class="alphaE">
                        <a class="btn btn-danger" style="width: 150px" href="{{route('freeproperties.delete', ['id' => $essenceId, 'prop_id' => $freeProperty->id, 'comparison' => $comparison, 'cmprsn' => md5($freeProperty->id)])}}">Удалить</a>
                    </div>

                </td>
            </tr>
        </table>

    @endforeach

    <div style="clear:both"></div><!--Clear-->
    <div style="width: 100%; height: 30px"></div>

@stop

<!--
т.к. блок с JS ниже, это section, и он будет встраиваться в ведущий Шаблон views/layouts/cabinet.blade.php,
соответственно в данном ведущем шаблоне, нам нужно через yield подключить эту секцию как yield(js) по имени данной секции
-->
@section('js')
    <!-- Наша задача, это отловить событие при Клике по ссылке 'Очистить', у нас на эту ссылку стоит class="clearNum" -->
    <script>
        $(function () {
            $("#clearNum").on('click', function () {                                /* обращаемся к class: если событие 'click' - значит идём в безымянную функцию */
                if(confirm("Вы действительно хотите очистить Количество?")) {       /* (a) - по условию спросим пользователя, действительно ли он хочет очистить Количество */
                    /* let это Ecmascript 6 */let id=$(this).attr("rel");           /* получим в переменную id Сущности, чей num мы очищаем (указанн в rel) */
                    $.ajax({                                                        /* Блок Ajax */
                        type: "DELETE",                                             /* тип Ajax-Запроса: DELETE */
                        url: "{{ route('properties.clearNum') }}",                  /* URL на Роут очистки */
                        data: {_token:"{{csrf_token()}}", id:id},                   /* data - это самое важное: во-первых у нас будет Токен csrf_token (уже не csrf_field() обратите внимание!) - т.е. мы у Laravel получаем Token на использование, передавая его в Свойство _token (то же самое, но без web-формы, т.к. у нас здесь её нет), и передаём id который мы приняли - в Свойство id */
                        complete: function () {                                     /* complete - означает, что действие выполниться всегда, когда завершилось действие, не зависимо от того, даже если действие завершилось ошибкой, будет выполнен complete / если действие было выполнено успешно, также будет выполнен complete */
                                                                                    /* мы не будем сейчас отлавливать как завершилось действие, а будем сразу делать complete (обрати внимание, что мы в if, иначе мы не попали бы на complete) */

                            location.reload();                                      /* перегрузим текущую страницу */

                        }
                    });
                }else{                                                              /* иначе */
                    alertify.error('Очистка отменена');                             /* (b) - (воспользуемся напрямую alertify) выведем, что Очистка отменена */
                }
            })
        });

        /* :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: */

        $(function () {
            $("#clearDesc").on('click', function () {
                if(confirm("Вы действительно хотите очистить Описание?")) {
                    /* let это Ecmascript 6 */let id=$(this).attr("rel");
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('properties.clearDesc') }}",
                        data: {_token:"{{csrf_token()}}", id:id},
                        complete: function () {

                            location.reload();
                        }
                    });
                }else{
                    alertify.error('Очистка отменена');
                }
            })
        });

        /* :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: */

        $(function () {
            $("#clearImg").on('click', function () {
                if(confirm("Вы действительно хотите очистить Изображение?")) {
                    /* let это Ecmascript 6 */let id=$(this).attr("rel");
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('properties.clearImg') }}",
                        data: {_token:"{{csrf_token()}}", id:id},
                        complete: function () {

                            location.reload();
                        }
                    });
                }else{
                    alertify.error('Очистка отменена');
                }
            })
        });

        /* :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: */

    </script>
@stop