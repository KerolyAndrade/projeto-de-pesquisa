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
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Inicializar o mapa
            const map = L.map('world-map').setView([20, 0], 2); // Posição central inicial e zoom

            // Adicionar camada de tile do OpenStreetMap
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Função para atualizar o mapa com base nos filtros
            const updateMap = (filters) => {
                // Limpar marcadores anteriores
                map.eachLayer(function(layer) {
                    if (layer instanceof L.Marker) {
                        map.removeLayer(layer);
                    }
                });

                // Aqui você usaria um endpoint para buscar as congregações filtradas ou os dados já disponíveis
                fetch(`{{ route('congregations.index') }}?pais_fundacao[]=${filters.pais_fundacao.join('&pais_fundacao[]=')}&ano_fundacao_inicio=${filters.ano_fundacao_inicio}&ano_fundacao_fim=${filters.ano_fundacao_fim}`)
                    .then(response => response.json())
                    .then(data => {
                        // Adicionar os marcadores para as congregações no mapa
                        data.forEach(congregation => {
                            L.marker([congregation.latitude, congregation.longitude]).addTo(map)
                                .bindPopup(`<strong>${congregation.nome_principal}</strong><br>País: ${congregation.pais_fundacao}<br>Ano de Fundação: ${congregation.ano_fundacao}`);
                        });
                    });
            };

            // Formulário de filtro
            const filterForm = document.getElementById('filter-form');
            filterForm.addEventListener('submit', function(event) {
                event.preventDefault();
                const pais_fundacao = Array.from(document.getElementById('pais_fundacao').selectedOptions).map(option => option.value);
                const ano_fundacao_inicio = document.getElementById('ano_fundacao_inicio').value;
                const ano_fundacao_fim = document.getElementById('ano_fundacao_fim').value;

                // Atualizar o mapa com base nos filtros
                updateMap({
                    pais_fundacao: pais_fundacao,
                    ano_fundacao_inicio: ano_fundacao_inicio,
                    ano_fundacao_fim: ano_fundacao_fim
                });
            });

            // Função para limpar os filtros
            document.getElementById('reset-filters').addEventListener('click', function() {
                filterForm.reset();
                updateMap({
                    pais_fundacao: [],
                    ano_fundacao_inicio: '',
                    ano_fundacao_fim: ''
                });
            });

            // Inicializar o mapa com todos os resultados (sem filtros)
            updateMap({
                pais_fundacao: [],
                ano_fundacao_inicio: '',
                ano_fundacao_fim: ''
            });
        });
    </script>
@endsection
