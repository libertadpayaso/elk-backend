@extends('layouts.front')

@section('title','Nosotros')

@section('encabezado')
		<div class="texto-encabezado text-xs-center">
			<div class="container">
				<h1 class="display-4">Nosotros</h1>
				<p class="wow bounceIn" data-wow-delay=".3s">¿Quienes somos? y ¿Que hacemos?.</p>
			</div>
		</div>
@endsection

@section('main')
	<section class="ruta">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<a href="{{ url('/') }}">Inicio</a> » Nosotros

				</div>
			</div>
		</div>
	</section>

	<main class="py-5">
		<div class="container">
			<div class="row">
				<article class="col-md-8 mb-4">
				   <h2>¿Quienes somos?</h2>
					<p>Somos una empresa nacional dedicada a la fabricación y comercialización de indumentaria deportiva. Nuestras prendas están confeccionadas con materiales de primera calidad, para garantizar la excelencia en las terminaciones.</p>

					<div id="accordion" role="tablist" aria-multiselectable="true">
						<div class="panel panel-default">

							<h4 class="panel-heading">
								<a data-toggle="collapse" data-parent="#accordion" href="#tab-mision"> MISIÓN </a>
							</h4>
							<div id="tab-mision" class="panel-collapse collapse in">
								<p>Buscamos resaltar la belleza particular de cada mujer.</p>
							</div>
						</div>

						<div class="panel panel-default">
							<h4 class="panel-heading">
								<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#tab-vision" >VISIÓN</a>
							</h4>
							<div id="tab-vision" class="panel-collapse collapse">
								<p>Esperamos formar parte de tu vida y acompañarte en los mejores momentos.</p>

							</div>
						</div>
					</div>
				</article>

				<aside class="col-md-4">
					<img src="images/nosotros.svg" alt="Nosotros">
				</aside>
			</div>
		</div>
	</main>
@endsection