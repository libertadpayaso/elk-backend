<?php

namespace App\Http\Controllers;

use App\Pedido;
use App\ResumenPedido;
use App\Imagen;
use App\Talle;
use App\Stock;
use App\Linea;
use App\Client;
use App\Producto;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;

class PedidoController extends Controller
{
	public function descargarPorEstado(Request $request){

		$pedidos    = Pedido::where('pdv', 0)->where('estado', $request->estado)->get();
		$html 	    = view("adm.clients.pedidos.sinArmar", compact('pedidos'))->render();
		$carbon     = Carbon::now();
		$pdf        = PDF::loadHTML($html);
		$estadoName = strtolower(str_replace([' ', '/'], '_', Pedido::ESTADOS_PEDIDO[$request->estado]));
		$filename   = $estadoName . '_' . $carbon->format("d_m_Y_H_i_s") . '.pdf';
		
		return $pdf->download($filename);
	}

	public function descargar($id){
		$pedido = Pedido::find($id);
		$resumen = array();
		foreach($pedido->lineas as $linea){
			if(array_key_exists($linea->imagen->producto->nombre, $resumen)){
				$resumen[$linea->imagen->producto->nombre]["cantidad"] += $linea->cantidad;
			}else{
				
				$precio = $linea->imagen->producto->precio;

				if ($linea->imagen->producto->descuento > 0) {
					$precio = $precio - $precio * $linea->imagen->producto->descuento / 100;
				}

				$nombre = $linea->imagen->producto->nombre;
				$resumen[$nombre]["cantidad"]        = $linea->cantidad;
				$resumen[$nombre]["nombre"]          = $nombre;
				$resumen[$nombre]["precio"]          = $linea->precio;
				$resumen[$nombre]["tiene_promocion"] = $linea->tiene_promocion;
			}  
		}

		$carbon = new Carbon($pedido->created_at, 'America/Argentina/Buenos_Aires');

		$html = view("adm.clients.pedidos.factura", compact('resumen', 'pedido', 'carbon'))->render();
		$pdf = PDF::loadHTML($html)->setPaper('a5', 'portrait');
		return $pdf->download($pedido->client->nombre.'-'.$carbon->format("d-m-Y")."-".$pedido->id.'.pdf');
	}

	public function ver($id)
	{
		$pedido = Pedido::find($id);
		foreach($pedido->lineas as $linea){
			if (!$linea->imagen) {
				$brokenLine = Linea::find($linea->id);
				$brokenLine->delete();
			}
		}

		return view('ver',  [
			'pedido'  => $pedido, 
			'estados' => Pedido::ESTADOS_PEDIDO, 
			'colores' => Pedido::COLORES_ESTADO
		]);
	}

	public function verPedido($id)
	{
		$pedido = Pedido::find($id);
		foreach($pedido->lineas as $linea){
			if (!$linea->imagen) {
				$brokenLine = Linea::find($linea->id);
				$brokenLine->delete();
			}
		}
		
		return view('adm.clients.pedidos.ver', [
			'pedido'  => $pedido, 
			'estados' => Pedido::ESTADOS_PEDIDO, 
			'colores' => Pedido::COLORES_ESTADO
		]);
	}

	public function listarPedidos(Request $request)
	{
		$cantidad = 400;
		$pagina = 1;
		
		if ($request->page) {
			$pagina = $request->page;
		}

		if ($request->cant) {
			$cantidad = $request->cant;
		}

		$query = Pedido::where('pdv', 0)->whereHas('client');
		
		$total = $query->count();
		$paginas = (int) ceil( $total/$cantidad );
		$inicio = $cantidad * $pagina - $cantidad;

		$query  = $query->offset($inicio)->limit($cantidad);

		return view('adm.clients.pedidos.list',  [
			'pedidos' => $query->orderBy('created_at', 'DESC')->get(),
			'total'   => $total,
			'paginas' => $paginas,
			'estados' => Pedido::ESTADOS_PEDIDO,
			'colores' => Pedido::COLORES_ESTADO
		]);
	}

	public function update(Request $request, $id)
	{
		$datos = $request->all();
		$pedido = Pedido::find($id);
		$pedido->fill($datos);
		$pedido->save();
		if($datos['estado']==3)
		{
			foreach ($pedido->lineas as $linea)
			{
				$stock = Stock::where('imagen_id', $linea->imagen_id)->where('talle_id', $linea->talle_id)->first();
				$stock->stock = $stock->stock+$linea->cantidad;
				$stock->save();
			}
		}
		return Pedido::COLORES_ESTADO[$request->estado];
	}

