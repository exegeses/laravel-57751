<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categorias = Categoria::paginate(7);
        return view('categorias', [ 'categorias' => $categorias ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categoriaCreate');
    }

    private function validarForm( Request $request )
    {
        $request->validate(
            [
                'catNombre'=>'required|min:2|max:30'
            ],
            [
                'catNombre.required' => 'El campo "Nombre de la categoría" es obligatorio.',
                'catNombre.min' => 'El campo "Nombre de la categoría" debe tener 2 caractéres como mínimo.',
                'catNombre.max' => 'El campo "Nombre de la categoría" no puede superar los 30 caractéres.'
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
        //capturar envio del form
        $catNombre = $request->catNombre;
        //validar
        $this->validarForm( $request );
        //instanciar & asignar atributo
        $Categoria = new Categoria;
        $Categoria->catNombre = $catNombre;
        //guardar en tabla
        $Categoria->save();
        //retorna a peticion con mensaje ok
        return redirect('/categorias')
            ->with(
                ['mensaje'=>'Categoría: '.$catNombre. ' agregada correctamente.']
            );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function show(Categoria $categoria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function edit( $id )
    {
        $Categoria = Categoria::find($id);
        return view('categoriaEdit', [ 'Categoria'=>$Categoria ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $catNombre = $request->catNombre;
        //validacion
        $this->validarForm($request);
        //obtenemos datos de la categoría
        $Categoria = Categoria::find($request->idCategoria);
        $Categoria->catNombre = $catNombre;
        $Categoria->save();
        return redirect('/categorias')
            ->with(
                ['mensaje'=>'Categoría: '.$catNombre. ' modificada correctamente.']
            );
    }

    private function productoPorCategoria( $idCategoria )
    {
        //$check = Producto::where('idCategoria', $idCategoria)->first();
        $check = Producto::firstWhere('idCategoria', $idCategoria);
        //$check = Producto::where('idCategoria', $idCategoria)->count();
        return $check;
    }

    public function confirm($id)
    {
        $Categoria = Categoria::find($id);
        if( !$this->productoPorCategoria($id) )
        {
            //retornamos vista de confirmación
            return view('categoriaDelete', [ 'Categoria'=>$Categoria ]);
        }
        //redirección con mensaje que no se puede eliminar
        return redirect('/categorias')
            ->with(
                [
                    'warning'=>'warning',
                    'mensaje'=>'No se puede eliminar la categoría: '.$Categoria->catNombre.' ya que tiene productos relacionados.'
                ]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function destroy( Request $request )
    {
        Categoria::destroy($request->idCategoria);
        return redirect('/categorias')
            ->with(
                ['mensaje'=>'Categoría: '.$request->catNombre. ' eliminada correctamente.']
            );
    }
}
