<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title> @yield('title') </title>

        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        @yield('style')
    </head>

    <body>
        <nav class="navbar navbar-dark bg-dark justify-content-between mb-3">
            <div class="container">
                <a href="{{ route('dashboard.show') }}" class="navbar-brand">
                    {{ config('app.name') }}
                </a>

                <form method="POST" action="{{ route('logout') }}" class="form-inline">
                    @csrf
                    <button class="btn btn-danger">
                        Log Out
                        <i class="fa fa-sign-out"></i>
                    </button>
                </form>
            </div>
        </nav>

        <div class="container" id="app">
            <div class="alert alert-info">
                <i class="fa fa-info"></i>
                Anda Log In dengan nama {{ auth()->user()->name }} dan status {{ auth()->user()->privilege }}
            </div>
        </div>

        @yield('content')
    </body>

    <script src="{{ asset('js/app.js') }}"></script>

    @yield('script')

    <script>
        $(document).ready(() => {
            $('#notification').fadeOut(5000);
        });
    </script>
</html>
