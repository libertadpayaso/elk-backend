@extends('layouts.back')

@section('title','Editar stock')
 
@section('main')
		<main>
			<div class="container">
				<div class="row">
					<div class="col 12 miga">
						<p><a href="{{ url('admin/productos/producto/edit/'.$stock->imagen->producto->categoria->sexo_id) }}">Productos</a> >
							<a href="{{ url('admin/productos/imagen/edit/'.$stock->imagen->producto->categoria->sexo_id.'/'.$stock->imagen->producto->id) }}">{{$stock->imagen->producto->nombre}}</a> >
							<a href="{{ url('admin/productos/stock/edit/'.$imagen) }}">{{$stock->imagen->nombre}}</a> > Stock de Talle {{$stock->talle_id}}</p>
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
					<div class="col s12 m6 offset-m3">
						{{Form::model($stock, ['route' => ['stock.update', $stock->id], 'method'=>'PUT', 'files' => true]) }}
							<div class="row">
								<div class="input-field col s12">
									{!!Form::label('Cantidad disponible')!!}
									{!!Form::number('stock',null,['class'=>'validate', 'min'=>'0', 'required'])!!}
								</div>
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