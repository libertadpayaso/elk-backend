@extends('layouts.front')

@section('title','Inicio')

@section('main')

<!-- features area start  -->
    <div class="features-area  d-md-block fix mb-50">
        <div class="row g-0">            
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                <div class="fetures">
                    <div class="fetures__thumb fix">
                        <a href="https://elkideasdeportivas.com.ar/productos"><img src="{{ asset('assets/img/features/fe1ELK11.jpg') }}" alt="features1"></a>
                    </div>
                    <div class="fetures__content">
                        <h4 class="feature-titleNEGRO mb-30">¿Sos Revendedor/a?</h4>
                        <p class="pedilista">¡Pedí la LISTA DE PRECIOS MAYORISTA!</p> 
                        <p class="pedilista"><a href="https://api.whatsapp.com/send?phone=5491130638568">HAZ CLIC AQUÍ</a></p> 
                    </div>
                </div>
            </div>            

            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                <div class="fetures">
                    <div class="fetures__thumb fix">
                        <a href="https://elkideasdeportivas.com.ar/productos"><img src="{{ asset('assets/img/features/fe2ELK13.jpg') }}" alt="features1"></a>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                <div class="fetures">
                    <div class="fetures__thumb fix">
                        <a href="https://elkideasdeportivas.com.ar/c/7/biker-(ciclistas)"><img src="{{ asset('assets/img/features/fe3ELK9.jpg') }}" alt="features1"></a>
                    </div>
                    <div class="fetures__content">
                        <h4 class="feature-titleNEGRO mb-40">Calzas Gofradas</h4>
                        <p class="feature-titleNEGRO d-md-none d-lg-block">¿Queres ver todos los modelos? <span class="discount"><a href="https://elkideasdeportivas.com.ar/productos">Haz clic aquí</a></span></p>   
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                <div class="fetures">
                    <div class="fetures__thumb fix">
                        <a href="https://api.whatsapp.com/send?phone=5491130638568"><img src="{{ asset('assets/img/features/fe3ELK10.jpg') }}" alt="features1"></a>
                    </div>
                    <div class="fetures__content">
                        <h4 class="feature-titleNEGRO mb-40">Seamless</h4>
                        <p class="feature-titleNEGRO d-md-none d-lg-block">LLevá x1 </p>
                        <p class="feature-titleNEGRO d-md-none d-lg-block">Pack x3</p>  
                        <p class="feature-titleNEGRO d-md-none d-lg-block">Pack x12</p>  
                        <p class="feature-titleNEGRO d-md-none d-lg-block"><span class="discount"><a href="https://api.whatsapp.com/send?phone=5491130638568">Haz clic aquí</a></span></p>
                    </div>
                </div>
            </div>


        </div>
    </div>

