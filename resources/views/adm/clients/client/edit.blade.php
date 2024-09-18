@extends('layouts.back')

@section('title','Crear cliente')
 
@section('main')
		<main>
			<div class="container">
				<div class="row">
					<div class="col 12 miga">
						<p>
							<a href="{{ url('admin/clientes/cliente/edit/') }}">Clientes</a> > Editar Cliente
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

						{{Form::model($client, ['route' => ['client.update', $client->id], 'method'=>'PUT', 'files' => true]) }}
							<div class="row">
								<div class="input-field col s6">
									{!!Form::label('Usuario')!!}
									{!!Form::text('usuario',null,['class'=>'validate', 'required'])!!}
								</div>
								<div class="input-field col s6">
									{!!Form::label('Nueva Contraseña')!!}
									{!!Form::text('newPassword',null,['class'=>'validate'])!!}
								</div>
							</div>
							<div class="row">
								<div class="input-field col s6">
									{!!Form::label('Nombre')!!}
									{!!Form::text('nombre',null,['class'=>'validate', 'required'])!!}
								</div>
								<div class="input-field col s12 m6">
									{!!Form::label('Repetir Contraseña')!!}
									{!!Form::text('repetir',null,['class'=>'validate'])!!}
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
									], $client->habilitado);!!}
								</div>
							</div>
							<div class="row">
								<div class="input-field col s6">
									{!!Form::select('tipo',
									[
									    '1' => 'Mayorista',
									    '2' => 'Punto de venta',
									], $client->tipo);!!}
								</div>
							</div>

							<div class="row">
								<div class="input-field col s6">
									{!!Form::select('formadepago',
									[
									    'Efectivo' => 'Efectivo',
									    'Transferencia' => 'Transferencia',
									    'Transferencia' => 'Transferencia',
									    'Deposito' => 'Deposito',
									    'Debito' => 'Debito',
									    'Credito' => 'Credito',
									    'Transferencia' => 'Transferencia',
									], $client->formadepago);!!}
								</div>
							</div>

							<div class="row">
								<div class="input-field col s6">
									{!!Form::select('formadeenvio',
									[
									    'Moto' => 'Moto',
									    'Viacargo' => 'Viacargo',
									    'TransportesAnk' => 'TransportesAnk',
									    'CruceroExpress' => 'CruceroExpress',
									    'BusPack' => 'BusPack',
									    'Ctc' => 'Ctc',
									    'EcaPack' => 'EcaPack',
									    'NuevoExpreso' => 'NuevoExpreso',
									    'ExpresoDemonte' => 'ExpresoDemonte',
									    'ElRapido' => 'ElRapido',
									    'ElVasquito' => 'ElVasquito',
									    'Tascar' => 'Tascar',
									    'CorreoArgentino' => 'CorreoArgentino',
									    'Andreani' => 'Andreani',
									    'Oca' => 'Oca',
									    'sevillanita' => 'sevillanita',
									    'lavelozdelnorte' => 'lavelozdelnorte',
									    'Otro' => 'Otro',
									    'expresocarena' => 'expresocarena',
									    'ellider' => 'ellider',
									    'balmar' => 'balmar',
									    'Aravera' => 'Aravera',
									    'Elrayo' => 'Elrayo',
									    'Mdcargas' => 'Mdcargas',
									    'Lancioni' => 'Lancioni',
									    'Bisonte' => 'Bisonte',
									    'Premat' => 'Premat',
									    'Cruzdelsur' => 'Cruzdelsur',
									    'Brinatti' => 'Brinatti',
									    'TransporteAguilar' => 'TransporteAguilar',
									    'CamioneraMendocina' => 'CamioneraMendocina',
									    'DistriAtlnta' => 'DistriAtlanta',
									    'TransporteCentauro' => 'TransporteCentauro',
									    'expresoBollati' => 'expresoBollati',
									    'OroNegro' => 'OroNegro',
									    'expresocarena' => 'expresocarena',
									    'TransporteSnaider' => 'TransporteSnaider',
									
									], $client->formadeenvio);!!}
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