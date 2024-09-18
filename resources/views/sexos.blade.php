@php
	Auth::setDefaultDriver('client');
@endphp
@extends('layouts.front')

@section('title','Catalogo')

@section('main')
<!-- breadcrumb sssarea start -->
    <div class="page-layout d-none d-sm-block" data-background="{{ asset('assets/img/slider/shopelk3.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="breadcrumb-area text-center">
                        <h2 class="page-title">Catálogo</h2>
                            <div class="breadcrumb-menu">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb justify-content-center">
                                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Inicio</a></li>
                                    <li class="breadcrumb-item"><a href="#!">Catálogo</a></li>
                                </ol>
                            </nav>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb area end -->


                                                        
    <!-- shop page start -->
    <div class="m_service__area mb-100">
        <div class="container">
            <div class="service__wrapper text-center pt-100">
                <h2>Categorías</h2>
            </div>
            <div class="row">
            	@foreach($sexos as $item)
                <div class="col-6 col-xl-3 col-lg-3 col-md-4 ">
                	<a href="{{ url('catalogo/' . $item->nombre) }}">
                        
                        <div class="catalogoweb">
                            <div class="catalogowebtext">{{ $item->nombre }}</div>
	                        <div >
	                            
	                        </div>
	                    </div>
                        

<!--
	                    <div class="m_single_service pt-80">
	                        <div class="m_single_service__content">
	                            <h5>{{ $item->nombre }}</h5>
	                        </div>
	                    </div>
-->
	                </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- shop page end -->
@endsection