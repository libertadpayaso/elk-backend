<?php

namespace App\Http\Controllers;

use App\Movimiento;
use Illuminate\Http\Request;

class MovimientoController extends Controller
{
    public function update(Request $request, Movimiento $movimiento)
    {  
        if ($request->cuenta_facturacion) {
            $movimiento->cuenta_facturacion = $request->cuenta_facturacion;
        }
        $movimiento->costo_envio = $request->costo_envio;
        $movimiento->monto = $movimiento->subtotal - $movimiento->descuento + $request->costo_envio;
        $movimiento->save();

        return back()->with('success', 'Los datos de facturacion fueron actualizados');
    }
}
