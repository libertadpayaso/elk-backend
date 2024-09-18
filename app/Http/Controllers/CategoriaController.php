<?php

namespace App\Http\Controllers;

use App\Categoria;
use Illuminate\Http\Request;
use App\Extensions\Helpers;

class CategoriaController extends Controller
{
    function crearCategoria($sexo)
    {
        return view('adm.productos.categoria.create', compact('sexo'));
    }

    function listarCategorias($sexo)
    {
        $categorias = Categoria::where('sexo_id', $sexo)->orderBy('nombre', 'asc')->get();

        return view('adm.productos.categoria.list',  compact('categorias', 'sexo'));
    }

    function editarCategoria($sexo, $id)
    {
        $categoria = Categoria::find($id);
        return view('adm.productos.categoria.edit', compact('categoria', 'sexo'));
    }

    public function store(Request $request)
    {
        $datos = $request->all();
        $categoria = Categoria::create($datos);
        $file_save = Helpers::saveImage($request->file('imagen'), 'categorias', $categoria->id);
        $file_save ? $categoria->imagen = $file_save : false;
        $categoria->save();
        
        $success = 'Categoria creada correctamente';

        return back()->with('success', $success);
    }

    public function update(Request $request, $id)
    {
        if(!isset($request['activado'])){
            $request['activado'] = 0;
        }
        if(!isset($request['catalogo'])){
            $request['catalogo'] = 0;
        }
        $categoria = Categoria::find($id);
        $datos = $request->all();
        $file_save = Helpers::saveImage($request->file('imagen'), 'categorias', $categoria->id);
        $file_save ? $datos['imagen'] = $file_save : false;

        $categoria->fill($datos);
        $categoria->save();
        $success = 'Categoria editada correctamente';
        return back()->with('success', $success);
    }

    public function destroy($id)
    {
        $categoria = Categoria::find($id);
        
        foreach ($categoria->productos as $producto) {
            foreach ($producto->imagenes as $imagen) {
                foreach ($imagen->stock as $stock) {
                    $stock->delete();
                }
                $imagen->delete();
            }
            $producto->delete();
        }

        $categoria->delete();
        
        $success = 'Categoria eliminada correctamente';
        return back()->with('success', $success);
    }
}
