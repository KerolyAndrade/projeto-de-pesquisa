<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Congregation;
use Illuminate\Support\Facades\Cache;

class CongregationController extends Controller
{
    // Método para exibir a lista de congregações
    public function index(Request $request)
    {
        // Definindo filtros com cache para melhorar o desempenho
        $filters = Cache::remember('congregation_filters', 60, function() {
            return [
                'familias' => Congregation::distinct()->pluck('familia_final')->sort(),
                'paises_fundacao' => Congregation::distinct()->pluck('pais_fundacao')->sort(),
                'estados_presente' => Congregation::distinct()->pluck('chegada_brasil_estado')->sort()
            ];
        });

        // Obtendo a pesquisa atual
        $query = Congregation::query();

        // Sanitizar e aplicar filtros conforme a pesquisa
        $input = $request->only([
            'nome_congregacao', 'nomes_alternativos', 'siglas', 'familia_final',
            'data_fundacao', 'pais_fundacao', 'chegada_brasil_estado', 'ano_fundacao', 'ano_chegada'
        ]);

        foreach ($input as $field => $value) {
            if ($request->filled($field)) {
                if (in_array($field, ['data_fundacao', 'ano_fundacao', 'ano_chegada'])) {
                    $query->whereYear($field, $value);
                } else {
                    $query->where($field, 'like', '%' . $value . '%');
                }
            }
        }

        $congregations = $query->paginate(10);

        return view('congregations.index', [
            'congregations' => $congregations,
            'filters' => $filters
        ]);
    }

    // Método para pesquisa
    public function search(Request $request)
    {
        // Redireciona para o método index com os parâmetros de pesquisa
        return $this->index($request);
    }

    // Páginas adicionais
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
