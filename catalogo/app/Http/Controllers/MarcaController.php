<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use App\Models\Producto;
use Illuminate\Http\Request;

class MarcaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //obtener listado de marcas
        $marcas = Marca::paginate(7);
        return view('marcas', [ 'marcas'=>$marcas ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('marcaCreate');
    }

    private function validarForm( Request $request )
    {
        $request->validate(
            [ 'mkNombre'=>'required|min:2|max:50' ],
            [
              'mkNombre.required'=>'El campo "Nombre de la marca" es obligatorio.',
              'mkNombre.min'=>'El campo "Nombre de la marca" debe tener como mínimo 2 caractéres.',
              'mkNombre.max'=>'El campo "Nombre de la marca" debe tener 50 caractéres como máximo.'
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //capturar dato enviado
        $mkNombre = $request->mkNombre;
        //validar
        $this->validarForm( $request );
        //instanciar + asignar atributo
        $Marca = new Marca;
        $Marca->mkNombre = $mkNombre;
        // guardar
        $Marca->save();
        //retorno con flashing de mensaje ok
        return redirect('/marcas')
                ->with(['mensaje'=>'Marca: '.$mkNombre.' agregada correctamente.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //obtener datos de una marca filtrada por su ID
        $Marca = Marca::find( $id );
        //retornar vista del formulario pasandoles los datos
        return view('marcaEdit', [ 'Marca'=>$Marca ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $mkNombre = $request->mkNombre;
        //validacion
        $this->validarForm($request);
        //obtenemos datos de la marca
        $Marca = Marca::find( $request->idMarca );
        //asignamos atributo
        $Marca->mkNombre = $mkNombre;
        //guardamos en tabla marcas
        $Marca->save();
        //retorno con flashing de mensaje ok
        return redirect('/marcas')
            ->with(['mensaje'=>'Marca: '.$mkNombre.' modificada correctamente.']);
    }

    private function productoPorMarca( $idMarca )
    {
        //$check = Producto::where('idMarca', $idMarca)->first();
        $check = Producto::firstWhere('idMarca', $idMarca);
        //$check = Producto::where('idMarca', $idMarca)->count();
        return $check;
    }

    public function confirm($id)
    {
        //obtenemos datos de la marca
        $Marca = Marca::find($id);

        //si NO hay productos de ese marca
        if( !$this->productoPorMarca($id) )
        {
            //retornamos vista de confirmación
            return view('marcaDelete', [ 'Marca'=>$Marca ]);
        }
        //redirección con mensaje que no se puede eliminar
        return redirect('/marcas')
            ->with(
                [
                    'warning'=>'warning',
                    'mensaje'=>'No se puede eliminar la marca: '.$Marca->mkNombre.' ya que tiene productos relacionados.'
                ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( Request $request )
    {
        /*
         * $Marca = Marca::find($request->idMarca);
            $Marca->delete();
         */
        Marca::destroy( $request->idMarca );
        //retorno con flashing de mensaje ok
        return redirect('/marcas')
            ->with(['mensaje'=>'Marca: '.$request->mkNombre.' eliminada correctamente.']);
    }
}
