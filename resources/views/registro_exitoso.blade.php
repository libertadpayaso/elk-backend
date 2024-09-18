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
            <div class="notification__message">
                <p><i class="fal fa-check-circle"></i>El registro se ha completado exitosamente.</p>
            </div>
            <div class="login_wrapper">
            	<h4>Ya puede ingresar al área de <a href="{{ url('/#nuevo') }}" class="alert-link">COMPRA</a> para elegir sus productos</h4>
            </div>
        </div>
    </div>
@endsection