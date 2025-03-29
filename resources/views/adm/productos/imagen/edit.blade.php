@extends('layouts.back')

@section('title','Editar imagen')
 
@section('main')
		<main>
			<div class="container">
				<div class="row">
					<div class="col 12 miga">
						<p>
							<a href="{{ url('admin/productos/producto/edit/'.$imagen->producto->categoria->sexo_id) }}">Productos</a> >
							<a href="{{ url('admin/productos/imagen/edit/'.$imagen->producto->categoria->sexo_id.'/'.$imagen->producto->id) }}">{{$imagen->producto->nombre}}</a> > Editar "{{$imagen->nombre }}"
						</p>
					</div>
				</div>
				<div class="row">
					<div class="col s12">

						{{Form::model($imagen, ['route' => ['imagen.update', $imagen->id], 'method'=>'PUT', 'files' => true]) }}
							<div class="row">
								<div class="input-field col s6">
									{!!Form::label('Nombre')!!}
									{!!Form::text('nombre',null,['class'=>'validate', 'required'])!!}
								</div>
								<div class="input-field col s6">
									{!!Form::label('Codigo')!!}
									{!!Form::text('codigo',null,['class'=>'validate'])!!}
								</div>
							</div>
							<div class="row">
								<div class="input-field file-field col s12">
									<div class="btn">
									    <span>Imagen</span>
									    {!! Form::file('imagen') !!}
									</div>
									<div class="file-path-wrapper">
									    {!! Form::text('',null, ['class'=>'file-path validate']) !!}
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="col s12">
									{!!Form::submit('Editar', ['class'=>'waves-effect waves-light btn right'])!!}
								</div>
							</div>
						{{Form::close()}}      
					</div>
				</div>
			</div>
		</main>
@endsection