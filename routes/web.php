<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('layouts.accueil');
});
Route::get('/service', [\App\Http\Controllers\CommandeController::class, 'commande']);

Route::get('/ajouterChauffeur', [\App\Http\Controllers\ChauffeurController::class,'ajouterChauffeur']);

Route::post('/enregistrer', [\App\Http\Controllers\ChauffeurController::class,'enregistrer_chauffeur'])->name('chauffeur.store');

Route::get('/chauffeur/{id}/edit', [\App\Http\Controllers\ChauffeurController::class, 'edit'])->name('chauffeur.edit');

Route::put('/chauffeur/{id}', [\App\Http\Controllers\ChauffeurController::class, 'update'])->name('chauffeur.update');

Route::delete('/chauffeur/{id}/delete', [App\Http\Controllers\ChauffeurController::class, 'destroy'])->name('chauffeur.delete');

Route::get('/liste', [\App\Http\Controllers\ChauffeurController::class,'liste'])->name('chauffeur.liste');

Route::get('/paiement', function () {
    return view('layouts.paiement');
});

Route::get('/login',[\App\Http\Controllers\AuthChauffeurController::class, 'login'])->name('chauffeur.login');

