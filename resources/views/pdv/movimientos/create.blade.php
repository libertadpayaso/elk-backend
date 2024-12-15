@extends('layouts.pdv')

@section('title','Crear Movimiento manual')
 
@section('main')
		<main>
			<div class="container">
				<div class="row">
					<div class="col 12 miga">
						<p>
							<a href="{{ url('pdv/movimientos') }}">Movimientos</a> > Nuevo
						</p>
					</div>
				</div>
				<div class="row">
                    <form action="{{ url('pdv/movimientos') }}" method="POST" id="formulario">
                        <div class="col s12 m4 input-field">
							<label for="fecha">Concepto</label>
							<input type="text" id="concepto" name="concepto" max="255" required>
                        </div>
						<div class="col s12 m4 input-field">
							<label for="monto">Monto</label>
							<input type="number" id="monto" name="monto" min="0" required>
                        </div>
						<div class="col s12 m4 input-field">
							<select name="modificador">
								<option value="-1" selected>Egreso (-)</option>
								<option value="1">Ingreso (+)</option>
							</select>
                        </div>
						<div class="col s12 input-field">
							<input type="submit" class="waves-effect waves-light btn right" value="Crear">
                        </div>
						<input type="hidden" name="_token" value="{{csrf_token()}}">
                    </form>
				</div>
			</div>
		</main>
@endsection

@section('javascript')
	<script type="text/javascript">
		$(document).ready(function(){
			@if(session('success'))
				Materialize.toast('{{ session('success') }}', 3000, 'green lighten-4 green-text text-darken-4');
			@endif

			@if(session('error'))
				Materialize.toast('{{ session('error') }}', 5000, 'red lighten-4 red-text text-darken-4');
			@endif
		});
	</script>
@endsection