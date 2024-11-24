@extends('layouts.pdv')

@section('title','Nuevo Pedido')
 
@section('main')
		<main>
				<div class="row">
					<div class="col 12 miga">
						<p>
							<a href="{{ url('pdv/pedidos') }}">Pedidos</a> > Nuevo Pedido
						</p>
					</div>
				</div>
				<div class="row">
					<div class="col s12 col m4">
						<form  action="{{ url('pdv/carrito/agregar') }}"  method="POST" >
							<div class="row">
								<div class="input-field col s12">
									<input name="codigo" type="text" required id="codigo" autofocus>
									<label for="codigo" id="label-codigo">Código de Artículo</label>
								</div>
								<div class="input-field col s12">
									<input name="cantidad" id="cantidad" type="number" disabled required min="0">
									<label for="cantidad" id="label-cantidad">Cantidad</label>
								</div>
								<div class="input-field col s12 center">
									<a href="{{ url('pdv/pedidos/nuevo') }}">
										<button class="btn waves-effect waves-light btn-large red" type="button" style="background-color:#F44336!important">Cancelar
											<i class="material-icons right">close</i>
										</button>
									</a>
									<button class="btn waves-effect waves-light btn-large" type="submit" disabled>Agregar
										<i class="material-icons right">add_shopping_cart</i>
									</button>
								</div>
							</div>
							<input type="hidden" name="stock_id" id="stock_id">
							{!! Form::token() !!}
						</form>
					</div>
					<div class="col s12 m8" id="carrito">
						<div class="row">
							<div class="col s12">
								<table class="highlight bordered responsive-table" >
									<thead >
										<td>Producto</td>
										<td>Cantidad</td>
										<td>Precio</td>
										<td>Subtotal</td>
										<td></td>
									</thead>
									@if(Cart::count() > 0)
									<tbody>
										@foreach(Cart::content()  as $row)
										<tr>
											<td>{{$row->name}}</td>
											<td>{{$row->qty}}</td>
											<td>${{$row->price}}</td>
											<td>${{$row->price*$row->qty}}</td>
											<td>
												<a class="grey-text text-darken-2" href="{{ url('pdv/carrito/borrar/'.$row->rowId) }}">
													<i class="material-icons">delete</i>
												</a>
											</td>
										</tr>
										@endforeach
										<tr>
											<td colspan="2"></td>
											<td>TOTAL:</td>
											<td>${{Cart::subtotal(0,'','')}}</td>
											<td></td>
										</tr>
									</tbody>
									@endif
								</table>
							</div>
						</div>
						<div class="row">
							<div class="col s12 center">
								<a href="{{ url('pdv/carrito/vaciar') }}">
									<button class="btn grey darken-2">VACIAR
										<i class="material-icons right">clear_all</i>
									</button>
								</a>
								<a @if(Cart::count() > 0) href="{{ url('pdv/pedidos/confirmar') }}" @endif>
									<button class="btn" @if(Cart::count()==0) disabled @endif>Cerrar Pedido
										<i class="material-icons right">check</i>
									</button>
								</a>
							</div>
						</div>
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

				$("#codigo").keyup(function(event) {

					var codigo = this.value.replace(/\D/g,'');

					if (codigo.length > 3) {
						getProducto(codigo);
					}
				});

				$("#codigo").keypress(function(event) {
					if (event.which<48 || event.which>105 || 57<event.which && event.which>96 || this.value.length==9) {
						event.preventDefault();
					}
				});

				$("#cantidad").keyup(function(event) {
					if ($(this).val() > 0) {
						$('button[type=submit]').removeAttr('disabled');
					}
				});

				function getProducto(codigo){
					$.ajax({
						url: "{{ url('pdv/carrito/producto') }}",
						type: "POST",
						data: { codigo: codigo , _token: "{{csrf_token()}}" }
					}).done(function (response, textStatus, jqXHR){
						$("#codigo").val('');
						if (response.status) {
							$("#codigo").attr('disabled', 'disabled');
							$('#label-codigo').removeClass('active').html(response.producto.nombre);
							$("#label-cantidad").html('Cantidad (Disponibles: <b>' + response.stock.stock + '</b>)');
							$('#cantidad').attr('max', response.stock.stock).removeAttr('disabled').focus();
							$('#stock_id').val(response.stock.id);
						} else {
							alert(response.message);
							$('#codigo').focus();
						}
					}).fail(function (jqXHR, textStatus, errorThrown){
						console.error( "Error: " + textStatus, errorThrown );
					});
				}
			});
		</script>
@endsection