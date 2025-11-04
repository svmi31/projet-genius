<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FiliereController;
use App\Http\Controllers\EtablissementController;
use App\Http\Controllers\AdminController;



/*Page d'accueil et liste des établissements*/
Route::get('/', [EtablissementController::class, 'index'])->name('etablissements.index');
// creation des routes de creation pour les filières
Route::get('/inscription', [FiliereController::class, 'create'])
    ->name('filieres.create');
Route::post('/inscription', [FiliereController::class, 'store'])
    ->name('filieres.store');
// Formulaire d'ajout
Route::get('/enscription', [EtablissementController::class, 'create'])
    ->name('etablissement.create');
// Enregistrement
Route::post('/inscription_e', [EtablissementController::class, 'store'])
    ->name('etablissement.store');
// Edition
Route::get('/etablissement/{id}/edit', [EtablissementController::class, 'edit'])
    ->name('etablissement.edit');
// Mise à jour
Route::put('/etablissement/{id}', [EtablissementController::class, 'update'])
    ->name('etablissement.update');
// Suppression
Route::delete('/etablissement/{id}', [EtablissementController::class, 'destroy'])
    ->name('etablissement.destroy');
// route super admin
Route::get('/admin', [EtablissementController::class, 'admin'])
    ->name('admin');
// Route pour admin
Route::get('/dashboard',[AdminController::class, 'select'])
    ->name('login');
Route::get('/dashboard/show',[AdminController::class, 'show'])
    ->name('admin_e');