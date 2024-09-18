@extends('layouts.front')

@section('title','Lista de precios')

@section('main')
	<<div class="page-layout thin">
        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="breadcrumb-area text-center">
                        <h2 class="page-title">Lista de Precios</h2>
                            <div class="breadcrumb-menu">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb justify-content-center">
                                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Inicio</a></li>
                                    <li class="breadcrumb-item"><a href="#!">Lista de Precios</a></li>
                                </ol>
                            </nav>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="f_cart_area pt-110 mb-100">
        <div class="container">
       		<h3 class="title">LISTA DE PRECIOS | MAYORISTA | {{strtoupper($carbon->formatLocalized('%B'))}} / {{$carbon->format('Y')}}</h3>
            @foreach($categorias as $categoria)
        	<div class="cart_table mt-25 mb-25">
				<h4>{{$categoria->nombre}}({{$categoria->sexo->nombre}})</h4>
                <table class="mt-30">
					<thead>
						<tr>
							<th>ARTICULO</th>
							<th>DESCRIPCIÓN</th>
							<th>PRECIO</th>
							<th>TALLES</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@foreach($categoria->productos()->where('catalogo', 1)->get() as $producto)
						<tr>
							<td class="articulo">{{$producto->nombre}}</td>
							<td class="descripcion">
							@php
								if (strlen($producto->descripcion)>40) {
									$descripcion = substr($producto->descripcion, 0, 40).'...';
								}else{
									$descripcion = $producto->descripcion;
								}
							@endphp	
								{{$descripcion}}</td>
							<td class="precio">${{$producto->precio}}</td>
							<td class="talle">
							@php
								$talles = [];
								foreach ($producto->talles()->get() as $talle) {
									$talles[] = $talle->id;
								}
								$tallesString = implode(' ', $talles);
							@endphp
								{{$tallesString}}
							</td>
							<td>
								<a target="_blank" href="{{ url('p/'.$producto->id.'/'. name($producto)) }}">
									<i class="fa fa-eye" aria-hidden="true"></i>
								</a>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
            </div>
            @endforeach
        </div>
    </div>
@endsection