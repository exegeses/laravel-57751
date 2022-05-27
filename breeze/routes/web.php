<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

####### CRUD de marcas
use App\Http\Controllers\MarcaController;
Route::get('/marcas', [ MarcaController::class, 'index' ])
        ->middleware(['auth'])->name('marcas');
Route::get('/marca/create', [ MarcaController::class, 'create' ])
        ->middleware(['auth']);
Route::get('/marca/edit/{id}', [ MarcaController::class, 'edit' ])
        ->middleware(['auth']);

####### CRUD de categorías
use App\Http\Controllers\CategoriaController;
Route::controller( CategoriaController::class )->group(function ()
{
    Route::get('/categorias', 'index')
                ->middleware(['auth'])->name('categorias');
    Route::get('/categoria/create', 'create')
                ->middleware(['auth']);
    Route::get('/categoria/edit/{id}', 'edit')
                ->middleware(['auth']);
});



####### CRUD de productos
use App\Http\Controllers\ProductoController;
Route::get('/productos', [ ProductoController::class, 'index' ] )
        ->middleware(['auth'])->name('productos');


require __DIR__.'/auth.php';
