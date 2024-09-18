@extends('layouts.back')

@section('title','Pedidos por Mes')

@section('main')

	<main>
		<div class="row">
			<div class="col s12 m4">
				<div class="card" style="background-color: #a3073f;">
					<div class="card-content white-text">
						@php
							$primero = current($estadisticas);
						@endphp
						<span class="card-title">Pedidos Vendidos este mes</span>
						<h1>{{ $primero['cantidad'] }}</h1>
						<span class="card-title">Monto Recaudado este mes</span>
						<h1>{{ $primero['monto'] }}</h1>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="container">
				<div class="col s12">
					<table class="highlight bordered">
						<thead>
							<td>Periodo</td>
							<td>Cantidad de Pedidos Entregados</td>
							<td>Monto Recaudado</td>
						</thead>
						<tbody>
							@foreach($estadisticas as $fila)
							<tr>
								<td>
									{{ $fila['mes'] }}
								</td>
								<td>
									{{ $fila['cantidad'] }}
								</td>
								<td>
									{{ $fila['monto'] }}
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