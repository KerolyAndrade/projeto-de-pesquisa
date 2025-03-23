@extends('layouts.app')

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mapa Interativo</title>
    <!-- Adicionando os links do Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .controls {
            background-color: #f1f1f1;
            padding: 10px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .controls button {
            margin: 0 10px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border: none;
            background-color: #007BFF;
            color: white;
            border-radius: 5px;
        }

        .controls button:hover {
            background-color: #0056b3;
        }

        #map {
            height: 100vh;
            width: 100%;
        }
    </style>
</head>
<body>

    <div id="map"></div>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        let map;
        let marker;

        // Função que carrega o mapa
        function loadMap() {
            if (map) {
                map.remove();
            }

            map = L.map('map').setView([0, 0], 2); // Centralizando o mapa

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Adicionar GeoJSON dos países
            fetch('/path/to/countries.geojson')  // Caminho para o seu arquivo GeoJSON
                .then(response => response.json())
                .then(data => {
                    L.geoJSON(data, {
                        onEachFeature: function (feature, layer) {
                            layer.on({
                                click: function() {
                                    onCountryClick(feature);
                                }
                            });
                        }
                    }).addTo(map);
                });

            map.on('click', onMapClick);
        }

        // Função chamada ao clicar em um país
        function onCountryClick(feature) {
            const countryName = feature.properties.name;  // Supondo que o nome do país esteja na propriedade 'name'
            
            // Realiza uma requisição para buscar o número de congregações no país
            fetch(`/api/congregacoes/${countryName}`)
                .then(response => response.json())
                .then(data => {
                    const lat = feature.properties.latitude; // Supondo que você tenha latitude e longitude no GeoJSON
                    const lon = feature.properties.longitude;

                    // Se já houver um marcador, remova-o
                    if (marker) {
                        marker.remove();
                    }

                    // Adicionar um marcador no mapa
                    marker = L.marker([lat, lon]).addTo(map)
                        .bindPopup(`<b>País: ${countryName}</b><br>Congregações: ${data.congregacoes}`)
                        .openPopup();
                })
                .catch(error => console.error('Erro ao buscar congregações:', error));
        }

        // Função chamada ao clicar no mapa
        function onMapClick(e) {
            const lat = e.latlng.lat.toFixed(4);
            const lon = e.latlng.lng.toFixed(4);

            if (marker) {
                marker.remove();
            }

            marker = L.marker([lat, lon]).addTo(map)
                .bindPopup(`<b>Você clicou aqui!</b><br>Latitude: ${lat}<br>Longitude: ${lon}`)
                .openPopup();
        }

        loadMap();  // Chama a função para carregar o mapa
    </script>

</body>
</html>
