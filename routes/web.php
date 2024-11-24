<?php
Route::get('/', 'HomeController@front');
Route::get('nosotros', function(){ return view('nosotros'); });
Route::get('listadeprecioselk', function(){ return view('listadeprecioselk'); });
Route::get('productos', 'ProductoController@productosTodos');
Route::get('catalogo', function(){ return view('sexos'); });
Route::get('catalogo/descargar', 'ProductoController@descargar');
Route::get('catalogo/lista-de-precios', 'ProductoController@lista');
Route::get('catalogo/{nombre}', 'ProductoController@categorias');
Route::get('c/{id}/{nombre}', 'ProductoController@productos');
Route::get('p/{id}/{nombre}', 'ProductoController@detalle');
Route::get('disponibles/{color}', 'ProductoController@disponibles');
Route::get('talles/{color}', 'ProductoController@talles');
Route::get('imagenes-json/{producto_id}', 'ProductoController@imagenesJson');
Route::get('talles-json/{color}', 'ProductoController@tallesJson');
Route::get('cantidad/{color}/{talle}', 'ProductoController@cantidad');
Route::post('stock', 'ProductoController@stock');
Route::get('busqueda', 'ProductoController@busqueda');
Route::get('solicitud', function(){ return view('solicitud'); });
Route::get('pedidos', function(){ return view('pedidos'); });
Route::get('nombres', 'ProductoController@nombres');
Route::get('nombres-ids', 'ProductoController@nombresConIds');
Route::post('imagenes', 'ProductoController@imagenes');
Route::get('contacto', 'ContactoController@front');
Route::get('iniciar', function(){ return view('iniciar'); });
Route::get('registrarse', function(){ return view('registro'); });
Route::get('preguntasfrecuentes', function(){ return view('preguntasfrecuentes'); });
Route::get('registro-exitoso', function(){ return view('registro_exitoso'); });
Route::get('lamismapasion', function(){ return view('lamismapasion'); });
Route::get('verificar/{nombre}', 'ClientController@verificar');
Route::get('perfil', 'ClientController@perfil');
Route::get('perfil/ver/{id}', 'PedidoController@ver');
Route::get('authenticated', 'ClientController@autenticado');
Route::get('actualizar-stock', 'StockController@actualizar');
Route::get('min-max', 'ProductoController@minMax');

//Carrito
Route::group(['prefix' => 'carrito'], function() {
	Route::post('agregar', 'CarritoController@agregar');
	Route::get('borrar/{id}/{return?}', 'CarritoController@borrar');
	Route::get('vaciar', 'CarritoController@vaciar');
	Route::get('solicitar', function(){ return view('solicitar'); });
	Route::post('ingresar', 'CarritoController@ingresar');
	Route::post('solicitar',  'CarritoController@solicitar');
	Route::get('confirmar', 'CarritoController@confirmar');
	Route::get('ver', function(){ return view('ver_carrito'); });
	Route::get('mercadopago/{id}', 'CarritoController@mercadopago');
	Route::post('actualizar', 'CarritoController@actualizar');
});

Route::post('redirect', 'ClientController@redirect');
Route::post('registrar', 'ClientController@store');
Route::post('ingresar', 'ClientController@ingresar');
Route::get('logout', 'ClientController@logout');
Route::post('login', ['uses'=>'UserController@ingresar','as'=>'usuarios.ingresar']);

