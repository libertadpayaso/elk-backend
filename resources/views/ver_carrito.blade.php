@php
	Auth::setDefaultDriver('client');
    $totalReal   = 0;
    $subtotal    = $total = Cart::subtotal(0,'','');
    $esMayorista = $subtotal >= env("MONTO_MAYORISTA");
@endphp
@extends('layouts.front')

@section('title','Carrito')

@section('main')

    <div class="f_cart_area pt-110 mb-100">
        <div class="container">
            <div class="row">
            	@if(session('error'))
                <div class="notification__message error">
                    <p><i class="fas fa-exclamation-triangle"></i>{{session('error')}}</p>
                </div>
				@endif
                <div class="col-xl-8 col-lg-8 col-md-12">
                    <div class="cart_table">
                        @if(count(Cart::content()) > 0)
                        <form method="POST" action="{{ url('carrito/actualizar') }}" id="cart-form">
                            @csrf
                            <table>
                                <tr> 
                                    <td>Producto</td>
                                    <td></td>
                                    <td>Precio</td>
                                    <td>Cantidad</td>
                                    <td>Subotal</td>
                                    
                                   </tr>
                                <tbody>
                                	@foreach(Cart::content()  as $row)
                                    <tr class="max-width-set">
                                        <td>
                                            <img src="{{ asset('assets/img/imagenes/'.$row->options->archivo) }}" alt="">
                                        </td>
                                        <td>{{$row->name}}<br>Talle {{$row->options->nombre_talle}}</td>
                                        <td>${{$row->price}}</td>
                                        <td>
                                        	<div class="viewcontent__action single_action pt-30">
                                            	<span>
                                                    <input type="number" name="cantidad[]" placeholder="1" value="{{$row->qty}}" min="1">
                                                    <input type="hidden" name="stock[]" value="{{$row->options->stock_id}}" max="{{ stock($row->options->stock_id)}}">
                                                </span>
                                        	</div>
                                    	</td>
                                        <td>${{$row->qty * $row->price}}</td>
                                        <td class="width-set">
                                            <a href="{{ url('carrito/borrar/' . $row->rowId . '/back') }}">
                                            	<i class="fal fa-times-circle"></i>
                                            </a>
                                        </td>
                                        @php
                                            if ($row->options->precio_descuento > 0) {
                                                $totalReal += $row->options->precio_descuento * $row->qty;
                                            } else {
                                                $totalReal += $row->options->precio_original * $row->qty;
                                            }
                                        @endphp
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="design-footer">
                                        <td colspan="5"><a type="submit" class="submit" href="#!">actualizar</a></td>                                        
                                    </tr>
                                    <tr class="design-footer">
                                        <td colspan="5"><a type="submit" class="submit" href="https://elkideasdeportivas.com.ar/productos">Seguir comprando</a></td>                                        
                                    </tr>
                                </tfoot>
                            </table>
                        </form>
                        @else
                        <div class="notification__message">
                            <p><i class="fal fa-shopping-cart"></i>El carrito esta vacío. Lo invitamos a la <a href="{{ url('https://elkideasdeportivas.com.ar/productos') }}"><b>Tienda</b></a></p>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-12">
                    <div class="cart__acount">
                        <h5>Total del pedido</h5>
						<table>
							<tr class="first-child lastchild">
								<td colspan="2">No incluye los costos de envío</td>
							</tr>
                            <tr class="first-child">
                                <td>Total @if($esMayorista) mayorista @endif</td>
                                <td>${{ $total }}@if(!$esMayorista)*@endif</td>
                            </tr>
                            @if($esMayorista)
                            <tr class="first-child">
                                <td><small>Total Real</small></td>
                                <td><small><del>${{ $totalReal }}</del></small></td>
                            </tr>
                            @endif
							@if(Cart::count() > 0)
							<tr>
								<td colspan="2">
                                    @if(Auth::check())
								  	<a href="{{ url('carrito/confirmar') }}"><input type="submit" value="Confirmar Pedido"></a>
								    @else
                                    <a href="{{ url('carrito/solicitar') }}"><input type="submit" value="Confirmar Pedido"></a>
                                    @endif
                                </td>
							</tr>
							@else
							<tr>
								<td colspan="2">
									El carrito está vacío, lo invitamos a seguir comprando.
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<a href="{{ url('https://elkideasdeportivas.com.ar/productos') }}"><input type="submit" value="CATÁLOGO"></a>
								</td>
							</tr>
							@endif
						</table>
                         @if(!$esMayorista)
                        <br>
                        <p class="info">*Te faltan ${{ env("MONTO_MAYORISTA") - $subtotal }} para obtener ENVÍO GRATIS por correo argentino</p>
                        @endif 
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection