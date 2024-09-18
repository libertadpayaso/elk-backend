@extends('layouts.back')

@section('title','Editar Stock')
 
@section('main')
		<main>
			<div class="container">
				<div class="row">
					<div class="col 12 miga">
						<p><a href="{{ url('admin/productos/producto/edit/'.$imagen->producto->categoria->sexo_id) }}">Productos</a> >
							<a href="{{ url('admin/productos/imagen/edit/'.$imagen->producto->categoria->sexo_id.'/'.$imagen->producto->id) }}">{{$imagen->producto->nombre}}</a> > {{$imagen->nombre}}</p>
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

				<form action="{{ url('admin/productos/stock') }}" method="POST">
					<div class="row">
						<div class="col s12">
							@csrf
							<table class="highlight bordered">
								<thead>
									<td>Talle</td>
									<td>Stock</td>
								</thead>
								<tbody>
									@foreach($stocks as $stock)
									<tr>
										<td>{{$stock->talle->talle}}</td>
										<td>
											<input type="number" name="stock[]" min="0" value="{{$stock->stock}}">
											<input type="hidden" name="id[]" value="{{$stock->id}}">
										</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
					<div class="row">
						<div class="col s12">
							<input class="waves-effect waves-light btn right mt-3" type="submit" value="Actualizar">        
							<a href="{{ url('admin/productos/stock/clear/'.$imagen->id) }}">
								<button class="waves-effect waves-light btn right mt-3" type="button">Vaciar</button>
							</a> 
						</div>
					</div>
				</form>
			</div>
		</main>
@endsection