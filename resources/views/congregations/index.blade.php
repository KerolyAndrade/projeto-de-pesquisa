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
                            <input type="text" name="nome_congregacao" id="nome_congregacao">
                        </div>
                        <div>
                            <label for="familia_final">Família:</label>
                            <select name="familia_final" id="familia_final">
                                <option value="">Todos</option>
                                @foreach($filters['familias'] as $familia)
                                    <option value="{{ $familia }}">{{ $familia }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="pais_fundacao">País - Fundação:</label>
                            <select name="pais_fundacao" id="pais_fundacao">
                                <option value="">Todos</option>
                                @foreach($filters['paises_fundacao'] as $pais)
                                    <option value="{{ $pais }}">{{ $pais }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="pais_presente">Países - Presente:</label> <!-- Corrigido para 'paises_presente' -->
                            <select name="pais_presente" id="pais_presente"> <!-- Corrigido para 'pais_presente' -->
                                <option value="">Todos</option>
                                @foreach($filters['paises_presente'] as $pais) <!-- Corrigido para 'paises_presente' -->
                                    <option value="{{ $pais }}">{{ $pais }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="estados_presente">Estados - Presente:</label>
                            <select name="estados_presente" id="estados_presente">
                                <option value="">Todos</option>
                                @foreach($filters['estados_presente'] as $estado)
                                    <option value="{{ $estado }}">{{ $estado }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="ano_fundacao">Ano de Fundação:</label>
                            <input type="number" name="ano_fundacao" id="ano_fundacao">
                        </div>
                        <div>
                            <label for="ano_chegada">Ano de Chegada:</label>
                            <input type="number" name="ano_chegada" id="ano_chegada">
                        </div>
                        <button type="submit">Pesquisar</button>
                    </form>
                </div>
                <div class="results-card card">
                    <h2>Resultados</h2>
                    @if($congregations->isEmpty())
                        <p>Nenhuma congregação encontrada.</p>
                    @else
                        <table>
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Família</th>
                                    <th>País de Fundação</th>
                                    <th>Países Presente</th> <!-- Corrigido para 'paises_presente' -->
                                    <th>Estados Presente</th>
                                    <th>Data de Fundação</th>
                                    <th>Data de Chegada</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($congregations as $congregation)
                                    <tr>
                                        <td>{{ $congregation->nome_principal }}</td>
                                        <td>{{ $congregation->familia_final }}</td>
                                        <td>{{ $congregation->pais_fundacao }}</td>
                                        <td>{{ $congregation->paises_presente }}</td> <!-- Corrigido para 'paises_presente' -->
                                        <td>{{ $congregation->estados_presente }}</td>
                                        <td>
                                            @if(is_string($congregation->data_fundacao) || is_int($congregation->data_fundacao))
                                                {{ $congregation->data_fundacao }}
                                            @elseif($congregation->data_fundacao)
                                                {{ $congregation->data_fundacao->format('d/m/Y') }}
                                            @endif
                                        </td>
                                        <td>
                                            @if(is_string($congregation->chegada_brasil_estado) || is_int($congregation->chegada_brasil_estado))
                                                {{ $congregation->chegada_brasil_estado }}
                                            @elseif($congregation->chegada_brasil_estado)
                                                {{ $congregation->chegada_brasil_estado->format('d/m/Y') }}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $congregations->links() }}
                    @endif
                </div>
            </div>
        </div>
    </main>
@endsection