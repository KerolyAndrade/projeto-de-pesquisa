<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Congregation;

class CongregationController extends Controller
{
    public function index()
    {
        $filters = $this->getFilters(); // Obter filtros

        // Paginar congregações com 10 por página
        $congregations = Congregation::paginate(10);

        // Passar congregações e filtros para a view
        return view('congregations.index', compact('congregations', 'filters'));
    }

    public function search(Request $request)
    {
        // Iniciar a query para congregações
        $query = Congregation::query();

        // Aplicar filtros com base nos parâmetros da solicitação
        if ($request->filled('nome_congregacao')) {
            $query->where('nome_principal', 'like', '%' . $request->input('nome_congregacao') . '%');
        }
        if ($request->filled('familia_final')) {
            $query->where('familia_final', $request->input('familia_final'));
        }
        if ($request->filled('pais_fundacao')) {
            $query->where('pais_fundacao', $request->input('pais_fundacao'));
        }
        if ($request->filled('pais_presente')) {
            $query->where('paises_presente', $request->input('pais_presente')); // Alterado para 'paises_presente'
        }
        if ($request->filled('estados_presente')) {
            $query->where('estados_presente', $request->input('estados_presente'));
        }
        if ($request->filled('ano_fundacao')) {
            $query->whereYear('data_fundacao', $request->input('ano_fundacao'));
        }
        if ($request->filled('ano_chegada')) {
            $query->whereYear('chegada_brasil_estado', $request->input('ano_chegada'));
        }

        // Obter filtros para exibição na view
        $filters = $this->getFilters();

        // Paginar resultados e passar para a view
        $congregations = $query->paginate(10);

        return view('congregations.index', compact('congregations', 'filters'));
    }

    private function getFilters()
    {
        // Selecionar filtros específicos das congregações
        $filters = Congregation::select('familia_final', 'pais_fundacao', 'paises_presente', 'estados_presente')
            ->distinct()
            ->get();

        // Retornar filtros como array associativo
        return [
            'familias' => $filters->pluck('familia_final')->filter()->unique(),
            'paises_fundacao' => $filters->pluck('pais_fundacao')->filter()->unique(),
            'paises_presente' => $filters->pluck('paises_presente')->filter()->unique(),
            'estados_presente' => $filters->pluck('estados_presente')->filter()->unique(),
        ];
    }

    public function mapa()
    {
        // Ação para exibir o mapa (se necessário)
        return view('congregations.mapa');
    }
}