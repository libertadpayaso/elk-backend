@php
	$csrf_token = csrf_token();
	$parameters = [];
    $parameters['page'] = (isset($_GET['page'])) ? $_GET['page'] : 1 ;
@endphp
@extends('layouts.back')
@section('title','Pedidos')

@section('main')
		<main>
			<div class="container-fluid">
				<div class="row">
					<div class="col s12 miga">
						<p>Pedidos</p>
					</div>
					@if(count($errors) > 0)
					<div class="col s12 card-panel red lighten-4 red-text text-darken-4">
						<ul>
							@foreach($errors->all() as $error)
								<li>{!!$error!!}</li>
							@endforeach
						</ul>
					</div>
					@endif
					@if(session('success'))
					<div class="col s12 card-panel green lighten-4 green-text text-darken-4">
						{{ session('success') }}
					</div>
					@endif
				</div>
				<div class="row">
					<div class="col s12">
						<ul class="pagination center">
							<li class="@if($parameters['page'] == 1) disabled @else waves-effect @endif">
								<a href="{{ url('admin/clientes/pedidos') . updateURL($parameters, ['page' => 1]) }}">
									<i class="material-icons">chevron_left</i>
								</a>
							</li>
							@for ($i = 1; $i <= $paginas; $i++)
							<li class="@if($parameters['page'] == $i) active @else waves-effect @endif">
								<a href="{{ url('admin/clientes/pedidos') . updateURL($parameters, ['page' => $i]) }}">{{ $i }}</a>
							</li>
							@endfor
							<li class="@if($parameters['page'] == $paginas) disabled @else waves-effect @endif">
								<a href="{{ url('admin/clientes/pedidos') . updateURL($parameters, ['page' => $paginas]) }}">
									<i class="material-icons">chevron_right</i>
								</a>
							</li>
						</ul>
					</div>
				</div>
				<div class="row">
					<div class="col s6 input-field">
						<label for="name">Filtrar por Nombre</label>
						<input type="text" name="filter">
					</div>
					<form method="POST" action="{{ url('admin/clientes/pedidos/descargarPorEstado') }}">
						<div class="col s4 input-field">
							<select name="estado">
								@foreach($estados as $key => $value)
								<option value="{{ $key }}">{{ $value }}</option>
								@endforeach
							</select>
						</div>
						<div class="col s2 input-field">
							<button class="btn">DESCARGAR</button>
						</div>
						<input type="hidden" name="_token" value="{{ $csrf_token }}" />
					</form>
				</div>
				<!-- <button type="button" onclick="javascript:imprim2();">Imprimir</button> -->
				<div class="row" >
					<div class="col s12">
						<table class="highlight bordered responsive-table" >
							<thead >
								<td >Fecha</td>
								<td >Cliente</td>
								<td >Celular</td>
								<td >Provincia</td>
								<td >Localidad</td>
								<td >Dirección</td>
								<td >Dni</td>
								<td >Forma de pago</td>
								<td >Forma de envío</td>
								<td >Estado</td>
								<td >Ver</td>
							</thead>
							<tbody>
								@foreach($pedidos as $pedido)
								<tr style="background-color: {{ $colores[$pedido->estado] }}">
									<td >
										{{ $pedido->created_at }}
									</td>
									<td >
										{{ $pedido->client->nombre }}
									</td>
									<td>
										{{ $pedido->client->celular }}
									</td>
									<td >
										{{ $pedido->client->provincia }}
									</td>
									<td >
										{{ $pedido->client->localidad }}
									</td>
									<td >
										{{ $pedido->client->direccion }}
									</td>
									<td >
										{{ $pedido->client->cuit }}
									</td>
									<td >
										{{ $pedido->client->formadepago }}
									</td>
									<td >
										{{ $pedido->client->formadeenvio }}
									</td>
									<td >
										<select name="estado" pedido="{{ $pedido->id }}" @if($pedido->estado==3) disabled @endif>
											@foreach($estados as $key => $estado)
											<option value="{{$key}}" @if($key==$pedido->estado) selected @endif>{{$estado}}</option>
											@endforeach
										</select>
									</td>
									<td >
										<a href="{{ url('admin/clientes/pedidos/ver/'.$pedido->id) }}"><i class="material-icons">remove_red_eye</i></a>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>            
					</div>
				</div>
				<div class="row">
					<div class="col s12">
						<ul class="pagination center">
							<li class="@if($parameters['page'] == 1) disabled @else waves-effect @endif">
								<a href="{{ url('admin/clientes/pedidos') . updateURL($parameters, ['page' => 1]) }}">
									<i class="material-icons">chevron_left</i>
								</a>
							</li>
							@for ($i = 1; $i <= $paginas; $i++)
							<li class="@if($parameters['page'] == $i) active @else waves-effect @endif">
								<a href="{{ url('admin/clientes/pedidos') . updateURL($parameters, ['page' => $i]) }}">{{ $i }}</a>
							</li>
							@endfor
							<li class="@if($parameters['page'] == $paginas) disabled @else waves-effect @endif">
								<a href="{{ url('admin/clientes/pedidos') . updateURL($parameters, ['page' => $paginas]) }}">
									<i class="material-icons">chevron_right</i>
								</a>
							</li>
						</ul>
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
						_token: '{{ $csrf_token }}'
					},
				})
				.done(function(data) {
					$('table.responsive-table tbody tr').eq(index).css('background-color', data);
				});
			}
			$('input[name=filter]').keyup(function(event) {
				var filter = $(this).val().toLowerCase();
				// Loop through all table rows, and hide those who don't match the search query
				$('tbody tr').each(function(index, el) {
					if (el.children['1'].innerText.toLowerCase().indexOf(filter) > -1) {
						$(this).css('display', '');
					} else {

						$(this).css('display', 'none');
					}
				});
				celdas = $('table tbody tr:visible').length;
				if (celdas == 0) {
					$('tfoot').css('display', '');
				} else {
					$('tfoot').css('display', 'none');
				}
			});
		</script>
@endsection