<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title> @yield('title') </title>

        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <script src="{{ asset('js/app.js') }}"></script>

        @yield('style')
    </head>

    <body>
        <nav class="navbar navbar-dark bg-dark mb-3">
            <div class="container">
                <a href="{{ route('dashboard') }}" class="navbar-brand">
                    Property Developer Information System
                </a>
            </div>
        </nav>

        @yield('content')
    </body>

    @yield('script')
</html>