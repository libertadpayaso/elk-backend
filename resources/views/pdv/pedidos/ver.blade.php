@php
	$subtotal = 0;
	$sumas = 0;
@endphp
@extends('layouts.pdv')

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
						<a class="btn right" href="{{ url('admin/pdv/pedidos/descargar/'.$pedido->id) }}">Descargar</a>
					</div>
				</div>
				<div class="row">
					<div class="col s12">
						<table class="highlight bordered">
							<thead>
								<tr>
									<th>Imagen</th>
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
									<td><img class="responsive-img materialboxed" src="{{ asset('assets/img/imagenes/'.$linea->getImagen()) }}"></td>
									<td>{{$linea->imagen->producto->nombre}}</td>
									<td class="center-align">{{$linea->talle->talle}}</td>
									<td class="center-align">{{$linea->cantidad}}</td>
									<td>{{$linea->imagen->nombre}}</td>
									
									@php
										$precio = $linea->imagen->producto->precio;
										$subtotal += $precio * $linea->cantidad;
										$sumas    += $linea->cantidad;
									@endphp

									<td class="center-align">${{$precio*$linea->cantidad}}</td>
								</tr>
								@endforeach

								@if($pedido->es_mayorista == 1)
								<tr>
									<td colspan="4"></td>
									<td class="center-align">Subtotal:</td>
									<td class="center-align"><del>${{ $pedido->subtotal }}</del></td>
								</tr>
								<tr>
									<td colspan="4"></td>
									<td class="center-align">Descuento:</td>
									<td class="center-align">${{ $pedido->subtotal - $pedido->monto }}</td>
								</tr>
								@endif

								<tr>
									<td colspan="3"></td>
									<td class="center-align">{{ $sumas }} Prendas</td>
									<td class="center-align">Total:</td>
									<td class="center-align">${{ $pedido->monto }}</td>
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
					<div class="col s12 m6 offset-m3">
						<input type="hidden" name="id" value="{{ $pedido->id }}">
						<div class="row">
							<div class="col s12">
								<h5>Enviar comprobante por E-mail</h5>
							</div>
							<div class="input-field col s12">
								<input placeholder="Nombre" type="text" name="nombre">
							</div>
							<div class="input-field col s12">
								<input placeholder="Email" type="text" name="email">
							</div>
							<div class="input-field col s12 center">
								<button class="btn waves-effect waves-light btn-large" type="submit">Enviar
									<i class="material-icons right">send</i>
								</button>
							</div>
						</div>	
					</div>
				</div>
				<div class="row">
					<div class="col s12">
						<a href="{{ url('admin/pdv/pedidos') }}">
							<button class="btn right">Volver atras</button>
						</a>
					</div>
				</div>
			</div>
		</main>
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

			$('button[type=submit]').click(function(event) {
				
				var mail = $('input[name=email]').val();
				var nombre = $('input[name=nombre]').val();

				if(mail!='' && nombre!=''){

					var id = $('input[name=id]').val();
					
					$.ajax({
						url: "{{ url('admin/pdv/pedidos/mail') }}",
						type: "POST",
						data: { id: id, 
							email: mail,
							nombre: nombre, 
							_token: "{{csrf_token()}}" }
					}).done(function (response, textStatus, jqXHR){
						
						$('input[name=email]').val('');
						$('input[name=nombre]').val('');
						alert(response);
					
					}).fail(function (jqXHR, textStatus, errorThrown){
						console.error( "Error: "+ textStatus, errorThrown );
					});
				}else{
					alert('Complete los campos Nombre y E-mail');
				}
			});
		</script>
@endsection