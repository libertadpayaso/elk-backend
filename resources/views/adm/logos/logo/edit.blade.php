@extends('layouts.back')

@section('title','Editar logo')
 
@section('main')
		<main>
			<div class="container">
				<div class="row">
					<div class="col s12">

						{{Form::model($logo, ['route' => ['logo.update', $logo->id], 'method'=>'PUT', 'files' => true]) }}
							<div class="row">
								<div class="file-field input-field col s12">
									<div class="btn">
									    <span>Imagen</span>
									    {!! Form::file('imagen') !!}
									</div>
									<div class="file-path-wrapper">
									    {!! Form::text('',null, ['class'=>'file-path validate']) !!}
									</div>
								</div>
							</div>
							<div class="col s12 no-padding">
								{!!Form::hidden('seccion',null,['class'=>'validate', 'required'])!!}
								{!!Form::submit('Actualizar', ['class'=>'waves-effect waves-light btn right'])!!}
							</div>
						{{Form::close()}}      
					</div>
				</div>
			</div>
		</main>
@endsection