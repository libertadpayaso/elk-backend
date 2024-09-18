<?php

namespace App\Http\Controllers;

use App\Promocion;
use App\Producto;
use Illuminate\Http\Request;
use App\Extensions\Helpers;

class PromocionController extends Controller
{
    function crearPromocion()
    {
        return view('adm.promocion.create');
    }

    function show()
    {
        $promociones = Promocion::orderBy('nombre', 'asc')->get();

        return view('adm.promocion.list',  compact('promociones'));
    }

    function editarPromocion($id)
    {
        $promocion = Promocion::find($id);
        return view('adm.promocion.edit', compact('promocion'));
    }

    public function store(Request $request)
    {
        $datos = $request->all();
        $promocion = Promocion::create($datos);
        $promocion->save();
        
        $success = 'Promoción creada correctamente';

        return back()->with('success', $success);
    }

    public function update(Request $request, $id)
    {
        if(!isset($request['activa'])){
            $request['activa'] = 0;
        }
        $promocion = Promocion::find($id);
        $datos = $request->all();

        $promocion->fill($datos);
        $promocion->save();
        $success = 'Promoción editada correctamente';
        return back()->with('success', $success);
    }

    public function destroy($id)
    {
        $promocion = Promocion::find($id);
        $promocion->delete();
        $success = 'Promoción eliminada correctamente';
        return back()->with('success', $success);
    }

    public function productosEnPromocion($id)
    {
        $promocion = Promocion::find($id);
        $productos = Producto::where('activado', 1)->orderBy('nombre', 'asc')->get();
        return view('adm.promocion.productos', compact('promocion', 'productos'));
    }

    public function guardarProductos(Request $request)
    {
        $promocion = Promocion::find($request['promocion_id']);
        $promocion->productos()->detach();
        if (isset($request['producto'])) {
            $promocion->productos()->attach($request['producto']);
        }
        $success = 'Promoción editada correctamente';
        return back()->with('success', $success);
    }
    
}
