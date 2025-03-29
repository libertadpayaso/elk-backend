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