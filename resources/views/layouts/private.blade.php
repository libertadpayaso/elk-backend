@php
	$rutas = explode("/", $_SERVER['REQUEST_URI']);
	if(isset($rutas[2]))
	{
		$seccion = $rutas[2];
		$subseccion = str_replace('/'.$rutas[0].'/'.$rutas[1].'/'.$rutas[2].'/', "", $_SERVER['REQUEST_URI']);
	}
	else
	{
		$seccion="";
		$subseccion="";
	}
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title') | Elk | Ropa deportiva</title>
    <!-- Required meta tags always come first -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="Ropa deportiva elk® Venta por mayor y menor">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logos/'.$favicon->imagen) }}"/>  
    <!-- Cargando fuentes -->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700,700italic' rel='stylesheet' type='text/css'>

    <!-- Cargando iconos -->
    <link href='{{ asset('assets/css/font-awesome.min.css') }}' rel='stylesheet' type='text/css'>

    <!-- Carga de Galeria de imágenes -->
    <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">

    <!-- Carga de archivos css -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/estilos.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/jquery.fancybox.min.css') }}">
</head>

<body class="paginas-internas">
	<section class="bienvenidos">
		<header class="encabezado fixed-top" role="banner" id="encabezado">
			<div class="container">
				<a href="{{ url('/') }}" class="logo">
					<img class="d-none d-sm-block" src="{{ asset('assets/img/logos/'.$blanco->imagen) }}" alt="Logo del sitio">
					<img class="d-block d-sm-none" style="max-height: 30px;" src="{{ asset('assets/img/logos/'.$blanco->imagen) }}" alt="Logo del sitio">
				</a>

				<button type="button" class="boton-buscar" data-toggle="collapse" data-target="#bloque-buscar" aria-expanded="false">
					<i class="fa fa-search" aria-hidden="true"></i>
				</button>
				<button type="button" class="boton-menu d-block d-sm-none" data-toggle="collapse" data-target="#menu-principal" aria-expanded="false">
					<i class="fa fa-bars fa-sm" aria-hidden="true"></i></button>
				<form action="{{ url('buscar') }}" id="bloque-buscar" class="collapse">
					<div class="contenedor-bloque-buscar">
						<input type="text" placeholder="Buscar...">
						<input type="submit" value="Buscar">
					</div>
				</form>

				<nav id="menu-principal" class="collapse">
					<ul>
						<li><a href="{{ url('/') }}">INICIO</a></li>
						<li><a href="{{ url('nosotros') }}">NOSOTROS</a></li>
						<li><a href="{{ url('catalogo') }}">VENTA MAYORISTA</a></li>
						<li><a href="{{ url('contacto') }}">CONTACTO</a></li>
						<li><a href="{{ url('salir') }}">CERRAR SESION</a></li>
					</ul>
				</nav>

			</div>
		</header>
        <div class="texto-encabezado text-xs-center">
            @yield('encabezado')
        </div>
        <div class="flecha-bajar text-xs-center">
            <a data-scroll href="#agencia"> <i class="fa fa-angle-down" aria-hidden="true"></i></a>
        </div>

    </section>
	@yield('main')
    <footer class="piedepagina p-y-1" role="contentinfo">
        <div class="container">
            <p>2023 © ELK - Todos los derechos reservados</p>
            <ul class="redes-sociales">
                <li><a href="https://www.facebook.com/elkideasdeportivas/"><i class="fa fa-facebook" aria-hidden="true"> </i>  </a></li>
                <li><a href="https://www.instagram.com/elkideasdeportivas"><i class="fa fa-instagram" aria-hidden="true"></i> </a></li>
                <li><a href="llamar.php"><i class="fa fa-whatsapp" aria-hidden="true"></i></a></li>
            </ul>

        </div>

    </footer>

    <a data-scroll class="ir-arriba" href="#encabezado"><i class="fa  fa-arrow-circle-up" aria-hidden="true"> </i> </a>

    <!-- Carga de archivos  JS -->

    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
    <script type="text/javascript">
        $('.owl-carousel').owlCarousel({
            loop: true,
            margin: 0,
            nav: true,
            autoWidth: false,
            navText: ['<i class="fa fa-arrow-circle-left" title="Anterior"></i>', '<i class="fa  fa-arrow-circle-right" title="Siguiente"></i>'],
            responsive: {
                0: {
                    items: 1
                },
                500: {
                    items: 2,
                    margin: 20
                },
                800: {
                    items: 3,
                    margin: 20
                },
                1000: {
                    items: 4,
                    margin: 20
                }
            }
        })

    </script>
    <script src="{{ asset('assets/js/wow.min.js') }}"></script>
    <script src="{{ asset('assets/js/smooth-scroll.min.js') }}"></script>
    <script src="{{ asset('assets/js/sitio.js') }}"></script>
</body>

</html>
