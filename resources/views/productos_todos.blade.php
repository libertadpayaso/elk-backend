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

    <div class="fix d-block d-sm-none">
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

	<!-- shop page start -->
    <div class="shop-page">
        <div class="container" id="main-shop">
            <div class="row">
                <div class="col d-sm-none pt-20 pb-20">
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
                        <!--div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Accordion Item #1
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Accordion Item #2
                            </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                            <strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                            </div>
                            </div>
                            </div>
                            <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Accordion Item #3
                            </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                            <strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                            </div>
                            </div>
                            </div>
                        </div-->
                        <div class="product-widget pb-50">
                            <ul class="product-categories">
                                <li @if(isset($_GET['nuevo'])) class="active" @endif>
                                    <a href="{{ url('productos') . updateURL($parameters, ['nuevo' => 1, 'page' => 1]) }}">
                                        ¡Quiero VER LO NUEVO!
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="product-widget pb-50">
                            <h3 class="widget-title mb-30">Tipo</h3>
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
                        

                        <div class="product-widget pb-50">
                            <h3 class="widget-title mb-30">Categorías</h3>
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
                    <!-- sidebar area end -->
                </div>
                <div class="col-xl-9 col-lg-8 col-md-12 col-sm-12">
                    @if(count($productos) > 0)
                    <div class="shop-top-bar position-relative">
                        <div class="showing-result">
                            <p> Mostrando {{ $inicio + 1 }} - {{ $inicio + count($productos) }} de {{ $total }} resultados</p>
                        </div>
                        <div class="shop-tab d-none d-sm-block">
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
                    </div>
                    <div class="shop-page-product pb-100">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12">
                                  <div class="tab-content" id="nav-tabContent">
                                    <div class="tab-pane fade" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                        <div class="row">
                                            @foreach($productos as $item)
                                            <div class="col-xl-6">
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



                                                        <div class="product__nameelk">
                                                            
                                                            <div class="pro-priceelk">
                                                                <p class="pr-1elk">
                                                                    @if($item->descuento > 0 && !$item->tienePromocion())
                                                                    <span class="black"><strike class="precioviejo"><span>$</span>{{$item->precio}}</strike> -
                                                                    @endif
                                                                     <span>$</span>{{$item->precioConDescuento()}}</span>
                                                                    <!--@if($item->descuento == 0)
                                                                    <span class="preciomayorista">(${{$item->precioMayorista()}} x Mayor)</span>
                                                                    @endif -->
                                                                </p>
                                                                
                                                            </div>
                                                        </div>



                                                        <div class="product-info mb-10">
                                                            <div class="product_category">
                                                                <h4><a class="resaltar" href="{{ url('p/'.$item->id.'/'.name($item)) }}">{{$item->nombre}}</a></h4>
                                                                
                                                                <p class="description">{{ $item->categoria->nombre }}</p>
                                                                <p class="description">{{$item->descripcion}}</p>
                                                                @if($item->talles_disponibles)
                                                                <p class="tallesdisp">Talles disponibles: <br>{{$item->talles_disponibles}}</p>
                                                                @endif
                                                                <a class="p-absoulute pr-2" href="{{ url('p/'.$item->id.'/'.name($item)) }}">Ver más</a>
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
                                    <div class="tab-pane fade " id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                        <div class="row">

                                            @foreach($productos as $item)
                                            <div class="col-xl-4 col-6">
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

                                                        <div class="product__name">
                                                            
                                                            <div class="pro-priceelk">
                                                                <p class="pr-1elk">
                                                                    @if($item->descuento > 0 && !$item->tienePromocion())
                                                                    <strike class="precioviejo"><span>$</span>{{$item->precio}}</strike> -
                                                                    @endif
                                                                     <span>$</span>{{$item->precioConDescuento()}}
                                                                   <!-- @if($item->descuento == 0)
                                                                    <span class="preciomayorista">(${{$item->precioMayorista()}} x Mayor)</span>
                                                                    @endif -->
                                                                </p>
                                                                 
                                                            </div>
                                                        </div>




                                                        <div class="product-info">
                                                            <div class="product_category">
                                                                <h4><a class="resaltar" href="{{ url('p/'.$item->id.'/'.name($item)) }}">{{$item->nombre}}</a></h4>
                                                                <p class="description">{{ $item->categoria->nombre }}</p>
                                                                <p class="description">{{$item->descripcion}}</p>
                                                                @if($item->talles_disponibles)
                                                                <p class="tallesdisp">Talles disponibles: <br> {{$item->talles_disponibles}}</p>
                                                                @endif
                                                                <a class="p-absoulute pr-2" href="{{ url('p/'.$item->id.'/'.name($item)) }}">Ver más</a>
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
                                    <div class="tab-pane fade show active" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                                        <div class="row">

                                            @foreach($productos as $item)
                                            <div class="col-xl-3">
                                                <div class="product product-3">
                                                    <div class="product__thumb">
                                                        <a href="{{ url('p/'.$item->id.'/'.name($item)) }}">
                                                            <img class="product-primary" src="{{ asset('assets/img/imagenes/'.$item->imagenesConStock()->first()->imagen) }}" alt="product_image">
                                                            <img class="product-secondary" src="{{ asset('assets/img/imagenes/'.$item->imagenesConStock()->first()->imagen) }}" alt="product_image">
                                                        </a>
                                                        <!-- <div class="product__update">
                                                            <a class="#">new</a>
                                                        </div> -->
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

                                                        <div class="product__name">
                                                            
                                                            <div class="pro-priceelk">
                                                                <p class="pr-1elk">
                                                                    @if($item->descuento > 0 && !$item->tienePromocion())
                                                                    <strike class="precioviejo"><span>$</span>{{$item->precio}}</strike> -
                                                                    @endif
                                                                    <span>$</span>{{$item->precioConDescuento()}}
                                                                     @if($item->descuento == 0)
                                                                    <!--<span class="preciomayorista">(${{$item->precioMayorista()}} x Mayor)</span>
                                                                    @endif -->
                                                                </p>
                                                                
                                                            </div>
                                                        </div>




                                                        <div class="product-info mb-10">
                                                            <div class="product_category">
                                                                <h4><a class="resaltar" href="{{ url('p/'.$item->id.'/'.name($item)) }}">{{$item->nombre}}</a></h4>
                                                                <p class="description">{{ $item->categoria->nombre }}</p>
                                                                <p class="description">{{$item->descripcion}}</p>
                                                                @if($item->talles_disponibles)
                                                                <p class="tallesdisp">Talles disponibles: <br> {{$item->talles_disponibles}}</p>
                                                                @endif
                                                                <a class="pr-2" href="{{ url('p/'.$item->id.'/'.name($item)) }}">Ver más</a>
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
    </div>
    <!-- shop page end -->
@endsection
@section('custom_js')
<script type="text/javascript">
</script>
@endsection