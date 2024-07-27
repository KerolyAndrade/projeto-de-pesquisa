<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Congregation;

class CongregationController extends Controller
{
    public function index()
    {
        // Fetch all congregations with pagination or other logic
        $congregations = Congregation::paginate(10);
        
        // Fetch filters for the dropdowns
        $filters = [
            'familias' => Congregation::select('familia_final')->distinct()->pluck('familia_final'),
            'paises_fundacao' => Congregation::select('pais_fundacao')->distinct()->pluck('pais_fundacao'),
            'estados_presente' => Congregation::select('chegada_brasil_estado')->distinct()->pluck('chegada_brasil_estado'),
            'siglas' => Congregation::select('siglas')->distinct()->pluck('siglas'),
            'nomes_alternativos' => Congregation::select('nomes_alternativos')->distinct()->pluck('nomes_alternativos'),
        ];

        return view('congregations.index', compact('congregations', 'filters'));
    }

    public function search(Request $request)
    {
        $query = Congregation::query();

        // Apply filters based on user input
        if ($request->filled('nome_congregacao')) {
            $query->where('nome_principal', 'like', '%' . $request->input('nome_congregacao') . '%');
        }
        
        if ($request->filled('nomes_alternativos')) {
            $query->where('nomes_alternativos', 'like', '%' . $request->input('nomes_alternativos') . '%');
        }
        
        if ($request->filled('siglas')) {
            $query->where('siglas', $request->input('siglas'));
        }

        if ($request->filled('familia_final')) {
            $query->where('familia_final', $request->input('familia_final'));
        }

        if ($request->filled('data_fundacao')) {
            $query->whereYear('data_fundacao', $request->input('data_fundacao'));
        }

        if ($request->filled('pais_fundacao')) {
            $query->where('pais_fundacao', $request->input('pais_fundacao'));
        }

        if ($request->filled('chegada_brasil_estado')) {
            $query->where('chegada_brasil_estado', $request->input('chegada_brasil_estado'));
        }

        if ($request->filled('ano_fundacao')) {
            $query->whereYear('data_fundacao', $request->input('ano_fundacao'));
        }

        if ($request->filled('ano_chegada')) {
            $query->whereYear('ano_chegada', $request->input('ano_chegada'));
        }

        // Paginate the results
        $congregations = $query->paginate(10);

        // Fetch filters for the dropdowns
        $filters = [
            'familias' => Congregation::select('familia_final')->distinct()->pluck('familia_final'),
            'paises_fundacao' => Congregation::select('pais_fundacao')->distinct()->pluck('pais_fundacao'),
            'estados_presente' => Congregation::select('chegada_brasil_estado')->distinct()->pluck('chegada_brasil_estado'),
            'siglas' => Congregation::select('siglas')->distinct()->pluck('siglas'),
            'nomes_alternativos' => Congregation::select('nomes_alternativos')->distinct()->pluck('nomes_alternativos'),
        ];

        return view('congregations.index', compact('congregations', 'filters'));
    }
}
