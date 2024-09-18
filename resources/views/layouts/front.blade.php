@php
	Auth::setDefaultDriver('client');
	CarritoController::sanitisize();
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
    $totalReal   = 0;
    $subtotal    = $total = Cart::subtotal(0,'','');
    $esMayorista = $subtotal >= env("MONTO_MAYORISTA");
@endphp
<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>@yield('title') | Elk | Sitio Oficial</title>
        <meta name="description" content="Bienvenido al sitio oficial de indumentaria deportiva ELK®. ¡Somos fabricantes! Encontrá calzas, buzos, remeras, camperas, térmica... ¡Conoce más!">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="manifest" href="manifest.json">
		<link rel="icon" type="image/png" href="{{ asset('assets/img/logos/'.$favicon->imagen) }}"/> 
        <!-- Place favicon.ico in the root directory -->

		<!-- CSS here -->
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/animate.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/fontawesome-all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/themify-icons.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/futura-std-font.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/meanmenu.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/swiper-bundle.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/slick.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/style050923.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/ui.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/EasyAutocomplete/easy-autocomplete.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/EasyAutocomplete/easy-autocomplete.themes.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/imageselect.css') }}" media="screen" type="text/css" />
        
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-QK0ZQDB6B2"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'G-QK0ZQDB6B2');
        </script>
        
        
        
        
    </head>
    

    <body>
        <script>
            fbq('track', 'AddToCart');
        </script>

    <!-- header area start -->
    <header class="header-area">
        
        <div class="gota_top bg-soft d-none d-sm-block">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        
                        <div class="gota_lang">
                            <ul>
                                <li><a class="gotatop2">Catalogo<i class="fal fa-chevron-down"></i></a>
                                    <ul class="additional_dropdown">
                                        @foreach($categorias_menu as $id_categoria => $item_menu)
                                        <li>
                                            <a class="gotatop3" href="{{ url('productos?') . http_build_query(['category' => $id_categoria]) }}">
                                                {{ $item_menu['nombre'] }}
                                            </a>
                                        </li>
                                        @endforeach
                                    </ul>
                                </li>
                                <li>
                                    <a href="{{ url('catalogo/lista-de-precios') }}">Lista de precios<i class="fal fa-chevron-right"></i></a>
                                </li>
                                <li><a href="https://api.whatsapp.com/send?phone=5491130638568"><i class="fab fa-whatsapp fa-lg"></i></a></li>
                                <li><a href="https://www.facebook.com/elkideasdeportivas"><i class="fab fa-facebook-f fa-lg"></i></a></li>
                                <li><a href="https://www.instagram.com/elkideasdeportivas"><i class="fab fa-instagram fa-lg "></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-6 text-end">
                        <div class="gota_right">
                            <ul>
                                @if(!Auth::check())
                                <li><a href="{{ url('iniciar') }}">Iniciar sesión</a></li>
                                <li><a href="{{ url('registrarse') }}">Registrarse</a></li>
                                
                                
                                
                                
                                
                                @else
                                <li><a href="{{ url('perfil') }}">Mi cuenta</a></li>
                                <li><a href="{{ url('logout') }}">Cerrar sesión</a></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="gota_bottom position-relative">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-xl-2 col-lg-2 col-md-4 col-sm-4 d-none d-sm-block">
                    </div>
                    <div class="col-xl-8 col-lg-8 col-md-4 col-sm-4">
                        
                        <div class="sidemenu sidemenu-1 d-lg-none d-md-block">
                            
                            <a href="https://api.whatsapp.com/send?phone=5491130638568"><i class="fab fa-whatsapp" style="margin: 10px;"></i></a>                            
                            <a class="open" href="#"><i class="fal fa-bars"></i></a>
                            
                        </div>
                        <div class="main-menu">
                            <nav id="mobile-menu">
                                <ul>
                                    <li><a href="{{ url('/') }}">Inicio</a></li>
                                   <li class="menu-item-has-children d-sm-none">
                                    <a href="{{ url('https://elkideasdeportivas.com.ar/productos') }}" class="alert-link">Tienda</a>
                                        <ul class="sub-menu">
                                            @foreach($categorias_menu as $id_categoria => $item_menu)
                                            <li>
                                                <a href="{{ url('productos?') . http_build_query(['category' => $id_categoria]) }}">
                                                    {{ $item_menu['nombre'] }}
                                                </a>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </li>


                                    <li>
                                    	<a class="d-none d-xl-block" href="{{ url('/') }}">
                                        	<img class="pl-50 pr-50"  src="{{ asset('assets/images/logo_fondo_blanco5.png') }}" alt="">
                                    	</a>
                                	</li>
                                    <li class="position-static menu-item-has-children d-none d-sm-inline-block">
                                        <a href="{{ url('productos') }}" class="alert-link">Tienda</a>
                                    </li>
                                    <li><a href="{{ url('pedidos') }}">Pedidos</a></li>
                                    <li><a href="{{ url('contacto') }}">Contacto </a></li>
                                </ul>
                            </nav>
                        </div>

                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-4 col-sm-4">
                        <div class="gota_cart gotat_cart_1 text-end">
                            <a href="javascript:void(0)"><i class="fal fa-shopping-cart"></i>Carrito<span class="counter"> ({{Cart::count()}})</span></a>
                        
                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Meta Pixel Code -->
        <script>
          !function(f,b,e,v,n,t,s)
          {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
          n.callMethod.apply(n,arguments):n.queue.push(arguments)};
          if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
          n.queue=[];t=b.createElement(e);t.async=!0;
          t.src=v;s=b.getElementsByTagName(e)[0];
          s.parentNode.insertBefore(t,s)}(window, document,'script',
          'https://connect.facebook.net/en_US/fbevents.js');
          fbq('init', '829570237246828');
          fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" style="display:none"
          src="https://www.facebook.com/tr?id=829570237246828&ev=PageView&noscript=1"
        /></noscript>
        <!-- End Meta Pixel Codeeee -->
    </header>
    <!-- header area end -->

    <div class="search_area">
        <div class="search_close">
            <span><i class="fal fa-times"></i></span>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12">
                    <div class="search-wrapper text-center">
                        <h2>buscar</h2>
                        <div class="search-filtering pt-30">
                            <div class="search_tab">
                                <ul class="nav nav-tabs justify-content-center mb-55" id="myTab2" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="home-tab2" data-bs-toggle="tab"
                                            data-bs-target="#home2" type="button" role="tab"
                                            aria-selected="true">Todas las categorias</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="profile-tab2" data-bs-toggle="tab"
                                            data-bs-target="#profile2" type="button" role="tab" 
                                            aria-selected="false">Basketball</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" data-bs-toggle="tab"
                                            data-bs-target="#contact2" type="button" role="tab" 
                                            aria-selected="false">Handbag</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="sportswear-tab" data-bs-toggle="tab"
                                            data-bs-target="#sportswear" type="button" role="tab"
                                            aria-selected="false">Sportswear</button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent2">
                                    <div class="tab-pane fade show active" id="home2" role="tabpanel"
                                        >

                                    </div>
                                    <div class="tab-pane fade" id="profile2" role="tabpanel"
                                        >

                                    </div>
                                    <div class="tab-pane fade" id="contact2" role="tabpanel">

                                    </div>
                                    <div class="tab-pane fade" id="sportswear" role="tabpanel"
                                        >

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="main_search">
                            <form action="#">
                                <input type="text" name="search" placeholder="search products">
                                <button class="m-search"><i class="fal fa-search d-sm-none d-md-block"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="fix">
        <div class="side-info">
            <button class="side-info-close"><i class="fal fa-times"></i></button>
            <div class="side-info-content">
                <div class="mobile-menu"></div>
                <div class="contact-infos mb-30">
                    <div class="contact-list mb-30">
                        <h4><a href="{{ url('catalogo/lista-de-precios') }}">VER LISTA DE PRECIOS </a></h4>
                    </div>
                    <div class="contact-list mb-30">
                        <h4>Dirección</h4>
                        <p>Av. Avellaneda 3593, Flores. Buenos aires, Argentina</p>
                    </div>
                    <div class="contact-list mb-30">
                        <h4>Whatsapp</h4>
                        <p>Hacé tu pedido al (011) 15 3063 8568</p>
                    </div>
                    <div class="contact-list mb-30">
                        <h4>Email</h4>
                        <p>contacto@elkideasdeportivas.com.ar</p>
                    </div>
                    
                    <div class="social__media mb-30">
                            <h3 class="f-title">REDES SOCIALES</h3>
                            <a href="https://www.facebook.com/elkideasdeportivas"><i class="fab fa-facebook-f"></i></a>
