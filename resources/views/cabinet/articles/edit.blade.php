<!-- Create by Xenial -->

@extends('layouts.cabinet')

@section('content')

    <h1>{{$title}}</h1>

    <form method="post">
        {{ csrf_field() }}

        <p>Выбор категорий:
            <select name="categories[]" class="form-control" multiple>

                <!--
                    Итак, в редактировании, мы принимаем Массив выбранных Категорий к Статье.
                    У нас могут быть выбраны несколько Категорий. Мы передаём Массив Категорий,
                    которые добавлены к Статье, это будет Массив id Категорий из Таблицы `category_articles`
                    Для того, чтобы получить данный Массив, нам нужно запросить его от Модели Article,
                    однако Модель Article (а именно Таблица) - не содержит таких данных,
                    эти данные храняться в Таблице `category_articles`, но так как Таблица Article
                    имеет связь с Таблицей `category_articles`, мы получаем id Категорий
                    Нам понадобяться Связи. т.е. нам понадобиться связывать Таблицы `categories` и `articles`
                    через связующую Таблицу `category_articles`, и выводить те Категории, которые указаны к Статье

                    Ниже в foreach, проверяем: in_array() ~ PHP-функция, проверяет, присутствует ли в Массиве Значение
                    т.е. принимает Параметры, что мы ищём, и где мы ищем, и если мы находим, нам возвращается true,
                    в нашем случае, при данном условии, мы в option выделяем элемент как selected
                -->

                @foreach($categories as $category)
                    <option value="{{$category->id}}"
                            @if(in_array($category->id, $arrCategories)) selected @endif>{{$category->title}}
                    </option>
                @endforeach
            </select>
        </p>

        <!--Обрати внимание, что ниже мы уже принимаем существующие Значения, в value=""-->
        <p>Название статьи:<br><input type="text" name="title" value="{{$article->title}}" class="form-control"></p>
        <p>Короткий текст:<br><textarea name="short_text" class="form-control">{{ $article->short_text }}</textarea></p>
        <p>Полный текст:<br><textarea name="full_text" class="form-control">{{ $article->full_text }}</textarea></p>
        <button type="submit" class="btn btn-success" style="cursor: pointer">Редактировать</button>
    </form>

@stop