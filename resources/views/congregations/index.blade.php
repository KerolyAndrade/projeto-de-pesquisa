@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h1 class="mb-5">Pesquisa de Congregações</h1>
                <form action="{{ route('congregations.search') }}" method="POST" class="bg-light p-4 border rounded shadow-sm">
                    @csrf

                    @foreach([
                        'nome_congregacao' => 'Nome da Congregação',
                        'nomes_alternativos' => 'Nomes Alternativos',
                        'siglas' => 'Siglas'
                    ] as $name => $label)
                        <div class="form-group mb-4">
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
                        <div class="form-group mb-4">
                            <label for="{{ $name }}" class="form-label">{{ $filter['label'] }}</label>
                            <select name="{{ $name }}[]" class="form-control" id="{{ $name }}" aria-label="{{ $filter['label'] }}" multiple>
                                @foreach($filter['options'] as $option)
                                    <option value="{{ $option }}" {{ in_array($option, request($name, [])) ? 'selected' : '' }}>
                                        {{ $option }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endforeach

                    <div class="form-group mb-4">
                        <label for="genero" class="form-label">Gênero da Congregação</label>
                        <select name="genero" class="form-control" id="genero" aria-label="Gênero da Congregação">
                            <option value="">Todos</option>
                            <option value="f" {{ request('genero') == 'f' ? 'selected' : '' }}>Feminino</option>
                            <option value="m" {{ request('genero') == 'm' ? 'selected' : '' }}>Masculino</option>
                        </select>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label">Ano de Fundação</label>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="ano_fundacao_de" class="form-label">De</label>
                                <input type="number" name="ano_fundacao_de" class="form-control" id="ano_fundacao_de" placeholder="Ano inicial" value="{{ request('ano_fundacao_de') }}">
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="ano_fundacao_ate" class="form-label">Até</label>
                                <input type="number" name="ano_fundacao_ate" class="form-control" id="ano_fundacao_ate" placeholder="Ano final" value="{{ request('ano_fundacao_ate') }}">
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" onclick="clearForm()">Limpar</button>
                        <button type="submit" class="btn btn-primary">Buscar</button>
                    </div>
                </form>
            </div>

            <div class="col-md-8 mb-4">
                @if($congregations->isEmpty())
                    <div class="alert alert-info mt-3">
                        Nenhuma congregação encontrada.
                    </div>
                @else
                    @foreach($congregations as $index => $congregation)
                        <div class="congregation-card mb-4 p-4 border rounded shadow-sm">
                            <h2 class="text-primary congregation-name mb-3" data-id="{{ $congregation->id }}">
                                {{ ($congregations->currentPage() - 1) * $congregations->perPage() + $loop->iteration }}. {{ $congregation->nome_principal }}
                            </h2>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <small>
                                        <strong>Gênero:</strong> {{ $congregation->genero == 'f' ? 'Feminino' : ($congregation->genero == 'm' ? 'Masculino' : 'Não Informado') }}
                                    </small>
                                </div>
                                <div class="col-md-6 text-end">
                                    <small>
                                        <strong>País de Fundação:</strong> {{ $congregation->pais_fundacao ?? 'Não Informado' }}
                                    </small>
                                </div>
                            </div>

                            <div class="congregation-details" id="details-{{ $congregation->id }}" style="display: none;">
                                @include('congregations.partials.details', ['congregation' => $congregation])
                            </div>
                        </div>
                    @endforeach

                    <div class="mt-4">
                        {{ $congregations->links('pagination::bootstrap-4') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/congregations.js') }}" defer></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleDetails = (id) => {
                const details = document.getElementById(`details-${id}`);
                details.style.display = (details.style.display === 'none' || details.style.display === '') ? 'block' : 'none';
            };

            document.querySelectorAll('.congregation-name').forEach(name => {
                name.addEventListener('click', () => toggleDetails(name.getAttribute('data-id')));
            });

            window.clearForm = () => {
                document.querySelector('form').reset();
                window.location.href = "{{ route('congregations.index') }}";  
            };
        });
    </script>
@endsection

