@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Congregações</h1>

        <form action="{{ route('congregations.search') }}" method="GET">
            <div class="row">
                <!-- Campos de Pesquisa -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="nome_congregacao">Nome da Congregação</label>
                        <input type="text" name="nome_congregacao" class="form-control" id="nome_congregacao" placeholder="Digite o nome da congregação" value="{{ request('nome_congregacao') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="nomes_alternativos">Nomes Alternativos</label>
                        <input type="text" name="nomes_alternativos" class="form-control" id="nomes_alternativos" placeholder="Digite os nomes alternativos" value="{{ request('nomes_alternativos') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="siglas">Siglas</label>
                        <input type="text" name="siglas" class="form-control" id="siglas" placeholder="Digite as siglas" value="{{ request('siglas') }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- Filtros de Pesquisa Avançada -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="familia_final">Família Final</label>
                        <select name="familia_final" class="form-control" id="familia_final">
                            <option value="">Selecione</option>
                            @foreach($filters['familias'] as $familia)
                                <option value="{{ $familia }}" {{ request('familia_final') == $familia ? 'selected' : '' }}>{{ $familia }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="data_fundacao">Ano de Fundação</label>
                        <input type="number" name="data_fundacao" class="form-control" id="data_fundacao" placeholder="Digite o ano de fundação" value="{{ request('data_fundacao') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="pais_fundacao">País de Fundação</label>
                        <select name="pais_fundacao" class="form-control" id="pais_fundacao">
                            <option value="">Selecione</option>
                            @foreach($filters['paises_fundacao'] as $pais)
                                <option value="{{ $pais }}" {{ request('pais_fundacao') == $pais ? 'selected' : '' }}>{{ $pais }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- Mais Filtros -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="chegada_brasil_estado">Estado de Chegada ao Brasil</label>
                        <select name="chegada_brasil_estado" class="form-control" id="chegada_brasil_estado">
                            <option value="">Selecione</option>
                            @foreach($filters['estados_presente'] as $estado)
                                <option value="{{ $estado }}" {{ request('chegada_brasil_estado') == $estado ? 'selected' : '' }}>{{ $estado }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="ano_fundacao">Ano de Fundação</label>
                        <input type="number" name="ano_fundacao" class="form-control" id="ano_fundacao" placeholder="Digite o ano de fundação" value="{{ request('ano_fundacao') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="ano_chegada">Ano de Chegada</label>
                        <input type="number" name="ano_chegada" class="form-control" id="ano_chegada" placeholder="Digite o ano de chegada" value="{{ request('ano_chegada') }}">
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Buscar</button>
        </form>

        @if($congregations->isEmpty())
            <div class="alert alert-info mt-3">
                Nenhuma congregação encontrada.
            </div>
        @else
            @foreach($congregations as $congregation)
                <div class="congregation-card mt-4 p-3 border rounded">
                    <h2 class="text-primary">{{ $congregation->nome_principal }}</h2>
                    
                    <!-- Seção de Dados Gerais -->
                    <div class="section mb-3">
                        <h3>Dados Gerais</h3>
                        <p><strong>Nomes Alternativos:</strong> {{ $congregation->nomes_alternativos }}</p>
                        <p><strong>Siglas:</strong> {{ $congregation->siglas }}</p>
                        <p><strong>Família Final:</strong> {{ $congregation->familia_final }}</p>
                        <p><strong>Gênero da Congregação:</strong> {{ $congregation->genero == 'f' ? 'Feminino' : 'Masculino' }}</p>
                    </div>

                    <!-- Seção de Fundação -->
                    <div class="section mb-3">
                        <h3>Fundação</h3>
                        <p><strong>Ano de Fundação:</strong> {{ \Carbon\Carbon::parse($congregation->data_fundacao)->format('Y') }}</p>
                        <p><strong>Local de Fundação:</strong> {{ $congregation->cidade_fundacao }}, {{ $congregation->pais_fundacao }}</p>
                    </div>

                    <!-- Seção de Congregação no Brasil -->
                    <div class="section mb-3">
                        <h3>Congregação no Brasil</h3>
                        <p><strong>Estado de Chegada ao Brasil:</strong> {{ $congregation->chegada_brasil_estado }}</p>
                        <p><strong>Município de Chegada ao Brasil:</strong> {{ $congregation->chegada_brasil_municipio }}</p>
                        <p><strong>Membros no Brasil:</strong> {{ $congregation->membros_brasil }}</p>
                        <p><strong>Irmãos/ãs:</strong> {{ $congregation->irmãos_as }}</p>
                        <p><strong>Postulantes:</strong> {{ $congregation->postulantes }}</p>
                        <p><strong>Noviços:</strong> {{ $congregation->noviços }}</p>
                    </div>

                    <!-- Seção de Informações Qualitativas -->
                    <div class="section mb-3">
                        <h3>Informações Qualitativas</h3>
                        <p><strong>Carisma:</strong> {{ $congregation->carisma }}</p>
                        <p><strong>Motivos da Vinda:</strong> {{ $congregation->motivos_vinda }}</p>
                    </div>
                </div>
            @endforeach

            <!-- Paginação -->
            <div class="mt-4">
                {{ $congregations->links() }}
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('#searchInput').on('input', function() {
            let query = $(this).val();
            $.ajax({
                url: '{{ route('congregations.suggestions') }}',
                data: { query: query },
                success: function(data) {
                    $('#suggestions').empty();
                    data.forEach(item => {
                        $('#suggestions').append('<div>' + item + '</div>');
                    });
                }
            });
        });
    </script>
@endsection
