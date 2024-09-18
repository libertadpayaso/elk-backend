@extends('layouts.back')

@section('title','Crear usuario')
 
@section('main')
		<main>
			<div class="container">
				<div class="row">
					<div class="col 12 miga">
						<p>
							<a href="{{ url('admin/usuarios/usuario/edit/') }}">Usuarios</a> > Editar Usuario
						</p>
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

						{{Form::model($user, ['route' => ['user.update', $user->id], 'method'=>'PUT', 'files' => true]) }}
							<div class="row">
								<div class="input-field col s6">
									{!!Form::label('Nombre')!!}
									{!!Form::text('nombre',null,['class'=>'validate', 'required'])!!}
								</div>
								<div class="input-field col s6">
									{!!Form::label('Apellido')!!}
									{!!Form::text('apellido',null,['class'=>'validate', 'required'])!!}
								</div>
							</div>
							<div class="row">
								<div class="input-field col s6">
									{!!Form::label('Usuario')!!}
									{!!Form::text('usuario',null,['class'=>'validate', 'required'])!!}
								</div>
								<div class="input-field col s6">
									{!!Form::label('Nueva Contraseña')!!}
									{!!Form::password('newPassword',null,['class'=>'validate', 'required'])!!}
								</div>
							</div>
							<div class="row">
								<div class="input-field col s6">
									{!!Form::select('type',
									[
									    '0' => 'Regular',
									    '1' => 'Administrador',
									]);!!}

								</div>
								<div class="input-field col s6">
									{!!Form::label('Repetir Contraseña')!!}
									{!!Form::password('repetir',null,['class'=>'validate', 'required'])!!}
								</div>
							</div>
							<div class="col s12 no-padding">
								{!!Form::submit('Actualizar', ['class'=>'waves-effect waves-light btn right'])!!}
							</div>
						{{Form::close()}}      
					</div>
				</div>
			</div>
		</main>
@endsection