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
        $filters = Cache::remember('congregation_filters', 60, function () {
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
            'pais_fundacao', 'chegada_brasil_estado', 'ano_fundacao_de', 'ano_fundacao_ate', 'genero'
        ]);

        foreach ($input as $field => $value) {
            if ($request->filled($field)) {
                if ($field == 'ano_fundacao_de') {
                    $query->whereYear('data_fundacao', '>=', $value);
                } elseif ($field == 'ano_fundacao_ate') {
                    $query->whereYear('data_fundacao', '<=', $value);
                } elseif (in_array($field, ['familia_final', 'pais_fundacao', 'chegada_brasil_estado']) && is_array($value)) {
                    $query->whereIn($field, $value); // Para selects múltiplos
                } elseif ($field == 'genero') {
                    $query->where('genero', $value);
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

    // Método para pesquisa via POST
    public function search(Request $request)
    {
        if ($request->isMethod('post')) {
            return $this->index($request);
        }
        return redirect()->route('congregations.index');
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
