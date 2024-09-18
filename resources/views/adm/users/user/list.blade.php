@extends('layouts.back')

@section('title','Editar users')
 
@section('main')
		<main>
			<div class="container">
				<div class="row">
					<div class="col s12 miga">
						<p>Usuarios</p>
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
						<a href="{{ url('admin/usuarios/usuario/create/') }}">
							<button class="btn">Agregar Usuario</button>
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
								<td class="text-right">Acciones</td>
							</thead>
							<tbody>
								@foreach($users as $user)
								<tr>
									<td>
										{{ $user->nombre.' '.$user->nombre }}
									</td>
									<td class="text-right">
										<a href="{{ url('admin/usuarios/usuario/edit/'.$user->id) }}"><i class="material-icons">create</i></a>
										{!!Form::open(['class'=>'en-linea', 'route'=>['user.destroy', $user->id], 'method' => 'DELETE'])!!}
											<button type="submit" class="submit-button">
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
			</div>
		</main>
@endsection

@section('javascript')
		<script>
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