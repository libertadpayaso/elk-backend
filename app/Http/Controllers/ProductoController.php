<?php

namespace App\Http\Controllers;

use App\Producto;
use App\Sexo;
use App\Imagen;
use App\Categoria;
use App\Estilo;
use App\Talle;
use App\Stock;
use Illuminate\Http\Request;
use App\Extensions\Helpers;
use Illuminate\Support\Collection;
use Gloudemans\Shoppingcart\Facades\Cart;
use Dompdf\Dompdf;
use Dompdf\Options;
use Carbon\Carbon;
use Illuminate\Http\Response;

class ProductoController extends Controller
{
	protected $descuentos = [
		'0' => 'Sin descuento',
		'10' => '10%',
		'15' => '15%',
		'20' => '20%',
		'25' => '25%',
		'30' => '30%',
		'33' => '33%',
		'40' => '40%',
		'50' => '50%',
	];

	public function cantidad($color, $talle)
	{        
		$stock = Stock::where('imagen_id', $color)->where('talle_id', $talle)->first();
		foreach (Cart::content() as $key => $fila) {
			if($fila->id==$color && $fila->options->talle){
				return $stock->stock-$fila->qty;
			}
		}
		return $stock->stock;
	}

	public function talles($color)
	{        
		$stocks = Stock::where('imagen_id', $color)->where('stock', '>' , 0)->with('talle')->get();
		foreach (Cart::content() as $key => $fila) {
			
			if($existing = $stocks->where('imagen_id', $fila->id)->where('talle_id', $fila->options->talle)->first()){

				if($existing->stock-$fila->qty==0){

					$stocks = $stocks->keyBy('id')->forget($existing->id);
				}else{
					$existing['stock']= $existing->stock-$fila->qty;
				}
			}
		}

		return view('talles',compact('stocks'));
	}

	public function imagenesJson($producto_id)
	{        
		$imagenes = Imagen::where('producto_id', $producto_id)->whereHas('stocks', function($q) {
            $q->where('almacen_id', Stock::WEB)->where('stock', '>' , 0);
        })->get();

		return $imagenes->toJson();
	}

	public function tallesJson($color)
	{        
		$stocks = Stock::where('imagen_id', $color)->where('stock', '>' , 0)->with('talle')->get();

		return $stocks->toJson();
	}

	public function disponibles($color)
	{        
		$stocks = Stock::where('imagen_id', $color)->where('stock', '>' , 0)->get();

		$talles = '';
		foreach ($stocks as $key => $stock) {
			$talles .= $stock->talle_id.' ';
		}
		return $talles;
	}

	public function nombres()
	{
		$productos = Producto::where('activado', '1')->where('stock', '>', '0')->whereHas('categoria', function ($query) {
			$query->where('activado', '1');
		})->pluck('nombre');

		return $productos->toJson();
	}

	public function imagenes(Request $request)
	{
		$imagenes = new Collection();

		$productos = Producto::where('nombre', $request->articulo)->where('activado', '1')->where('stock', '>', '0')-> get();

		if(count($productos)==1){
			$imagenes = $productos->first()->imagenes()->whereHas('stocks', function ($query) {
			    $query->where('almacen_id', Stock::WEB)->where('stock', '>', '0');
			})->pluck('imagen', 'id');
		}
		
		return response()->json($imagenes);
	}

	public function detalle($id, $nombre)
	{
		$producto = Producto::find($id);
		$imagenes = $producto->imagenes()->whereHas('stocks', function($q) {
			$q->where('almacen_id', Stock::WEB)->where('stock', '>' , 0);
		})->get();

		return view('detalle',compact('producto', 'imagenes'));
	}

	public function productos($id)
	{
		$categoria = Categoria::where('id',$id)->first();
		$stock = $categoria->disponibles();
		return view('productos',compact('categoria', 'stock'));
	}

	public function productosTodos(Request $request)
	{
		$cantidad = 24;
		$pagina   = 1;
		
		if ($request->page) {
			$pagina = $request->page;
		}

		if ($request->cant) {
			$cantidad = $request->cant;
		}

		$query  = Producto::where('stock', '>', '0')->where('activado', '1')->whereHas('categoria', function($q) {
			$q->where('stock', '>', 0)->where('activado', 1);
		});

		//filtros
		if ($request->category) {
			$query->where('categoria_id', $request->category);
		}

		if ($request->type) {
			$query->where('estilo_id', $request->type);
		}

		if ($request->size) {
			$query->whereHas('stocks', function($q) use ($request) {
				$q->where('talle_id', $request->size)->where('stock', '>', 0);
			});
		}

		if ($request->price_range) {
			$minMax = explode('-', $request->price_range);
			$query->where('precio', '>', $minMax[0]);
			$query->where('precio', '<', $minMax[1]);
		}

		if ($request->nuevo) {
			$query->where('nuevo', '1');
		}
		//end filtros

		$total      = $query->count();
		$categorias = Categoria::where('stock', '>', '0')->where('activado', '1')->get();
		$estilos    = Estilo::all();

		$tallesConStock = Stock::where('stock', '>', 0)->whereHas('talle')->whereHas('imagen.producto', function($q){
			$q->where('activado', 1)->where('stock', '>', 0);
		})->groupBy('talle_id')->orderBy('talle_id')->get();

		$paginas = (int) ceil( $total/$cantidad );
		$inicio  = $cantidad * $pagina - $cantidad;

		$query     = $query->offset($inicio)->limit($cantidad);
		$productos = $query->get();
		
		return view('productos_todos', compact('productos', 'categorias', 'estilos', 'tallesConStock', 'paginas', 'inicio', 'total'));
	}

	public function categorias($nombre)
	{
		$sexo = Sexo::where('nombre',$nombre)->first();
		$stock = $sexo->disponibles();
		return view('categorias',compact('sexo', 'stock'));
	}

	public function crearProducto($sexo)
	{
		$categorias = Categoria::where('sexo_id', $sexo)->orderBy('nombre', 'asc')->get()->pluck('nombre', 'id');
		$talles = Talle::all();
		$estilos = Estilo::all()->pluck('nombre', 'id');
		$descuentos = $this->descuentos;
		return view('adm.productos.producto.create', compact('categorias', 'estilos', 'sexo', 'talles', 'descuentos'));
	}

	public function listarProductos($sexo)
	{
		$productos = Producto::whereHas('categoria', function($q) use ($sexo){
			$q->where('sexo_id',$sexo);
		})->get();
		$categorias = Categoria::where('sexo_id', $sexo)->orderBy('nombre', 'asc')->get();
		$categoria = null;

		return view('adm.productos.producto.list',  compact('productos', 'categorias', 'sexo', 'categoria'));
	}

	public function listarProductosFiltrados(Request $request)
	{
		$sexo = $request->input('sexo');

		if ($request->input('categoria')=='')
		{
			$categoria = null;
			$productos = Producto::whereHas('categoria', function($q) use ($sexo){
				$q->where('sexo_id',$sexo);
			})->get();
		}
		else
		{        
			$seleccionada = Categoria::find($request->input('categoria'));
			$categoria = $seleccionada->id;
			$productos = Producto::where('categoria_id', $request->input('categoria'))->get();
		}

		$categorias = Categoria::where('sexo_id', $sexo)->orderBy('nombre', 'asc')->get();
		return view('adm.productos.producto.list',  compact('productos', 'categorias', 'sexo', 'categoria'));
	}

	public function editarProducto($sexo, $id)
	{
		$producto = Producto::find($id);
		$categorias = Categoria::where('sexo_id', $sexo)->orderBy('nombre', 'asc')->get()->pluck('nombre', 'id');
		$talles = Talle::all();
		$estilos = Estilo::all()->pluck('nombre', 'id');
		$descuentos = $this->descuentos;
		return view('adm.productos.producto.edit', compact('producto', 'categorias', 'estilos', 'sexo', 'talles', 'descuentos'));
	}

	public function store(Request $request)
	{
		$datos = $request->all();
		$producto = Producto::create($datos);
		$file_save = Helpers::saveImage($request->file('ficha'), 'productos', $producto->id);
		$file_save ? $producto->ficha = $file_save : false;
		$producto->save();
		if($datos['talle']!=null)
		{
			$producto->talles()->attach($datos['talle']);
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
		
		$success = 'Producto creado correctamente';

		return back()->with('success', $success);
	}

	public function update(Request $request, Producto $producto)
	{
		if(!isset($request['front'])){
			$request['front'] = 0;
		}
		if(!isset($request['activado'])){
			$request['activado'] = 0;
		}
		if(!isset($request['catalogo'])){
			$request['catalogo'] = 0;
		}
		if(!isset($request['nuevo'])){
			$request['nuevo'] = 0;
		}
		$datos = $request->all();

		$file_save = Helpers::saveImage($request->file('ficha'), 'productos', $producto->id);
		$file_save ? $datos['ficha'] = $file_save : false;

		$producto->fill($datos);
		$producto->save();
		$producto->talles()->detach();
		if($datos['talle']!=null)
		{
			$producto->talles()->attach($datos['talle']);
		}
		foreach ($producto->imagenes()->get() as $i => $imagen)
		{
			foreach ($producto->talles()->get() as $j => $talle)
			{
				$stock = Stock::where('imagen_id',$imagen->id)->where('talle_id',$talle->id)->get();
				if($stock->isEmpty())
				{
					$stock = new Stock();
					$stock->talle_id  = $talle->id;
					$stock->imagen_id = $imagen->id;
					$stock->stock = 0;
					$stock->save();
				}
			}
		}
		$producto->calcularTallesDisponibles();
		$success = 'Producto editado correctamente';
		return back()->with('success', $success);
	}

	public function destroy(Producto $producto)
	{
		foreach ($producto->stocks as $stock) {
			$stock->delete();
		}

		foreach ($producto->imagenes as $imagen) {
			$imagen->delete();
		}

		$producto->delete();
		
		$success = 'Producto eliminado correctamente';
		return back()->with('success', $success);
	}

	public function descargar(){
		$categorias = Categoria::where('catalogo', 1)->whereHas('productos', function ($query) {
			$query->where('catalogo', 1);
		})->get();
		setlocale(LC_ALL, 'es_ES');
		$carbon = new Carbon(date("d-m-Y"), env('APP_TIMEZONE'));
		$html = view("catalogo", compact('categorias', 'carbon'))->render();
		$options = new Options();
		$options->set('defaultMediaType', 'all');
		$options->set('isRemoteEnabled', true);
		$options->set('isHtml5ParserEnabled', true);
		$options->set('isFontSubsettingEnabled', true);
		$dompdf = new Dompdf($options);
		$dompdf->loadHTML($html);
		$dompdf->setPaper('a4', 'portrait');
		$dompdf->render();
		return $dompdf->stream('LISTA DE PRECIOS - MAYORISTA -'.strtoupper($carbon->formatLocalized('%B')).' '.$carbon->format('Y').'.pdf');
	}

	public function lista(){
		$categorias = Categoria::where('catalogo', 1)->whereHas('productos', function ($query) {
			$query->where('catalogo', 1);
		})->get();
		setlocale(LC_ALL, 'es_ES');
		$carbon = new Carbon(date("d-m-Y"), env('APP_TIMEZONE'));
		return view("lista", compact('categorias', 'carbon'));
	}

	public function listaPrecios()
	{
		$categorias = Categoria::has('productos')->get();
		return view('adm.productos.precios',  compact('categorias'));
	}

	public function actualizarPrecios(Request $request)
	{
		$datos = $request->all();

		$producto = Producto::find($datos['producto']);
		$producto->precio = $datos['precio'];
		$producto->save();

		return response()->json([
		    'success' => 'El precio se ha actualizaco correctamente'
		], 200);
	}

	public function minMax()
	{
		$max = Producto::where('stock', '>', '0')->where('activado', '1')->max('precio');
		$min = Producto::where('stock', '>', '0')->where('activado', '1')->min('precio');

		return response()->json([
		    'min' => $min,
		    'max' => $max
		], 200);
	}
}