@php
	Auth::setDefaultDriver('client');

    $parameters = [];
    $parameters['page'] = (isset($_GET['page'])) ? $_GET['page'] : 1 ;
    $parameters['cant'] = (isset($_GET['cant'])) ? $_GET['cant'] : 24 ;
    if(isset($_GET['type'])){
        $parameters['type'] = $_GET['type'] ;
    }
    if(isset($_GET['category'])){
        $parameters['category'] = $_GET['category'] ;
    }
    if(isset($_GET['nuevo'])){
        $parameters['nuevo'] = $_GET['nuevo'] ;
    }
@endphp
@extends('layouts.front')

@section('title', 'Productos')

@section('main')

    <!--INICIO CELU-->
    <div class="fix d-block d-md-none">
        <div class="side-filter">
            <button class="side-filter-close"><i class="fal fa-times"></i></button>
            <div class="side-filter-content">
                @if(isset($parameters['type']) || isset($parameters['category']) || isset($parameters['nuevo']))
                <div class="product-widget pb-20">
                    <a href="{{ url('productos') }}" class="filter-form-submit">
                        <i class="far fa-window-close"></i> Quitar todos los filtros
                    </a>
                </div>
                @endif
                
                <div class="product-widget pb-30">
                    <ul class="product-ver">
                        <li @if(isset($_GET['nuevo'])) class="active" @endif>
                            <a href="{{ url('productos') . updateURL($parameters, ['nuevo' => 1, 'page' => 1]) }}">
                                ¡Quiero VER LO NUEVO!
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="product-widget pb-30">
                    <h3 class="widget-title">Tipo</h3>
                    <ul class="product-categories">
                        <li @if(!isset($_GET['type'])) class="active" @endif>
                            <a href="{{ url('productos') . updateURL($parameters, ['type' => null, 'page' => 1]) }}">
                                Todos
                            </a>
                        </li>
                        @foreach($estilos as $estilo)
                        <li @if(isset($_GET['type']) && $_GET['type'] == $estilo->id) class="active" @endif>
                            <a href="{{ url('productos') . updateURL($parameters, ['type' => $estilo->id, 'page' => 1]) }}">
                                {{ $estilo->nombre }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <div class="product-widget pb-30">
                    <h3 class="widget-title">Categorías</h3>
                    <ul class="product-categories">
                        <li @if(!isset($_GET['category'])) class="active" @endif>
                            <a href="{{ url('productos') . updateURL($parameters, ['category' => null, 'page' => 1]) }}">
                                Todas las Categorias
                            </a>
                        </li>
                        @foreach($categorias as $categoria)
                        <li @if(isset($_GET['category']) && $_GET['category'] == $categoria->id) class="active" @endif>
                            <a href="{{ url('productos') . updateURL($parameters, ['category' => $categoria->id, 'page' => 1]) }}">
                                {{ $categoria->nombre }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <div class="product-widget">
                    <h3 class="widget-title mb-30">Talles</h3>
                    <ul class="product-categories">
                        <li @if(!isset($_GET['size'])) class="active" @endif>
                            <a href="{{ url('productos') . updateURL($parameters, ['size' => null, 'page' => 1]) }}">
                                Todos los Talles
                            </a>
                        </li>
                        @foreach($tallesConStock as $stock)
                        <li @if(isset($_GET['size']) && $_GET['size'] == $stock->talle->id) class="active" @endif>
                            <a href="{{ url('productos') . updateURL($parameters, ['size' => $stock->talle->id, 'page' => 1]) }}">
                                {{ $stock->talle->talle }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="filter-offcanvas-overlay d-block d-sm-none"></div>
    <!--FIN CELU-->

	<!-- shop page start -->
    <div class="shop-page">
        <div class="container" id="main-shop">
            <div class="row">
                <div class="col d-md-none pt-20 pb-20">
                    <button id="filters"><i class="far fa-filter"></i> Filtrar por</button>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-12 d-none d-sm-block">
                    <!-- sidebar area start -->
                    <div class="sidebar">
                        @if(isset($parameters['type']) || isset($parameters['category']) || isset($parameters['nuevo']))
                        <div class="product-widget pb-50">
                            <a href="{{ url('productos') }}" class="filter-form-submit">
                                <button type="button"><i class="far fa-window-close"></i> Quitar todos los filtros</button>
                            </a>
                        </div>
                        @endif
                    </div>
                    <!-- sidebar area end -->
                </div>
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    @if(count($productos) > 0)
                    <div class="shop-top-bar position-relative">
                        <div class="showing-result">
                            <p> Mostrando {{ $inicio + 1 }} - {{ $inicio + count($productos) }} de {{ $total }} resultados</p>
                        </div>
                        <div class="shop-tab d-none d-sm-block ">
                            <nav>
                                <div class="nav nav-tabs shop-tabs" id="nav-tab" role="tablist">
                                    <button>
                                        <span>Vista</span>
                                    </button>
                                    <button class="nav-link" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="false">
                                        <img src="{{ asset('assets/img/essential/i2.svg') }}" alt="">
                                    </button>
                                    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">
                                        <img src="{{ asset('assets/img/essential/i3.svg') }}" alt="">
                                    </button>
                                    <button class="nav-link active" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contactnav-profile" aria-selected="false">
                                        <img src="{{ asset('assets/img/essential/i4.svg') }}" alt="">
                                    </button>
                            	</div>
                            </nav>                                 
                        </div>
                    
                    
                    <div class="main-menu">
                                    <nav id="mobile-menu">
                                        <ul>
                                            <li class="menu-item-has-children">
                                                <a>Categorias</a>
                                                <ul class="sub-menu">
                                                    <li @if(!isset($_GET['category']))  @endif class="menu-item-has-children">
                                                        <a href="{{ url('productos') . updateURL($parameters, ['category' => null, 'page' => 1]) }}">Todas las Categorias</a></li>
                                                    @foreach($categorias as $categoria)
                                                    
                                                    <li @if(isset($_GET['category']) && $_GET['category'] == $categoria->
                                                        id) class="active" @endif>
                                                        <a href="{{ url('productos') . updateURL($parameters, ['category' => $categoria->id, 'page' => 1]) }}">
                                                            {{ $categoria->nombre }}</a>
                                                    </li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                    
                    
                    <div class="shop-filtaring d-none d-md-block">
                            <div class="filter-select">
                                <button class="open-filter"><i class="fal fa-plus"></i>filtross</button>
                                    <div class="filter-content">
                                        <div class="row">
                                            
                                            <div class="col-xl-3 col-lg-3">
                                                <div class="product-widget pt-10">
                                                    <h3 class="widget-title mb-30">Colecciones</h3>
                                                    <div class="tags mb-50">
                                                        <a href="https://elkideasdeportivas.com.ar/catalogo/Mujer">Mujer</a>
                                                        <a href="https://elkideasdeportivas.com.ar/catalogo/Hombre">Hombre</a>
                                                        <a href="https://elkideasdeportivas.com.ar/catalogo/Ni%C3%B1os">Niños</a>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-xl-3 col-lg-3">
                                                <div class="product-widget pt-10">
                                                    <h3 class="widget-title mb-10">Categorias</h3>
                                                    
                                                    <div class="layer-size">
                                                        <ul>
                                                        <span @if(!isset($_GET['category'])) class="active" @endif class="menu-item-has-children">
                                                        <a href="{{ url('productos') . updateURL($parameters, ['category' => null, 'page' => 1]) }}">Todas las Categorias</a></span>
                                                    @foreach($categorias as $categoria)
                                                    
                                                    <span @if(isset($_GET['category']) && $_GET['category'] == $categoria->
                                                        id) class="active" @endif>
                                                        <a href="{{ url('productos') . updateURL($parameters, ['category' => $categoria->id, 'page' => 1]) }}">
                                                            {{ $categoria->nombre }}</a>
                                                    </span>
                                                    @endforeach
                                                        </ul>
                                                    </div>
                                                    
                                                    
                                                </div>
                                            </div>
                                            
                                            
                                            <div class="col-xl-3 col-lg-3">
                                                <div class="product-widget pt-10">
                                                    <h3 class="widget-title mb-10">Tipo</h3>
                                                    <div class="layer-size">
                                                        <ul>
                                                        <span @if(!isset($_GET['type'])) class="active" @endif>
                                                            <a href="{{ url('productos') . updateURL($parameters, ['type' => null, 'page' => 1]) }}">Todos
                                                            </a>
                                                        </span>
                                                        @foreach($estilos as $estilo)
                                                        <span @if(isset($_GET['type']) && $_GET['type'] == $estilo->
                                                            id) class="active" @endif>
                                                            <a href="{{ url('productos') . updateURL($parameters, ['type' => $estilo->id, 'page' => 1]) }}">{{ $estilo->nombre }}
                                                            </a>
                                                        </span>
                                                        @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-lg-3">
                                                <div class="product-widget pt-10">
                                                    <h3 class="widget-title mb-10">Talles</h3>
                                                    <div class="layer-size">
                                                        
                                                        <span @if(!isset($_GET['size'])) class="active" @endif>
                                                            <a href="{{ url('productos') . updateURL($parameters, ['size' => null, 'page' => 1]) }}">
                                                                Todos los Talles
                                                            </a>
                                                        </span>
                                                        @foreach($tallesConStock as $stock)
                                                        
                                                        
                                                        <span @if(isset($_GET['size']) && $_GET['size'] == $stock->talle->id) class="active" @endif>
                                                            <a href="{{ url('productos') . updateURL($parameters, ['size' => $stock->talle->id, 'page' => 1]) }}">
                                                                {{ $stock->talle->talle }}
                                                            </a>
                                                        </span>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
            </div>
                
            <div class="shop-page-product pb-100">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12">
                        <div class="tab-content" id="nav-tabContent">
                            <!--           PRIMERO                            -->
                            <div class="tab-pane fade" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                <div class="row">
                                    @foreach($productos as $item)
                                    <div class="col-xl-4">
                                        <div class="product product-4">
                                            <div class="product__thumb">
                                                <a href="{{ url('p/'.$item->id.'/'.name($item)) }}">
                                                    <img class="product-primary" src="{{ asset('assets/img/imagenes/'.$item->imagenesConStock()->first()->imagen) }}" alt="product_image">
                                                    <img class="product-secondary" src="{{ asset('assets/img/imagenes/'.$item->imagenesConStock()->first()->imagen) }}" alt="product_image">
                                                </a>
                                                @if($item->mensaje_personalizado != '')
                                                <div class="product__update">
                                                    <a class="lightblueclr" href="#">{{$item->mensaje_personalizado}}</a>
                                                </div>
                                                @elseif($item->descuento > 0 && !$item->tienePromocion())
                                                <div class="product__update">
                                                    <a class="lightblueclr" href="#">-{{$item->descuento}}%</a>
                                                </div>
                                                @elseif($item->nuevo == 1)
                                                <div class="product__update">
                                                    <a class="lightblueclr" href="#">Nuevo</a>
                                                </div>
                                                @endif
                                                <div class="product-info mb-10">
                                                    <div class="product_category">
                                                        <p class="description">{{ $item->categoria->nombre }}</p>
                                                    </div>
                                                    <div>
                                                        <h4><a class="resaltar" href="{{ url('p/'.$item->id.'/'.name($item)) }}">{{$item->nombre}}</a></h4>
                                                    </div>
                                                </div>
                                                <div class="product-info mb-10">
                                                    <div class="product_category">
                                                        
                                                        <p class="description">{{$item->descripcion}}</p>
                                                        
                                                        @if($item->talles_disponibles)
                                                        <p class="tallesdisp">Talles disponibles: <br> {{$item->talles_disponibles}}</p>
                                                        @endif                                                                
                                                        
                                                        
                                                        <div class="product__name">
                                                            <div class="pro-priceelk">
                                                                <p class="widget-title mb-10">
                                                            @if($item->descuento > 0 && !$item->tienePromocion())
                                                            <strike class="precioviejo">${{$item->precio}}</strike> -
                                                            @endif
                                                                </p>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                </div>                                                        
                                                <div class="product__action">
                                                    <div class="inner__action">
                                                        <div class="view" prod-id="{{$item->id}}">
                                                            <a href="javascript:void(0)"><i class="fal fa-eye"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <!--           SEGUNDOOOOOOO -->  
                            <div class="tab-pane fade " id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                <div class="row">

                                    @foreach($productos as $item)
                                    <div class="col-xl-3">
                                        <div class="product product-4">
                                            <div class="product__thumb">
                                                <a href="{{ url('p/'.$item->id.'/'.name($item)) }}">
                                                    <img class="product-primary" src="{{ asset('assets/img/imagenes/'.$item->imagenesConStock()->first()->imagen) }}" alt="product_image">
                                                    <img class="product-secondary" src="{{ asset('assets/img/imagenes/'.$item->imagenesConStock()->first()->imagen) }}" alt="product_image">
                                                </a>
                                                @if($item->mensaje_personalizado != '')
                                                <div class="product__update">
                                                    <a class="lightblueclr" href="#">{{$item->mensaje_personalizado}}</a>
                                                </div>
                                                @elseif($item->descuento > 0 && !$item->tienePromocion())
                                                <div class="product__update">
                                                    <a class="lightblueclr" href="#">-{{$item->descuento}}%</a>
                                                </div>
                                                @elseif($item->nuevo == 1)
                                                <div class="product__update">
                                                    <a class="lightblueclr" href="#">Nuevo</a>
                                                </div>
                                                @endif
                                                <div class="product-info mb-10">
                                                    <div class="product_category">
                                                        <p class="description">{{ $item->categoria->nombre }}</p>
                                                    </div>
                                                    <div>
                                                        <h4><a class="resaltar" href="{{ url('p/'.$item->id.'/'.name($item)) }}">{{$item->nombre}}</a></h4>
                                                    </div>
                                                </div>
                                                <div class="product-info mb-10">
                                                    <div class="product_category">
                                                        <p class="description">{{$item->descripcion}}</p>
                                                        @if($item->talles_disponibles)
                                                        <p class="tallesdisp">Talles disponibles: <br> {{$item->talles_disponibles}}</p>
                                                        @endif
                                                        <div class="product__name">
                                                            <div class="pro-priceelk">
                                                                <p class="widget-title mb-10">
                                                            @if($item->descuento > 0 && !$item->tienePromocion())
                                                            <strike class="precioviejo">${{$item->precio}}</strike> -
                                                            @endif
                                                                </p>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                                <div class="product__action">
                                                    <div class="inner__action">
                                                        <div class="view" prod-id="{{$item->id}}">
                                                            <a href="javascript:void(0)"><i class="fal fa-eye"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <!--                                      TERCEROOO-->  
                            <div class="tab-pane fade show active" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                                <div class="row">
                                    @foreach($productos as $item)
                                    <div class="col-xl-2">
                                        <div class="product product-3">
                                            <div class="product__thumb">
                                                <a href="{{ url('p/'.$item->id.'/'.name($item)) }}">
                                                    <img class="product-primary" src="{{ asset('assets/img/imagenes/'.$item->imagenesConStock()->first()->imagen) }}" alt="product_image">
                                                    <img class="product-secondary" src="{{ asset('assets/img/imagenes/'.$item->imagenesConStock()->first()->imagen) }}" alt="product_image">
                                                </a>
                                                @if($item->mensaje_personalizado != '')
                                                <div class="product__update">
                                                    <a class="lightblueclr" href="#">{{$item->mensaje_personalizado}}</a>
                                                </div>
                                                @elseif($item->descuento > 0 && !$item->tienePromocion())
                                                <div class="product__update">
                                                    <a class="lightblueclr" href="#">-{{$item->descuento}}%</a>
                                                </div>
                                                @elseif($item->nuevo == 1)
                                                <div class="product__update">
                                                    <a class="lightblueclr" href="#">Nuevo</a>
                                                </div>
                                                @endif
                                                <div class="product-info mb-10">
                                                    <div class="product_category">
                                                        
                                                        <p class="description">{{ $item->categoria->nombre }}</p>
                                                    </div>
                                                    <div>
                                                        <h4><a class="resaltar" href="{{ url('p/'.$item->id.'/'.name($item)) }}">{{$item->nombre}}</a></h4>
                                                    </div>
                                                </div>
                                                <div class="product-info mb-10">
                                                    <div class="product_category">
                                                        <p class="description">{{$item->descripcion}}</p>
                                                        @if($item->talles_disponibles)
                                                        <p class="tallesdisp">Talles disponibles: <br> {{$item->talles_disponibles}}</p>
                                                        @endif
                                                        <div class="product__name">
                                                            <div class="pro-priceelk">
                                                                <p class="widget-title mb-10">
                                                            @if($item->descuento > 0 && !$item->tienePromocion())
                                                            <strike class="precioviejo">${{$item->precio}}</strike> -
                                                            @endif
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="product__action">
                                                    <div class="inner__action">
                                                        <div class="view" prod-id="{{$item->id}}">
                                                            <a href="javascript:void(0)"><i class="fal fa-eye"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @if( $paginas > 1)
                            <div class="columndivide__tags mt-50">
                                <ul class="text-center">
                                    @for ($i = 1; $i <= $paginas; $i++)
                                    <li @if($i == $parameters['page']) class="active" @endif>
                                        <a href="{{ url('productos') . updateURL($parameters, ['page' => $i]) }}">{{ $i }}</a>
                                    </li>
                                    @endfor
                                </ul>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @else
                <div class="text-center">
                    <h3 class="widget-title">Sin resultados</h3>
                    <h3>No se han encontrado resultados para los filtros aplicados</h3>
                    <h3>Por favor intentelo de nuevo</h3>
                </div>
                @endif
            </div>
        </div>
    </div>
    <!-- shop page end -->
@endsection
@section('custom_js')
<script type="text/javascript">
</script>
@endsection