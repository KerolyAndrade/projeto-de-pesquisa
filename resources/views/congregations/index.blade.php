@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <!-- Formulário de Pesquisa -->
            <div class="col-md-4 mb-4">
                <h1 class="mb-4">Pesquisa de Congregações</h1>
                <form action="{{ route('congregations.search') }}" method="GET" class="bg-light p-4 border rounded shadow-sm">
                    @foreach([
                        'nome_congregacao' => 'Nome da Congregação',
                        'nomes_alternativos' => 'Nomes Alternativos',
                        'siglas' => 'Siglas'
                    ] as $name => $label)
                        <div class="form-group mb-3">
                            <label for="{{ $name }}" class="form-label">{{ $label }}</label>
                            <input type="text" name="{{ $name }}" class="form-control" id="{{ $name }}"
                                   placeholder="Digite o {{ strtolower($label) }}"
                                   value="{{ request($name) }}" aria-label="{{ $label }}">
                        </div>
                    @endforeach

                    @foreach([
                        'familia_final' => ['label' => 'Família Final', 'options' => $filters['familias']],
                        'pais_fundacao' => ['label' => 'País de Fundação', 'options' => $filters['paises_fundacao']],
                        'chegada_brasil_estado' => ['label' => 'Estado de Chegada ao Brasil', 'options' => $filters['estados_presente']]
                    ] as $name => $filter)
                        <div class="form-group mb-3">
                            <label for="{{ $name }}" class="form-label">{{ $filter['label'] }}</label>
                            <select name="{{ $name }}" class="form-control" id="{{ $name }}" aria-label="{{ $filter['label'] }}">
                                <option value="">Selecione</option>
                                @foreach($filter['options'] as $option)
                                    <option value="{{ $option }}" {{ request($name) == $option ? 'selected' : '' }}>
                                        {{ $option }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endforeach

                    <!-- Novo campo para gênero -->
                    <div class="form-group mb-3">
                        <label for="genero" class="form-label">Gênero da Congregação</label>
                        <select name="genero" class="form-control" id="genero" aria-label="Gênero da Congregação">
                            <option value="">Todos</option>
                            <option value="f" {{ request('genero') == 'f' ? 'selected' : '' }}>Feminino</option>
                            <option value="m" {{ request('genero') == 'm' ? 'selected' : '' }}>Masculino</option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" onclick="clearForm()">Limpar</button>
                        <button type="submit" class="btn btn-primary">Buscar</button>
                    </div>
                </form>
            </div>

            <!-- Resultados da Pesquisa -->
            <div class="col-md-8 mb-4">
                @if($congregations->isEmpty())
                    <div class="alert alert-info mt-3">
                        Nenhuma congregação encontrada.
                    </div>
                @else
                    @foreach($congregations as $index => $congregation)
                        <div class="congregation-card mb-4 p-4 border rounded shadow-sm">
                            <!-- Nome da Congregação e Informações Básicas -->
                            <h2 class="text-primary congregation-name mb-3" data-id="{{ $congregation->id }}">
                                {{ ($congregations->currentPage() - 1) * $congregations->perPage() + $loop->iteration }}. {{ $congregation->nome_principal }}
                            </h2>
                            <div class="congregation-info mb-3">
                                <small>
                                    <strong>Siglas:</strong> {{ $congregation->siglas ?? 'Não Informado' }}<br>
                                    <strong>Ano de Fundação:</strong> {{ \Carbon\Carbon::parse($congregation->data_fundacao)->year ?? 'Não Informado' }}<br>
                                    <strong>País de Fundação:</strong> {{ $congregation->pais_fundacao ?? 'Não Informado' }}<br>
                                    <strong>Gênero:</strong> {{ $congregation->genero == 'f' ? 'Feminino' : ($congregation->genero == 'm' ? 'Masculino' : 'Não Informado') }}
                                </small>
                            </div>

                            <!-- Seção de Detalhes (inicialmente oculta) -->
                            <div class="congregation-details" id="details-{{ $congregation->id }}" style="display: none;">
                                <!-- Seção de Dados Gerais -->
                                <div class="section mb-3">
                                    <h3 class="section-title">Dados Gerais</h3>
                                    <p><strong>Nomes Alternativos:</strong> {{ $congregation->nomes_alternativos ?? 'Não Informado' }}</p>
                                    <p><strong>Família Final:</strong> {{ $congregation->familia_final ?? 'Não Informado' }}</p>
                                </div>

                                <!-- Seção de Fundação -->
                                <div class="section mb-3">
                                    <h3 class="section-title">Fundação</h3>
                                    <p><strong>Ano de Fundação:</strong> {{ \Carbon\Carbon::parse($congregation->data_fundacao)->year ?? 'Não Informado' }}</p>
                                    <p><strong>País de Fundação:</strong> {{ $congregation->pais_fundacao ?? 'Não Informado' }}</p>
                                    <p><strong>Cidade de Fundação:</strong> {{ $congregation->cidade_fundacao ?? 'Não Informado' }}</p>
                                </div>

                                <!-- Seção de Chegada ao Brasil -->
                                <div class="section mb-3">
                                    <h3 class="section-title">Chegada ao Brasil</h3>
                                    <p><strong>Estado:</strong> {{ $congregation->chegada_brasil_estado ?? 'Não Informado' }}</p>
                                    <p><strong>Município:</strong> {{ $congregation->chegada_brasil_municipio ?? 'Não Informado' }}</p>
                                </div>

                                <!-- Seção de Membros -->
                                <div class="section mb-3">
                                    <h3 class="section-title">Membros</h3>
                                    <p><strong>Membros no Brasil:</strong> {{ $congregation->membros_brasil ?? 'Não Informado' }}</p>
                                    <p><strong>Irmandade:</strong> {{ $congregation->irmaos ?? 'Não Informado' }}</p>
                                    <p><strong>Postulantes:</strong> {{ $congregation->postulantes ?? 'Não Informado' }}</p>
                                    <p><strong>Noviços:</strong> {{ $congregation->novicos ?? 'Não Informado' }}</p>
                                </div>

                                <!-- Seção de Carisma -->
                                <div class="section mb-3">
                                    <h3 class="section-title">Carisma</h3>
                                    <p>{{ $congregation->carisma ?? 'Não Informado' }}</p>
                                </div>

                                <!-- Seção de Motivos da Vinda -->
                                <div class="section mb-3">
                                    <h3 class="section-title">Motivos da Vinda</h3>
                                    <p>{{ $congregation->motivos_vinda ?? 'Não Informado' }}</p>
                                </div>

                                <!-- Seção de Referências -->
                                <div class="section mb-3">
                                    <h3 class="section-title">Referências</h3>
                                    @if($congregation->sources->isNotEmpty())
                                        @foreach($congregation->sources as $index => $source)
                                            <p>[{{ $index + 1 }}] <a href="{{ $source->url }}" target="_blank">{{ $source->url }}</a></p>
                                        @endforeach
                                    @else
                                        <p>Não Informado</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <!-- Paginação -->
                    <div class="mt-4">
                        {{ $congregations->links('pagination::bootstrap-4') }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Função para alternar a exibição dos detalhes da congregação
            const toggleDetails = (id) => {
                const details = document.getElementById(`details-${id}`);
                details.style.display = (details.style.display === 'none' || details.style.display === '') ? 'block' : 'none';
            };

            document.querySelectorAll('.congregation-name').forEach(name => {
                name.addEventListener('click', () => toggleDetails(name.getAttribute('data-id')));
            });

            // Função para limpar o formulário
            window.clearForm = () => document.querySelector('form').reset();
        });
        
    </script>
@endsection
