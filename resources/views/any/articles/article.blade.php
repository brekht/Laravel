<!-- Create by Xenial -->

@extends('layouts.any.articles')

@section('content')

    <!-- Page Header -->
    <header class="masthead" style="background-image: url('{{ asset('any/articles/img/post-bg.jpg') }}')">
        <div class="overlay"></div>

        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-10 mx-auto">
                    <div class="post-heading">
                        <h1>{{ $article->title }}</h1>
                        <h2 class="subheading">{{ $article->short_text }}</h2>
                        <span class="meta">Опубликовал
            <a href="#">{{_user($article->user_id)->email}}</a>
            в {{ $article->created_at->format('H:i d.m.Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Post Content -->
    <article>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-10 mx-auto">

                    <!--
                    <h2 class="section-heading">To meet the stars</h2>
                    <p>And ahead of the way to meet the stars</p>
                    <blockquote class="blockquote">Space walk expects to be full of pleasant events</blockquote>

                    <a href="#">
                        <img class="img-fluid" src="{{-- asset('any/articles/img/post-sample-image.jpg') --}}" alt="">
                    </a>
                    <span class="caption text-muted">To go places and do things that have never been done before – that’s what living is all about.</span>
                    -->

                    <h2 class="section-heading">{{ $article->title }}</h2>
                    <p>{{ $article->full_text }}</p>

                </div>

                <br><br>
                <hr>

                <!-- Web-форма добавления Комментария -->
                <!--
                    Проверим, перед тем как показать web-форму, Авторизован (Зарегистрирован) ли Пользователь:
                    Пользователя мы получаем автоматически при авторизации
                 -->
                @if(Auth::check())

                    <!-- Обрати внимание, что web-форма имеет action, который ведёт на вне-админ Роут 'comments.add' -->
                    <form method="post" action="{{ route('comments.add') }}">
                        {{ csrf_field() }}

                        <!-- Через скрытое поле - передаём id Статьи -->
                        <input type="hidden" value="{{$article->id}}" name="article_id">

                        <p>Комментарий<br><textarea class="form-control" name="comment"></textarea></p>
                        <button type="submit" class="btn btn-success" style="cursor:pointer">Добавить комментарий</button>
                    </form>
                @endif

                <!--
                    Выводим Комментарии, которые прошли Модерацию
                    используем Пользовательский Help-ер _user() - чтобы определить 'кто оставил Комментарий'
                -->
                @foreach($comments as $comment)
                        <div class="comment" style="border: 1px solid #b8d6f6; margin: 10px 0px 0px 40px; padding: 10px; width: 70%; font-family: Arial; font-size: 12px">

                            <!--
                                Кто оставил Комментарий (передавая в Help-ер _user() id Пользователя, кто оставил Комментарий)
                                и от найденного Объекта Пользователя, получаем его email
                            -->
                            <span style="color:#8c8c8c; display:block; clear: both;">{{ _user($comment->user_id)->email }}</span>
                            <span style="color:#8c8c8c; display:block; clear: both;">{{$comment->created_at->format('H:i d.m.Y ')}}</span>
                            {{ $comment->comment }}
                        </div>
                @endforeach

            </div>
        </div>
    </article>

@stop