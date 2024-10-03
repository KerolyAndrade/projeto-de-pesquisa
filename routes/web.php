<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CongregationController;
use App\Http\Controllers\SearchController;

// Rota para a página inicial
Route::get('/', [CongregationController::class, 'index'])->name('congregations.index');

// Rota para o mapa
Route::get('/mapa', [CongregationController::class, 'mapa'])->name('congregations.mapa');

// Rota para a equipe responsável
Route::get('/equipe', [CongregationController::class, 'equipe'])->name('congregations.equipe');

// Rota para pagina sobre 
Route::get('/sobre', [CongregationController::class, 'sobre'])->name('congregations.sobre');

Route::prefix('congregations')->group(function() {
    Route::get('/', [CongregationController::class, 'index'])->name('congregations.index');
    Route::get('/search', [CongregationController::class, 'search'])->name('congregations.search');
    Route::get('/suggestions', [CongregationController::class, 'suggestions'])->name('congregations.suggestions');
    Route::get('/autocomplete', [CongregationController::class, 'autocomplete'])->name('congregations.autocomplete');
    Route::post('/api/congregations', [CongregationController::class, 'filterByCountries']);
    Route::get('/autocomplete/names', [SearchController::class, 'autocompleteNames'])->name('autocomplete.names');
    Route::get('/autocomplete/alternatives', [SearchController::class, 'autocompleteAlternatives'])->name('autocomplete.alternatives');
    Route::get('/autocomplete/acronyms', [SearchController::class, 'autocompleteAcronyms'])->name('autocomplete.acronyms');
});




