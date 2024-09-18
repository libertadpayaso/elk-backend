@extends('layouts.front')

@section('title','Formulario de Registro')

@section('main')
<!-- breadcrumb area start -->
    <div class="page-layout" data-background="{{ asset('assets/img/slider/shopelk3.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="breadcrumb-area text-center">
                        <h2 class="page-title">Registro</h2>
                            <div class="breadcrumb-menu">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb justify-content-center">
                                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Inicio</a></li>
                                    <li class="breadcrumb-item"><a href="#!">Registro</a></li>
                                </ol>
                            </nav>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb area end -->

	<div class="login_register_area">
        <div class="container">
            <h3 class="title-7">Formulario de clientes</h3>
            <p>Ingresa tus datos para informarte sobre tu compra y estar en contacto directo.</p>
			
            <div class="login_wrapper">
                <form action="{{ url('registrar') }}" method="POST"> 
					@csrf
					@if(session('error'))
					<div class="notification__message error">
	                    <p><i class="fas fa-exclamation-triangle"></i>{{session('error')}}</p>
	                </div>
					@endif
					<h4>Datos para iniciar sesión</h4>
					<div class="row">
	                    <div class="input_wrap col-md-6 col-sm-12">
	                        <label>Usuario <span>*</span></label>
	                        <input type="text" name="usuario" required autofocus placeholder="Escribe nombre de usuario">
	                        <div class="alert alert-danger text-center" role="alert" id="alerta" style="display: none "></div>
	                    </div>
	                    <div class="input_wrap col-md-6 col-sm-12">
	                        <label>Contraseña<span>*</span></label>
	                        <input type="password" name="password" required placeholder="Escribe contraseña">
	                    </div>
	                    <div class="input_wrap col-md-6 col-sm-12">
	                        <label>Repetir Contraseña<span>*</span></label>
	                        <input type="password" name="repetir" required placeholder="Escribe nuevamente la contraseña">
	                    </div>
					</div>
					<h4>Datos para Envío</h4>
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
	                        <label>Celular/Whatsapp (Contacto directo)<span>*</span></label>
	                        <input type="number" name="celular" required placeholder="Escribe tu numero de celular">
	                    </div>
	                    <div class="input_wrap col-md-6 col-sm-12">
	                        <label>Forma de Pago<span>*</span></label>
	                        <select name="formadepago">
								<option value="">Elige una Forma de Pago</option>
								<option value="Efectivo">Efectivo</option>
								<option value="Transferenciabancario">Transferencia</option>
								<option value="Depositobancario">Depósito</option>
								<option value="TarjetaDebito">Tarjeta Débito</option>
								<option value="TarjetaCredito">Tarjeta Crédito</option>
							</select>
	                    </div>
	                    <div class="input_wrap col-md-6 col-sm-12">
	                    	<label>Forma de envíos<span>*</span></label>
	                        <select name="formadeenvio">
								<option value="">Elige una empresa p/envíos</option>
								<option value="Moto">Moto (Capital y Alrededores)</option>
								<option value="Viacargo">Vía cargo</option>
								<option value="TransportesAnk">Transportes Ank</option>
								<option value="CruceroExpress">Crucero Express</option>
								<option value="BusPack">Bus Pack</option>
								<option value="Ctc">Central de Cargas Terrestres</option>
								<option value="EcaPack">Eca Pack</option>
								<option value="NuevoExpreso">Nuevo Expreso</option>
								<option value="ExpresoDemonte">Expreso Demonte</option>
								<option value="ElRapido">El Rápido</option>
								<option value="ElVasquito">El Vasquito</option>
								<option value="Tascar">Expreso Tascar</option>
								<option value="Otro">Otro (Consulto alternativas)</option>
								<option value="CorreoArgentino">Correo Argentino</option>
							</select>
	                    </div>	
	                    <div class="col-sm-12">
	                    	<p>*Los datos ingresados serán los datos de envío, en caso de modificación avisarle al vendedor.</p>
	                    </div>
					</div>
					<div class="row pt-20">
						<div class="input_wrap offset-md-3 col-md-6 col-sm-12">
	                        <button type="submit">Registrar</button>
	                    </div>
					</div>
                </form>
            </div>
        </div>
    </div>
@endsection