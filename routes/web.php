<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CongregationController;

Route::get('/', [CongregationController::class, 'index'])->name('congregations.index');
Route::get('/mapa', [CongregationController::class, 'mapa'])->name('congregations.mapa');
Route::get('/congregations', [CongregationController::class, 'index'])->name('congregations.index');
Route::get('/congregations/search', [CongregationController::class, 'search'])->name('congregations.search');
Route::get('/congregations/suggestions', [CongregationController::class, 'suggestions'])->name('congregations.suggestions');