Route::group(['prefix' => 'admin'], function() {
    Route::resource('user', 'UserController');
    Route::resource('client', 'ClientController');
    Route::resource('contacto', 'ContactoController');
    Route::resource('producto', 'ProductoController');
    Route::resource('imagen', 'ImagenController');
    Route::resource('pedido', 'PedidoController');
    Route::resource('categoria', 'CategoriaController');
    Route::resource('stock', 'StockController');
    Route::resource('promocion', 'PromocionController');

    Route::get('/', function (){ return view('adm.login'); });
    Route::get('panel', 'UserController@index');
    Route::get('logout', 'UserController@logout');
    Route::post('filtrar-categoria', 'ProductoController@listarProductosFiltrados');

	//Productos
	Route::group(['prefix' => 'productos'], function() {
		Route::group(['prefix' => 'categoria'], function() {
			Route::get('create/{sexo}', 'CategoriaController@crearCategoria');
			Route::get('edit/{sexo}', 'CategoriaController@listarCategorias');
			Route::get('edit/{sexo}/{id}', 'CategoriaController@editarCategoria');
		});
		Route::group(['prefix' => 'producto'], function() {
			Route::get('create/{sexo}', 'ProductoController@crearProducto');
			Route::get('edit/{sexo}', 'ProductoController@listarProductos');
			Route::get('edit/{sexo}/{id}', 'ProductoController@editarProducto');
			Route::get('vaciar-stock/{id}', 'StockController@clearAll');
		});
		Route::group(['prefix' => 'imagen'], function() {
			Route::get('create/{sexo}/{producto}', 'ImagenController@crearImagen');
			Route::get('edit/{sexo}/{producto}', 'ImagenController@listarImagenes');
			Route::get('edit/{sexo}/{producto}/{id}', 'ImagenController@editarImagen');
		});
		Route::get('stock/edit/{imagen}', 'StockController@listarStocks');
		Route::post('stock', 'StockController@update');
		Route::get('stock/clear/{id}', 'StockController@clear');
		Route::get('precios', 'ProductoController@listaPrecios');
		Route::post('precios', 'ProductoController@actualizarPrecios');
	});
	
	//Promociones
	Route::group(['prefix' => 'promocion'], function() {
		Route::post('productos', 'PromocionController@guardarProductos');
		Route::get('create', 'PromocionController@crearPromocion');
		Route::get('list', 'PromocionController@listarPromociones');
		Route::get('edit/{id}', 'PromocionController@editarPromocion');
		Route::get('productos/{id}', 'PromocionController@productosEnPromocion');
	});

	Route::group(['prefix' => 'usuarios'], function() {
		Route::group(['prefix' => 'usuario'], function() {
			Route::get('create', 'UserController@crearUser');
			Route::get('edit', 'UserController@listarUsers');
			Route::get('edit/{id}', 'UserController@editarUser');
		});
	});

	//Clientes
	Route::group(['prefix' => 'clientes'], function() {

		Route::group(['prefix' => 'cliente'], function() {
			Route::get('create', 'ClientController@crearClient');
			Route::get('edit', 'ClientController@listarClients');
			Route::get('edit/{id}', 'ClientController@editarClient');
		});

		Route::group(['prefix' => 'pedidos'], function() {
			Route::get('/', 'PedidoController@listarPedidos');
			Route::get('ver/{id}', 'PedidoController@verPedido');
			Route::post('descargarPorEstado', 'PedidoController@descargarPorEstado');
			Route::get('descargar/{id}', 'PedidoController@descargar');
			Route::get('edit/{client}', 'PedidoController@listarPedidosCliente');
			Route::get('resumenes', 'ResumenPedidoController@listarResumenes');
			Route::get('resumen/{id}', 'ResumenPedidoController@verResumen');
			Route::post('resumen', 'ResumenPedidoController@guardarCambios');
			Route::get('agregar/{id}', 'PedidoController@agregar');
			Route::post('agregar', 'PedidoController@agregarPrenda');
			Route::post('quitar', 'PedidoController@quitarPrenda');
			Route::get('linea/{id}', 'LineaController@obtener');
		});
	});

	//Estadisticas
	Route::group(['prefix' => 'estadisticas'], function() {
		Route::get('por-mes', 'PedidoController@pedidosPorMes');
		Route::get('por-cliente', 'PedidoController@pedidosClientes');
	});

	//Settings
	Route::get('settings', 'SettingController@listSettings');
	Route::post('settings', 'SettingController@update');
});

Route::group(['prefix' => 'pdv'], function() {
		
	Route::group(['prefix' => 'stock'], function() {
		Route::get('{sexo_id}', 'PdvController@listarProductos');
		Route::get('{sexo_id}/{stock_id}', 'PdvController@listarProductos');
		Route::post('editar', 'PdvController@editarStock');
	});

	Route::group(['prefix' => 'carrito'], function() {
		Route::post('producto', 'PdvController@producto');
		Route::post('agregar', 'PdvController@agregar');
		Route::get('borrar/{row_id}', 'PdvController@borrar');
		Route::get('vaciar', 'PdvController@vaciar');
	});

	Route::group(['prefix' => 'cliente'], function() {
		Route::get('create', 'ClientController@crearClient');
		Route::get('edit', 'ClientController@listarClients');
		Route::get('edit/{id}', 'ClientController@editarClient');
	});

	Route::group(['prefix' => 'pedidos'], function() {
		Route::get('/', 'PdvController@listar');
		Route::get('ver/{id}', 'PdvController@ver');
		Route::get('descargar/{id}', 'PdvController@descargar');
		Route::get('nuevo', function (){ return view('pdv.pedidos.nuevo'); });
		Route::get('confirmar', 'PdvController@confirmar');
		Route::get('/{pedido_id}', 'PdvController@listar');
		Route::post('mail', 'PdvController@mail');
	});

	Route::get('salir', 'PdvController@logout');
});

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/tarea-manual/{metodo}', 'HomeController@tareaManual');