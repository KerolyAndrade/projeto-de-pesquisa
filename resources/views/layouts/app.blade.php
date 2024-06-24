<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Congregações Católicas, Educação e Estado Nacional')</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <link href="{{ asset('css/database.css') }}" rel="stylesheet">
    <link href="{{ asset('css/header.css') }}" rel="stylesheet">
    <!-- Adicione outros estilos aqui se necessário -->
</head>
<body>
    <header>
        <div class="header-container">
            @include('partials.header')
        </div>
    </header>

    <div class="content">
        @yield('content')
    </div>

    <footer>
        @include('partials.footer')
    </footer>

    <!-- Adicione scripts JS no final do body para melhor performance -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqvmap/1.5.1/jquery.vmap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqvmap/1.5.1/maps/jquery.vmap.world.js"></script>
    <script>
        $(document).ready(function() {
            // Configuração do mapa usando JQVMap
            $('#world-map').vectorMap({
                map: 'world_en',
                backgroundColor: 'transparent',
                borderColor: '#000',
                borderOpacity: 1,
                borderWidth: 1,
                color: '#fff',
                hoverColor: '#000',
                enableZoom: true,
                hoverOpacity: 0.7,
                normalizeFunction: 'linear',
                scaleColors: ['#000', '#fff'],
                selectedColor: '#000',
                selectedRegions: null,
                showTooltip: true,
                onRegionClick: function(event, code, region) {
                    alert('País selecionado: ' + region);
                }
            });
        });
    </script>
</body>
</html>
