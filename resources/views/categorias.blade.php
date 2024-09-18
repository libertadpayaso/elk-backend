@php
	Auth::setDefaultDriver('client');
@endphp
@extends('layouts.front')

@section('title','Catalogo '.ucfirst($sexo->nombre))

@section('main')

    <!-- shop page start -->
    <div class="shop-page pt-35">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-4">
                    <!-- sidebar area start -->
                    <div class="sidebar col-md-12 d-none d-lg-block">
                        <div class="product-widget">
                            <h3 class="widget-title mb-30">Categorías</h3>
                            <ul class="product-categories">
                                @foreach($sexos as $option)
                                <li>
                                    <a href="{{ url('catalogo/'.$option->nombre) }}">{{ ucfirst($option->nombre) }} <span></span></a>
                                    @if($option->id == $sexo->id)
                                    <ul>
                                        @foreach($option->disponibles() as $item)
                                        <li>
                                            <a href="{{ url('productos?') . http_build_query(['category' => $item->id]) }}">{{$item->nombre}} <span></span></a>
                                            @if(isset($categoria) && $item->id == $categoria->id)
                                            <ul>
                                                @foreach($item as $child)
                                                <li><a href="{{ url('p/'.$child->id.'/'.name($child)) }}">{{$child->nombre}}</a></li>
                                                @endforeach
                                            </ul>
                                            @endif
                                        </li>
                                        @endforeach
                                    </ul>
                                    @endif
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <!-- sidebar area end -->
                    <!-- single_breadcrumb_area start -->
                    <nav class="single_breadcrumb breadcrumb-mobile d-lg-none mb-30" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('catalogo') }}">Catálogo</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('catalogo/'.$sexo->nombre) }}">{{$sexo->nombre}}</a></li>
                        </ol>
                    </nav>
                    <!-- single_breadcrumb_area end -->
                </div>
                <div class="col-xl-9 col-lg-8 col-md-12 col-sm-12">
                    <div class="shop-top-bar position-relative">
                        <div class="showing-result">
                            <p> Mostrando {{ count($stock) }} resultados</p>
                        </div>
                        <div class="shop-tab d-none d-sm-block">
                            <nav>
                                <div class="nav nav-tabs shop-tabs" id="nav-tab" role="tablist">
                                    <button>
                                        <span>Vista</span>
                                    </button>
                                    <button class="nav-link" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">
                                        <img src="{{ asset('assets/img/essential/i2.svg') }}" alt="">
                                    </button>
                                    <button class="nav-link active" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">
                                        <img src="{{ asset('assets/img/essential/i3.svg') }}" alt="">
                                    </button>
                                    <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">
                                        <img src="{{ asset('assets/img/essential/i4.svg') }}" alt="">
                                    </button>
                                </div>
                            </nav>                                 
                        </div>
                    </div>
                    <div class="shop-page-product pt-50 pb-100">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12">
                                  <div class="tab-content" id="nav-tabContent">
                                    <div class="tab-pane fade" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                        <div class="row">
                                            @foreach($stock as $item)
                                            <div class="col-xl-6">
                                                <div class="product product-4">
                                                    <div class="product__thumb">
                                                        <a href="{{ url('productos?') . http_build_query(['category' => $item->id]) }}">
                                                            <img class="product-primary" src="{{ asset('assets/img/categorias/'.$item->imagen) }}" alt="product_image">
                                                            <img class="product-secondary" src="{{ asset('assets/img/categorias/'.$item->imagen) }}" alt="product_image">
                                                        </a>
                                                        <div class="product__name">
                                                            <h4><a href="{{ url('productos?') . http_build_query(['category' => $item->id]) }}">{{$item->nombre}}</a></h4>
                                                            <div class="pro-price">
                                                                <a class="p-absoulute pr-2" href="{{ url('productos?') . http_build_query(['category' => $item->id]) }}">Ver más</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="tab-pane fade show active" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                        <div class="row">

                                            @foreach($stock as $item)
                                            <div class="col-6 col-xl-4">
                                                <div class="product product-4">
                                                    <div class="product__thumb">
                                                        <a href="{{ url('productos?') . http_build_query(['category' => $item->id]) }}">
                                                            <img class="product-primary" src="{{ asset('assets/img/categorias/'.$item->imagen) }}" alt="product_image">
                                                            <img class="product-secondary" src="{{ asset('assets/img/categorias/'.$item->imagen) }}" alt="product_image">
                                                        </a>
                                                        <div class="product__name">
                                                            <h4><a href="{{ url('productos?') . http_build_query(['category' => $item->id]) }}">{{$item->nombre}}</a></h4>
                                                            <div class="pro-price">
                                                                <a class="p-absoulute pr-2" href="{{ url('productos?') . http_build_query(['category' => $item->id]) }}">Ver más</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach

                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                                        <div class="row">

                                            @foreach($stock as $item)
                                            <div class="col-xl-3">
                                                <div class="product product-3">
                                                    <div class="product__thumb">
                                                        <a href="{{ url('productos?') . http_build_query(['category' => $item->id]) }}">
                                                            <img class="product-primary" src="{{ asset('assets/img/categorias/'.$item->imagen) }}" alt="product_image">
                                                            <img class="product-secondary" src="{{ asset('assets/img/categorias/'.$item->imagen) }}" alt="product_image">
                                                        </a>
                                                        <div class="product__name">
                                                            <h4><a href="{{ url('productos?') . http_build_query(['category' => $item->id]) }}">{{$item->nombre}}</a></h4>
                                                            <div class="pro-price">
                                                                <a class="p-absoulute pr-2" href="{{ url('productos?') . http_build_query(['category' => $item->id]) }}">Ver más</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
    </div>
    <!-- shop page end -->
@endsection