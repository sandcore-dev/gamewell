<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Gamewell') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <main>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-10">
                        <nav class="navbar navbar-expand-md px-0">
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>

                            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                <ul class="navbar-nav mr-auto">
                                </ul>
                                <ul class="navbar-nav ml-auto">
                                    <li class="nav-item">
                                        <form class="logout" action="{{ route('logout') }}" method="post">
                                            @csrf
                                            <label for="logout">@lang('Logout')</label>
                                            <button type="submit" id="logout">@lang('Logout')</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </nav>

                        <div class="logo">
                            <a href="{{ route('home') }}"><img src="{{ config('gamewell.header.image') }}" alt="logo"/></a>
                        </div>

                        @yield('content')
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
