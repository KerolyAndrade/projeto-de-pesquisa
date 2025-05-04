<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CongregationController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SatisfactionSurveyController;
use Illuminate\Http\Request;

// Rota principal
Route::get('/', [CongregationController::class, 'index'])->name('congregations.index');

// Outras rotas de páginas estáticas
Route::get('/sobre', [CongregationController::class, 'sobre'])->name('congregations.sobre');
Route::get('/equipe', [CongregationController::class, 'equipe'])->name('congregations.equipe');
Route::get('/mapa', [CongregationController::class, 'mapa'])->name('congregations.mapa');
Route::get('/apresentacao', [CongregationController::class, 'apresentacao'])->name('congregations.apresentacao');

// Rota para Política de Privacidade (LGPD)
Route::get('/termos', function () {
    return view('termos'); 
})->name('termos');

// Rotas com prefixo 'congregations'
Route::prefix('congregations')->group(function() {
    // Rota de pesquisa de congregações
    Route::match(['get', 'post'], '/search', [CongregationController::class, 'search'])->name('congregations.search');
    Route::get('/suggestions', [CongregationController::class, 'suggestions'])->name('congregations.suggestions');
    Route::get('/autocomplete', [CongregationController::class, 'autocomplete'])->name('congregations.autocomplete');
    Route::post('/api/congregations', [CongregationController::class, 'filterByCountries']);
    
    // Rotas para autocomplete
    Route::get('/autocomplete/names', [SearchController::class, 'autocompleteNames'])->name('autocomplete.names');
    Route::get('/autocomplete/alternatives', [SearchController::class, 'autocompleteAlternatives'])->name('autocomplete.alternatives');
    Route::get('/autocomplete/acronyms', [SearchController::class, 'autocompleteAcronyms'])->name('autocomplete.acronyms');

    // Rota para enviar o formulário de pesquisa de satisfação
    Route::post('/enviar-formulario', [SatisfactionSurveyController::class, 'store'])->name('formulario.submit');

    // Rota para exportar os dados das pesquisas de satisfação
    Route::get('/exportar-pesquisas', [SatisfactionSurveyController::class, 'export'])->name('survey.export');
});
