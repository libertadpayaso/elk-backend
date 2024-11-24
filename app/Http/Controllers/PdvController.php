<?php

namespace App\Http\Controllers;

use App\Categoria;
use App\Extensions\FileHelper;
use App\Imagen;
use App\Linea;
use App\Mail\Comprobante;
use App\Pedido;
use App\Producto;
use App\Sexo;
use App\Stock;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
		$codigoPdv = (int) $request->codigo;
		$producto = Producto::where('pdv', $codigoPdv)->first();
		
		if ($producto) {

			$stock = $producto->stockPDV();
			$cartItem = Cart::search(function ($cartItem, $rowId) use ($stock) {
				return $cartItem->id === $stock->id;
			})->first();

			if ($cartItem) {
				$stock->stock = $stock->stock - $cartItem->qty;
			}

			$response = [
				'status' => true,
				'producto' => $producto,
				'stock' => $stock
			];
		} else {
			$response = [
				'status' => false,
				'message' => 'No se encontró el producto Codigo: ' . $codigoPdv
			];
		}	

		return response()->json($response);
	}

	public function agregar(Request $request)
	{ 
		$stock = Stock::find($request->stock_id);

		if(!$stock){
			return back()->with('error', 'No se encontró el producto');
		}

		$cartItem = Cart::search(function ($cartItem, $rowId) use ($stock) {
			return $cartItem->id === $stock->id;
		})->first();

		if( $cartItem && $stock->stock < ($request->cantidad + $cartItem->qty)){
			return back()->with('error', 'No hay stock suficiente');
		}
			
		$options = [
			'talle_id'         => $stock->talle->id, 
			'nombre_talle'     => $stock->talle->talle, 
			'imagen'           => $stock->imagen->id,
			'archivo'          => $stock->imagen->imagen,
			'producto'         => $stock->imagen->producto->id,
			'stock_id'         => $stock->id,
			'url'              => name($stock->imagen->producto),
			'precio_original'  => $stock->imagen->producto->precio,
			'precio_descuento' => $stock->imagen->producto->precioConDescuento(),
			'precio_mayorista' => $stock->imagen->producto->precioMayorista(),
			'es_promocion' => false
		];

		if ($stock->imagen->producto->descuento > 0) {
			$precio = $stock->imagen->producto->precioConDescuento();
		}else{
			$precio = $stock->imagen->producto->precio;
		}

		Cart::add($stock->id, $stock->imagen->producto->nombre, $request->cantidad, $precio, $options);

		return back()->with('success', "{$stock->imagen->producto->nombre} agregado al carrito");
	}

	public function borrar($id)
	{
		$eraMayorista = Cart::subtotal(0,'','') >= env("MONTO_MAYORISTA");
		
		Cart::remove($id);
		$this->aplicarDescuentoMayorista($eraMayorista);

		return back()->with('success', 'Se eliminó el producto del Carrito');
	}

	public function vaciar()
	{
		Cart::destroy();
		return back()->with('success', 'Se vació el carrito carrito');
	}

	public function mail(Request $request){
		
		$pedido  = Pedido::find($request->id);
		
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

		$nombre     = $request->nombre;
		$carbon     = new Carbon($pedido->created_at, env('APP_TIMEZONE'));
		$fileHelper = new FileHelper();
		$html       = view("pdv.pedidos.factura", compact('resumen', 'pedido', 'carbon', 'nombre', 'fileHelper'))->render();
		$filename   = $carbon->format("d-m-Y")."-".$pedido->id.'.pdf';
		PDF::loadHTML($html)->setPaper('a5', 'portrait')->save(public_path().'/pdf/'.$filename);
		Mail::to($request->email)->send(new Comprobante($carbon->format("d-m-Y"), $carbon->format("H:i"), $filename, $nombre));

		return "Mail enviado correctamente";
	}

	public function confirmar()
	{
		Auth::setDefaultDriver('client');

		if (Cart::count()>0)
		{
			$total    = Cart::subtotal(0,'','');
			$subtotal = 0;
			
			$pedido               = new Pedido();
			$pedido->client_id    =  Auth::user()->id;
			$pedido->pdv          = 1;
			$pedido->estado       = 1;
			$pedido->es_mayorista = $total >= env("MONTO_MAYORISTA");
			$pedido->monto        = $total;
			$pedido->subtotal     = $pedido->monto;
			$pedido->save();
			
			foreach (Cart::content() as $i => $row)
			{
				$linea                  = new Linea();
				$linea->pedido_id       = $pedido->id;
				$linea->imagen_id       = $row->options->imagen;
				$linea->cantidad        = $row->qty;
				$linea->precio          = $row->price;
				$linea->talle_id        = $row->options->talle_id;
				$linea->tiene_promocion = ($row->options->es_promocion) ? 1 : 0 ;
				$linea->save();
				$stock = Stock::find($row->id);
				$stock->stock = $stock->stock-$row->qty;
				$stock->save();
			}
			Cart::destroy();

			return view('pdv.pedidos.finalizar', compact('pedido'));
		} else {
			$error = 'Error: No hay stock disponible para completar la compra';
			return view('pdv.pedidos.finalizar', compact('error'));
		}	
	}

	public function listar($pedido_id = null){

		Auth::setDefaultDriver('client');
		$pedidos = Pedido::where('pdv', 1)->where('client_id', Auth::user()->id)->orderBy('updated_at', 'desc') ->get();

		return view('pdv.pedidos.lista', [
			'pedidos'   => $pedidos,
			'estados'   => self::ESTADOS,
			'colores'   => self::COLORES,
			'pedido_id' => $pedido_id
		]);
	}

	public function logout()
	{
		Auth::setDefaultDriver('client');
		Auth::logout();
		return redirect('iniciar');
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

		return view('pdv.pedidos.ver',  [
			'pedido'  => $pedido,
			'estados' => self::ESTADOS,
			'colores' => self::COLORES
		]);
	}

	public function descargar($id){
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

		$nombre     = null;
		$carbon     = new Carbon($pedido->created_at, env('APP_TIMEZONE'));
		$fileHelper = new FileHelper();
		$html       = view("pdv.pedidos.factura", compact('resumen', 'pedido', 'carbon', 'nombre', 'fileHelper'))->render();
		$pdf        = PDF::loadHTML($html)->setPaper('a5', 'portrait');
		
		return $pdf->download($carbon->format("d-m-Y")."-".$pedido->id.'.pdf');
	}

	public function listarProductos($sexo_id, $stock_id = null, Request $request)
	{
		$sexo              = Sexo::find($sexo_id);
		$categoria_id      = $request->categoria_id;
		$categoria         = Categoria::find($categoria_id);
		$stockSeleccionado = Stock::find($stock_id);

		$stocks = Stock::with('imagen.producto.categoria')->whereHas('imagen.producto.categoria', function($q) use ($sexo_id, $categoria_id) {
			$q->where('sexo_id', $sexo_id);
			if ($categoria_id) {
				$q->where('id', $categoria_id);
			}
		})->where('almacen_id', Stock::PDV)->get();

		$listaCategorias = Categoria::where('sexo_id', $sexo_id)->orderBy('nombre', 'asc')->get();
		
		return view('pdv.stock.list',  compact('listaCategorias', 'sexo', 'categoria', 'stocks', 'stockSeleccionado'));
	}

	public function editarStock(Request $request)
	{
		$stock = Stock::find($request->stock_id);
		$stock->stock = $request->cantidad;
		$stock->save();

        return back()->with('success', 'Stock actualizado');
	}

	protected function aplicarDescuentoMayorista($eraMayorista)
	{
		if (Cart::subtotal(0,'','') >= env("MONTO_MAYORISTA")) {
			foreach (Cart::content() as $row) {
				$row->price = $row->options->precio_mayorista;
			}
		} elseif ($eraMayorista) {
			foreach (Cart::content() as $row) {
				if ($row->options->precio_descuento > 0) {
					$row->price = $row->options->precio_descuento;
				} else {
					$row->price = $row->options->precio_original;
				}
			}
		}
	}
}
