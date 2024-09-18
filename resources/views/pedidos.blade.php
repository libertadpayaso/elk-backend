@php
	Auth::setDefaultDriver('client');
@endphp
@extends('layouts.front')

@section('title','Pedido')

@section('main')

	<div class="login_register_area">
        <div class="container">
            <div class="row gx-5">
                <div class="col-md-6 col-sm-12 offset-md-3">
                    @if(session('error'))
                        <div class="notification__message error">
                            <p><i class="fas fa-exclamation-triangle"></i>{{session('error')}}</p>
                        </div>
                    @endif
                    @if($tienda->value==1)
                    
                    
                    <h3 class="title-7">¿Como realizar un pedido?</h3>
                    <p class="pedidotext">1- Conocé los modelos y cada número de articulo haciendo clic en:</p> <p class="pedidotextcolor">  <a href="{{ url('catalogo/lista-de-precios') }}">VER MODELOS/ÁRTICULOS</a></p>
                    <p class="pedidotext">2- Ahora en el siguiente formulario podes escribir el número de articulo que buscás y el sistema te mostrará las variantes de colores disponibles.</p>
                    <h3 class="title-7">Realiza tu pedido</h3>
                    <div class="login_wrapper">
                        <form id="add-to-cart" method="POST" action="{{ url('carrito/agregar') }}">
							@csrf
                            <div class="input_wrap">
                                <label>1- Articulo</label>
                                <option>Escribe numero de árticulo</option>
                                <input type="text" class="autocomplete" name="articulo" @if(session('articulo')) value="{{session('articulo')}}" @endif placeholder="Ejemplo: 204">
                            </div>
                            <div class="input_wrap">
                                <label>2- Color</label>
                                <option>Seleccione una variante de color</option>
                                <select name="variante" class="form-control-color" required disabled>
                                	<option>Seleccione un color</option>
								</select>
                            </div>
                            <div class="input_wrap">
                                <label>3- Talle</label>
                                <option>Seleccione talles y cantidad según disponibilidad</option>
                                <div class="col-12 pt-2" id="sizes">
								</div>
                            </div>
                            <div class="input_wrap">
                            	<input type="hidden" name="publico" value="true">
                                <button>Agregar al carrito</button>
                            </div>
                        </form>
                    </div>
                    @else
                    <p>ESTAMOS ACTUALIZANDO STOCK. El día de mañana podrá realizar su pedido nuevamente con el stock actualizado y novedades de nuevos articulos disponibles. Disculpe las molestias.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection