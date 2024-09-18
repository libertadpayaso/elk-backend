@extends('layouts.login')

@section('title','Ingreso a la Zona Privada')

@section('main')
		<main>
			<div class="container">
				<div class="row">
					<div class="col s12">
						<img src="{{ asset('assets/img/logos/logos_2_logoN.png') }}">
						{!!Form::open(['route'=>'usuarios.ingresar', 'method'=>'POST'])!!}
							<div class="row">
								<div class="input-field col s12">
									{!!Form::label('Usuario')!!}
									{!!Form::text('usuario',null,['class'=>'validate', 'required'])!!}
								</div>
								<div class="input-field col s12">
									{!!Form::label('Contraseña')!!}
									{!!Form::password('password',null,['class'=>'validate', 'required'])!!}
								</div>
								<div class="col s12">
									{!!Form::submit('Ingresar', ['class'=>'waves-effect waves-light btn right'])!!}
								</div>
								@if(isset($error))
								<div class="col s12 card-panel red lighten-4 red-text text-darken-4">
									{{ $error }}
								</div>
								@endif
							</div>
						{!!Form::close()!!}
					</div>
				</div>
			</div>
		</main>
@endsection