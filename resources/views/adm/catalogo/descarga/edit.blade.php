@extends('layouts.back')

@section('title','Editar descarga')
 
@section('main')
		<main>
			<div class="container">
				<div class="row">
					<div class="col s12">

						{{Form::model($descarga, ['route' => ['descarga.update', $descarga->id], 'method'=>'PUT', 'files' => true]) }}
							<div class="row">
								<div class="input-field col s12">
									{!!Form::label('Titulo')!!}
									{!!Form::text('titulo',null,['class'=>'validate', 'required'])!!}
								</div>
							</div>
							<div class="row">
								<div class="file-field input-field col s6">
									<div class="btn">
									    <span>Imagen</span>
									    {!! Form::file('imagen') !!}
									</div>
									<div class="file-path-wrapper">
									    {!! Form::text('',null, ['class'=>'file-path validate']) !!}
									</div>
								</div>
								<div class="file-field input-field col s6">
									<div class="btn">
									    <span>Archivo</span>
									    {!! Form::file('archivo') !!}
									</div>
									<div class="file-path-wrapper">
									    {!! Form::text('',null, ['class'=>'file-path validate']) !!}
									</div>
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