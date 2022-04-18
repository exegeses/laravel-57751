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
Route::get('/region/edit/{id}', function ($id)
{
    //obtenemos datos de la región por su ID
    /*$region = DB::select('SELECT idRegion, regNombre
                            FROM regiones
                            WHERE idRegion = :idRegion',
                        [ $id ]);*/
    $region = DB::table('regiones')
                    ->where( 'idRegion', $id )
                    ->first(); //fetch
    //retornamos vista del formulario con sus datos cargados
    return view('regionEdit', [ 'region' => $region ]);
});
Route::post('/region/update', function ()
{
    $idRegion  = request()->idRegion;
    $regNombre = request()->regNombre;
    /*DB::update( 'UPDATE regiones
                    SET
                        regNombre = :regNombre
                    WHERE idRegion = :idRegion',
                [ $regNombre, $idRegion ]);*/
    DB::table('regiones')
        ->where( 'idRegion', $idRegion )
        ->update( [ 'regNombre'=>$regNombre ] );
    return redirect('/regiones')
        ->with(['mensaje'=>'Región '.$regNombre.' modificada correctamente']);
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
Route::get('/destino/create', function ()
{
    $regiones = DB::table('regiones')
                    ->select('idRegion','regNombre')
                    ->get();
    return view('destinoCreate', [ 'regiones' => $regiones ]);
});
Route::post('/destino/create', function ()
{
    $destNombre = request()->destNombre;
    $idRegion = request()->idRegion;
    $destPrecio = request()->destPrecio;
    $destAsientos = request()->destAsientos;
    $destDisponibles = request()->destDisponibles;
    //$destActivo = request()->destActivo;
    DB::table('destinos')
        ->insert([
                'destNombre'=>$destNombre,
                'idRegion'=>$idRegion,
                'destPrecio'=>$destPrecio,
                'destAsientos'=>$destAsientos,
                'destDisponibles'=>$destDisponibles
                /*'destActivo'=>$destActivo*/
            ]);

    return redirect('/destinos')
        ->with( [ 'mensaje'=>'Destino '.$destNombre.' agregado correctamente' ]);
});
