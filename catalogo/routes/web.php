<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::view('/inicio', 'inicio');

########  crud de marcas  #######
use App\Http\Controllers\MarcaController;

//Route::get('peticion', acción);
Route::get('/marcas', [ MarcaController::class, 'index' ]);
Route::get('/marca/create', [ MarcaController::class, 'create' ]);
Route::post('/marca/store', [ MarcaController::class, 'store' ]);
