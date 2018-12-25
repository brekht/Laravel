<!-- Create by Xenial -->

@extends('layouts.cabinet')

@section('content')

    <?php
    # При не пройденной валидации - при специально созданной Request Валидации
    # Если Сессия содержит Ошибки (has = имеет)

    #if(session()->has('errors')) {

        #dd(session()->get('errors'));   # смотрим, что сессия возвращает (get() выбираем все данные)
        #dd('^ errors');                 # Расскоментируй и посмотри
    #}

    # Логика вывода Ошибок Сессии 'errors' - описана в views/inc/messages.blade.php

    ?>

    <h1>{{$title}}</h1>

        <form method="post">
        {{ csrf_field() }} <!-- Обязательно добавляем поле Токена защиты от CSRF атак -->
            <p>Введите наименование категории:<br><input type="text" name="title" class="form-control"></p>
            <p>Текст категории:<br><textarea name="description" class="form-control"></textarea></p>
            <button type="submit" class="btn btn-success" style="cursor: pointer">Добавить</button>
        </form>
@stop