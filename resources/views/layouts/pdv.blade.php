@php
	$rutas = explode("/", $_SERVER['REQUEST_URI']);
	if(isset($rutas[3]))
	{
		$seccion = $rutas[3];
		$subseccion = str_replace('/'.$rutas[0].'/'.$rutas[1].'/'.$rutas[2].'/'.$rutas[3].'/', "", $_SERVER['REQUEST_URI']);
	}
	else
	{
		$seccion="";
		$subseccion="";
	}
@endphp

<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">

		<title>Elk - Panel de administraci&oacuten - @yield('title')</title>
		
		<link rel="icon" type="image/png" href="{{ asset('assets/img/logos/'.$favicon->imagen) }}"/>
		<link href="{{ asset('adm/css/icon.css') }}" rel="stylesheet">
		<link rel="stylesheet" href="{{ asset('adm/css/materialize.css') }}">
		<link type="text/css" rel="stylesheet" href="{{ asset('adm/css/admin.css') }}"  media="screen,projection"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	</head>

	<body>
		<!-- CABECERA -->
		<header>
			<nav class="top-nav">
				<div class="container hide-on-med-and-down">
					<div class="nav-wrapper">
						<a class="page-title">@yield('title')</a>
						<a class="right" href="{{ url('admin/pdv/salir') }}">Cerrar sesi&oacuten</a>
					</div>
				</div>
				<a href="#" data-activates="nav-mobile" class="button-collapse top-nav full hide-on-large-only"><i class="material-icons">menu</i></a>
				<div class="logo hide-on-large-only">
					<a id="logo-container" href="{{ url('admin/pdv/pedidos') }}" class="brand-logo">
						<img class="responsive-img" src="{{ asset('assets/images/logo.svg') }}" style="height: 45px">
					</a>
				</div>
			</nav>

		  <!-- MENÚ -->

			<ul id="nav-mobile" class="side-nav fixed">
				<div class="logo hide-on-med-and-down">
					<a id="logo-container" href="{{ url('admin/pdv/pedidos') }}" class="brand-logo">
						<img src="{{ asset('assets/img/logos/logos_1_logoN.png') }}">
					</a>
				</div>
				<li class="no-padding">
					<ul class="collapsible collapsible-accordion">
						<li class="bold"><a class="collapsible-header waves-effect waves-admin @if($seccion=="clientes") active @endif"><i class="material-icons">assignment</i>Pedidos</a>
							<div class="collapsible-body">
								<ul>
									<li class="@if($subseccion=="cliente/edit") active @endif"><a href="{{ url('admin/pdv/pedidos/nuevo') }}">Nuevo Pedido</a></li>
									<li class="@if($subseccion=="cliente/edit") active @endif"><a href="{{ url('admin/pdv/pedidos') }}">Listar Pedidos</a></li>
								</ul>
							</div>
						</li>
						<li class="bold">
							<a class="collapsible-header waves-effect waves-admin" href="{{ url('admin/pdv/salir') }}"><i class="material-icons">backspace</i>Cerrar sesi&oacuten</a>
						</li>
						
					</ul>
				</li>
			</ul>
		</header>

		@yield('main')
		<script type="text/javascript" src="{{ asset('adm/js/jquery-3.3.1.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('adm/js/materialize.min.js') }}"></script>
		<script src="//cdn.ckeditor.com/4.9.2/full/ckeditor.js"></script>
		<script src="https://use.fontawesome.com/c3d13979f5.js"></script>
		<script type="text/javascript" src="{{ asset('adm/js/custom.js') }}"></script>
		<script>
			$(document).ready(function() {
				$('select').material_select();
				$(".button-collapse").sideNav();
			});
		</script>

	</body>
</html>
