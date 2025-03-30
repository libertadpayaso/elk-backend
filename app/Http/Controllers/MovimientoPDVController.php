<?php

namespace App\Http\Controllers;

use App\Movimiento;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MovimientoPDVController extends Controller
{
    public function index(Request $request)
    {
        $fecha = $request->fecha;
		$query = Movimiento::whereDoesntHave('pedido', function($q) {
            $q->where('pdv', 0);
        });

        if ($fecha) {
            $carbon = new Carbon($fecha, env('APP_TIMEZONE'));
        } else {
            $carbon = Carbon::now();
        }
        $query->whereDate('created_at', $carbon->format("Y-m-d"));
		$movimientos = $query->orderBy('created_at', 'desc')->get();
        $recaudacion = $movimientos->sum('monto');

		return view('pdv.movimientos.index', compact('movimientos', 'fecha', 'recaudacion'));
	}

    public function create()
    {
        return view('pdv.movimientos.create');
    }

    public function store(Request $request)
    {
        Auth::setDefaultDriver('client');
        $monto = $request->monto * $request->modificador;
        $movimiento             = new Movimiento();
        $movimiento->usuario_id = Auth::user()->id;
        $movimiento->tipo       = Movimiento::TIPO_MANUAL;
        $movimiento->concepto   = $request->concepto;
        $movimiento->subtotal   = $monto;
        $movimiento->monto      = $monto;
        $movimiento->save();
        
        return back()->with('success', "Se creó el movimiento");
    }
}
