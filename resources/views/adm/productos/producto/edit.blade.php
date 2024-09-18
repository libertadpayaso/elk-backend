@extends('layouts.back')

@section('title','Editar producto')
 
@section('main')
		<main>
			<div class="container">
				<div class="row">
					<div class="col 12 miga">
						<p>
							<a href="{{ url('admin/productos/producto/edit/'.$sexo) }}">Productos</a> > Editar "{{$producto->nombre}}"
						</p>
					</div>
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

				<div class="row">
					<div class="col s12">

						{{Form::model($producto, ['route' => ['producto.update', $producto->id], 'method'=>'PUT', 'files' => true]) }}
							<div class="row">
								<div class="input-field col s12 m6">
									{!!Form::label('Nombre')!!}
									{!!Form::text('nombre',null,['class'=>'validate', 'required'])!!}
								</div>
								<div class="input-field col s12 m6">
									{!!Form::select('categoria_id', $categorias, $producto->categoria_id)!!}
								</div>
							</div>
							<div class="row">
						        <div class="input-field col s12">
						        	<label for="descripcion">Descripción</label>
									{!!Form::textarea('descripcion', null,['class'=>'validate materialize-textarea'])!!}
						        </div>
							</div>
							<div class="row">
								<div class="input-field col s12 m6">
									{!!Form::label('Precio')!!}
									{!!Form::text('precio',null,['class'=>'validate', 'required'])!!}
								</div>
								<div class="input-field col s12 m6">
									{!!Form::select('descuento', $descuentos, $producto->descuento, ['placeholder' => 'Seleccionar descuento'])!!}
								</div>
							</div>
							<div class="row">
								<div class="input-field col s12 m6">
									{!!Form::label('Código PDV')!!}
									{!!Form::text('pdv',null,['class'=>'validate', 'required'])!!}
								</div>
								<div class="input-field col s12 m6">
									{!!Form::select('estilo_id', $estilos, $producto->estilo_id)!!}
								</div>
							</div>
							<div class="row">
								<div class="input-field col s12 m6">
									{!!Form::label('Mensaje personalizado')!!}
									{!!Form::text('mensaje_personalizado')!!}
								</div>
							</div>
							<div class="row">
								<div class="col s12">
									<p>Talles</p>
								</div>
								@foreach($talles as $talle)
								<div class="col s4 m2">
									<p>
										<input type="checkbox" id="id{{$loop->index}}" value="{{$talle->id}}" name="talle[]" @if($producto->talles()->find($talle->id)!=null) checked @endif>
										<label for="id{{$loop->index}}">Talle {{$talle->talle}}</label>
									</p>
								</div>
								@endforeach
							</div>
							<div class="row">
								<div class="col s12 m6">
									<label>Activado</label>
									<p>
										<div class="switch">
											<label>
												No
												<input type="checkbox" value="1" name="activado" @if($producto->activado==1) checked @endif>
												<span class="lever"></span>
												Si
											</label>
										</div>
									</p>
								</div>
								<div class="col s12 m6">
									<label>¿Página principal?</label>
									<p>
										<div class="switch">
											<label>
												No
												<input type="checkbox" value="1" name="front" @if($producto->front==1) checked @endif>
												<span class="lever"></span>
												Si
											</label>
										</div>
									</p>
								</div>
							</div>
							<div class="row">
								<div class="col s12 m6">
									<label>Catálogo</label>
									<p>
										<div class="switch">
											<label>
												No
												<input type="checkbox" value="1" name="catalogo" @if($producto->catalogo==1) checked @endif>
												<span class="lever"></span>
												Si
											</label>
										</div>
									</p>
								</div>
								<div class="col s12 m6">
									<label>¿Producto nuevo?</label>
									<p>
										<div class="switch">
											<label>
												No
												<input type="checkbox" value="1" name="nuevo" @if($producto->nuevo==1) checked @endif>
												<span class="lever"></span>
												Si
											</label>
										</div>
									</p>
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