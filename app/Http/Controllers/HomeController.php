<?php

namespace App\Http\Controllers;

use App\Categoria;
use App\Imagen;
use App\Producto;
use App\Stock;
use App\Talle;
use Illuminate\Http\Request;

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

        switch ($nombreMetodo) {
            case 'renovarStock':
                $this->renovarStock();
                break;
            case 'crearStockPDV':
                $this->crearStockPDV();
                break;
            default:
                echo "Nombre del Metodo incorrecto" . PHP_EOL;
                break;
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
}
