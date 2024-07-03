<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Congregation;

class CongregationController extends Controller
{
    public function index()
    {
        $congregations = Congregation::paginate(10);
        $filters = $this->getFilters();
        return view('congregations.index', compact('congregations', 'filters'));
    }

    public function search(Request $request)
    {
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
            $query->where('pais_presente', $request->input('pais_presente'));
        }
        if ($request->filled('estados_presente')) {
            $query->where('estados_presente', $request->input('estados_presente'));
        }
        if ($request->filled('ano_fundacao')) {
            $query->where('ano_fundacao', $request->input('ano_fundacao'));
        }
        if ($request->filled('ano_chegada')) {
            $query->where('ano_chegada', $request->input('ano_chegada'));
        }

        $congregations = $query->paginate(10);
        $filters = $this->getFilters();

        return view('congregations.index', compact('congregations', 'filters'));
    }

    private function getFilters()
    {
        $filters = Congregation::select('familia_final', 'pais_fundacao', 'pais_presente', 'estados_presente')
            ->distinct()
            ->get();

        return [
            'familias' => $filters->pluck('familia_final')->filter()->unique(),
            'paises_fundacao' => $filters->pluck('pais_fundacao')->filter()->unique(),
            'pais_presente' => $filters->pluck('pais_presente')->filter()->unique(),
            'estados_presente' => $filters->pluck('estados_presente')->filter()->unique(),
        ];
    }

    public function mapa()
    {
        return view('congregations.mapa');
    }
}
