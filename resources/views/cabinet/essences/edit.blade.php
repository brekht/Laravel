<!-- Create by Xenial -->

@extends('layouts.cabinet')

@section('content')

    <h1>{{$title}}</h1>

    <form method="post">
        {{ csrf_field() }}

        <p>Наименование сущности:<br><input type="text" name="name" value="{{$essence->name}}" class="form-control"></p>
        <button type="submit" class="btn btn-success" style="cursor: pointer">Редактировать</button>
    </form>

@stop