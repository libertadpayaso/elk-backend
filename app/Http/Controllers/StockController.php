<?php

namespace App\Http\Controllers;

use App\Stock;
use App\Imagen;
use App\Categoria;
use App\Producto;
use Illuminate\Http\Request;

class StockController extends Controller
{
    function listarStocks($imagen)
    {
        $stocks = Stock::where('imagen_id', $imagen)->get();
        $imagen = Imagen::find($imagen);
        return view('adm.productos.stock.list',  compact('stocks', 'imagen'));
    }

    public function update(Request $request)
    {
        $actualizar = ['categorias' => [], 'productos' =>[]];

        for ($i=0; $i < sizeof($request->id); $i++) { 

            $stock = Stock::find($request->id[$i]);
            $stock->stock = $request->stock[$i];
            $stock->save();

            $actualizar['categorias'][] = $stock->imagen->producto->categoria->id;
            $actualizar['productos'][]  = $stock->imagen->producto->id;
        }

        actualizarStock($actualizar);
        foreach ($actualizar['productos'] as $producto_id) {
            $producto = Producto::find($producto_id);
            $producto->calcularTallesDisponibles();
        }
        $success = 'Stock editado correctamente';
        return back()->with('success', $success);
    }

    public function clear($id)
    {

        $imagen = Imagen::find($id);

        foreach ($imagen->stocks as $stock) {

            $stock->stock = '0';
            $stock->save();
        }

        actualizarStock([
            'categorias' => [$imagen->producto->categoria->id],
            'productos'  => [$imagen->producto->id]
        ]);
        $imagen->producto->calcularTallesDisponibles();
        
        $success = 'Se vació el Stock del producto';
        return back()->with('success', $success);
    }

    public function clearAll($id)
    {
        $producto = Producto::find($id);

        foreach ($producto->imagenes()->get() as $imagen) {

            foreach ($imagen->stocks as $stock) {

                $stock->stock = '0';
                $stock->save();
            }
        }

        actualizarStock([
            'categorias' => [$producto->categoria->id],
            'productos'  => [$producto->id]
        ]);
        $producto->calcularTallesDisponibles();

        $success = 'Se vació el Stock del producto';
        return back()->with('success', $success);
    }

    public function actualizar()
    {
        set_time_limit(300);
        $result = actualizarStock();
    }
}
