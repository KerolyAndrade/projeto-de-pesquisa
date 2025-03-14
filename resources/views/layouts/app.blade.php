<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Congregações Católicas, Educação e Estado Nacional')</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <script src="{{ mix('js/app.js') }}" defer></script>

    @yield('styles')
</head>
<body>
    <header>
        <div class="header-container">
            @include('partials.header')
        </div>
    </header>

    <div class="container content" style="margin-top: 70px;">
        @yield('content')
    </div>

    <footer>
        @include('partials.footer')
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    @yield('scripts')
</body>
</html>

