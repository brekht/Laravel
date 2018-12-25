<!-- Create by Xenial -->

@extends('layouts.cabinet')

@section('content')

    <h1>{{$title}}</h1>

    <form method="post">
        {{ csrf_field() }}
        <p>Текст комментария:<br><textarea name="commentedit" class="form-control">{{$comment->comment}}</textarea></p>
        <button type="submit" class="btn btn-success" style="cursor: pointer">Редактировать</button>
    </form>
@stop