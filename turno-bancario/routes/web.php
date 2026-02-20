<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TurnoController;

Route::get('/', function () { return view('welcome'); });

Route::get('/turno',        [TurnoController::class, 'index'])     ->name('turno.index');
Route::post('/turno',       [TurnoController::class, 'registrar']) ->name('turno.registrar');
Route::get('/turno/reset',  [TurnoController::class, 'reset'])     ->name('turno.reset');
Route::post('/turno/atender', [TurnoController::class, 'atender'])->name('turno.atender');