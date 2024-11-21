@extends('layouts.pdv')

@section('title','Nuevo Pedido')
 
@section('main')
		<main>
				<div class="row">
					<div class="col 12 miga">
						<p>
							<a href="{{ url('admin/pdv/pedidos') }}">Pedidos</a> > Nuevo Pedido
						</p>
					</div>
				</div>
				<div class="row">
					@if(session('success'))
					<div class="col s12 card-panel green lighten-4 green-text text-darken-4 center">
						{{ session('success') }}
					</div>
					@endif
					@if(session('error'))
					<div class="col s12 card-panel red lighten-4 red-text text-darken-4 center">
						{{ session('error') }}
					</div>
					@endif
					<div class="col s12 col m4">
						<div class="row">
							<div class="input-field col s12">
								<input placeholder="Código de Artículo" name="codigo" type="text" required autofocus>
								<label for="codigo">Código</label>
							</div>
							<!--<div class="input-field col s12">
								<input placeholder="No encontrado" id="producto" type="text" readonly required>
								<label for="producto">Producto</label>
							</div>
							<div class="input-field col s12">
								<input placeholder="No encontrada" id="variante" type="text" readonly required>
								<label for="variante">Variante</label>
							</div>
							<div class="input-field col s12">
								<input placeholder="No encontrada" id="talle" type="text" readonly required>
								<label for="talle">Talle</label>
							</div>
							<div class="input-field col s12 center">
								<button class="btn waves-effect waves-light btn-large" type="submit" disabled>Agregar
									<i class="material-icons right">add_shopping_cart</i>
								</button>
							</div>-->
						</div>
					</div>
					<div class="col s12 m8" id="carrito">
						<div class="row">
							<div class="col s12">
								<table class="highlight bordered responsive-table" >
									<thead >
										<td>Producto</td>
										<td>Talle</td>
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
											<td>{{$row->options->talle}}</td>
											<td>{{$row->qty}}</td>
											<td>${{$row->price}}</td>
											<td>${{$row->price*$row->qty}}</td>
											<td>
												<a class="grey-text text-darken-2" href="{{ url('carrito/borrar/'.$row->rowId) }}">
													<i class="material-icons">delete</i>
												</a>
											</td>
										</tr>
										@endforeach
										<tr>
											<td colspan="3"></td>
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
								<a href="{{ url('carrito/vaciar') }}">
									<button class="btn grey darken-2">VACIAR
										<i class="material-icons right">clear_all</i>
									</button>
								</a>
								<a @if(Cart::count() > 0) href="{{ url('admin/pdv/pedidos/confirmar') }}" @endif>
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

			$("input[name=codigo]").keyup(function(event) {

				var codigo = this.value.replace(/\D/g,'');

				if (codigo.length > 3) {
					agregar(codigo);
				}
			});

			$("input[name=codigo]").keypress(function(event) {

				if(event.currentTarget.textLength==9 && event.which==13){
					$('form').submit();
				}
				if (event.which<48 || event.which>105 || 57<event.which && event.which>96 || this.value.length==9) {
					event.preventDefault();
				}
			});

			function agregar(codigo){
				$.ajax({
					url: "{{ url('pdv/pedidos/agregar') }}",
					type: "POST",
					data: { codigo: codigo , _token: "{{csrf_token()}}" }
				}).done(function (response, textStatus, jqXHR){
					$('#carrito').html(response);
					$("input[name=codigo]").val('');
				}).fail(function (jqXHR, textStatus, errorThrown){
					console.error( "Error: "+ textStatus, errorThrown );
				});
			}
		</script>
@endsection