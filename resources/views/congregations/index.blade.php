@extends('layouts.app')

@section('content')
<main>
    <div class="database-content">
        <div class="card-container">
            <div class="search-card card">
                <h2>Pesquisa</h2>
                <form class="search-form" method="GET" action="{{ route('congregations.search') }}">
                    <div>
                        <label for="nome_congregacao">Nome da congregação:</label>
                        <input type="text" name="nome_congregacao" id="nome_congregacao" value="{{ request('nome_congregacao') }}">
                    </div>
                    <div>
                        <label for="familia_final">Família final:</label>
                        <select name="familia_final" id="familia_final">
                            <option value="">Selecione</option>
                            @foreach ($filters['familias'] as $familia)
                                <option value="{{ $familia }}"{{ request('familia_final') == $familia ? ' selected' : '' }}>{{ $familia }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="pais_fundacao">País de fundação:</label>
                        <select name="pais_fundacao" id="pais_fundacao">
                            <option value="">Selecione</option>
                            @foreach ($filters['paises_fundacao'] as $pais)
                                <option value="{{ $pais }}"{{ request('pais_fundacao') == $pais ? ' selected' : '' }}>{{ $pais }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="pais_presente">País presente:</label>
                        <select name="pais_presente" id="pais_presente">
                            <option value="">Selecione</option>
                            @foreach ($filters['paises_presente'] as $pais)
                                <option value="{{ $pais }}"{{ request('pais_presente') == $pais ? ' selected' : '' }}>{{ $pais }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="estados_presente">Estados presente:</label>
                        <select name="estados_presente" id="estados_presente">
                            <option value="">Selecione</option>
                            @foreach ($filters['estados_presente'] as $estado)
                                <option value="{{ $estado }}"{{ request('estados_presente') == $estado ? ' selected' : '' }}>{{ $estado }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="ano_fundacao">Ano de fundação:</label>
                        <input type="text" name="ano_fundacao" id="ano_fundacao" value="{{ request('ano_fundacao') }}">
                    </div>
                    <div>
                        <label for="ano_chegada">Ano de chegada:</label>
                        <input type="text" name="ano_chegada" id="ano_chegada" value="{{ request('ano_chegada') }}">
                    </div>
                    <div>
                        <button type="submit">Pesquisar</button>
                    </div>
                </form>
            </div>
            <div class="results-card card">
                <h2>Resultados</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Nome da congregação</th>
                            <th>Família final</th>
                            <th>País de fundação</th>
                            <th>País presente</th>
                            <th>Estados presente</th>
                            <th>Ano de fundação</th>
                            <th>Ano de chegada</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($congregations as $congregation)
                            <tr>
                                <td>{{ $congregation->nome_principal }}</td>
                                <td>{{ $congregation->familia_final }}</td>
                                <td>{{ $congregation->pais_fundacao }}</td>
                                <td>{{ $congregation->paises_presente }}</td>
                                <td>{{ $congregation->estados_presente }}</td>
                                <td>{{ $congregation->data_fundacao ? $congregation->data_fundacao->format('Y') : '' }}</td>
                                <td>{{ $congregation->chegada_brasil_ano }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $congregations->links() }}
            </div>
        </div>
    </div>
</main>
@endsection
