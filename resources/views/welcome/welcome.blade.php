<!--Created by xenial-->

<!DOCTYPE html>
<html lang="en">
<head>

    <title>Welcome to Essences</title>

    <meta charset="utf-8">
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/my/welcome.css') }}" rel="stylesheet">

</head>
    <body>
        <div id="app">
            <nav class="navbar navbar-default navbar-static-top">
                <div class="container">

                    <div class="navbar-header">
                        <!-- Branding Image -->
                        @auth
                        <a class="navbar-brand" href="{{ route('account') }}">Account</a>
                        @endauth
                    </div>

                    <div class="collapse navbar-collapse" id="app-navbar-collapse">

                        <!-- Right Side Of Navbar -->
                        <ul class="nav navbar-nav navbar-right">
                            <!-- Authentication Links -->
                            @guest
                                <li><a href="{{ route('login') }}">Login</a></li>
                                <li><a href="{{ route('register') }}">Register</a></li>
                            @else
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
                            @endguest
                        </ul>

                    </div>
                </div>
            </nav>

            <div class="flex-center position-ref full-height">
                <div class="content">
                    <div class="title m-b-md">Welcome to Essences</div>
                    <div class="links">
                        <a href="{{route('essences.show')}}">Essences</a>
                        &
                        <a href="{{route('articles.show')}}">Articles</a>
                    </div>
                </div>
            </div>

        <!--end div id="app"--></div>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}"></script>

    </body>
</html>