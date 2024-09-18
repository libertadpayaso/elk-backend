@extends('layouts.front')

@section('title','Iniciar Sesion')

@section('main')

	<div class="login_register_area">
        <div class="container">
            <div class="row gx-5">
                <div class="col-xl-5 col-lg-6 col-md-12 col-sm-12 offset-xl-1">
                    @if(session('error'))
                        <div class="notification__message error">
                            <p><i class="fas fa-exclamation-triangle"></i>{{session('error')}}</p>
                        </div>
                    @endif
                    <h3 class="title-7">Inicie sesión</h3>
                    <p class="mb-30">Inicia sesión para realizar tu compra</p>
                    <div class="login_wrapper">
                        <form class="form-signin" action="{{ url('ingresar') }}" method="POST">
							@csrf
                            <div class="input_wrap">
                                <label>Usuario <span>*</span></label>
                                <input type="text" name="usuario" required autofocus placeholder="Escribe nombre de usuario">
                            </div>
                            <div class="input_wrap">
                                <label>Contraseña<span>*</span></label>
                                <input type="password" name="password" required placeholder="Escribe contraseña">
                            </div>
                            <div class="input_wrap">
                                <button type="submit">Iniciar sesión</button>
                            </div>
                            
                            <p class="mb-30"> * Podrás ver el estado de tu pedido <br> * Podrás acceder a descuentos para clientes recurrentes</p>
                        </form>
                    </div>
                </div>
                <div class="col-xl-5 col-lg-6 col-md-12 col-sm-12">
                    <h3 class="title-7">No tengo cuenta</h3>
                    <div class="login_wrapper login_wrapper_2">
                        <div class="input_wrap input_wrap_3">
                            <p class="mb-30">Regístrate para poder iniciar sesión</p>
                            <a href="{{ url('registrarse') }}"><button type="submit">Registrarme</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection