@php
	Auth::setDefaultDriver('client');
@endphp
@extends('layouts.front')

@section('title', $producto->nombre)

@section('main')
    <div class="container pt-35 pb-30">
        <!-- single_breadcrumb_area start -->
        <nav class="single_breadcrumb" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ url('catalogo') }}">Catálogo</a></li>
                <li class="breadcrumb-item"><a href="{{ url('catalogo/'.$producto->categoria->sexo->nombre) }}">{{$producto->categoria->sexo->nombre}}</a></li>
                <li class="breadcrumb-item"><a href="{{ url('productos?') . http_build_query(['category' => $producto->categoria->id]) }}">{{$producto->categoria->nombre}}</a></li>
                <li class="breadcrumb-item"><a href="{{ url('p/'.$producto->id.'/'.name($producto)) }}">{{$producto->nombre}}</a></li>
            </ol>
        </nav>
        <!-- single_breadcrumb_area end -->
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-12">
                <div class="row">
                    <div class="col-xl-10 col-lg-10 col-md-10 pb-20">
                        <div class="single_preview_product">
                            <div class="single-popup-view">
                                @if(count($imagenes) > 0)
                                <a class="popup-image" href="{{ asset('assets/img/imagenes/'.$imagenes->first()->imagen) }}"><i class="fal fa-search"></i></a>
                                @else
                                <a class="popup-image" href="{{ asset('assets/img/imagenes/'.$producto->imagenes()->first()->imagen) }}"><i class="fal fa-search"></i></a>
                                @endif
                            </div>
                            <div class="tab-content" id="myTabefContent">
                                @if(count($imagenes) > 0)
                            	@foreach($imagenes as $imagen)
                                <div class="tab-pane fade @if($loop->first) show active @endif " id="tab-{{ $imagen->id }}" role="tabpanel" >
                                   <div class="full-view">
                                        <img src="{{ asset('assets/img/imagenes/'.$imagen->imagen) }}" alt="">
                                   </div>
                                </div>
                                @endforeach
                                @else
                                @foreach($producto->imagenes as $imagen)
                                <div class="tab-pane fade @if($loop->first) show active @endif " id="tab-{{ $imagen->id }}" role="tabpanel" >
                                   <div class="full-view">
                                        <img src="{{ asset('assets/img/imagenes/'.$imagen->imagen) }}" alt="">
                                   </div>
                                </div>
                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-2">
                        <div class="single_product_tab">
                            <div class="single_prodct">
                                <ul class="nav nav-tabs justify-content-center mb-55" id="dfde" role="tablist">
                                    @if(count($imagenes) > 0)
                                	@foreach($imagenes as $imagen)
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link @if($loop->first) active @endif" id="product-tab-{{ $imagen->id }}" data-bs-toggle="tab" data-bs-target="#tab-{{ $imagen->id }}" type="button" role="tab" prod-id="{{ $imagen->id }}"
                                            aria-selected="@if($loop->first) true @else false @endif">
                                            <img src="{{ asset('assets/img/imagenes/'.$imagen->imagen) }}" alt="">
                                        </button>
                                    </li>
                                    @endforeach
                                    @else
                                    @foreach($producto->imagenes as $imagen)
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link @if($loop->first) active @endif" id="product-tab-{{ $imagen->id }}" data-bs-toggle="tab" data-bs-target="#tab-{{ $imagen->id }}" type="button" role="tab" prod-id="{{ $imagen->id }}"
                                            aria-selected="@if($loop->first) true @else false @endif">
                                            <img src="{{ asset('assets/img/imagenes/'.$imagen->imagen) }}" alt="">
                                        </button>
                                    </li>
                                    @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-12">
                <div class="single_preview_content pl-30">
                    <h2 class="title-5 edit-title border-bottom-0">{{$producto->nombre}}</h2>
                    <div class="s-des">
                        <p>{{$producto->descripcion}}</p>
                    </div>
                    <div class="s-price">
                    	@if($producto->descuento > 0 && !$producto->tienePromocion())
						<span><del>${{$producto->precio}}</del> <b>${{$producto->precioConDescuento()}} ({{$producto->descuento}}% OFF)</b></span>
						@else
                        <span>${{$producto->precio}}</span>
						@endif
<!--
                        @if($producto->descuento == 0)
                        <span class="preciomayorista">(Precio mayorista: ${{$producto->precioMayorista()}})</span>
                        @endif
-->
                    </div>
                    <div class="viewcontent__footer border-top-0 border-bottom">
                        <ul>
                            <li>Categoría:</li>
                        </ul>
                        <ul>
                            <li>{{$producto->categoria->nombre}}</li>
                        </ul>
                    </div>
                    @if($tienda->value==1)
                        @if(count($imagenes) > 0)
                        <form method="POST" action="{{ url('carrito/agregar') }}" id="cart-form">
                        	@csrf
                        	<div id="sizes" class="pb-20">
                        		@php
									if(session('variante')){
										$stocks = $imagenes->find(session('variante'))->stock()->where('stock', '>', 0)->get() ;
									}else{
										$stocks = $imagenes->first()->stock()->where('stock', '>', 0)->get() ;
									}
									foreach (Cart::content() as $key => $fila) {

										if($existing = $stocks->where('imagen_id', $fila->id)->where('talle_id', $fila->options->talle)->first()){

											if($existing->stock-$fila->qty==0){

												$stocks = $stocks->keyBy('id')->forget($existing->id);
											}else{
												$existing['stock']= $existing->stock-$fila->qty;
											}
										}
									}
								@endphp
								@foreach($stocks as $stock)
		                        <div class="size pt-10">
		                        	<span><input type="checkbox" name="talle[]" value="{{$stock->talle_id}}"> Talle {{$stock->talle->talle}}</span>
		                            <span><input type="number" name="cantidad[]" min="1" max="{{$stock->stock}}" value="1" disabled></span>
		                            <span>Stock: {{$stock->stock}}</span>
		                        </div>
		                        @endforeach
                        	</div>
	                        <div class="viewcontent__action single_action pt-10">
	                            <span><a href="#!" id="add-to-cart">+ Agregar al carrito</a></span>
	                        </div>
                            <input type="hidden" name="producto" @if($producto->descuento > 0) value="{{$producto->precio - $producto->precio * $producto->descuento / 100}}" @else value="{{$producto->precio}}" @endif>
                            <input type="hidden" name="variante" @if (session('variante')) value="{{session('variante')}}" @else value="{{$imagenes->first()->id}}" @endif>
                        </form>
                        @else
                        <div class="viewcontent__action single_action mt-40">
                            <h4>Stock agotado</h4>
                            <p>Navegue nuestro catalogo para obtener nuestros productos disponibles</p>
                            <span><a class="iniciar" href="{{ url('catalogo') }}">Catalogo</a></span>
                        </div>
                        @endif
                    @else
                    <p>ESTAMOS ACTUALIZANDO STOCK. El día de mañana podrá realizar su pedido nuevamente con el stock actualizado y novedades de nuevos articulos disponibles. Disculpe las molestias.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@section('custom_js')
<script src="{{ asset('assets/js/detail.js') }}"></script>
@endsection