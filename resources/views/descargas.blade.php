@php
	Auth::setDefaultDriver('client');
@endphp
@extends('layouts.private')

@section('title','Descargas')
 
@section('main')
		<section class="portada" style="background-image: url('{{ asset('assets/img/iconos/'.$icono->imagen) }}');">
			<div class="capa"></div>
			<div class="container">
				<h4 class="bitter">{{$icono->texto}}</h4>
			</div>
		</section>
		<main class="pt70 pb30 casos">
			<div class="container">
				<div class="row">
				    @foreach(Auth::user()->descargas()->get() as $descarga)
                    <div class="col s12 m4">
                        <div class="card caso">
                        	<a href="{{ asset('assets/img/descargas/'.$descarga->archivo) }}" download>
	                        	<div class="imagen">
	                        		<i class="material-icons">folder_shared</i>
	                        	</div>
	                        	<div class="texto center-align">
	                        		{{$descarga->titulo}}
	                        	</div>
                        	</a>
                        </div>
                    </div>
                    @endforeach
				</div>
			</div>
		</main>
@endsection