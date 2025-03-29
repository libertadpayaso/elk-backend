@extends('layouts.back')

@section('title','Agregar imagen')
 
@section('main')
		<main>
			<div class="container">
				<div class="row">
					<div class="col 12 miga">
						<p>
							<a href="{{ url('admin/productos/producto/edit/'.$producto->categoria->sexo->id) }}">Productos</a> >
							<a href="{{ url('admin/productos/imagen/edit/'.$producto->categoria->sexo->id.'/'.$producto->id) }}">{{$producto->nombre}}</a> > Crear Imagen
						</p>
					</div>
				</div>
				<div class="row">
					<div class="col s12">

						{!!Form::open(['route'=>'imagen.store', 'method'=>'POST', 'files' => true])!!}
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
									    {!! Form::file('imagen', ['required'=>'required']) !!}
									</div>
									<div class="file-path-wrapper">
									    {!! Form::text('',null, ['class'=>'file-path validate']) !!}
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col s12">
									{!!Form::submit('Crear', ['class'=>'waves-effect waves-light btn right'])!!}
								</div>
							</div>
							{!!Form::hidden('producto_id',$producto->id)!!}
						{!!Form::close()!!}         
					</div>
				</div>
			</div>
		</main>
@endsection