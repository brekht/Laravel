<!-- Create by Xenial -->

@extends('layouts.cabinet')

@section('content')

    <h1>{{$title}}</h1>

    <form method="post">
        {{ csrf_field() }}

        <p>Выбор категорий:<br>
            <select name="categories[]" class="form-control" multiple>
                @foreach($categories as $category)
                    <option value="{{$category->id}}">{{$category->title}}</option>
                @endforeach
            </select>
        </p>

        <p>Название статьи:<br><input type="text" name="title" class="form-control"></p>
        <p>Короткий текст:<br><textarea name="short_text" class="form-control"></textarea></p>
        <p>Полный текст:<br><textarea name="full_text" class="form-control"></textarea></p>
        <button type="submit" class="btn btn-success" style="cursor: pointer">Добавить</button>
    </form>

@stop