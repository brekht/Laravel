<!-- Create by Xenial -->
<!--https://startbootstrap.com/template-overviews/4-col-portfolio/-->

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Essences</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('any/essences/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ asset('any/essences/css/4-col-portfolio.css') }}" rel="stylesheet">

    <!-- My CSS -->
    <link href="{{ asset('any/essences/css/my.css') }}" rel="stylesheet">

</head>

<body>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">

        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">

                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/') }}">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('articles.show') }}">Articles</a>
                </li>

                    <li class="nav-item">
                        <a class="nav-link"></a>
                    </li>

                @auth
                <li class="nav-item">
                    <a class="nav-link" style="color: #9cdbdc" href="{{ route('account') }}">Account</a>
                </li>

                    <!--Если текущий пользователь является админом-->
                    @if(\Auth::user()->isAdmin == 1)
                        <li class="nav-item">
                            <a class="nav-link" style="color: #9cdbdc" href="{{ route('cabinet') }}">Cabinet</a>
                        </li>
                    @endif

                @endauth

            </ul>
        </div>
    </div>
</nav>

@yield('content')

<!-- Footer -->
<!--<footer class="py-5 bg-dark">-->
    <!--<div class="container">-->
        <!--<p class="m-0 text-center text-white">Copyright &copy; Your Website 2018</p>-->
    <!--</div>-->
    <!-- /.container -->
<!--</footer>-->

<!-- Bootstrap core JavaScript -->
<script src="{{ asset('any/essences/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('any/essences/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

</body>

</html>