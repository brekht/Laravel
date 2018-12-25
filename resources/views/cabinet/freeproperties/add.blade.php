<!-- Create by Xenial -->

@extends('layouts.cabinet')

@section('content')

    <div class="divBack">
        <a href="{{ route('properties', ['id' => $essenceId]) }}" class="linkBack"> &rarr; обратно к Свойствам</a>
    </div>
    <div style="clear:both"></div><!--Clear-->

    <h1>{{$title}}</h1>

    <form method="post">
        {{ csrf_field() }}

        <p>Имя Свойства:<br><input type="text" name="col_prop" class="form-control"></p>
        <p>Описание Свойства:<br><input type="text" name="col_desc" class="form-control"></p>
        <button type="submit" class="btn btn-success" style="cursor: pointer">Добавить</button>
    </form>

@stop