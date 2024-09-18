<?php

namespace App\Http\Controllers;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Producto;
use App\Promocion;
use App\Imagen;
use App\Pedido;
use App\ResumenPedido;
use App\Client;
use App\Linea;
use App\Stock;
use App\Talle;
use Redirect;
use MP;

class CarritoController extends Controller
{
	protected static function aplicarPromociones($dataPromociones){

		foreach ($dataPromociones as $idPromocion => $data) {
			
			$precio      = ($data['minimo'] <= $data['cantidad']) ? $data['precio_promocion'] : $data['precio_normal'] ;
			$esPromocion = $data['minimo'] <= $data['cantidad'];
			foreach (array_unique($data['row_ids']) as $rowId) {
				$row = Cart::get($rowId);
				$dataUpdate = [
					'id'      => $row->id,
					'qty'     => $row->qty,
					'name'    => $row->name,
					'price'   => $precio,
					'options' => $row->options->all()
				];
				$dataUpdate['options']['es_promocion'] = $esPromocion;
				Cart::update($rowId, $dataUpdate);
			}
		}
	}

	public static function sanitisize()
	{
		if (Cart::count() == 0) {
			return ;
		}

		$dataPromociones = [];
		foreach (Cart::content() as $key => $row) {
			
			$imagen = Imagen::find($row->options->imagen);
			if (!$imagen) {
				Cart::remove($row->rowId);
				continue;
			}

			$producto = Producto::find($imagen->producto->id);
			if (!$producto) {
				Cart::remove($row->rowId);
				continue;
			}

			$stock = Stock::where('imagen_id', $row->options->imagen)->where('talle_id', $row->options->talle_id)->first();
			if(!$stock || $stock->stock < 1){
				Cart::remove($row->rowId);
				continue;
			}
			//Cuando el stock es negativo, se inserta lo que hay
			if ($stock->stock - $row->qty < 0) {
				Cart::update($row->rowId, $stock->stock);
			}

			foreach ($producto->promociones()->where('activa', 1)->get() as $promocion) {
				if (isset($dataPromociones[$promocion->id])) {
					$dataPromociones[$promocion->id]['cantidad'] += $row->qty;
				} else {
					$dataPromociones[$promocion->id]['cantidad']         = $row->qty;
					$dataPromociones[$promocion->id]['minimo']           = $promocion->cantidad;
					$dataPromociones[$promocion->id]['precio_normal']    = $producto->precio;
					$dataPromociones[$promocion->id]['precio_promocion'] = $promocion->precio;
				}
				$dataPromociones[$promocion->id]['row_ids'][] = $row->rowId;
			}
		}

		self::aplicarPromociones($dataPromociones);
	}

	public function actualizar(Request $request)
	{
		$eraMayorista = Cart::subtotal(0,'','') >= env("MONTO_MAYORISTA");

		for ($i=0; $i < sizeof($request->stock); $i++) { 
			foreach (Cart::content()  as $row) {
				if ($row->options->stock_id == $request->stock[$i]) {
					$stock = Stock::find($request->stock[$i]);
					if($stock!=null && $stock->stock >= $request->cantidad[$i]){
						Cart::update($row->rowId, $request->cantidad[$i]);
					} else { 
						return back()->with('error', 'No hay stock suficiente para este producto');
					}
				}
			}
		}

		$this->sanitisize();
		$this->aplicarDescuentoMayorista($eraMayorista);
		
		if($request->articulo!=null){
			return back()->with('variante', $request->variante)->with('articulo', $request->articulo);
		}else{

			return back()->with('variante', $request->variante);
		}
	}

	public function agregar(Request $request)
	{
		$eraMayorista = Cart::subtotal(0,'','') >= env("MONTO_MAYORISTA");
		
		for ($i=0; $i < sizeof($request->talle); $i++) { 

			$stock = Stock::where('imagen_id', $request->variante)->where('talle_id', $request->talle[$i])->first();
			if($stock!=null && $stock->stock >= $request->cantidad[$i]){

				Auth::setDefaultDriver('client');
				$imagen = Imagen::find($request->variante);
				if ($imagen->producto->descuento > 0) {
					$precio = $imagen->producto->precioConDescuento();
				}else{
					$precio = $imagen->producto->precio;
				}
				$talle = Talle::find($request->talle[$i]);
				$options = [
					'talle_id'         => $talle->id, 
					'nombre_talle'     => $talle->talle, 
					'imagen'           => $imagen->id,
					'archivo'          => $imagen->imagen,
					'producto'         => $imagen->producto->id,
					'stock_id'         => $stock->id,
					'url'              => name($imagen->producto),
					'precio_original'  => $imagen->producto->precio,
					'precio_descuento' => $imagen->producto->precioConDescuento(),
					'precio_mayorista' => $imagen->producto->precioMayorista(),
					'es_promocion' => false
				];
				Cart::add($imagen->id, $imagen->nombre, $request->cantidad[$i], $precio, $options);
			}
			else{
				return back()->with('error', 'No hay stock suficiente para este producto');
			}
		}

		$this->sanitisize();
		$this->aplicarDescuentoMayorista($eraMayorista);
		
		if($request->articulo!=null){
			return back()->with('variante', $request->variante)->with('articulo', $request->articulo);
		}else{

			return back()->with('variante', $request->variante);
		}
	}

