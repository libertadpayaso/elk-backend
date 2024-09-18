@extends('layouts.back')

@section('title','Crear Promoción')
 
@section('main')
<table>
	<tbody></tbody>
</table>
		<main>
			<div class="container">
				<div class="row">
					<div class="col 12 miga">
						<p>
							<a href="{{ url('admin/promocion/list') }}">Promociones</a> > Crear Promoción
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

						{!!Form::open(['route'=>'promocion.store', 'method'=>'POST'])!!}
							<div class="row">
								<div class="input-field col s12 m6">
									{!!Form::label('Nombre')!!}
									{!!Form::text('nombre',null,['class'=>'validate', 'required'])!!}
								</div>
								<div class="input-field col s12 m6">
									{!!Form::label('Cantidad')!!}
									{!!Form::number('cantidad',null,['class'=>'validate', 'min'=>'0', 'required'])!!}
								</div>
							</div>
							<div class="row">
								<div class="input-field col s12 m6">
									{!!Form::label('precio')!!}
									{!!Form::number('precio',null,['class'=>'validate', 'min'=>'0', 'required'])!!}
								</div>
								<div class="col s12 m6">
									<label>Activado</label>
									<p>
										<div class="switch">
											<label>
												No
												<input type="checkbox" value="1" name="activa" checked>
												<span class="lever"></span>
												Si
											</label>
										</div>
									</p>
								</div>
							</div>
							<div class="row">
								<div class="col s12">
									{!!Form::submit('Crear', ['class'=>'waves-effect waves-light btn right'])!!}
								</div>
							</div>
						{!!Form::close()!!}         
					</div>
				</div>
			</div>
		</main>
@endsection