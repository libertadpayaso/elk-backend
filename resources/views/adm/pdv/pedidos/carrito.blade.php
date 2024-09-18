						<div class="row">
							@isset($error)
							<div class="col s12 card-panel red lighten-4 red-text text-darken-4 center">
								{{ $error }}
							</div>
							@endisset
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