<!-- features area end  -->


 <!-- inicio productos nuevos -->
    @if(count($nuevos) > 0)
    <div class="mb-50">
        <div class="container-fluid">
            <div class="row">
                <div class="section-wrapper text-center">
                    <h2 class="section-title">
                        <a href="{{ url('productos?page=1&cant=24&nuevo=1') }}">Productos Nuevos</a>
                    </h2>
                </div>
                <div class="carousel-nuevos swiper-container">
                    <div class="swiper-wrapper">
                        @foreach($nuevos as $item)
                        @if(null !==$item->imagenes()->first())
                        <div class="product-item swiper-slide  wow fadeInLeft " data-wow-duration=".9s" data-wow-delay=".5s">
                            <div class="product product-2">
                                <div class="product__thumb">
                                    <a href="{{ url('p/'.$item->id.'/'.name($item)) }}">
                                        <img class="product-primary" src="{{ url('assets/img/imagenes/'.$item->imagenes()->first()->imagen) }}" alt="{{$item->nombre}}" title="{{$item->nombre}}">
                                        <img class="product-secondary" src="{{ url('assets/img/imagenes/'.$item->imagenes()->first()->imagen) }}" alt="{{$item->nombre}}" title="{{$item->nombre}}">
                                    </a>
                                    @if($item->descuento > 0 && !$item->tienePromocion())
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
                                            </p>
                                        </div>
                                    </div>
                                    <div class="product-info mb-10">
                                        <div class="product_category">
                                            <h4><a class="resaltar" href="{{ url('p/'.$item->id.'/'.name($item)) }}">{{$item->nombre}}</a></h4>
                                            
                                            <span>{{$item->categoria->nombre}}</span>
                                            <p class="description">{{$item->descripcion}}</p>
                                            @if($item->talles_disponibles)
                                            <p class="tallesdisp">Talles disponibles: <br>{{$item->talles_disponibles}}</p>
                                            @endif
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
                        @endif
                        @endforeach
                    </div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <!-- final productos nuevos -->

    <!-- inicio ofertas -->
    @if(count($ofertas) > 0)
    <div class="mb-80" id="nuevooferta">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="section-wrapper text-center">
                        <h2 class="section-title2"><a href="https://elkideasdeportivas.com.ar/productos">Ofertas | Descuentos | Discontinuos </a>
                        <div class="blacking">Prendas con hasta 40% de decuentos </div></h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="carousel-ofertas swiper-container">
                    <div class="swiper-wrapper">
                        @foreach($ofertas as $item)
                        @if(null !==$item->imagenes()->first())
                        <div class="product-item swiper-slide  wow fadeInLeft " data-wow-duration=".9s" data-wow-delay=".5s">
                            <div class="product product-2">
                                <div class="product__thumb">
                                    <a href="{{ url('p/'.$item->id.'/'.name($item)) }}">
                                        <img class="product-primary" src="{{ url('assets/img/imagenes/'.$item->imagenes()->first()->imagen) }}" alt="{{$item->nombre}}" title="{{$item->nombre}}">
                                        <img class="product-secondary" src="{{ url('assets/img/imagenes/'.$item->imagenes()->first()->imagen) }}" alt="{{$item->nombre}}" title="{{$item->nombre}}">
                                    </a>
                                    @if($item->descuento > 0 && !$item->tienePromocion())
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
                                            <span>{{$item->categoria->nombre}}</span>
                                            <p class="description">{{$item->descripcion}}</p>
                                            @if($item->talles_disponibles)
                                            <p class="tallesdisp">Talles: {{$item->talles_disponibles}}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="product__name">
                                        <h4><a href="{{ url('p/'.$item->id.'/'.name($item)) }}">{{$item->nombre}}</a></h4>
                                        <div class="pro-price">
                                            <p class="p-absoulute pr-1">
                                                @if($item->descuento > 0 && !$item->tienePromocion())
                                                <strike class="precioviejo"><span>$</span>{{$item->precio}}</strike> -
                                                @endif
                                                <span>$</span>{{$item->precioConDescuento()}}
                                                @if($item->descuento == 0)
                                                <span class="preciomayorista">(Precio mayorista: ${{$item->precioMayorista()}})</span>
                                                @endif
                                            </p>
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
                        @endif
                        @endforeach
                    </div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <!-- final ofertas -->

    <!-- gallary area start  -->
    <div class="gallary_area">
        <div class="gallary__thumb">
            <a href="https://elkideasdeportivas.com.ar/productos"><img src="./assets/img/gallary/gallary3-2.jpg" alt="gallaryImage"></a>
        </div>
        <div class="gallary__thumb">
            <a href="https://elkideasdeportivas.com.ar/productos"><img src="./assets/img/gallary/gallary1-3.jpg" alt="gallaryImage"></a>
        </div>
        <div class="gallary__thumb">
            <a href="https://elkideasdeportivas.com.ar/productos"><img src="./assets/img/gallary/gallary2-3.jpg" alt="gallaryImage"></a>
        </div>
        <div class="gallary__thumb">
            <a href="https://elkideasdeportivas.com.ar/productos"><img src="./assets/img/gallary/gallary4-1.jpg" alt="gallaryImage"></a>
        </div>
        <div class="gallary__thumb">
            <a href="https://elkideasdeportivas.com.ar/productos"><img src="./assets/img/gallary/gallary6-1.jpg" alt="gallaryImage"></a>
        </div>
        <div class="gallary__thumb">
            <a href="https://elkideasdeportivas.com.ar/productos"><img src="./assets/img/gallary/gallary5-1.jpg" alt="gallaryImage"></a>
        </div>
    </div>
    <!-- gallary area end  -->
@endsection