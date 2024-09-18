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
                    <!-- <div class="fetures__content pt-200">
                        <p class="d-md-none d-lg-block">Comprá nuestra linea deportiva, con envío a todo el país. </p>
                    </div> -->
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


<!-- slider start -->
<!--
    <div class="slider-active swiper-container height">
        <div class="swiper-wrapper">
            <div class="swiper-slide slider-item">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="slider_images">                                
                                <img class="back" src="{{ asset('assets/img/slider/slider-img-1elk8.png') }}" alt="">
                                <img class="top" src="{{ asset('assets/img/slider/textelk1-9.png') }}" alt="">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-slide slider-item2">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="slider_images">
                                <img class="back" src="{{ asset('assets/img/slider/revo2221elk4.png') }}" alt="">
                                <img class="top" src="{{ asset('assets/img/slider/textelk23.png') }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-slide slider-item3">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="slider_images">
                                <img class="back" src="{{ asset('assets/img/slider/slider-img-elk33.png') }}" alt="">
                                <img class="top" src="{{ asset('assets/img/slider/textelk31.png') }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="swiper-pagination"></div>
        <div class="swiper-pagination swiper-pagination-clickable swiper-pagination-bullets">
            <span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 1"></span>
            <span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 2"></span>
            <span class="swiper-pagination-bullet swiper-pagination-bullet-active" tabindex="0" role="button" aria-label="Go to slide 3"></span>
            <span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 4"></span>
            <span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 5"></span>
        </div>
        <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
    </div>
-->
    <!-- slider end -->


    




    
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


 <!-- product show case area start  -->
    <div class="show-case lightblue pt-125">
        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="section-wrapper text-center mb-35">
                        <h4 class="sub-title">Equipos personalizados</h4>
                        <h2 class="section-title text-white">Vestí a tu equipo</h2>
                        <p class=" d-lg-block">Ahora podés pedirnos un diseño personalizado para tu equipo.</p>
                    </div>
                    <div class="fetures_3_body text-center">
                    <a class="button_style_f" href="https://api.whatsapp.com/send?phone=+5491130638568&text=QuieroMiEquipo">Use Code: QUIEROMIEQUIPO</a>
                    </div>
                </div>
                
                
                <div class="case-info text-center">
                    <span class="offer-text d-none d-lg-block">pre mium<i class="far fa-stars"></i></span>
                    <h2 class="back1-text d-none d-lg-block">top</h2>
                    <h2 class="back-text d-none d-lg-block">limited</h2>
                    <a href="https://api.whatsapp.com/send?phone=+5491130638568&text=QuieroMiEquipo"><img class="banar-product" src="./assets/img/product/product4-1.png" alt=""></a>
                </div>
                
                
                
                
            </div>
        </div>
        
    </div>
    <!-- product show case area end  -->

   


<!-- fetures-3 area start -->
<!--
    <div class="fetures_area_3 pt-30">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                    <div class="fetures_3" data-background="assets/img/features/diadelpadre1-4.jpg">
                        <div class="fetures_3_header pt-30">
                            <span class="offer-text offer_3">New<i class="far fa-stars"></i></span>
                        </div>
                        <div class="fetures_3_body">
                            <a href="https://www.elkideasdeportivas.com.ar/c/62/su%C3%A9teres"><h2 class="mb-60">El<br>Mejor<br> Abrigo</h2></a>
                            <p>Quiero <span>Comprar</span><br> Envíos a todo el país</p>
                        </div>
                        <div class="fetures_3_footer"></div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 d-sm-none d-md-block">
                    <div class="fetures_3" data-background="assets/img/features/termicas1-3.jpg">
                        <div class="fetures_3_header pt-30 text-center ">
                           <p>Ropa Deportiva Hombre</p>
                        </div>
                        <div class="fetures_3_body text-center">
                            <a href="https://www.elkideasdeportivas.com.ar/c/60/camiseta-termica-hombre"><h2 class="fetures_s_2 fesection-2 mb-80">Térmica<span> Deportiva</span></h2></a>
                            <a class="button_style_f" href="https://api.whatsapp.com/send?phone=+5491130638568&text=QuieroMiT%C3%A9rmica">Quiero Mi Térmica</a>
                        </div>
                        <div class="fetures_3_footer mb-80"></div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                    <div class="fetures_3" data-background="assets/img/features/hombre1.jpg">
                        <div class="fetures_3_header pt-30 ">
                           <span class="text-white text-uppercase">Elk tienda</span>
                        </div>
                        <div class="fetures_3_body">
                            <a href="shop.html"><h2 class="mb-30">deporte<br>Comodidad<br> entrenamiento</h2></a>
                            <p>ofertas <span class="text-clr-change"> NUEVO</span><br> Línea de hombre</p>
                        </div>
                        <div class="fetures_3_footer"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
-->
    <!-- fetures-3 area end -->






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
    
    <!-- inicio categorias -->
    <!-- final categorias -->  
@endsection