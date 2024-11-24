@extends('layouts.pdv')

@section('title','Pedido creado')
 
@section('main')
		<main>
				<div class="row">
					<div class="col 12 miga">
						<p>
							<a href="{{ url('pdv/pedidos') }}">Pedidos</a> > Pedido creado
						</p>
					</div>
				</div>
				<div class="row">
					@isset($pedido)
					<div class="col s12 m6 offset-m3 card-panel green lighten-4 green-text text-darken-4 center">
						El pedido <b>#{{$pedido->id}}</b> fue creado correctamente
					</div>
					<div class="col s12 m4 offset-m4">
						<input type="hidden" name="id" value="{{ $pedido->id }}">
						<div class="row">
							<div class="col s12">
								<h5>Enviar comprobante por E-mail</h5>
							</div>
							<div class="input-field col s12">
								<input placeholder="Nombre" type="text" name="nombre">
							</div>
							<div class="input-field col s12">
								<input placeholder="Email" type="text" name="email">
							</div>
							<div class="input-field col s12 center">
								<button class="btn waves-effect waves-light btn-large" type="submit">Enviar
									<i class="material-icons right">send</i>
								</button>
							</div>
						</div>	
					</div>
					@endisset
					@isset($error)
					<div class="col s12 card-panel red lighten-4 red-text text-darken-4 center">
						{{ $error }}
					</div>
					@endisset
				</div>
		</main>
@endsection

@section('javascript')
		<script type="text/javascript">
			$('button[type=submit]').click(function(event) {
				
				var mail = $('input[name=email]').val();
				var nombre = $('input[name=nombre]').val();

				if(mail!='' && nombre!=''){

					var id = $('input[name=id]').val();
					
					$.ajax({
						url: "{{ url('pdv/pedidos/mail') }}",
						type: "POST",
						data: { id: id, 
							email: mail,
							nombre: nombre, 
							_token: "{{csrf_token()}}" }
					}).done(function (response, textStatus, jqXHR){
						
						$('input[name=email]').val('');
						$('input[name=nombre]').val('');

						Materialize.toast(response, 5000, 'red lighten-4 red-text text-darken-4');					
					}).fail(function (jqXHR, textStatus, errorThrown){
						console.error( "Error: "+ textStatus, errorThrown );
					});
				}else{
					Materialize.toast('Complete los campos Nombre y E-mail', 5000, 'red lighten-4 red-text text-darken-4');
				}
			});
		</script>
@endsection