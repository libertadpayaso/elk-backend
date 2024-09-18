<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categoria;
use App\Producto;
use App\Talle;
use App\Linea;
use App\Stock;
use App\Pedido;
use App\ResumenPedido;

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

    public function tareaManual(){
        /*set_time_limit(600);
        
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
        }*/

        foreach (Pedido::all() as $pedido) {
            if (!$pedido->resumen) {

                $resumenPedido                 = new ResumenPedido();
                $resumenPedido->nombre_cliente = $pedido->client->nombre;
                $resumenPedido->monto_total    = $pedido->monto;
                $resumenPedido->pedido_id      = $pedido->id;
                $resumenPedido->created_at     = $pedido->created_at;
                $resumenPedido->save();
            }
        }
    }
}
