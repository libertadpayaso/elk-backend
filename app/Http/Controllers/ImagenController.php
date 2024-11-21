<?php

namespace App\Http\Controllers;

use App\Imagen;
use App\Stock;
use App\Producto;
use Illuminate\Http\Request;
use App\Extensions\Helpers;
use Redirect;

class ImagenController extends Controller
{
	function crearImagen($sexo, $producto)
	{
		$producto = Producto::find($producto);
		return view('adm.productos.imagen.create', compact('producto', 'sexo'));
	}

	function listarImagenes($sexo, $producto)
	{
		$imagenes = Imagen::fromAlmacen()->where('producto_id', $producto)->get();
		$producto = Producto::find($producto);
		return view('adm.productos.imagen.list',  compact('imagenes', 'producto', 'sexo'));
	}

	function editarImagen($sexo, $producto, $id)
	{
		$imagen = Imagen::find($id);
		
		return view('adm.productos.imagen.edit', compact('imagen', 'producto', 'sexo'));
	}

	public function store(Request $request)
	{
		$datos = $request->all();

		$file_save = Helpers::saveImage($request->file('imagen'), 'imagenes');
		$file_save ? $datos['imagen'] = $file_save : false;

		$imagen = Imagen::create($datos);
		foreach ($imagen->producto->talles()->get() as $i => $talle)
		{
		   $stock = new Stock();
		   $stock->talle_id = $talle->id;
		   $stock->imagen_id = $imagen->id;
		   $stock->stock = 0;
		   $stock->save();
		}

		$success = 'Imagen creada correctamente';
		return back()->with('success', $success);
	}

	public function update(Request $request, $id)
	{
		$datos = $request->all();
		$imagen = Imagen::find($id);
		
		$file_save = Helpers::saveImage($request->file('imagen'), 'imagenes');
		$file_save ? $datos['imagen'] = $file_save : false;

		$imagen->fill($datos);
		$imagen->save();
		$success = 'Imagen editada correctamente';
		return back()->with('success', $success);
	}

	public function destroy($id)
	{
		$imagen = Imagen::find($id);
		
		foreach ($imagen->stocks as $stock) {
			$stock->delete();
		}

		$imagen->delete();
		
		$success = 'Imagen eliminada correctamente';
		return back()->with('success', $success);
	}
}
