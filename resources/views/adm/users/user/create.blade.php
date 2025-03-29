@extends('layouts.back')

@section('title','Crear usuario')
 
@section('main')
		<main>
			<div class="container">
				<div class="row">
					<div class="col 12 miga">
						<p>
							<a href="{{ url('admin/usuarios/usuario/edit/') }}">Usuarios</a> > Crear Usuario
						</p>
					</div>
				</div>
				<div class="row">
					<div class="col s12">

						{!!Form::open(['route'=>'user.store', 'method'=>'POST'])!!}
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
									{!!Form::label('Contraseña')!!}
									{!!Form::password('password',null,['class'=>'validate', 'required'])!!}
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
								{!!Form::submit('Crear', ['class'=>'waves-effect waves-light btn right'])!!}
							</div>
						{!!Form::close()!!}           
					</div>
				</div>
			</div>
		</main>
@endsection