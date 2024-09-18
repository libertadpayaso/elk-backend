@extends('layouts.back')

@section('title','Editar imagenes')
 
@section('main')
		<main>
			<div class="container">
				<div class="row">
					<div class="col 12 miga">
						<p>
							<a href="{{ url('admin/productos/producto/edit/'.$producto->categoria->sexo_id) }}">Productos</a> > {{$producto->nombre}}
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
						<a href="{{ url('admin/productos/imagen/create/'.$sexo.'/'.$producto->id) }}">
							<button class="btn">Agregar imagen</button>
						</a>
					</div>
				</div>
				<div class="row">
					<div class="col s12">
						<table class="highlight bordered">
							<thead>
								<td>Nombre</td>
								<td>Imagen</td>
								<td>Stock</td>
								<td class="text-right">Editar</td>
							</thead>
							<tbody>
								@foreach($imagenes as $imagen)
								<tr>
									<td>{{$imagen->nombre}}</td>
									<td>
										<img class="responsive-img materialboxed" src="{{ asset("assets/img/imagenes/".$imagen->imagen) }}">
									</td>
									<td><a href="{{ url('admin/productos/stock/edit/'.$imagen->id) }}" title="Stock disponible"><i class="material-icons">add_box</i></a></td>
									<td class="text-right">
										<a href="{{ url('admin/productos/imagen/edit/'.$sexo.'/'.$imagen->producto_id.'/'.$imagen->id) }}"><i class="material-icons">create</i></a>
										{!!Form::open(['class'=>'en-linea', 'route'=>['imagen.destroy', $imagen->id], 'method' => 'DELETE'])!!}
											<button type="submit" class="submit-button">
												<i class="material-icons red-text">cancel</i>
											</button>
										{!!Form::close()!!}
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>            
					</div>
				</div>
			</div>
		</main>
@endsection