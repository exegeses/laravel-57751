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

//Route::get('/peticion', accion );
Route::get('/saludo', function ()
{
    return 'Hola mundo desde Laravel';
});
Route::get('/prueba', function ()
{
    return view('test');
});

// plantilla
Route::get('/inicio', function ()
{
    return view('inicio');
});

##### CRUD de regiones
Route::get('/regiones', function () {
    //obtenemos listado de regiones
    /*
    $regiones = DB::select('SELECT idRegion, regNombre

                                FROM regiones');
    */
    $regiones = DB::table('regiones')->get();

    return view('regiones', [ 'regiones'=>$regiones ]);
});
Route::get('/region/create', function ()
{
    return view('regionCreate');
});
Route::post('/region/store', function ()
{
    $regNombre = request()->regNombre;
    //insertamos en tabla regiones
    /*DB::insert(
                'INSERT INTO regiones
                            ( regNombre )
                        VALUE
                            ( :regNombre )',
                [ $regNombre ]
            );*/
    DB::table('regiones')
            ->insert([ 'regNombre'=>$regNombre ]);

    return redirect('/regiones')
                ->with(['mensaje'=>'Región '.$regNombre.' agregada correctamente']);
});

##### CRUD de destinos
Route::get('/destinos', function ()
{
    //raw sql
    /*$destinos = DB::select('
                        SELECT destinos.*, regiones.regNombre
                            FROM regiones, destinos
                            WHERE regiones.idRegion = destinos.idRegion');*/
    // query Builder
    $destinos = DB::table('destinos as d')
            ->join('regiones as r','d.idRegion','=','r.idRegion')
            ->select('d.*','r.regNombre')
            ->get();
    return view('destinos', [ 'destinos' => $destinos ] );
});
