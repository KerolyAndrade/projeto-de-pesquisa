<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CongregationController;

Route::get('/', [CongregationController::class, 'index'])->name('congregations.index');
Route::get('/search', [CongregationController::class, 'search'])->name('congregations.search');
Route::get('/mapa', [CongregationController::class, 'mapa'])->name('congregations.mapa');

