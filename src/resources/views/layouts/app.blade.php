<!DOCTYPE html>

<html>
    <head>
        <title>@yield('title')</title>
    </head>

    <body>
        <header>
            @include('layouts.navbar')
        </header>

        <main>
            @yield('content')
        </main>

        <footer>
            @include('layouts.footer')
        </footer>
    </body>
</html>