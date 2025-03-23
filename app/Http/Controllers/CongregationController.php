<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Congregation;
use Illuminate\Support\Facades\Cache;

class CongregationController extends Controller
{
    // Método para obter os filtros de pesquisa e cacheá-los
    protected function getFilters()
    {
        return Cache::remember('congregation_filters', 60, function () {
            return [
                'familias' => Congregation::distinct()->pluck('familia_final')->sort(),
                'paises_fundacao' => Congregation::distinct()->pluck('pais_fundacao')->sort(),
                'estados_presente' => Congregation::distinct()->pluck('chegada_brasil_estado')->sort()
            ];
        });
    }

    // Método de exibição das congregações com filtros aplicados
    public function index(Request $request)
    {
        $filters = $this->getFilters();
        $query = Congregation::query();

        // Obtém todos os parâmetros de pesquisa da requisição
        $input = $request->only([
            'nome_principal', 'nomes_alternativos', 'siglas', 'familia_final',
            'pais_fundacao', 'chegada_brasil_estado', 'ano_fundacao_de', 'ano_fundacao_ate', 'genero'
        ]);

        // Aplica cada filtro de acordo com os valores da requisição
        foreach ($input as $field => $value) {
            if ($request->filled($field)) {
                $this->applyFilter($query, $field, $value);
            }
        }

        // Paginação de resultados
        $congregations = $query->paginate(10);

        return view('congregations.index', [
            'congregations' => $congregations,
            'filters' => $filters
        ]);
    }

    // Método para aplicar filtros de pesquisa no query
    protected function applyFilter($query, $field, $value)
    {
        if ($field == 'ano_fundacao_de') {
            $query->whereYear('data_fundacao', '>=', $value);
        } elseif ($field == 'ano_fundacao_ate') {
            $query->whereYear('data_fundacao', '<=', $value);
        } elseif (in_array($field, ['familia_final', 'pais_fundacao', 'chegada_brasil_estado']) && is_array($value)) {
            $query->whereIn($field, $value);
        } elseif ($field == 'genero') {
            // Verifica se o gênero é válido, ignorando maiúsculas/minúsculas
            $validGeneros = ['f', 'm']; // 'f' para feminino, 'm' para masculino
            if (in_array(strtolower($value), $validGeneros)) {
                $query->whereRaw('LOWER(genero) = ?', [strtolower($value)]);
            }
        } else {
            // Aplica filtro para qualquer outro campo utilizando LIKE insensível a maiúsculas/minúsculas
            $query->whereRaw('LOWER(' . $field . ') LIKE ?', [strtolower('%' . trim($value) . '%')]);
        }
    }

    public function search(Request $request)
    {
        // Se for uma requisição POST, chama o método 'index' para pesquisar
        if ($request->isMethod('post')) {
            return $this->index($request);
        }
    
        // Se for uma requisição GET, apenas retorna a view inicial (sem resultados)
        return redirect()->route('congregations.index');
    }    

    // Métodos adicionais para outras páginas (sobre, equipe, mapa)
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
