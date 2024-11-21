@extends('layouts.pdv')

@if($stockSeleccionado)
	@section('title','Actualizar Stock Articulo ' . $stockSeleccionado->imagen->producto->nombre)
@else
	@section('title','Stock Productos PDV')
@endif
@section('main')
		<main>
			<div class="container">
				<div class="row">
					<div class="col s12 m6 miga">
						<p>Productos {{ $sexo->nombre }} @if($stockSeleccionado)> Actualizar Stock @endif</p>
					</div>
				</div>
				@if($stockSeleccionado)
				<div class="row">
					<form action="{{ url('pdv/stock/editar') }}"  method="POST" id="formulario-stock">
						<div class="input-field col s12">
							<h5>Actualizar Stock <b>{{$stockSeleccionado->imagen->producto->nombre}}</b></h5>
						</div>
						<div class="input-field col s12 m6">
							<label for="cantidad">Cantidad</label>
							<input type="text" name="cantidad" id="cantidad" value="{{ $stockSeleccionado->stock }}">
						</div>
						<div class="input-field col s12 m6">
							<input type="submit" value="Actualizar" class="waves-effect waves-light btn">
						</div>
						{!! Form::token() !!}
						<input type="hidden" name="stock_id" value="{{$stockSeleccionado->id}}">

						@if(session('success'))
						<div class="col s10 offset-s1 card-panel green lighten-4 green-text text-darken-4 center-align">
							{{ session('success') }}
						</div>
						@endif
					</form>
				</div>
				@endif
				<div class="row">
					<div class="input-field col s12">
						<h5>Filtrar Productos @if($categoria) (Categoria {{ $categoria->nombre }}) @endif</h5>
					</div>
					<div class="input-field col s12 m6">
						<label for="filter">Filtrar por Nombre</label>
						<input type="text" name="filter" id="filter">
					</div>
					<div class="input-field col s12 m6">
						<form action="{{ url('pdv/stock/' . $sexo->id) }}" method="GET" id="formulario">	
							<select name="categoria_id" id="categoria_id">
								<option value="" @if(!$categoria) selected @endif>Todas las Categorias</option>
								@foreach($listaCategorias as $item)
								<option value="{{ $item->id }}" @if($categoria && $item->id == $categoria->id) selected @endif>{{ $item->nombre }}</option>
								@endforeach
							</select>
						</form>
					</div>
				</div>
				<div class="row">
					<div class="col s12">
						<table class="highlight bordered">
							<thead>
								<td>Nombre</td>
								<td>Stock</td>
								<td class="text-right">Acciones</td>
							</thead>
							<tbody>
								@foreach($stocks as $item)
								<tr>
									<td>{{ $item->imagen->producto->nombre }}</td>
									<td>{{ $item->stock }}</td>
									<td><a href="{{ url('pdv/stock/' . $sexo->id . '/'.$item->id) }}" title="Stock disponible"><i class="material-icons">add_box</i></a></td>
								</tr>
								@endforeach
							</tbody>
						</table>            
					</div>
				</div>
			</div>
		</main>
@endsection

@section('javascript')
		<script type="text/javascript">
			$(document).ready(function(){
				$('#categoria_id').change(function(event) {
					$('#formulario').submit();
				});

				$('input[name=filter]').keyup(function(event) {

					var filter = $(this).val().toLowerCase();

					// Loop through all table rows, and hide those who don't match the search query
					$('tbody tr').each(function(index, el) {
						var td = $(this).find('td:first');
						console.log(td)
						if (td) {
							if (td.html().toLowerCase().indexOf(filter) > -1) {
								$(this).css('display', '');
							} else {
								$(this).css('display', 'none');
							}
						}
					});

					celdas = $('table tbody tr:visible').length;
					if (celdas == 0) {
						$('tfoot').css('display', '');
					} else {
						$('tfoot').css('display', 'none');
					}
				});
			});
		</script>
@endsection