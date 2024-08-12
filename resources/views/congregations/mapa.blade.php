@extends('layouts.app')

@section('title', 'Mapa das Congregações')

@section('head')
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <!-- Leaflet Draw CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-draw@1.0.4/dist/leaflet.draw.css" />
    <!-- CSS personalizado -->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}" />
    <style>
        /* Certifique-se de que o mapa ocupe a altura desejada */
        #world-map {
            width: 100%;
            height: 500px; /* Ajuste esta altura conforme necessário */
            /* height: 100vh; - Caso queira ocupar toda a altura da viewport */
        }

        /* Adiciona margem inferior para evitar sobreposição com o footer */
        main {
            margin-bottom: 50px; /* Ajuste conforme necessário */
        }
    </style>
@endsection

@section('content')
<main>
    <section class="map-section py-5">
        <div class="container">
            <h1 class="site-title mb-4 text-center">Mapa das Congregações</h1>

            <!-- Formulário de Filtro -->
            <form id="filter-form" class="row mb-4" aria-labelledby="filter-form-label">
                <div class="col-md-6 col-lg-4">
                    <div class="form-group">
                        <label for="pais_fundacao">País de Fundação</label>
                        <select id="pais_fundacao" name="pais_fundacao[]" multiple class="form-control" aria-describedby="pais_fundacao_help">
                            @foreach($filters['paises_fundacao'] as $pais)
                                <option value="{{ $pais }}">{{ $pais }}</option>
                            @endforeach
                        </select>
                        <small id="pais_fundacao_help" class="form-text text-muted">Selecione um ou mais países de fundação.</small>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="form-group">
                        <label for="ano_fundacao_inicio">Ano de Fundação (De)</label>
                        <input type="number" id="ano_fundacao_inicio" name="ano_fundacao_inicio" class="form-control" min="1900" max="{{ date('Y') }}" aria-describedby="ano_fundacao_inicio_help">
                        <small id="ano_fundacao_inicio_help" class="form-text text-muted">Insira o ano inicial da fundação.</small>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="form-group">
                        <label for="ano_fundacao_fim">Ano de Fundação (Até)</label>
                        <input type="number" id="ano_fundacao_fim" name="ano_fundacao_fim" class="form-control" min="1900" max="{{ date('Y') }}" aria-describedby="ano_fundacao_fim_help">
                        <small id="ano_fundacao_fim_help" class="form-text text-muted">Insira o ano final da fundação.</small>
                    </div>
                </div>
                <div class="col-12 text-center mt-3">
                    <button type="submit" class="btn btn-primary">Aplicar Filtros</button>
                    <button type="button" id="reset-filters" class="btn btn-secondary ml-2">Limpar Filtros</button>
                </div>
            </form>

            <!-- Mapa -->
            <div id="world-map" aria-label="Mapa mundial interativo"></div>

            <!-- Países Selecionados -->
            <div id="selected-countries" class="mt-4">
                <h4>Países Selecionados:</h4>
                <ul id="selected-countries-list" class="list-unstyled" aria-labelledby="selected-countries">
                    <!-- Lista de países selecionados será inserida aqui -->
                </ul>
            </div>

            <!-- Resultados -->
            <div id="results" class="mt-4">
                <!-- Os resultados serão injetados aqui pelo JavaScript -->
            </div>
        </div>
    </section>
</main>
@endsection

@section('scripts')
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" defer></script>
    <!-- Leaflet Draw JS -->
    <script src="https://unpkg.com/leaflet-draw@1.0.4/dist/leaflet.draw.js" defer></script>
    <!-- JS personalizado para o mapa -->
    <script src="{{ asset('js/map.js') }}" defer></script>
@endsection