	public function solicitar(Request $request){

		if($request->crear_cuenta === '1') {
        	$credentials = $request->only('usuario', 'password');
			$request['password'] = Hash::make($request['password']);
	        $cliente = Client::create($request->all());
	        Auth::guard('client')->attempt($credentials);
        	Auth::setDefaultDriver('client');
		}else{
			$request['usuario'] = 'usuario-' . uniqid();
			$request['password'] = 'automatico';
        	$cliente = Client::create($request->all());
		}
		
        return $this->confirmar($cliente->id);
	}

	public function ingresar(Request $request)
    {
        $credentials = $request->only('usuario', 'password');
        $client      = Client::where('usuario', $request->usuario)->first();

        if(!$client){
            return back()->with('error', "Su usuario no existe en nuestra base de datos");
        }

        if (Auth::guard('client')->attempt($credentials)) {
            Auth::setDefaultDriver('client');
            return $this->confirmar(Auth::user()->id);
        } else {
            return back()->with('error', "Contraseña invalida");
        }
    }

	public function confirmar($client_id = null)
	{
		
		$this->sanitisize();
		Auth::setDefaultDriver('client');
		$total = Cart::subtotal(0,'','');
		$subtotal = 0;

		if (Cart::count() > 0)
		{
			$actualizar = ['categorias' => [], 'productos' =>[]];
			$pedido = new Pedido();
			
			if($client_id){
				$pedido->client_id = $client_id;
			}else{
				$pedido->client_id =  Auth::user()->id;
			}

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

				$stock        = Stock::where('imagen_id', $row->options->imagen)->where('talle_id', $row->options->talle_id)->first();
				$stock->stock = $stock->stock-$row->qty;
				$stock->save();

				$actualizar['categorias'][] = $stock->imagen->producto->categoria->id;
            	$actualizar['productos'][]  = $stock->imagen->producto->id;

            	if ($row->options->precio_descuento > 0) {
            		$subtotal += $row->options->precio_descuento * $row->qty;
            	} else {
            		$subtotal += $row->options->precio_original * $row->qty;
            	}
			}

			$pedido->subtotal = $subtotal;
			$pedido->save();

			Cart::destroy();
			actualizarStock($actualizar);
			foreach ($actualizar['productos'] as $producto_id) {
	            $producto = Producto::find($producto_id);
	            $producto->calcularTallesDisponibles();
	        }
			$resumenPedido                 = new ResumenPedido();
			$resumenPedido->nombre_cliente = $pedido->client->nombre;
			$resumenPedido->monto_total    = $pedido->monto;
			$resumenPedido->pedido_id      = $pedido->id;
			$resumenPedido->save();

			return view('confirmar', ['pedido_id' => $pedido->id]);
		}
		else
		{
			return back()->with('error', 'Error: el carrito está vacío.');
		}	
	}

	public function mercadopago($id)
	{
		$modoTestMP    = env("MP_MODO_TEST");
		$coeficienteMP = env("COEFICIENTE_MERCADOPAGO");
		$pedido = Pedido::find($id);
		$pedido->mercadopago = 1;
		$pedido->monto = $pedido->monto * $coeficienteMP;
		$pedido->save();
		foreach ($pedido->lineas as $linea) {
			$linea->precio = $linea->precio * $coeficienteMP;
			$linea->save();
		}
		Auth::setDefaultDriver('client');
		$mp = new MP ('8092948116185813', 'xbOvLgYAF24OBNNB3rXP7xrpRfLKHvVR');
		$mp->sandbox_mode($modoTestMP);

		$current_user = auth()->user();

		foreach ($pedido->lineas as $linea){
			
			$preferenceData['items'][] = [
				"id" => $linea->id,
				"category_id" => 'Ropa Deportiva',
				"title" => $linea->imagen->nombre,
				"quantity" => $linea->cantidad,
				"currency_id" => "ARS",
				"description" => "Talle " . $linea->talle->talle,
				"unit_price" => $linea->precio * 1.10
			];
		}

		$preference = $mp->create_preference($preferenceData);

		//Endpoint de Test
		if ($modoTestMP) {
			$link = $preference['response']['sandbox_init_point'];
		} else {
			$link = $preference['response']['init_point'];
		}
		return redirect($link);
	}

	public function borrar($id, $return = null)
	{
		$eraMayorista = Cart::subtotal(0,'','') >= env("MONTO_MAYORISTA");
		
		Cart::remove($id);
		$this->sanitisize();
		$this->aplicarDescuentoMayorista($eraMayorista);
		
		$total = Cart::subtotal(0,'','');

		if ($return) {
			return back();
		} else {		
			return view('carrito', [
				'subtotal'    => $total,
				'total'       => $total,
	    		'esMayorista' => $total >= env("MONTO_MAYORISTA")
			]);
		}
	}

	public function vaciar()
	{
		Cart::destroy();
		return redirect('carrito/ver');
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
