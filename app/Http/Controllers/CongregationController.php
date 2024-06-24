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
    // Apply filters based on request parameters
    //...
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
        'familias' => $filters->pluck('familia_final')->unique(),
        'paises_fundacao' => $filters->pluck('pais_fundacao')->unique(),
        'pais_presente' => $filters->pluck('pais_presente')->unique(),
        'estados_presente' => $filters->pluck('estados_presente')->unique(),
    ];
}public function mapa()
{
    return view('congregations.mapa');
}


}
