@extends('layouts.back')

@section('title','Editar productos de Promocion')
 
@section('main')
		<main>
			<div class="container">
				<div class="row">
					<div class="col 12 miga">
						<p>
							<a href="{{ url('admin/promocion/list') }}">Promociones</a> > Editar "{{$promocion->nombre}}"
						</p>
					</div>
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

				<div class="row">
					<div class="col s12">
						{{Form::open(['url' => 'admin/promocion/productos', 'method'=>'POST']) }}
							<div class="row">
								<div class="col s12 m6">
									<h4>Productos</h4>
								</div>
								<div class="col s12 m6 input-field">
									<label for="name">Filtrar por Nombre</label>
									<input type="text" name="filter">
								</div>
								@foreach($productos as $producto)
								<div class="col s4 m2 producto">
									<p>
										<input type="checkbox" id="id{{$loop->index}}" value="{{$producto->id}}" name="producto[]" @if($promocion->productos()->find($producto->id)!=null) checked @endif>
										<label for="id{{$loop->index}}"> {{$producto->nombre}}</label>
									</p>
								</div>
								@endforeach
								<div class="col s4 m6" id="aviso" style="display: none;">
									<p>Ningun Producto coincide con el término buscado</p>
								</div>
								{!!Form::hidden('promocion_id',$promocion->id)!!}
							</div>						
							<div class="row">
								<div class="col s12">
									{!!Form::submit('Guardar productos', ['class'=>'waves-effect waves-light btn right'])!!}
								</div>
							</div>
						{{Form::close()}}      
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
				$('.producto').each(function(index, el) {

					if (el.children[0].children[1].innerText.toLowerCase().indexOf(filter) > -1) {

						$(this).css('display', '');
					} else {
						
						$(this).css('display', 'none');
					}
				});

				celdas = $('.producto:visible').length;
				if (celdas == 0) {
					$('#aviso').css('display', '');
				} else {
					$('#aviso').css('display', 'none');
				}
			});
		</script>
@endsection