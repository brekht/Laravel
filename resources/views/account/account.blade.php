<!--Created by xenial-->

<!DOCTYPE html>
<html lang="en">
<head>

    <title>
        @if (Auth::user()->root == 1 && Auth::user()->isAdmin == 1) Root-Admin Account
        @elseif (Auth::user()->root == 0 && Auth::user()->isAdmin == 1) Admin Account
        @else Account
        @endif
    </title>

    <meta charset="utf-8">
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
    <body>
        <div id="app">
            <nav class="navbar navbar-default navbar-static-top">
                <div class="container">

                    @auth
                        <div class="navbar-header">
                            <!-- Branding Image -->
                            <a class="navbar-brand" href="{{ url('/') }}">
                                Home
                            </a>
                        </div>
                    @endauth

                    <div class="collapse navbar-collapse" id="app-navbar-collapse">

                        <!-- Right Side Of Navbar -->
                        <ul class="nav navbar-nav navbar-right">
                            <!-- Authentication Links -->

                            <!--@guest-->
                                <!--<li><a href="{{-- route('login') --}}">Login</a></li>-->
                                <!--<li><a href="{{-- route('register') --}}">Register</a></li>-->

                            <!--@else-->
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" v-pre>
                                        {{ Auth::user()->name }} <span class="caret"></span>
                                    </a>

                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="{{ route('logout') }}"
                                               onclick="event.preventDefault();
                                                             document.getElementById('logout-form').submit();">
                                                Logout
                                            </a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                {{ csrf_field() }}
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                            <!--@endguest-->

                        </ul>

                    </div>
                </div>
            </nav>


            <!-- ············································································ -->
            <div class="container">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="panel panel-default">
                            <div class="panel-heading">Dashboard</div>

                            <div class="panel-body">
                                @if (session('status'))
                                    <div class="alert alert-success">
                                        {{ session('status') }}
                                    </div>
                                @endif

                            <!-- После авторизации, мы можем обращаться через Фасад auth, получая данные о Авторизованном пользователе -->

                                <b>{{ Auth::user()->email }}</b> - You are logged
                                @if(Auth::user()->root == 1)
                                    in as <b>Root-Admin</b>!
                                @elseif(Auth::user()->root == 0 && Auth::user()->isAdmin == 1)
                                    in as <b>Admin</b>!
                                @elseif(Auth::user()->root == 0 && Auth::user()->isAdmin == 0)
                                    in a simple User
                                @endif

                                <div style="clear:both; margin-bottom: 10px;"></div><!--Clear-->

                                <!--Если текущий пользователь является Confirm или Root-Admin, формируем соответствующие ссылки-->
                                @if(Auth::user()->isConfirm == 1 or Auth::user()->root == 1)
                                    <a href="{{ route('cabinet') }}">go Cabinet</a>
                                @else
                                    <span style="color:#ff4661">Вы ограничены в правах Администратором!</span>
                                @endif

                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- ············································································ -->

        <!--end div id="app"--></div>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}"></script>


        <!-- Scripts: JQuery -->
        <script src="{{ asset('js/my/jquery-3.2.1.js') }}"></script> <!--JS храняться в public/js-->

        <!-- Scripts: Alertify -->
        <script src="{{ asset('js/alertify/alertify.js') }}"></script>

        @include('inc.messages');

    </body>
</html>