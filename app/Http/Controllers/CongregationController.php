<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Congregation;

class CongregationController extends Controller
{
    public function index()
    {
        $congregations = Congregation::paginate(10); // Fetch paginated congregations
        return view('congregations.index', compact( 'congregations'));
    }

    public function search(Request $request)
    {
        $query = Congregation::query();
        $congregations = $query->paginate(10); // Pagination

        if ($request->filled('nome_congregacao')) {
            $query->where('nome_congregacao', 'like', '%' . $request->nome_congregacao . '%');
        }

        if ($request->filled('palavra_chave')) {
            $query->where('palavra_chave', 'like', '%' . $request->palavra_chave . '%');
        }

        if ($request->filled('familia')) {
            $query->where('familia', $request->familia);
        }

        if ($request->filled('genero')) {
            $query->where('genero', $request->genero);
        }

        if ($request->filled('pais_fundacao')) {
            $query->where('pais_fundacao', $request->pais_fundacao);
        }

        if ($request->filled('paises_presente')) {
            $query->where('paises_presente', $request->paises_presente);
        }

        if ($request->filled('estados_presente')) {
            $query->where('estados_presente', $request->estados_presente);
        }

        if ($request->filled('ano_fundacao')) {
            $query->where('ano_fundacao', $request->ano_fundacao);
        }

        if ($request->filled('ano_chegada')) {
            $query->where('ano_chegada', $request->ano_chegada);
        }

        $congregations = $query->paginate(10); // Pagination
        return view('congregations.index', compact('congregations'));
    }
}