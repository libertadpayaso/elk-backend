@php
	$total = 0;
@endphp
<!DOCTYPE html>
<html>
<head>
	<title>Detalle del pedido</title>
	<style type="text/css">
		@page {
            margin: 0px 0px 0px 0px !important;
            padding: 0px 0px 0px 0px !important;
        }
		@font-face {
			font-family: 'Antonio';
			font-style: normal;
  			font-weight: normal;
			src: url({{ asset('assets/fonts/ANTONIO-REGULAR.TTF') }}) format('truetype');
		}
		@font-face {
			font-family: 'Scratchy';
			font-style: normal;
  			font-weight: normal;
			src: url({{ asset('assets/fonts/PERFECTLY SCRATCHY.TTF') }}) format('truetype');
		}
		@font-face {
			font-family: 'ErasLight';
			font-style: normal;
  			font-weight: normal;
			src: url({{ asset('assets/fonts/ERASLGHT.TTF') }}) format('truetype');
		}
		@font-face {
			font-family: 'ErasBold';
			font-style: normal;
  			font-weight: normal;
			src: url({{ asset('assets/fonts/ERASBD.TTF') }}) format('truetype');
		}
		html{
			font-family: 'ErasLight';
			font-weight: normal;
		}
		body{
			width:20.3cm;
			background-color: #eaeaea;
			padding: 20px;
		}
		img{
		    margin: auto;
		    width: 300px;
		    display: block;
		}
		label{
			font-family: 'Antonio';
			font-weight: normal;
			color: white;
			background-color: #cc4ea6;
			text-transform: uppercase;
			font-size: 30px;
			padding: 0px 20px 8px 20px !important;
			display: inline-block;
		}
		th{
			font-size: 25px;
		}
		table{
			width: 100%;
			margin-bottom: 30px;
		}
		td{
			padding: 5px;
			font-size: 17px;
		}
		th,
		.title{
			font-family: 'Scratchy';
			font-weight: normal;
			text-align: center;
		}
		.title{
			font-size: 20px;
		}
		.precio,
		.articulo{
			font-family: 'ErasBold';
			font-weight: normal;
		}
		.precio{
			color: #cc4ea6;
		}
		.talle{
			text-align: center;
		}
	</style>
	<script src="https://use.fontawesome.com/c3d13979f5.js"></script>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>
	<p class="title">LISTA DE PRECIOS | MAYORISTA | {{strtoupper($carbon->formatLocalized('%B'))}} / {{$carbon->format('Y')}}</p>
	@foreach($categorias as $categoria)
	<label>{{$categoria->nombre}}({{$categoria->sexo->nombre}})</label>
	<table>
		<thead>
			<tr>
				<th>ARTICULO</th>
				<th>DESCRIPCIÓN</th>
				<th>PRECIO</th>
				<th>TALLES</th>
			</tr>
		</thead>
		<tbody>
			@foreach($categoria->productos()->where('catalogo', 1)->get() as $producto)
			<tr>
				<td class="articulo">{{$producto->nombre}}</td>
				<td class="descripcion">
				@php
					if (strlen($producto->descripcion)>40) {
						$descripcion = substr($producto->descripcion, 0, 40).'...';
					}else{
						$descripcion = $producto->descripcion;
					}
				@endphp	
					{{$descripcion}}</td>
				<td class="precio">${{$producto->precio}}</td>
				<td class="talle">
				@php
					$talles = [];
					foreach ($producto->talles()->get() as $talle) {
						$talles[] = $talle->id;
					}
					$tallesString = implode(' ', $talles);
				@endphp
					{{$tallesString}}
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	@endforeach
</body>
</html>