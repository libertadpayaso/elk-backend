@extends('layouts.front')

@section('title','Formulario de Registro')

@section('encabezado')
@endsection

@section('main')
	
	<div class="f_cart_area pt-110 mb-100">
        <div class="container">
            <div class="row">
				<h3 class="title-7">Formulario de clientes</h3>
	            <p>Ingresa tus datos para informarte sobre tu compra y estar en contacto directo.</p>
            	@if(session('error'))
                <div class="notification__message error">
                    <p><i class="fas fa-exclamation-triangle"></i>{{session('error')}}</p>
                </div>
				@endif
				<div class="col-xl-7 col-lg-7 col-md-12">
		            <div class="login_wrapper">
		            	 <ul class="nav nav-tabs justify-content-center mb-55" id="myTab" role="tablist">
		                    <li class="nav-item" role="presentation">
		                        <button class="nav-link active" id="sincuenta-tab" data-bs-toggle="tab" data-bs-target="#sincuenta" type="button" role="tab"  aria-selected="false">No tengo una cuenta</button> 
		                    </li>
		                    <li class="nav-item" role="presentation">
		                        <button class="nav-link" id="cuenta-tab" data-bs-toggle="tab" data-bs-target="#cuenta" type="button" role="tab"  aria-selected="true">Ya tengo una cuenta</button>
                                
		                    </li>
		                </ul>
		                <div class="tab-content" id="myTabContent">
	                    	<div class="tab-pane fade show active" id="sincuenta">
	                    		<form action="{{ url('carrito/solicitar') }}" method="POST"> 
									@csrf
									@if(session('error'))
									<div class="notification__message error">
					                    <p><i class="fas fa-exclamation-triangle"></i>{{session('error')}}</p>
					                </div>
									@endif
									<h4>INFORMACIÓN DE ENTREGA</h4>
									<div class="row">
										<div class="input_wrap col-md-6 col-sm-12">
					                        <label>Nombre y Apellido<span>*</span></label>
					                        <input type="text" name="nombre" required placeholder="Escribe Nombre y apellido">
					                    </div>
					                    <div class="input_wrap col-md-6 col-sm-12">
					                        <label>CUIT/CUIL/DNI (Para facturación)<span>*</span></label>
					                        <input type="text" name="cuit" required placeholder="Escribe Cuit/Dni">
					                    </div>
					                    <div class="input_wrap col-md-6 col-sm-12">
					                        <label>Provincia<span>*</span></label>
					                        <input type="text" name="provincia" required placeholder="Escribe de que provincia eres">
					                    </div>
					                    <div class="input_wrap col-md-6 col-sm-12">
					                        <label>Localidad<span>*</span></label>
					                        <input type="text" name="localidad" required placeholder="Escribe de que localidad eres">
					                    </div>
					                    <div class="input_wrap col-md-6 col-sm-12">
					                        <label>Dirección<span>*</span></label>
					                        <input type="text" name="direccion" required placeholder="Escribe tu domicilio">
					                    </div>
					                    <div class="input_wrap col-md-6 col-sm-12">
					                        <label>Código Postal<span>*</span></label>
					                        <input type="text" name="codigo_postal" required placeholder="Escribe tu código postal" maxlength="6">
					                    </div>
					                    <div class="input_wrap col-md-6 col-sm-12">
					                        <label>E-mail<span>*</span></label>
					                        <input type="text" name="email" required placeholder="Escribe tu dirección de correo">
					                    </div>
					                    <div class="input_wrap col-md-6 col-sm-12">
					                        <label>Celular/Whatsapp (Contacto directo)<span>*</span></label>
					                        <input type="number" name="celular" required placeholder="Escribe tu numero de celular">
					                    </div>
					                    <div class="input_wrap col-md-6 col-sm-12">
					                        <label>Forma de Pago<span>*</span></label>
					                        <select name="formadepago">
												<option value="">Elige una Forma de Pago</option>
												<option value="Efectivo">Efectivo en el local</option>
												<option value="TransferenciDeposito">Transferencia/Deposito</option>
												<option value="DebitoCredito">Tarjeta Débito/Crédito (Recargo del 10%)</option>
												<option value="comisionista">Comisionista</option>
											</select>
					                    </div>
					                    <div class="input_wrap col-md-6 col-sm-12">
					                    	<label>Forma de envíos<span>*</span></label>
                                            
					                        <select name="formadeenvio">
												<option value="">Elige una empresa p/envíos</option>
                                                <option value="CorreoSUCURSAL">Correo Argentino (SUCURSAL)</option>
                                                <option value="CorreoDOMICILIO">Correo Argentino (DOMICILIO)</option>
                                                <option value="Transporte">Transporte/Expresos</option>	
                                                <option value="Local">Retiro por local</option>	
												<option value="Otro">Otro (Consulto alternativas)</option>
												
											</select>
					                    </div>	
					                    <div class="col-sm-12">
					                    	<p>*Los datos ingresados serán los datos de envío, en caso de modificación avisarle al vendedor.</p>
					                    </div>
					                    <div class="input_wrap col-sm-12">
					                    	<span><input type="checkbox" name="crear_cuenta" value="1"> Quiero crear una cuenta (Opcional)</span>
					                    </div>
					                    <div class="input_wrap toggle-login col-md-6 col-sm-12" style="display: none;">
			                                <label>Usuario <span>*</span></label>
			                                <input type="text" name="usuario" placeholder="Escribe nombre de usuario">
			                            </div>
			                            <div class="input_wrap toggle-login col-md-6 col-sm-12" style="display: none;">
			                                <label>Contraseña<span>*</span></label>
			                                <input type="password" name="password" placeholder="Escribe contraseña">
			                            </div>
									</div>
									<div class="row pt-20">
										<div class="input_wrap offset-md-3 col-md-6 col-sm-12">
					                        <button type="submit">Enviar datos</button>
					                    </div>
									</div>
				                </form>
	                    	</div>
	                    	<div class="tab-pane fade" id="cuenta">
	                    		<form class="form-signin" action="{{ url('carrito/ingresar') }}" method="POST">
									@csrf
									<div class="row">
			                            <div class="input_wrap col-md-6 col-sm-12">
			                                <label>Usuario <span>*</span></label>
			                                <input type="text" name="usuario" required autofocus placeholder="Escribe nombre de usuario">
			                            </div>
			                            <div class="input_wrap col-md-6 col-sm-12">
			                                <label>Contraseña<span>*</span></label>
			                                <input type="password" name="password" required placeholder="Escribe contraseña">
			                            </div>
			                            <div class="input_wrap offset-md-3 col-md-6 col-sm-12">
			                                <button type="submit">Iniciar sesión</button>
			                            </div>
									</div>
		                        </form>
	                    	</div>
			     		</div>
		            </div>
                </div>
                <div class="col-xl-5 col-lg-5 col-md-12">
                    <div class="cart_table">
                        <table>
                            <tr> 
                                <td>Producto</td>
                                <td></td>
                                <td>Precio</td>
                                <td>Cantidad</td>
                                <td>Total</td>
                                
                               </tr>
                            <tbody>
                            	@foreach(Cart::content()  as $row)
                                <tr class="max-width-set">
                                    <td>
                                        <img src="{{ asset('assets/img/imagenes/'.$row->options->archivo) }}" alt="">
                                    </td>
                                    <td>{{$row->name}}<br>Talle {{$row->options->talle}}</td>
                                    <td>${{$row->price}}</td>
                                    <td>{{$row->qty}}</td>
                                    <td>${{$row->qty * $row->price}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="design-footer">
                                    <td colspan="3"></td>
                                    <td colspan="2">TOTAL ${{Cart::subtotal(0,'','')}}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection