@php
	Auth::setDefaultDriver('client');
	$subtotal = 0;
	$sumas = 0;
@endphp

@extends('layouts.front')

@section('title','Ver Pedido #' . $pedido->id)

@section('main')
	<div class="page-layout thin">
        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="breadcrumb-area text-center">
                        <h2 class="page-title">Pedido #{{ $pedido->id }}</h2>
                            <div class="breadcrumb-menu">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb justify-content-center">
                                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Inicio</a></li>
                                    <li class="breadcrumb-item"><a href="{{ url('perfil') }}">Mi cuenta</a></li>
                                    <li class="breadcrumb-item"><a href="#!">Pedido #{{ $pedido->id }}</a></li>
                                </ol>
                            </nav>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
    <div class="categories_area pt-85 mb-150">
        <div class="container-fluid">
            @if($pedido->mercadopago==1)
            <div class="section-wrapper text-center mb-35">
				<p>Cobrado con Mercado Pago</p>
            </div>
			@endif
            <div class="container cart_table">
                <table>
                    <thead>
						<td>Imagen</td>
						<td>Producto</td>
						<td class="center-align">Talle</td>
						<td class="center-align">Cantidad</td>
						<td>Color/Estampado</td>
						<td class="center-align">Subtotal</td>
                    </thead>
                    <tbody>
                       @foreach($pedido->lineas as $linea)
						<tr>
							<td><img class="responsive-img materialboxed" src="{{ asset('assets/img/imagenes/'.$linea->imagen->imagen) }}"></td>
							<td>{{$linea->imagen->producto->nombre}}</td>
							<td class="center-align">{{$linea->talle->talle}}</td>
							<td class="center-align">{{$linea->cantidad}}</td>
							<td>{{$linea->imagen->nombre}}</td>
								@php
								$subtotal+=$linea->precio*$linea->cantidad;
								$sumas+=$linea->cantidad;
							@endphp
							<td class="center-align">${{$linea->precio*$linea->cantidad}}</td>
						</tr>
						@endforeach
						<tr>
							<td colspan="3"></td>
							<td class="center-algn">{{ $sumas }} Prendas</td>
							<td class="center-align">Total:</td>
							<td class="center-align">${{ $pedido->monto }}</td>
						</tr>
						<tr style="background-color: {{ $colores[$pedido->estado] }}">
							<td colspan="4"></td>
							<td class="center-align">Estado:</td>
							<td>
								{{$estados[$pedido->estado]}}
							</td>
						</tr>
                    </tbody>
                    <tfoot>
                    	<tr class="design-footer">
                    		<td colspan="6">
                				<a class="mr-15" href="{{ url('admin/clientes/pedidos/descargar/'.$pedido->id) }}">Descargar en PDF</a>
                    		</td>
                    	</tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection