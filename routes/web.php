<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FiliereController;
use App\Http\Controllers\EtablissementController;


Route::get('/', [EtablissementController::class, 'index'])->name('home');
Route::get('/inscription', [FiliereController::class, 'create'])->name('filieres.create');
Route::post('/inscription', [FiliereController::class, 'store'])->name('filieres.store');
Route::get('/', [EtablissementController::class, 'index'])->name('etablissements.index');

Route::get('/enscription', [EtablissementController::class, 'create'])->name('etablissement.create');
Route::post('/inscription_e', [EtablissementController::class, 'store'])->name('etablissement.store');