	public function pedidosPorMes()
	{

		$estadisticas = [];
		$pedidosPorMes = Pedido::where('estado', 1)->whereHas('client')->orderBy('created_at', 'DESC')->get()
		->groupBy(function($val) {
		    return Carbon::parse($val->created_at)->format('m-Y');
		});

		foreach ($pedidosPorMes as $key => $pedidos) {

			setlocale(LC_MONETARY, 'es_AR');
			$estadisticas[$key]["mes"] = $key;
			$estadisticas[$key]["cantidad"] = count($pedidos);
			$estadisticas[$key]["monto"] = money_format('%.0n', $pedidos->sum('monto'));
		}
		      
		return view('adm.estadisticas.pedidos.pormes',  compact('estadisticas'));
	}

	public function pedidosClientes()
	{
		$estadisticas = [];
		$pedidosPorCliente = Client::withCount('pedidos')->whereHas('pedidos', function($q) {
            $q->where('estado', 1);
        })->orderBy('pedidos_count', 'desc')->get();


		foreach ($pedidosPorCliente as $key => $client) {
			$estadisticas[$key]["cliente"]  = $client->id . " - " . $client->nombre;
			$estadisticas[$key]["cantidad"] = count($client->pedidos);
			$estadisticas[$key]["contacto"] = $client->celular;
			$estadisticas[$key]["ultimo"]   = $client->pedidos->last()->created_at->format("d-m-Y");
		}
		
		return view('adm.estadisticas.pedidos.clientes',  compact('estadisticas'));
	}

	public function agregar($id){
		$productos = Producto::where('activado', '1')->where('stock', '>', '0')->whereHas('categoria', function ($query) {
			$query->where('activado', '1');
		})->orderBy('nombre')->get();

		return view('adm.clients.pedidos.agregar', [
			'pedido'    => Pedido::find($id),
			'productos' => $productos
		]);
	}

	public function agregarPrenda(Request $request){
		$pedido = Pedido::find($request->pedido_id);
		$imagen = Imagen::find($request->imagen_id);
		$talle  = Talle::find($request->talle_id);

		$linea = Linea::where('pedido_id', $pedido->id)->where('imagen_id', $imagen->id)->where('talle_id', $talle->id)->first();
		if (!$linea) {
			$linea                  = new Linea();
			$linea->pedido_id       = $pedido->id;
			$linea->imagen_id       = $imagen->id;
			$linea->precio          = $imagen->producto->precio;
			$linea->talle_id        = $talle->id;
			$linea->tiene_promocion = 0;
			$linea->cantidad        = $request->cantidad;
		} else {
			$linea->cantidad = $linea->cantidad + $request->cantidad;
		}
		$linea->save();

		$stock        = Stock::where('imagen_id', $imagen->id)->where('talle_id', $talle->id)->first();
		$stock->stock = $stock->stock - $request->cantidad;
		$stock->save();

		$actualizar = ['categorias' => [], 'productos' =>[]];
		$actualizar['categorias'][] = $imagen->producto->categoria->id;
        $actualizar['productos'][]  = $imagen->producto->id;
		actualizarStock($actualizar);
		$imagen->producto->calcularTallesDisponibles();

		$montoTotal = 0;
		foreach ($pedido->lineas as $linea) {
			$montoTotal += ($linea->precio * $linea->cantidad);
		}

		$pedido->monto = $montoTotal;
		$pedido->save();

		$resumenPedido = ResumenPedido::where('pedido_id', $pedido->id)->first();
		$resumenPedido->monto_total = $pedido->monto;
		$resumenPedido->save();
		
		return back();
	}

	public function quitarPrenda(Request $request){
		$linea         = Linea::find($request->linea_id);
		$pedido        = Pedido::find($linea->pedido_id);
		$resumenPedido = ResumenPedido::where('pedido_id', $pedido->id)->firstOrFail();
		$stock         = Stock::where('imagen_id', $linea->imagen_id)->where('talle_id', $linea->talle_id)->firstOrFail();
		
		if ($request->cantidad == 0) {
			$stock->stock += $linea->cantidad;
			$linea->delete();
		} else {
			$stock->stock += $linea->cantidad - $request->cantidad;
			$linea->cantidad = $request->cantidad;
			$linea->save();
		}

		$stock->save();
		$pedido->monto = $pedido->calcularMonto();
		$pedido->save();
		$resumenPedido->monto_total = $pedido->monto;
		$resumenPedido->save();
		$linea->imagen->producto->calcularTallesDisponibles();

		return $this->verPedido($linea->pedido->id);
	}
}
