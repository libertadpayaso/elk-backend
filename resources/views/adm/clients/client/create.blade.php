@extends('layouts.back')

@section('title','Crear cliente')
 
@section('main')
		<main>
			<div class="container">
				<div class="row">
					<div class="col 12 miga">
						<p>
							<a href="{{ url('admin/clientes/cliente/edit/') }}">Clientes</a> > Crear Cliente
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

						{!!Form::open(['route'=>'client.store', 'method'=>'POST'])!!}
							<div class="row">
								<div class="input-field col s6">
									{!!Form::label('Usuario')!!}
									{!!Form::text('Usuario',null,['class'=>'validate', 'required'])!!}
								</div>
								<div class="input-field col s6">
									{!!Form::label('Contraseña')!!}
									{!!Form::text('password',null,['class'=>'validate', 'required'])!!}
								</div>
							</div>
							<div class="row">
								<div class="input-field col s6">
									{!!Form::label('Nombre')!!}
									{!!Form::text('nombre',null,['class'=>'validate', 'required'])!!}
								</div>
								<div class="input-field col s12 m6">
									{!!Form::label('Repetir Contraseña')!!}
									{!!Form::text('repetir',null,['class'=>'validate', 'required'])!!}
								</div>
							</div>
							<div class="row">
								<div class="input-field col s6">
									{!!Form::label('Direccion')!!}
									{!!Form::text('direccion',null,['class'=>'validate', 'required'])!!}
								</div>
								<div class="input-field col s6">
									{!!Form::label('Localidad')!!}
									{!!Form::text('localidad',null,['class'=>'validate', 'required'])!!}
								</div>
							</div>
							<div class="row">
								<div class="input-field col s6">
									{!!Form::label('Provincia')!!}
									{!!Form::text('provincia',null,['class'=>'validate', 'required'])!!}
								</div>
								<div class="input-field col s6">
									{!!Form::label('Celular/Whatsapp')!!}
									{!!Form::text('celular',null,['class'=>'validate', 'required'])!!}
								</div>
							</div>
							<div class="row">
								<div class="input-field col s6">
									{!!Form::label('CUIT/CUIL/DNI')!!}
									{!!Form::text('cuit',null,['class'=>'validate', 'required'])!!}
								</div>
								<div class="input-field col s6">
									{!!Form::select('habilitado',
									[
									    '0' => 'Deshabilitado',
									    '1' => 'Habilitado',
									]);!!}
								</div>
							</div>
							<div class="row">
								<div class="input-field col s6">
									{!!Form::select('tipo',
									[
									    '1' => 'Mayorista',
									    '2' => 'Punto de venta',
									], null);!!}
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