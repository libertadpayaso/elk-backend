@php
	$parameters = [];
    $parameters['page'] = (isset($_GET['page'])) ? $_GET['page'] : 1 ;
@endphp
@extends('layouts.back')

@section('title','Editar clientes')
 
@section('main')
		<main>
			<div class="container">
				<div class="row">
					<div class="col s12 miga">
						<p>Clientes</p>
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
								<a href="{{ url('admin/clientes/cliente/edit') . updateURL($parameters, ['page' => 1]) }}">
									<i class="material-icons">chevron_left</i>
								</a>
							</li>
							@for ($i = 1; $i <= $paginas; $i++)
							<li class="@if($parameters['page'] == $i) active @else waves-effect @endif">
								<a href="{{ url('admin/clientes/cliente/edit') . updateURL($parameters, ['page' => $i]) }}">{{ $i }}</a>
							</li>
							@endfor
							<li class="@if($parameters['page'] == $paginas) disabled @else waves-effect @endif">
								<a href="{{ url('admin/clientes/cliente/edit') . updateURL($parameters, ['page' => $paginas]) }}">
									<i class="material-icons">chevron_right</i>
								</a>
							</li>
						</ul>
					</div>
				</div>
				<div class="row">
					<div class="col s12">
						<a href="{{ url('admin/clientes/cliente/create/') }}">
							<button class="btn">Agregar Cliente</button>
						</a>
					</div>
				</div>

				<div class="row">
					<div class="col s6 input-field">
						<label for="name">Filtrar por Nombre</label>
						<input type="text" name="filter">
					</div>
				</div>

				<div class="row">
					<div class="col s12">
						<table class="highlight bordered">
							<thead>
								<td>Nombre</td>
								<td>Pedidos</td>
								<td>Fecha de Alta</td>
								<td class="text-right">Editar/Borrar</td>
							</thead>
							<tbody>
								@foreach($clients as $client)
								<tr>
									<td> {{ $client->nombre }} </td>
									<td> {{ $client->pedidos()->count() }} </td>
									<td> {{ $client->created_at }} </td>
									<td class="text-right">
										<a href="{{ url('admin/clientes/cliente/edit/'.$client->id) }}" title="Editar"><i class="material-icons">create</i></a>
										{!!Form::open(['class'=>'en-linea', 'route'=>['client.destroy', $client->id], 'method' => 'DELETE'])!!}
											<button type="submit" class="submit-button" title="Eliminar">
												<i class="material-icons red-text">cancel</i>
											</button>
										{!!Form::close()!!}
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
								<a href="{{ url('admin/clientes/cliente/edit') . updateURL($parameters, ['page' => 1]) }}">
									<i class="material-icons">chevron_left</i>
								</a>
							</li>
							@for ($i = 1; $i <= $paginas; $i++)
							<li class="@if($parameters['page'] == $i) active @else waves-effect @endif">
								<a href="{{ url('admin/clientes/cliente/edit') . updateURL($parameters, ['page' => $i]) }}">{{ $i }}</a>
							</li>
							@endfor
							<li class="@if($parameters['page'] == $paginas) disabled @else waves-effect @endif">
								<a href="{{ url('admin/clientes/cliente/edit') . updateURL($parameters, ['page' => $paginas]) }}">
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
			$('input[name=filter]').keyup(function(event) {

				var filter = $(this).val().toLowerCase();

				// Loop through all table rows, and hide those who don't match the search query
				$('tbody tr').each(function(index, el) {

					if (el.children['0'].innerText.toLowerCase().indexOf(filter) > -1) {

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