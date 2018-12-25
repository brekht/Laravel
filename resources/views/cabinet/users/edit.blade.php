<!-- Create by Xenial -->

@extends('layouts.cabinet')

@section('content')

    <h1>{{$title}}</h1>

        <form method="post">
            {{ csrf_field() }}
            <br>
            <p>E-mail Пользователя: <b>{{$user->email}}</b></p>
            <br>
            <p>Права Пользователя: <b>@if($user->isAdmin)Администратор @else Пользователь @endif</b></p>
            <br>

            <p>Изменить Права Пользователя:
                @if($user->isAdmin==1)
                    <p>&nbsp;&nbsp;&nbsp;<input name="rights" type="radio" value="0"> Без прав</p>
                @else
                    <p>&nbsp;&nbsp;&nbsp;<input name="rights" type="radio" value="1"> Admin</p>
                @endif
            </p>
            <br>

            <button type="submit" class="btn btn-success" style="cursor: pointer">Редактировать</button>
        </form>

@stop