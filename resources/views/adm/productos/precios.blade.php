@extends('layouts.back')

@section('title','Editar precios de productos')
 
@section('main')
		<main>
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
			</div>
			<div class="row">
				<div class="col s12">
					<ul class="tabs">
						@foreach($categorias as $categoria)
						<li class="tab"><a href="#cat-{{ $categoria->id }}">{{ $categoria->nombre }}</a></li>
						@endforeach
					</ul>
					@foreach($categorias as $categoria)
					<div id="cat-{{ $categoria->id }}" class="container">
						<table class="highlight bordered">
							<thead>
								<td>Nombre</td>
								<td>Precio</td>
							</thead>
							<tbody>
								@foreach($categoria->productos as $producto)
								<tr>
									<td>{{ $producto->nombre }}</td>
									<td>
										<input type="number" producto="{{$producto->id}}" name="precio" value="{{$producto->precio}}">
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>            
					</div>
					@endforeach
				</div>
			</div>
		</main>
@endsection

@section('javascript')
		<script type="text/javascript">
			$('input[name=precio]').keyup(function(event) {
				if (event.target.value.length > 2 && !isNaN(event.target.value)) {
					$.ajax({
						url: "{{ url('admin/productos/precios') }}",
						type: "POST",
						data: { 
							producto: event.target.attributes.producto.value, 
							precio: event.target.value, 
							_token: "{{csrf_token()}}" 
						}
					}).done(function (response, textStatus, jqXHR){
						console.log(response);
					}).fail(function (jqXHR, textStatus, errorThrown){
						console.error( "The following error occurred: "+ textStatus, errorThrown );
					});
				}
			});

			$(document).ready(function(){
				$('ul.tabs').tabs();
			});

		</script>
@endsection