<?php

namespace App\Http\Controllers;

use App\ResumenPedido;
use App\Pedido;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;

class ResumenPedidoController extends Controller
{

	function listarResumenes(Request $request)
	{
		$fecha      = new \DateTime("-6 months");
		$fechaDesde = $fecha->format('Y-m-d H:i:s');
		$cantidad   = 400;
		$pagina     = 1;
		
		if ($request->page) {
			$pagina = $request->page;
		}

		if ($request->cant) {
			$cantidad = $request->cant;
		}
		
		$query = ResumenPedido::where('created_at', '>', $fechaDesde);

		$total = $query->count();
		$paginas = (int) ceil( $total/$cantidad );
		$inicio = $cantidad * $pagina - $cantidad;

		$query  = $query->offset($inicio)->limit($cantidad);

		return view('adm.clients.pedidos.resumenes',  [
			'resumenes'  => $query->orderBy('created_at', 'DESC')->get(),
			'total'      => $total,
			'paginas'    => $paginas,
			'modosPago'  => ResumenPedido::MODO_PAGO,
			'modosEnvio' => ResumenPedido::MODO_ENVIO
		]);
	}

	function verResumen($id){
		$resumenPedido = ResumenPedido::find($id);
		return view('adm.clients.pedidos.resumen',  [
			'resumen'  => $resumenPedido,
			'modosPago'  => ResumenPedido::MODO_PAGO,
			'modosEnvio' => ResumenPedido::MODO_ENVIO
		]);
	}

	function guardarCambios(Request $request){
		$resumenPedido = ResumenPedido::find($request->resumen_id);
		if ($request->modo_pago) {
			$resumenPedido->modo_pago = $request->modo_pago;
		}
		if ($request->modo_envio) {
			$resumenPedido->modo_envio = $request->modo_envio;
		}
		if ($request->fecha_pago) {
			$resumenPedido->fecha_pago = $request->fecha_pago;
		} else {
			$resumenPedido->fecha_pago = null;
		}
		if ($request->facturado) {
			$resumenPedido->facturado = $request->facturado;
		} else {
			$resumenPedido->facturado = 0;
		}
		$resumenPedido->observaciones = $request->observaciones;
		$resumenPedido->save();
		
		$success = 'Los cambios fueron guardados correctamente';
		return back()->with('success', $success);
	}
}