<!--                            <a href="#"><i class="fab fa-twitter"></i></a>-->
                            <a href="https://www.instagram.com/elkideasdeportivas"><i class="fab fa-instagram"></i></a>
                            <a href="https://api.whatsapp.com/send?phone=5491130638568"><i class="fab fa-whatsapp"></i></a>
                            <a href="https://g.page/elkideasdeportivas?share"><i class="fab fa-dribbble"></i></a>
                            
                        </div>
                </div>
            </div>
        </div>
    </div>
    <div class="offcanvas-overlay"></div>

    <!-- cart area start  -->
    <div class="cart__sidebar">
        <div class="container">
            <div class="cart__content" id="cart__content">
                <div class="cart-icon">
                    <i class="fal fa-times"></i>
                </div>
                <div class="cart-text">
                    <h3 class="mb-40">Carrito de Compra</h3>
                    @if(Cart::count() > 0)
                    @foreach(Cart::content()  as $row)
                    <div class="add_cart_product">
                        <div class="add_cart_product__thumb">
                            <img src="{{ asset('assets/img/imagenes/'.$row->options->archivo) }}" alt="">
                        </div>
                        <div class="add_cart_product__content">
                            <h5>
                                <a href="{{ url('p/'.$row->options->producto.'/'.$row->options->url) }}">
                                    {{$row->name}}<br>Talle {{$row->options->nombre_talle}}
                                </a>
                            </h5>
                            <p>{{$row->qty}} × ${{$row->price}} @if($row->options->es_promocion)(Precio oferta)@endif</p>
                            <a href="#!" id="{{ $row->rowId }}" class="delete-item">
                                <button class="cart_close"><i class="fal fa-times"></i></button>
                            </a>
                        </div>
                        @php
                            if ($row->options->precio_descuento > 0) {
                                $totalReal += $row->options->precio_descuento * $row->qty;
                            } else {
                                $totalReal += $row->options->precio_original * $row->qty;
                            }
                        @endphp
                    </div>
                    @endforeach
                    @endif
                </div>
                <div class="cart-bottom">
                    <div class="cart-bottom__text">
                        <span>Total:</span>
                        <span class="end">${{ $total }}@if(!$esMayorista)*@endif</span>
                        @if($esMayorista)
                        <span><small>Total real:</small></span>
                        <span class="end"><small><del>${{ $totalReal }}<del></small></span>
                        @endif
                        <a href="{{ url('carrito/ver') }}">Ver Carrito</a>
                        <a href="{{ url('carrito/vaciar') }}">Vaciar Carrito</a>
                        @if(Auth::check())
                        <a href="{{ url('carrito/confirmar') }}" class="espere">Finalizar Compra</a>
                        @else
                        <a href="{{ url('carrito/solicitar') }}" class="espere">Finalizar Compra</a>
                        @endif
                    </div>
                    @if(!$esMayorista)
                    <br>
                    <p>*Te faltan ${{ env("MONTO_MAYORISTA") - $subtotal }} para obtener ENVÍO GRATIS por Correo Argentino</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="cart-offcanvas-overlay"></div>
    <!-- cart area end  -->
	
    <!-- main area start -->
	@yield('main')
	<!-- main area end  -->

    <!-- popup area start -->
    <div class="overlay"></div>
    <div class="product-popup">
        <div class="view-background">
            <div class="row">
                <div class="col-xl-5 col-lg-5 col-md-5">
                    <div class="quickview">
                        <div class="quickview__thumb">
                            <img src="./assets/img/quick_view/25.jpg" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-xl-7 col-lg-7 col-md-7">
                    <div class="viewcontent">
                        <div class="viewcontent__header">
                            <h2></h2>
                            <a class="view_close product-p-close" href="javascript:void(0)"><i
                                    class="fal fa-times-circle"></i></a>
                        </div>
                        <div class="viewcontent__price">
                            <h4>$99.00</h4>
                        </div>
                        <div class="viewcontent__stock">
                            <h4>Disponible :<span> Hay stock</span></h4>
                        </div>
                        <div class="viewcontent__details">
                            <p></p>
                        </div>
                        <div class="viewcontent__action">
                            <span><a href="#">Ver más</a></span>
                        </div>
                        <div class="viewcontent__footer">
                            <ul>
                                <li>Categoria:</li>
                                <li>Talles:</li>
                            </ul>
                            <ul>
                                <li class="category"></li>
                                <li class="sizes"></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- popup area end -->

    <!-- footer area start -->
    <footer class="footer_area fix">
        <div class="container">
            <div class="row">
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                    <div class="company__info  wow fadeInUp " data-wow-duration=".s" data-wow-delay=".3s">
                        <h3 class="f-title">contacto</h3>
                        <ul>
                            <li>Av. Avellaneda 3593 </li>
                            <li>Flores, Buenos aires, Argentina.</li>
                            <li>contacto@elkideasdeportivas.com.ar</li>
                            <li>Pedidos online: (011) 15-3063-8568</li>
                        </ul>
                        <div class="social__media mb-30">
                            <h3 class="f-title">REDES SOCIALES</h3>
                            <a href="https://www.facebook.com/elkideasdeportivas"><i class="fab fa-facebook-f"></i></a>
                            <a href="https://www.instagram.com/elkideasdeportivas"><i class="fab fa-instagram"></i></a>
                            <a href="https://api.whatsapp.com/send?phone=5491130638568"><i class="fab fa-whatsapp"></i></a>
                            <a href="https://g.page/elkideasdeportivas?share"><i class="fab fa-dribbble"></i></a>
                            
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-6 col-md-6 col-sm-12">
                    <div class="company__info wow fadeInUp " data-wow-duration=".7s" data-wow-delay=".4s">
                        <h3 class="f-title">Consigue ayuda</h3>
                        <ul>
                            <li><a href="https://elkideasdeportivas.com.ar/contacto">Contacto</a></li>
                            <li><a href="https://elkideasdeportivas.com.ar/preguntasfrecuentes">Preguntas frecuentes</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-6 col-md-6 col-sm-12">
                    <div class="company__info wow fadeInUp " data-wow-duration=".8s" data-wow-delay=".5s">
                        <h3 class="f-title">Categorias Populares </h3>
                        <ul>
                            <li><a href="https://elkideasdeportivas.com.ar/c/2/calzas">Calzas</a></li>
                            <li><a href="https://elkideasdeportivas.com.ar/c/14/camperas">Camperas</a></li>
                            <li><a href="https://elkideasdeportivas.com.ar/c/20/buzos">Buzos</a></li>
                            <li><a href="https://elkideasd/portivas.com.ar/c/43/pantalones">Pantalones</a></li>
                            <li><a href="https://elkideasdeportivas.com.ar/c/17/tops-deportivos">Tops</a></li>
                            <li><a href="https://elkideasdeportivas.com.ar/c/19/camisetas-t%C3%A9rmicas">Térmicas</a></li>
                            <li><a href="https://elkideasdeportivas.com.ar/c/5/rectas">Rectas</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="footer__bottom pb-10 mt-60">
                <div class="row">
                    <div class="col-xl-5 col-lg-5 col-md-6 col-sm-12 ">
                        <p>Copyright © Elk Indumentaria Deportiva   <span>Todos los derechos reservados.</span>  <span>2024</span>
                        </p>
                    </div>
                    <div class="col-xl-5 offset-xl-2 col-lg-4 col-md-6 col-sm-12">
                        <div class="footer-menu">
                            <ul class="text-end">
                                <li><a href="https://elkideasdeportivas.com.ar/contacto">Contacto</a></li>
                                <li><a href="https://elkideasdeportivas.com.ar/catalogo/Mujer">Realizar una compra </a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- footer area end -->


    <!-- JS here -->
    <script type="text/javascript">
        var csrf_token = "{{ csrf_token() }}";
    </script>
    <script src="{{ asset('assets/js/vendor/modernizr-3.5.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery-1.12.4.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/js/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/js/one-page-nav-min.js') }}"></script>
    <script src="{{ asset('assets/js/slick.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.meanmenu.min.js') }}"></script>
    <script src="{{ asset('assets/js/countdown.js') }}"></script>
    <script src="{{ asset('assets/js/ajax-form.js') }}"></script>
    <script src="{{ asset('assets/js/wow.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.scrollUp.min.js') }}"></script>
    <script src="{{ asset('assets/js/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins.js') }}"></script>
    <script src="{{ asset('assets/js/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/ui.js') }}"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/EasyAutocomplete/jquery.easy-autocomplete.min.js') }}"></script>
    <script src="{{ asset('assets/js/imageselect.js') }}" type="text/javascript"></script> 
    <script src="{{ asset('assets/js/orders.js') }}" type="text/javascript"></script> 
    <script src="{{ asset('assets/js/main140423.js') }}"></script>
    <!-- custom JS start -->
    @yield('custom_js')
    <!-- custom JS end  -->
</body>

</html>