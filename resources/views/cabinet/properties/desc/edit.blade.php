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

        <p>Описание:<br><input type="text" name="desc" value="{{$desc}}" class="form-control"></p>
        <button type="submit" class="btn btn-success" style="cursor: pointer">Редактировать</button>
    </form>

@stop