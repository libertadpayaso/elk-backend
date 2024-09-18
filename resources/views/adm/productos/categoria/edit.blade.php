@extends('layouts.back')

@section('title','Editar categoria')
 
@section('main')
		<main>
			<div class="container">
				<div class="row">
					<div class="col 12 miga">
						<p>
							<a href="{{ url('admin/productos/categoria/edit/'.$sexo) }}">Categorias</a> > Editar "{{$categoria->nombre}}"
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

						{{Form::model($categoria, ['route' => ['categoria.update', $categoria->id], 'method'=>'PUT', 'files' => true]) }}
							<div class="row">
								<div class="input-field col s12 m6">
									{!!Form::label('Nombre')!!}
									{!!Form::text('nombre',null,['class'=>'validate', 'required'])!!}
								</div>
								<div class="file-field input-field col s12 m6">
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
								<div class="col s12 m6">
									<label>Activado</label>
									<p>
										<div class="switch">
											<label>
												No
												<input type="checkbox" value="1" name="activado" @if($categoria->activado==1) checked @endif>
												<span class="lever"></span>
												Si
											</label>
										</div>
									</p>
								</div>
								<div class="col s12 m6">
									<label>Catálogo</label>
									<p>
										<div class="switch">
											<label>
												No
												<input type="checkbox" value="1" name="catalogo" @if($categoria->catalogo==1) checked @endif>
												<span class="lever"></span>
												Si
											</label>
										</div>
									</p>
								</div>
							</div>
							{!! Form::hidden('sexo', $sexo) !!}
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