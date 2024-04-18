<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Gamewell') }}</title>

    <link rel="shortcut icon" href="{{ asset(config('gamewell.header.favicon')) }}">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <main>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-10">
                        <nav class="nav mt-2">
                            <div class="previous">
                                <a href="{{ route('games.index') }}">@lang('Games')</a>
                            </div>
                            <div class="next">
                                <form class="logout" action="{{ route('logout') }}" method="post">
                                    @csrf
                                    <label for="logout">@lang('Logout')</label>
                                    <button type="submit" id="logout">@lang('Logout')</button>
                                </form>
                            </div>
                        </nav>

                        <div class="logo">
                            <a href="{{ route('home') }}"><img src="{{ asset(config('gamewell.header.image')) }}" alt="logo"/></a>
                        </div>

                        @yield('content')
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
