<!-- Create by Xenial -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Cabinet ›
                    @if($title=='Properties')
                        Essence {{_essence($essenceId)->name}}: {{$title}}
                    @else
                        {{$title}}
                    @endif
    </title>
    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/dashboard/">

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('css/my/v4-alpha.getbootstrap.com_dist_css_bootstrap.min.css') }}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ asset('css/my/dashboard.css') }}" rel="stylesheet">

    <!-- Properties CSS -->
    <link href="{{ asset('css/my/properties.css') }}" rel="stylesheet">

</head>

<body>
<nav class="navbar navbar-toggleable-md navbar-inverse fixed-top bg-inverse">

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link active" style="color:#b0bfc6">Cabinet</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/') }}">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('account') }}">Account</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" style="color: #8fb7cf" href="{{ route('essences.show') }}">Essences</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" style="color: #8fb7cf" href="{{ route('articles.show') }}">Articles</a>
            </li>
        </ul>

        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav navbar-right" style="margin-right: 20px">
            <a class="nav-link"  href="{{ route('logout') }}"
               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                Logout
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        </ul>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">

        <nav class="col-sm-3 col-md-2 hidden-xs-down bg-faded sidebar">
            <ul class="nav nav-pills flex-column">
                <li class="nav-item">
                    <a class="nav-link  @if($active == 'Essences')
                                            active
                                        @endif
                            " style="cursor: pointer" href="{{route('essences')}}">Essences</a>
                </li>
            </ul>

            @if(Auth::user()->root == 1)
            <ul class="nav nav-pills flex-column">
                <li class="nav-item">
                    <a class="nav-link  @if($active == 'Users')
                                            active
                                        @endif
                            " style="cursor: pointer" href="{{route('users')}}">Users</a>
                </li>
            </ul>
            @endif

            <ul class="nav nav-pills flex-column">
                <li class="nav-item">
                    <a class="nav-link  @if($active == 'Categories')
                                            active
                                        @endif
                            " style="cursor: pointer" href="{{route('categories')}}">Categories</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link  @if($active == 'Articles')
                                            active
                                        @endif
                            " style="cursor: pointer" href="{{route('articles')}}">Articles</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link  @if($active == 'Comments')
                                            active
                                        @endif
                            " style="cursor: pointer" href="{{route('comments')}}">Comments</a>
                </li>
            </ul>
        </nav>

        <main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">

            @yield('content')

        </main>

    </div>
</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<!-- : <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script> -->
<!-- : <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script> -->
<!-- : <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script> -->
<!-- : <script src="../../dist/js/bootstrap.min.js"></script> -->
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<!-- : <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script> -->



<!-- Scripts: JQuery -->
<script src="{{ asset('js/my/jquery-3.2.1.js') }}"></script> <!--JS храняться в public/js-->

<!-- Scripts: Bootstrap -->
<script src="{{ asset('js/my/bootstrap.min.js') }}"></script>

<!-- Scripts: Alertify (подключаем alertify в ведущем Шаблоне) -->
<script src="{{ asset('js/alertify/alertify.js') }}"></script>

@include('inc.messages')

<!--Подключаем секцию с JQuery Ajax кодом на удаление Категории / Статьи-->
@yield('js')

</body>
</html>