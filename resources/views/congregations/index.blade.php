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
                            <label for="palavra_chave">Palavra chave:</label>
                            <input type="text" name="palavra_chave" id="palavra_chave">
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
                            <label for="genero">Gênero:</label>
                            <select name="genero" id="genero">
                                <option value="">Todos</option>
                                <option value="Masculino">Masculino</option>
                                <option value="Feminino">Feminino</option>
                            </select>
                        </div>
                        <div>
                            <label for="pais_fundacao">País - Fundação:</label>
                            <select name="pais_fundacao" id="pais_fundacao">
                                <option value="">Todos</option>
                                @if(isset($paises_fundacao))
                                    @foreach($paises_fundacao as $pais)
                                        <option value="{{ $pais }}">{{ $pais }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div>
                            <label for="pais_presente">Países - Presente:</label>
                            <select name="pais_presente" id="pais_presente">
                                <option value="">Todos</option>
                                @if(isset($pais_presente))
                                    @foreach($pais_presente as $pais)
                                        <option value="{{ $pais }}">{{ $pais }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div>
                            <label for="estados_presente">Estados brasileiros onde está presente:</label>
                            <select name="estados_presente" id="estados_presente">
                                <option value="">Todos</option>
                                @if(isset($estados_presente))
                                    @foreach($estados_presente as $estado)
                                        <option value="{{ $estado }}">{{ $estado }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div>
                            <label for="ano_fundacao">Ano - Fundação:</label>
                            <input type="number" name="ano_fundacao" id="ano_fundacao" min="0" max="2023">
                        </div>
                        <div>
                            <label for="ano_chegada">Ano - Chegada:</label>
                            <input type="number" name="ano_chegada" id="ano_chegada" min="0" max="2023">
                        </div>
                        <button type="submit">Buscar</button>
                    </form>
                </div>

                <div class="response-card card">
                    <h2>Resposta</h2>
                    <div class="response-content">
                        @if(isset($congregacoes) && $congregacoes->count() > 0)
                            <ul>
                                @foreach($congregacoes as $congregacao)
                                    <li>{{ $congregacao->nome }} - {{ $congregacao->pais->nome }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p>Nenhuma congregação encontrada.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

