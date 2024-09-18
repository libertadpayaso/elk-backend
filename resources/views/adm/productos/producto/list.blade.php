@extends('layouts.back')

@section('title','Editar productos')
 
@section('main')
		<main>
			<div class="container">
				<div class="row">
					<div class="col s12 miga">
						<p>Productos</p>
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
					<div class="input-field col s12 m6 offset-m3">
						<form action="{{ url('admin/filtrar-categoria') }}" method="POST" id="formulario">	
							{!! Form::token() !!}
							<select name="categoria">
								<option value="" @if(null==$categoria) selected @endif>Todas las Categorias</option>
								@foreach($categorias as $item)
								<option value="{{ $item->id }}" @if($item->id==$categoria) selected @endif>{{ $item->nombre }}</option>
								@endforeach
							</select>
							<input type="hidden" name="sexo" value="{{$sexo}}">
						</form>
					</div>
				</div>
				<div class="row">
					<div class="col s6">
						<a href="{{ url('admin/productos/producto/create/'.$sexo) }}">
							<button class="btn">Agregar Producto</button>
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
								<td>Variantes</td>
								<td class="text-right">Acciones</td>
							</thead>
							<tbody>
								@foreach($productos as $producto)
								<tr>
									<td>{{ $producto->nombre }}</td>
									<td><a href="{{ url('admin/productos/imagen/edit/'.$sexo.'/'.$producto->id) }}" title="Galeria de Imagenes"><i class="material-icons">photo</i></a></td>
									<td class="text-right">
										<a href="{{ url('admin/productos/producto/edit/'.$sexo.'/'.$producto->id) }}" title="Editar"><i class="material-icons">create</i></a>
										{!!Form::open(['class'=>'en-linea', 'route'=>['producto.destroy', $producto->id], 'method' => 'DELETE'])!!}
											<button title="Eliminar" type="submit" class="submit-button">
												<i class="material-icons red-text">cancel</i>
											</button>
										{!!Form::close()!!}
										<a href="{{ url('admin/productos/producto/vaciar-stock/' . $producto->id) }}" title="Vaciar stock" class="vaciar-stock">
											<i class="material-icons red-text">clear_all</i>
										</a>
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

@section('javascript')
		<script type="text/javascript">
			$('select[name=categoria]').change(function(event) {
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

			$('.en-linea').click(function(event){
				if (!window.confirm("¿Realmente desea eliminar el producto con todas sus variantes?")) {
				  	event.preventDefault();
				}
			});

			$('.vaciar-stock').click(function(event){
				if (!window.confirm("¿Realmente desea vaciar el stock del producto?")) {
				  	event.preventDefault();
				}
			});
		</script>
@endsection