<?php

namespace App\Http\Controllers;

use App\Categoria;
use App\Imagen;
use App\Movimiento;
use App\Pedido;
use App\Producto;
use App\Stock;
use App\Talle;

class HomeController extends Controller
{

    public function front()
    {
       	$productos = Producto::orderBy('updated_at', 'desc')->where('front', 1)->whereHas('categoria', function($q) {
            $q->where('stock', '>', '0')->where('activado', 1);
        })->limit('15')->get();

        $ofertas   = Producto::where('descuento', '>', 0)->where('front', 1)->whereHas('categoria', function($q) {
            $q->where('stock', '>', '0')->where('activado', 1);
        })->get();
        
        $nuevos    = Producto::where('nuevo', 1)->whereHas('categoria', function($q) {
            $q->where('stock', '>', '0')->where('activado', 1);
        })->get();
        
        if(count($productos) < 5){
        	$productos = Producto::orderBy('updated_at', 'desc')->where('activado', 1)->whereHas('categoria', function($q) {
                $q->where('stock', '>', '0')->where('activado', 1);
            })->limit('15')->get();
        }

        $categorias = Categoria::where('activado', 1)->get();
        return view('index',compact('productos', 'categorias', 'ofertas', 'nuevos'));
    }

    public function tareaManual($nombreMetodo = null){
        set_time_limit(600);

        if (method_exists($this, $nombreMetodo)) {
            $this->$nombreMetodo();
            echo "Se ejecutó el método $nombreMetodo correctamente" . PHP_EOL;
        } else {
            echo "Nombre del Metodo incorrecto" . PHP_EOL;
        }
    }

    private function crearMovimientosDesdePedido()
    {
        foreach (Pedido::all() as $pedido) {

            if ($pedido->movimiento) {
                continue;
            }

            $monto = 0;

            foreach ($pedido->lineas as $linea) {
                $monto += $linea->cantidad * $linea->precio;
            }

            $movimiento             = new Movimiento();
			$movimiento->usuario_id = $pedido->client_id;
			$movimiento->pedido_id  = $pedido->id;
			$movimiento->concepto   = "Cobro por Pedido # " . $pedido->id;
			$movimiento->subtotal   = $monto;
			$movimiento->monto      = $monto;
			$movimiento->created_at = $pedido->created_at;
			$movimiento->updated_at = $pedido->created_at;
			$movimiento->save();
        }
    }

    private function crearStockPDV()
    {
        foreach (Producto::all() as $producto) {

            $imagenes = Imagen::fromAlmacen(Stock::PDV)->where('producto_id', $producto->id)->get();
            
            if (count($imagenes) > 0) {
                continue;
            }
            
            $imagen = new Imagen();
            $imagen->producto_id = $producto->id;
            $imagen->nombre      = 'Único';
            $imagen->codigo      = 'PDV';
            $imagen->save();

            $stock = new Stock();
            $stock->talle_id   = Talle::TALLE_UNICO;
            $stock->imagen_id  = $imagen->id;
            $stock->almacen_id = Stock::PDV;
            $stock->stock      = 0;
            $stock->save();
        }
    }

    private function renovarStock()
    {
        foreach (Stock::all() as $stock) {
            if (!$stock->talle) {
                $stock->delete();
                continue;
            }

            if (!$stock->imagen) {
                $stock->delete();
                continue;
            }

            if (!$stock->imagen->producto) {
                $stock->delete();
                continue;
            }

            if (!$stock->imagen->producto->categoria) {
                $stock->delete();
                continue;
            }
        }

        actualizarStock();

        $productos = Producto::where('stock', '>', '0')->get();
        foreach ($productos as $producto) {
            $producto->calcularTallesDisponibles();
        }
    }

    private function calcularDescuentos()
    {
        $movimientos = Movimiento::where('descuento', 0)->get();
        foreach ($movimientos as $movimiento) {

            if ($movimiento->monto == $movimiento->subtotal) {
                continue;
            }

            $movimiento->descuento = $movimiento->subtotal - $movimiento->monto;
            $movimiento->save();
        }
    }

    private function version()
    {
        phpinfo();
    }
}
