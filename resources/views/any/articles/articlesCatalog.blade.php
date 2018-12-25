<!-- Create by Xenial -->

@extends('layouts.any.articles')

@section('content')

    <!-- Page Header -->
    <header class="masthead" style="background-image: url('{{ asset('any/articles/img/home-bg.jpg') }}')">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-10 mx-auto">
                    <div class="site-heading">
                        <h1 style="font-weight: lighter">Articles Blog</h1>
                        <span class="subheading"><i>Articles Blog</i></span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">

                @if($articles == null)
                    <div class="nullEssencesMessage">
                        Статьи не созданы!<br>
                        Зарегистрируйтесь, авторизуйтесь, создайте Категорию и создайте Статью!
                    </div>
                @else
                    <!--В цикле выводим превью всех Статей (принимаем $articles в данный Шаблон)-->
                    @foreach($articles as $article)
                        <div class="post-preview">
                            <!--формируем ссылку под Роут 'article', передавая id и slug (slug формируем преобразовывая title - с помощью str_slug() )-->
                            <a href="{{ route('article', [
                                                            'id' => $article->id,
                                                            'slug' => str_slug($article->title)
                            ]) }}">
                                <h2 class="post-title">
                                    <!--выводим заголовок-->
                                    {{ $article->title }}
                                </h2>
                                <h3 class="post-subtitle">
                                    <!--выводим краткий текст статьи-->
                                    {{ $article->short_text }}
                                </h3>
                            </a>
                            <p class="post-meta">Опубликовал
                                <!--выводим автора статьи-->
                                <a href="#">{{_user($article->user_id)->email}}</a>

                                <!--выводим время публикации статьи (указав пользовательский формат даты времени
                                    помни, что поля `created_at` и `updated_at` определены в Модели Article как мутаторы)-->
                                в {{ $article->created_at->format('H:i d.m.Y') }}</p>
                        </div>
                    @endforeach

                    <div style="clear:both;margin-bottom:100px"></div><!--Clear-->
                    <hr>

                    <!-- Pagination -->
                    <div class="pagination justify-content-center">
                        {{$articles->render('pagination::bootstrap-4')}}
                    </div>

                @endif

            </div>
        </div>
    </div>

@stop