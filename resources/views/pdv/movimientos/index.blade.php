@extends('layouts.pdv')

@section('title','Listado de Movimientos')
 
@section('main')
		<main>
			<div class="container">
				<div class="row">
					<div class="col 12 miga">
						<p>
							Movimientos
						</p>
					</div>
				</div>
				<div class="row">
					<div class="col s12">
						<div class="card blue-grey darken-1">
							<div class="card-content white-text">
								<span class="card-title">Recaudación @if($fecha) del {{$fecha}} @else de hoy @endif</span>
								<h2>${{ number_format($recaudacion, 0, ",",".") }}</h2>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
                    <div class="col s12 m6 input-field">
						<form action="{{ url('pdv/movimientos') }}" method="GET" id="formulario">
							<label for="fecha">Filtrar por Fecha</label>
							<input type="text" class="datepicker" id="fecha" name="fecha" @if($fecha) value="{{ $fecha }}" @endif>
						</form>
                    </div>
					<div class="col s12 m6">
						<a href="{{ url('pdv/movimientos/create') }}">
							<button class="btn waves-effect waves-light right">Nuevo
								<i class="material-icons right">add_to_photos</i>
							</button>
						</a>
					</div>
				</div>
				<div class="row">
					<div class="col s12">
						@if(count($movimientos) > 0)
						<table class="highlight bordered responsive-table" >
							<thead >
								<td>Fecha</td>
								<td>Pedido</td>
								<td>Concepto</td>
								<td>Subtotal</td>
								<td>Monto</td>
							</thead>
							<tbody>
								@foreach($movimientos as $movimiento)
								<tr style="background-color: @if($movimiento->monto > 0) #b4ffb4 @else #fbb1b1 @endif">
									<td>
										{{ $movimiento->created_at }}
									</td>
									<td>
                                        @if($movimiento->pedido_id)
                                        <a href="{{ url('pdv/pedidos/ver/' . $movimiento->pedido_id) }}" target="_blank"><i class="material-icons">remove_red_eye</i></a>
                                        @endif
									</td>
									<td>
										{{ $movimiento->concepto }}
									</td>
                                    <td>
										${{ $movimiento->subtotal }}
									</td>
                                    <td>
										${{ $movimiento->monto }}
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
						@else 
						<h3>No hay movimientos disponibles</h3>
						@endif
					</div>
				</div>
			</div>
		</main>
@endsection

@section('javascript')
        <script type="text/javascript">
			$(document).ready(function(){
                $('.datepicker').pickadate();
                //$('.datepicker').off('focus');
				$('#fecha').change(function(){
					$('#formulario').submit();
				});
            });
        </script>
@endsection