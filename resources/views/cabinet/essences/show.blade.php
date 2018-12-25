<!-- Create by Xenial -->

@extends('layouts.cabinet')

@section('content')

    <h1>{{$title}}</h1>

    <a style="margin-bottom: 20px;" href="{{ route('essences.add') }}" class="btn btn-info">Добавить сущность</a>

    <table class="table table-striped">
        <tr>
            <th>#</th>
            <th>Наименование</th>
            <th>Автор</th>
            <th>First Author</th>
            <th>Дата добавления</th>
            <th>Дата обновления</th>
            <th>Действия</th>
            <th>Управление Свойствами</th>
        </tr>

        @foreach($essences as $essence)
            @if(Auth::user()->isAdmin == 0 && Auth::user()->root == 0 && Auth::user()->isConfirm == 1)
                @if(Auth::user()->id == $essence->user_id)
                <tr>
                    <td>{{$essence->id}}</td>
                    <td>{{$essence->name}}</td>
                    <td>{{_user($essence->user_id)->email}}</td>
                    <td>{{_user($essence->first_author)->email}}</td>
                    <td>{{$essence->created_at->format('d-m-Y H:i')}}</td>
                    <td>{{$essence->updated_at->format('d-m-Y H:i')}}</td>
                    <td>
                        <a href="{{ route('essences.edit', ['id' => $essence->id]) }}">Редактировать</a> -
                        <a href="{{ route('essences.delete', ['id' => $essence->id, 'comparison' => md5($essence->id)]) }}">Удалить</a>
                    </td>
                    <td style="padding-left: 30px">
                        <a href="{{ route('properties', ['id' => $essence->id]) }}">Перейти &rarr;</a>
                    </td>
                </tr>
                @endif
            @else
                <tr>
                    <td>{{$essence->id}}</td>
                    <td>{{$essence->name}}</td>
                    <td>{{_user($essence->user_id)->email}}</td>
                    <td>{{_user($essence->first_author)->email}}</td>
                    <td>{{$essence->created_at->format('d-m-Y H:i')}}</td>
                    <td>{{$essence->updated_at->format('d-m-Y H:i')}}</td>
                    <td>
                        <a href="{{ route('essences.edit', ['id' => $essence->id]) }}">Редактировать</a> -
                        <a href="{{ route('essences.delete', ['id' => $essence->id, 'comparison' => md5($essence->id)]) }}">Удалить</a>
                    </td>
                    <td style="padding-left: 30px">
                        <a href="{{ route('properties', ['id' => $essence->id]) }}">Перейти &rarr;</a>
                    </td>
                </tr>
            @endif
        @endforeach
    </table>

@stop
