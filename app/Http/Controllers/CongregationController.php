<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Congregation;

class CongregationController extends Controller
{
    // Método para exibir a lista de congregações
    public function index(Request $request)
    {
        // Definindo filtros (podem ser carregados do banco de dados ou definidos estaticamente)
        $filters = [
            'familias' => Congregation::distinct()->pluck('familia_final')->sort(),
            'paises_fundacao' => Congregation::distinct()->pluck('pais_fundacao')->sort(),
            'estados_presente' => Congregation::distinct()->pluck('chegada_brasil_estado')->sort()
        ];

        // Obtendo a pesquisa atual
        $query = Congregation::query();

        // Aplicando filtros conforme a pesquisa
        if ($request->filled('nome_congregacao')) {
            $query->where('nome_principal', 'like', '%' . $request->input('nome_congregacao') . '%');
        }

        if ($request->filled('nomes_alternativos')) {
            $query->where('nomes_alternativos', 'like', '%' . $request->input('nomes_alternativos') . '%');
        }

        if ($request->filled('siglas')) {
            $query->where('siglas', 'like', '%' . $request->input('siglas') . '%');
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
}
