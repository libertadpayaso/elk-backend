@extends('layouts.back')

@section('title','Pedidos por Cliente')

@section('main')

	<main>
		<div class="row">
			<div class="col s12 m4">
				<div class="card" style="background-color: #a3073f;">
					<div class="card-content white-text">
						@php
							$primero = current($estadisticas);
						@endphp
						<span class="card-title">Cliente que mas compró</span>
						<p>{{ $primero['cliente'] }}</p>
						<h1>{{ $primero['cantidad'] }} productos</h1>
						<p>Último pedido: {{ $primero['ultimo'] }}</p>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="container">
				<div class="col s12">
					<table class="highlight bordered">
						<thead>
							<td>Cliente</td>
							<td>Cantidad de Pedidos Entregados</td>
							<td>Contacto</td>
							<td>Último Pedido Registrado</td>
						</thead>
						<tbody>
							@foreach($estadisticas as $fila)
							<tr>
								<td>
									{{ $fila['cliente'] }}
								</td>
								<td>
									{{ $fila['cantidad'] }}
								</td>
                                <td>
									{{ $fila['contacto'] }}
								</td>
								<td>
									{{ $fila['ultimo'] }}
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>            
				</div>
			</div>
		</div>
	</main>
@endsection