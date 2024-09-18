@php
	$subtotal = 0;
	$sumas = 0;
@endphp
@extends('layouts.back')

@section('title','Agregar prendas al Pedido del '.$pedido->created_at)
 
@section('main')
		<main>
			<div class="container">
				<div class="row">
					<div class="col 12 miga">
						<p>
							<a href="{{ url('admin/clientes/pedidos/') }}">Pedidos</a> > <a href="{{ url('admin/clientes/pedidos/ver/' . $pedido->id) }}">Pedido del {{ $pedido->created_at }}</a> > Agregar prendas
						</p>
					</div>
				</div>
				<div class="row">
					<form method="POST" action="{{ url('admin/clientes/pedidos/agregar') }}">
						<div class="input-field col s12 m6">
							Producto:
						</div>
						<div class="input-field col s12 m6">
							<select name="producto_id" id="producto">
								@foreach($productos as $producto)
								<option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
								@endforeach
							</select>
						</div>
						<div class="input-field col s12 m6">
							Variante:
						</div>
						<div class="input-field col s12 m6">
							<select name="imagen_id" id="imagen" disabled>
							</select>
						</div>
						<div class="input-field col s12 m6">
							Talle:
						</div>
						<div class="input-field col s12 m6">
							<select name="talle_id" id="talles" disabled>
							</select>
						</div>
						<div class="input-field col s12 m6">
							Cantidad:
						</div>
						<div class="input-field col s12 m6">
							<input id="cantidad" type="number" name="cantidad" min="0" disabled />
						</div>
						<div class="input-field col s12">
							<button class="btn right">Agregar prenda</button>
						</div>
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="hidden" name="pedido_id" value="{{ $pedido->id }}">
					</form>
					<div class="col s12 input-field">
						<table class="highlight bordered">
							<thead>
								<tr>
									<th>Producto</th>
									<th class="center-align">Talle</th>
									<th class="center-align">Cantidad</th>
									<th>Color/Estampado</th>
									
									<th class="center-align">Subtotal</th>
								</tr>
							</thead>
							<tbody>
								
								@foreach($pedido->lineas as $linea)
								<tr>
									<td>{{$linea->imagen->producto->nombre}}</td>
									<td class="center-align">{{$linea->talle->talle}}</td>
									<td class="center-align">{{$linea->cantidad}}</td>
									<td>{{$linea->imagen->nombre}}</td>
									
									@php
										$subtotal+=$linea->precio*$linea->cantidad;
										$sumas+=$linea->cantidad;
									@endphp

									<td class="center-align">${{$linea->precio*$linea->cantidad}} @if($linea->tiene_promocion == 1) (Precio Promoción)@endif</td>
																		

								</tr>
								@endforeach
								<tr>
									<td colspan="2"></td>
									<td class="center-align">{{ $sumas }} Prendas</td>
									<td class="center-align">Total:</td>
									<td class="center-align">${{ $pedido->monto }}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="row">
					<div class="col s12">
						<a href="{{ url('admin/clientes/pedidos/ver/' . $pedido->id) }}">
							<button class="btn right">Volver atras</button>
						</a>
					</div>
				</div>
			</div>
		</main>
@endsection
@section('javascript')
		<script type="text/javascript">
			$(document).ready(function(){
				initialize();

				$('#producto').change(function(){
					$('#imagen').removeAttr('disabled');
					let id = $(this).val();
					$.get( '{{ url('imagenes-json') }}/' + id, function( data ) {
						let stocks = JSON.parse(data);
						$('#imagen').html('');
						$(stocks).each(function( index, el ) {
						 	$('#imagen').append( "<option value='" + el.id + "'>" + el.nombre + "</option>" );
						 	initialize();
						});

						$('#talles').attr('disabled');
						$('#cantidad').attr('disabled', 'disabled');
					});
				});

			});
			function initialize(){
				$('select').material_select();
				document.querySelectorAll('.select-wrapper').forEach(t => t.addEventListener('click', e=>e.stopPropagation()));
				
				$('#imagen').change(function(){
					$('#talles').removeAttr('disabled');
					let id = $(this).val();
					$.get( '{{ url('talles-json') }}/' + id, function( data ) {
						let stocks = JSON.parse(data);
						$('#talles').html('');
						$(stocks).each(function( index, el ) {
						 	$('#talles').append( "<option stock='" + el.stock + "' value='" + el.talle.id + "'>" + el.talle.talle + "</option>" );
						 	initialize();
						});
						$('#cantidad').attr('disabled', 'disabled');
					});
				});

				$('#talles').change(function(){
					
					let max = $("option:selected", this).attr('stock');
					$('#cantidad').removeAttr('disabled');
					$('#cantidad').attr('max', max);
					$('#cantidad').val(1);
				});
			}
		</script>
@endsection