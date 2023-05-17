<?php

use App\Http\Controllers\DeclarationsController;
use App\Http\Controllers\HerosController;
use App\Http\Controllers\IncidentsController;
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
    return view('welcome');
})->name('welcome');

Route::get('/heros', [HerosController::class, 'index'])->name('heros.index');
Route::get('/heros/create', [HerosController::class, 'create'])->name('heros.create');
Route::post('/heros', [HerosController::class, 'store'])->name('heros.store');
Route::get('/heros/{hero}', [HerosController::class, 'show'])->name('heros.show');
Route::get('/heros/{hero}/edit', [HerosController::class, 'edit'])->name('heros.edit');
Route::put('/heros/{hero}', [HerosController::class, 'update'])->name('heros.update');
Route::delete('/heros/{hero}', [HerosController::class, 'destroy'])->name('heros.destroy');

Route::get('/incidents', [IncidentsController::class, 'index'])->name('incidents.index');
Route::get('/incidents/create', [IncidentsController::class, 'create'])->name('incidents.create');
Route::post('/incidents', [IncidentsController::class, 'store'])->name('incidents.store');
Route::get('/incidents/{incident}/edit', [IncidentsController::class, 'edit'])->name('incidents.edit');
Route::put('/incidents/{incident}', [IncidentsController::class, 'update'])->name('incidents.update');
Route::delete('/incidents/{incident}', [IncidentsController::class, 'destroy'])->name('incidents.destroy');

Route::get('/declarations', [DeclarationsController::class, 'index'])->name('declarations.index');
Route::get('/declarations/create', [DeclarationsController::class, 'create'])->name('declarations.create');
Route::post('/declarations', [DeclarationsController::class, 'store'])->name('declarations.store');
Route::get('/declarations/{declaration}', [DeclarationsController::class, 'show'])->name('declarations.show');
Route::get('/declarations/{declaration}/edit', [DeclarationsController::class, 'edit'])->name('declarations.edit');
Route::put('/declarations/{declaration}', [DeclarationsController::class, 'update'])->name('declarations.update');
Route::delete('/declarations/{declaration}', [DeclarationsController::class, 'destroy'])->name('declarations.destroy');

