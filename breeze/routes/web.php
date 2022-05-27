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


Route::get('/categorias', function ()
{
    return view('categorias');
})->middleware(['auth'])->name('categorias');

Route::get('/productos', function ()
{
    return view('productos');
})->middleware(['auth'])->name('productos');


require __DIR__.'/auth.php';
