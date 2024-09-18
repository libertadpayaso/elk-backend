@extends('layouts.back')

@section('title','Resumen del Pedido # ' . $resumen->pedido_id)
 
@section('main')
		<main>
			<div class="container">
				<div class="row">
					<div class="col 12 miga">
						<p>
							<a href="{{ url('admin/clientes/pedidos/resumenes') }}">Resumenes de Pedidos</a> > Resumen del Pedido # "{{ $resumen->pedido_id }}"
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

						{{Form::open(['url' => 'admin/clientes/pedidos/resumen', 'method'=>'POST']) }}
							<div class="row">
								<div class="input-field col s12 m4">
									<p><b>Cliente:</b> {{ $resumen->nombre_cliente }}</p>
								</div>
								<div class="input-field col s12 m4">
									<p><b>Pedido</b> # {{ $resumen->pedido_id }}</p>
								</div>
								<div class="input-field col s12 m4">
									<p><b>Monto Total:</b> ${{ $resumen->monto_total }}</p>
								</div>
								<div class="input-field col s12 m6">
									<p><b>Fecha de Alta:</b> {{ $resumen->created_at }}</p>
								</div>
								<div class="input-field col s12 m6">
									{!!Form::label('Fecha de Pago')!!}
									{!!Form::text('fecha_pago',$resumen->fecha_pago,['class'=>'datepicker', 'placeholder' => "aaaa-mm-dd" ])!!}
								</div>
								<div class="input-field col s12 m6">
									{!!Form::select('modo_pago', $modosPago, $resumen->modo_pago, ['placeholder' => 'Seleccionar Modo de Pago'])!!}
								</div>
								<div class="input-field col s12 m6">
									{!!Form::select('modo_envio', $modosEnvio, $resumen->modo_envio, ['placeholder' => 'Seleccionar Modo de Envío'])!!}
								</div>
								<div class="col s12 m6">
									<label>¿Facturado?</label>
									<p>
										<div class="switch">
											<label>
												No
												<input type="checkbox" value="1" name="facturado" @if($resumen->facturado==1) checked @endif>
												<span class="lever"></span>
												Si
											</label>
										</div>
									</p>
								</div>
								<div class="input-field col s12">
									{!!Form::label('Notas')!!}
									{!!Form::textarea('observaciones', $resumen->observaciones, ['class'=>'validate materialize-textarea', 'cols'=>'74', 'rows'=>'5'])!!}
								</div>
								<input type="hidden" name="resumen_id" value="{{ $resumen->id }}">
							</div>
							<div class="row">
								<div class="col s12">
									{!!Form::submit('Guardar cambios', ['class'=>'waves-effect waves-light btn right'])!!}
								</div>
							</div>
						{{Form::close()}}      
					</div>
				</div>
			</div>
		</main>
@endsection