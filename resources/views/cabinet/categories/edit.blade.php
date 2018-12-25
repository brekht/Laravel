<!-- Create by Xenial -->

@extends('layouts.cabinet')

@section('content')

    <h1>{{$title}}</h1>

        <form method="post">
            {{ csrf_field() }}
            <p>Введите наименование категории:<br><input type="text" name="title" class="form-control" value="{{$category->title}}"></p>
            <p>Текст категории:<br><textarea name="description" class="form-control">{{$category->desc}}</textarea></p>
            <button type="submit" class="btn btn-success" style="cursor: pointer">Редактировать</button>
        </form>
@stop