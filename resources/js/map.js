document.addEventListener('DOMContentLoaded', function () {
    // Inicializa o mapa
    const map = L.map('world-map', {
        worldCopyJump: true,  // Permite a rolagem infinita horizontal no mapa
        maxBounds: [[-90, -180], [90, 180]],  // Limita os limites do mapa
        minZoom: 2,
        maxZoom: 19
    }).setView([20, 0], 2);  // Centro do mapa em um ponto mais adequado para visualização mundial

    // URL das tiles do OpenStreetMap
    const tileUrl = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';

    // Adiciona a camada de tiles do OpenStreetMap
    L.tileLayer(tileUrl, {
        maxZoom: 19,
        attribution: '© OpenStreetMap',
        noWrap: true  // Evita que o mapa se repita horizontalmente
    }).addTo(map);

    // Inicializa as camadas de países e congregações
    const countriesLayer = L.geoJSON().addTo(map);
    const congregationsLayer = L.layerGroup().addTo(map);

    // Função para buscar e adicionar dados das congregações
    function updateCongregations(countries) {
        fetch('/api/congregations', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ countries })
        })
        .then(response => response.json())
        .then(data => {
            congregationsLayer.clearLayers();
            data.forEach(cong => {
                L.marker([cong.latitude, cong.longitude])
                    .addTo(congregationsLayer)
                    .bindPopup(`<strong>${cong.name}</strong><br>${cong.address}`);
            });
        })
        .catch(error => {
            console.error('Erro ao buscar congregações:', error);
            alert('Ocorreu um erro ao carregar as congregações. Por favor, tente novamente.');
        });
    }

    // Função para adicionar a seleção de países
    function addCountrySelection() {
        const countriesUrl = '/path/to/countries.geojson'; // Substitua pelo caminho correto do arquivo GeoJSON
        fetch(countriesUrl)
            .then(response => response.json())
            .then(data => {
                countriesLayer.addData(data);
                countriesLayer.eachLayer(layer => {
                    layer.on('click', function () {
                        const countryName = layer.feature.properties.name;
                        const countryCode = layer.feature.properties.iso_a2;
                        const list = document.getElementById('selected-countries-list');
                        
                        // Verifica se o país já está na lista
                        if (!Array.from(list.children).some(li => li.dataset.country === countryCode)) {
                            const listItem = document.createElement('li');
                            listItem.textContent = countryName;
                            listItem.dataset.country = countryCode; 
                            listItem.addEventListener('click', function () {
                                listItem.remove(); // Remover o país ao clicar
                            });
                            list.appendChild(listItem);
                        }
                    });
                });
            })
            .catch(error => {
                console.error('Erro ao carregar dados dos países:', error);
                alert('Ocorreu um erro ao carregar os dados dos países. Por favor, tente novamente.');
            });
    }

    // Adiciona o evento de submissão do formulário de filtro
    document.getElementById('filter-form').addEventListener('submit', function (event) {
        event.preventDefault();
        const selectedCountries = Array.from(document.getElementById('selected-countries-list').children)
                                      .map(li => li.dataset.country);
        updateCongregations(selectedCountries);
    });

    // Limpa filtros e resultados
    document.getElementById('reset-filters').addEventListener('click', function () {
        document.getElementById('filter-form').reset();
        congregationsLayer.clearLayers();
        document.getElementById('selected-countries-list').innerHTML = '';
    });

    // Inicializa a seleção de países no mapa
    addCountrySelection();
});
