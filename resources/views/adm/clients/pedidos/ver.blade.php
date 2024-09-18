@php
	$subtotal = 0;
	$sumas = 0;
@endphp
@extends('layouts.back')

@section('title','Pedido del '.$pedido->created_at)
 
@section('main')
		<main>
			<div class="container">
				<div class="row">
					<div class="col 12 miga">
						<p>
							<a href="{{ url('admin/clientes/pedidos/') }}">Pedidos</a> > {{'Pedido del '.$pedido->created_at}}
						</p>
					</div>
				</div>
				<div class="row">
					<div class="col s12">
						<h5>De: {{$pedido->client->nombre }}</h5>
						@if($pedido->mercadopago==1)
						<p>Cobrado con Mercado Pago</p>
						@endif
					</div>
					<div class="col s12">
						<a class="btn right red darken-4" href="{{ url('admin/clientes/pedidos/descargar/'.$pedido->id) }}">Descargar</a>
					</div>
					<div class="input-field col s12">
						<table class="highlight bordered">
							<thead>
								<tr>
									<th>Imagen</th>
									<th>Producto</th>
									<th class="center-align">Talle</th>
									<th class="center-align">Cantidad</th>
									<th>Color/Estampado</th>
									
									<th class="center-align">Subtotal</th>
									<th></th>
								</tr>
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
										$sumas+=$linea->cantidad;
									@endphp

									<td class="center-align">${{$linea->precio*$linea->cantidad}} @if($linea->tiene_promocion == 1) (Precio Promoción)@endif</td>
									<td>
										<a class="modal-trigger" href="#modal" id-linea="{{ $linea->id }}">
											<i class="material-icons red-text">cancel</i>
										</a>
									</td>
								</tr>
								@endforeach
								<tr>
								@if($pedido->es_mayorista)
								<tr>
									<td colspan="4"></td>
									<td class="center-align">Subtotal:</td>
									<td class="center-align">${{ $pedido->subtotal }}</td>
								</tr>
								@endif
									<td colspan="3"></td>
									<td class="center-align">{{ $sumas }} Prendas</td>
									@if($pedido->es_mayorista)
									<td class="center-align"><b>Total (Mayorista):</b></td>
									@else
									<td class="center-align"><b>Total:</b></td>
									@endif
									<td class="center-align"><b>${{ $pedido->monto }}</b></td>
								</tr>
								<tr style="background-color: {{ $colores[$pedido->estado] }}">
									<td colspan="4"></td>
									<td class="center-align">Estado:</td>
									<td>
										<select name="estado" pedido="{{ $pedido->id }}" @if($pedido->estado==3) disabled @endif>
											@foreach($estados as $key => $estado)
											<option value="{{$key}}" @if($key==$pedido->estado) selected @endif>{{$estado}}</option>
											@endforeach
										</select>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="row">
					<div class="col s12">
						<a href="{{ url('admin/clientes/pedidos/agregar/' . $pedido->id) }}">
							<button class="btn teal lighten-2">Agregar Productos</button>
						</a>
						<a href="{{ url('admin/clientes/pedidos') }}">
							<button class="btn right">Volver atras</button>
						</a>
					</div>
				</div>
			</div>
		</main>
		<div id="modal" class="modal">
			<div class="modal-content">
				<form method="POST" action="{{ url('admin/clientes/pedidos/quitar') }}">
					<div class="row">					
						<div id="nombre-producto" class="input-field col s12 m6">
						</div>
						<div class="input-field col s12 m6">
							<input id="cantidad" type="number" name="cantidad" min="0"/>
						</div>
						<div class="input-field col s12">
							<input type="submit" class="btn right" value="Modificar fila">
							<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat right">Cancelar</a>
						</div>
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="hidden" name="linea_id">
					</div>
				</form>
			</div>
		</div>
@endsection
@section('javascript')
		<script type="text/javascript">
			$('select[name=estado]').change(function(event) {
				var id = $(this).attr('pedido');
				var estate = $(this).val();
				var index = $('select[name=estado]').index(this);
				if (estate==3)
				{				
					if(confirm('¿Seguro desea cancelar la operacion? Este es un proceso irreversible'))
					{
						update(id, estate, index);
					}
				}
				else
				{
					update(id, estate, index);
				}
			});

			function update(id, estate, index){
				
				$.ajax({
					url: '{{ url('admin/pedido') }}/'+id,
					type: 'POST',
					data: {
						estado: estate,
						_method: 'PUT',
						_token: '{{ csrf_token() }}'
					},
				})
				.done(function(data) {
					$('table.highlight tbody tr').last().css('background-color', data);
				});
			}

			$('.modal').modal({
				dismissible: true, // Modal can be dismissed by clicking outside of the modal
				opacity: .5, // Opacity of modal background
				inDuration: 300, // Transition in duration
				outDuration: 200, // Transition out duration
				startingTop: '4%', // Starting top style attribute
				endingTop: '10%', // Ending top style attribute
				ready: function(modal, trigger) { // Callback for Modal open. Modal and trigger parameters available.
					
					let id = trigger.attr('id-linea');
					$.ajax({
				        method: "GET",
				        url: '{{ url('admin/clientes/pedidos/linea') }}/' + id
				    })
				    .done(function(data) {
				        let linea = JSON.parse(data);
				        let nombre = linea.imagen.nombre + ' - Talle ' + linea.talle.talle;
				        $('#modal #nombre-producto').html(nombre);
				        $('#modal input[name=linea_id]').val(id);
				        $('#modal #cantidad').attr('max', linea.cantidad);
				        $('#modal #cantidad').val(linea.cantidad);
				    });
				}
			});
		</script>
@endsection