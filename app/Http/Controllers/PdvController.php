<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use App\Imagen;
use App\Producto;
use App\Pedido;
use App\Linea;
use App\Stock;
use App\Client;
use MP;
use Redirect;
use Barryvdh\DomPDF\Facade as PDF;
use App\Mail\Comprobante;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class PdvController extends Controller
{
	const ESTADOS = [
		1 => 'Entregado',
		3 => 'Cancelado'
	];

	const COLORES = [
		1 => '#b4ffb4',  
		3 => '#fbb1b1'
	];

	public function producto(Request $request)
	{
		$producto = Producto::where('pdv', $request->codigo)->first();
		return response()->json($producto);
	}

	public function variante(Request $request)
	{
		$producto = Producto::where('pdv', $request->producto)->first();
		
		if (is_object($producto)) {

			$variante = Imagen::where('pdv', $request->codigo)->where('producto_id', $producto->id)->first();
			return response()->json($variante);
		}else{

			return response()->json($producto);
		}
	}

	public function agregar(Request $request)
	{ 
		$request['producto'] = ltrim(substr($request->codigo, 0, 4), '0');
		$request['variante'] = ltrim(substr($request->codigo, 4, 2), '0');
		$request['talle'] = ltrim(substr($request->codigo, 6, 1), '0');

		$producto = Producto::where('pdv', $request->producto)->first();
		if ($producto!=null) {

			$variante = Imagen::where('pdv', $request->variante)->where('producto_id', $producto->id)->first();
			if ($variante!=null) {

				$stock = Stock::where('imagen_id', $variante->id)->where('talle_id', $request->talle)->first();

				if($stock!=null && $stock->stock > 0){
					
					$options = [
						'talle' => $request->talle, 
						'imagen' => $variante->id,
						'producto' => $variante->producto->id,
						'url' => $variante->producto->name()];
					Cart::add($variante->id, $variante->producto->nombre.' ('.$variante->nombre.')', 1, $variante->producto->precio, $options);
				}else{

					$error = 'No hay stock suficiente para este producto';
				}
			}else{

				$error = 'La variante "'.$request->variante.'" no existe';
			}
		}else{

			$error = 'El producto "'.$request->producto.'" no existe';
		}

		$this->sanitisize();
		
		if (isset($error)) {

			return view('adm.pdv.pedidos.carrito', compact('error'));
		}else{

			return view('adm.pdv.pedidos.carrito');
		}
	}

	function mail(Request $request){
		
		$pedido = Pedido::find($request->id);
		$resumen = array();
		foreach($pedido->lineas as $linea){
			if(array_key_exists($linea->imagen->producto->nombre, $resumen)){
				$resumen[$linea->imagen->producto->nombre]["cantidad"] += $linea->cantidad;
			}else{
				$nombre = $linea->imagen->producto->nombre;
				$resumen[$nombre]["cantidad"] = $linea->cantidad;
				$resumen[$nombre]["nombre"] = $nombre;
				$resumen[$nombre]["precio"] = $linea->imagen->producto->precio;
			}  
		}

		$carbon = new Carbon($pedido->created_at, 'America/Argentina/Buenos_Aires');

		$nombre = $request->nombre;
		$html = view("adm.pdv.pedidos.factura", compact('resumen', 'pedido', 'carbon', 'nombre'))->render();
		$filename  = $carbon->format("d-m-Y")."-".$pedido->id.'.pdf';
		PDF::loadHTML($html)->setPaper('a5', 'portrait')->save(public_path().'/pdf/'.$filename);
		Mail::to($request->email)->send(new Comprobante($carbon->format("d-m-Y"), $carbon->format("H:i"), $filename, $nombre));

		return "Mail enviado correctamente";
	}

	public function confirmar()
	{
		$this->sanitisize();
		Auth::setDefaultDriver('client');

		if (Cart::count()>0)
		{
			$pedido = new Pedido();
			$pedido->client_id =  Auth::user()->id;
			$pedido->pdv = 1;
			$pedido->estado = 1;
			$pedido->save();
			foreach (Cart::content() as $i => $row)
			{

				$linea = new Linea();
				$linea->pedido_id = $pedido->id;
				$linea->imagen_id = $row->options->imagen;
				$linea->cantidad = $row->qty;
				$linea->talle = $row->options->talle;
				$linea->save();
				$stock = Stock::where('imagen_id', $row->options->imagen)->where('talle_id', $row->options->talle)->first();
				$stock->stock = $stock->stock-$row->qty;
				$stock->save();
			}
			Cart::destroy();

			return view('adm.pdv.pedidos.finalizar', compact('pedido'));
		}
		else
		{
			$error = 'Error: No hay stock disponible para completar la compra';
			return view('adm.pdv.pedidos.finalizar', compact('error'));
		}	
	}

	public function listar($pedido_id = null){

		Auth::setDefaultDriver('client');
		$pedidos = Pedido::where('pdv', 1)->where('client_id', Auth::user()->id)->orderBy('updated_at', 'desc') ->get();

		return view('adm.pdv.pedidos.lista', [
			'pedidos'   => $pedidos,
			'estados'   => self::ESTADOS,
			'colores'   => self::COLORES,
			'pedido_id' => $pedido_id
		]);
	}

	function logout()
	{
		Auth::setDefaultDriver('client');
		Auth::logout();
		return redirect('iniciar');
	}

	function ver($id)
	{
		$pedido = Pedido::find($id);
		
		foreach($pedido->lineas as $linea){
			if (!$linea->imagen) {
				$brokenLine = Linea::find($linea->id);
				$brokenLine->delete();
			}
		}

		return view('adm.pdv.pedidos.ver',  [
			'pedido'  => $pedido,
			'estados' => self::ESTADOS,
			'colores' => self::COLORES
		]);
	}

	function descargar($id){
		$pedido = Pedido::find($id);
		$resumen = array();
		foreach($pedido->lineas as $linea){
			if(array_key_exists($linea->imagen->producto->nombre, $resumen)){
				$resumen[$linea->imagen->producto->nombre]["cantidad"] += $linea->cantidad;
			}else{
				$nombre = $linea->imagen->producto->nombre;
				$resumen[$nombre]["cantidad"] = $linea->cantidad;
				$resumen[$nombre]["nombre"] = $nombre;
				$resumen[$nombre]["precio"] = $linea->imagen->producto->precio;
			}  
		}

		$carbon = new Carbon($pedido->created_at, 'America/Argentina/Buenos_Aires');

		$nombre = null;
		$html = view("adm.pdv.pedidos.factura", compact('resumen', 'pedido', 'carbon', 'nombre'))->render();
		
		$pdf = PDF::loadHTML($html)->setPaper('a5', 'portrait');
		return $pdf->download($carbon->format("d-m-Y")."-".$pedido->id.'.pdf');
	}

	//End PDV
	public static function sanitisize()
	{

		if (Cart::count()>0)
		{
			foreach (Cart::content() as $key => $row) {
				
				if(Imagen::find($row->options->imagen)!=null){

					$imagen = Imagen::find($row->options->imagen);

					if(Producto::find($imagen->producto->id)){

						$stock = Stock::where('imagen_id', $row->options->imagen)->where('talle_id', $row->options->talle)->first();
						
						if($stock==null){

							Cart::remove($row->rowId);
						}else{
							
							if ($stock->stock<1) {
								
								Cart::remove($row->rowId);
							}else{

								if ($stock->stock-$row->qty<0) {

									Cart::update($row->rowId, $stock->stock);
								}
							}
						}
					
					}else{
					
						Cart::remove($row->rowId);
					}
				
				}else{

					Cart::remove($row->rowId);
				}
			}
		}
	}
}
