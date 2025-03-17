<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Congregation;
use Illuminate\Support\Facades\Cache;

class CongregationController extends Controller
{
    public function index(Request $request)
    {
        // Cache para os filtros
        $filters = Cache::remember('congregation_filters', 60, function () {
            return [
                'familias' => Congregation::distinct()->pluck('familia_final')->sort(),
                'paises_fundacao' => Congregation::distinct()->pluck('pais_fundacao')->sort(),
                'estados_presente' => Congregation::distinct()->pluck('chegada_brasil_estado')->sort()
            ];
        });

        // Iniciar a query
        $query = Congregation::query();

        // Obter os dados do formulário
        $input = $request->only([
            'nome_principal', 'nomes_alternativos', 'siglas', 'familia_final',
            'pais_fundacao', 'chegada_brasil_estado', 'ano_fundacao_de', 'ano_fundacao_ate', 'genero'
        ]);

        // Aplicar filtros dinâmicos
        foreach ($input as $field => $value) {
            if ($request->filled($field)) {
                // Filtro para o ano de fundação
                if ($field == 'ano_fundacao_de') {
                    $query->whereYear('data_fundacao', '>=', $value);
                } elseif ($field == 'ano_fundacao_ate') {
                    $query->whereYear('data_fundacao', '<=', $value);
                }
                // Filtro para valores múltiplos (arrays)
                elseif (in_array($field, ['familia_final', 'pais_fundacao', 'chegada_brasil_estado']) && is_array($value)) {
                    $query->whereIn($field, $value);
                }
                // Filtro para gênero
                elseif ($field == 'genero') {
                    $query->where('genero', $value);
                }
                // Filtro para o nome da congregação e outros campos de texto
                else {
                    $query->where($field, 'like', '%' . $value . '%');
                }
            }
        }

        // Paginar os resultados
        $congregations = $query->paginate(10);

        // Retornar a view com os resultados e filtros
        return view('congregations.index', [
            'congregations' => $congregations,
            'filters' => $filters
        ]);
    }

    // Método para a busca específica
    public function search(Request $request)
    {
        // Verificar se a requisição é do tipo POST para aplicar a pesquisa
        if ($request->isMethod('post')) {
            return $this->index($request); // Chama o método index para aplicar a pesquisa
        }
        
        return redirect()->route('congregations.index'); // Caso contrário, redireciona para a página principal
    }

    // Outras páginas de informações
    public function sobre()
    {
        return view('congregations.sobre');
    }

    public function equipe()
    {
        return view('congregations.equipe');
    }

    public function mapa()
    {
        return view('congregations.mapa');
    }
}
