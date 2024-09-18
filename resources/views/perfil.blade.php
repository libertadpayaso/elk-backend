@php
    Auth::setDefaultDriver('client');
@endphp
@extends('layouts.front')

@section('title','Mi Cuenta')

@section('main')
    <div class="page-layout thin">
        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="breadcrumb-area text-center">
                        <h2 class="page-title">Mi cuenta</h2>
                            <div class="breadcrumb-menu">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb justify-content-center">
                                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Inicio</a></li>
                                    <li class="breadcrumb-item"><a href="#!">Mi cuenta</a></li>
                                </ol>
                            </nav>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
    <div class="categories_area pt-85 mb-150">
        <div class="container-fluid">
            <div class="categories__tab">
                <ul class="nav nav-tabs justify-content-center mb-55" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link @if(!session('success')) active @endif" id="pedidos-tab" data-bs-toggle="tab" data-bs-target="#pedidos" type="button" role="tab"  aria-selected="true">Mis Pedidos</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link @if(session('success')) active @endif" id="perfil-tab" data-bs-toggle="tab" data-bs-target="#perfil" type="button" role="tab"  aria-selected="false">Mis Datos</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade @if(!session('success')) show active @endif" id="pedidos">
                        <div class="container cart_table">
                            <table>
                                <thead>
                                    <td>Fecha</td>
                                    <td>Estado</td>
                                    <td></td>
                                </thead>
                                <tbody>
                                    @foreach($pedidos as $pedido)
                                    <tr style="background-color: {{ $colores[$pedido->estado] }}">
                                        <td >
                                            {{ date('d-m-Y H:m', strtotime($pedido->created_at)) }}
                                        </td>
                                        <td >
                                            {{ $estados[$pedido->estado] }}
                                        </td>
                                        <td >
                                            <a href="{{ url('perfil/ver/'.$pedido->id) }}"><b>Ver pedido</b></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade @if(session('success')) show active @endif" id="perfil">
                        <div class="container">
                            <form class="mt-5" action="{{ url('admin/client/'. Auth::user()->id) }}" method="POST"> 
                                @csrf
                                @method('PUT')
                                @if(session('success'))
                                <div class="notification__message error">
                                    <p><i class="fal fa-check-circle"></i>Los cambios se han guardado exitosamente</p>
                                </div>
                                @endif
                                @if(session('error'))
                                <div class="notification__message error">
                                    <p><i class="fas fa-exclamation-triangle"></i>{{session('error')}}</p>
                                </div>
                                @endif
                                <h4>Datos para iniciar sesión</h4>
                                <div class="row">
                                    <div class="input_wrap col-md-6 col-sm-12">
                                        <label>Usuario</label>
                                        <input type="text" name="usuario" value="{{Auth::user()->usuario}}" required autofocus>
                                    </div>
                                    <div class="input_wrap col-md-6 col-sm-12">
                                        <label>Cambiar Contraseña</label>
                                        <input type="password" name="newPassword" placeholder="Cambiar Contraseña">
                                    </div>
                                    <div class="input_wrap col-md-6 col-sm-12">
                                        <label>Repetir Contraseña</label>
                                        <input type="password" name="repetir">
                                    </div>
                                    <div class="input_wrap col-md-6 col-sm-12">
                                        <div id="alerta" class="notification__message error" style="display: none">
                                            <p><i class="fas fa-exclamation-triangle"></i></p>
                                        </div>
                                    </div>
                                </div>
                                <h4>Datos para Envío</h4>
                                <div class="row">
                                    <div class="input_wrap col-md-6 col-sm-12">
                                        <label>Nombre y Apellido</label>
                                        <input type="text" name="nombre" value="{{Auth::user()->nombre}}" required>
                                    </div>
                                    <div class="input_wrap col-md-6 col-sm-12">
                                        <label>Provincia</label>
                                        <input type="text" name="provincia" value="{{Auth::user()->provincia}}" required>
                                    </div>
                                    <div class="input_wrap col-md-6 col-sm-12">
                                        <label>Dirección</label>
                                        <input type="text" name="direccion" value="{{Auth::user()->direccion}}" required>
                                    </div>
                                    <div class="input_wrap col-md-6 col-sm-12">
                                        <label>Forma de Pago</label>
                                        <select class="form-control mb-2" name="formadepago">
                                            @foreach($formas_pago as $id_forma => $forma)
                                            <option value="{{ $id_forma }}" @if(Auth::user()->formadepago == $id_forma) selected @endif>{{ $forma }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="input_wrap col-md-6 col-sm-12">
                                        <label>Correo / Mensajería</label>
                                        <select class="form-control mb-2" name="formadeenvio">
                                            @foreach($formas_envio as $id_forma => $forma)
                                            <option value="{{ $id_forma }}" @if(Auth::user()->formadeenvio == $id_forma) selected @endif>{{ $forma }}</option>
                                            @endforeach
                                        </select>
                                    </div>  
                                    <div class="col-sm-12">
                                        <p>*Los datos ingresados serán los datos de envío, en caso de modificación avisarle al vendedor.</p>
                                    </div>
                                </div>
                                <div class="row pt-20">
                                    <div class="input_wrap offset-md-3 col-md-6 col-sm-12">
                                        <button type="submit">Guardar cambios</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection