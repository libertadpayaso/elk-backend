<!DOCTYPE html>

<html>
<head>
	<title>Pedidos pagados sin armar</title>
	<style type="text/css">
		html{
			font-family:erasbold;
		}
		table{
			border-collapse: collapse;
			border:1px solid black;
			margin: auto;
			width: 100%;
			font-family:erasbold;
		}
		tbody td{
			padding: 15px;
			border:1px solid black;
			width: 50%;
			font-family:erasbold;
		}
		h1{
			text-align: center;
			font-family:erasbold;
		}
		h2{
			text-align: center;
			margin: 0 0 10px 0;
			font-family:erasbold;
		}
		p{
			margin: 10px 0;
			font-family:eraslight;
		}
		h4{
			text-align: right;
			font-weight: bolder;
		}

		.psinarmar {
			background-size: 100px;
		}
	</style>

	<script src="https://use.fontawesome.com/c3d13979f5.js"></script>

</head>

<body>

	@if(count($pedidos)==0)
		<h1>No hay pedidos Pagados sin armar</h1>
	@else
		@foreach($pedidos as $pedido)
		@if($loop->index%2==0)
		<table>
			<tbody>
				<tr>
				@endif
					<td>
						<h3 style="font-family:erasbold; margin-top: 0px;">{{$pedido->client->nombre}}</h3>
						<p style="font-family:erasbold; text-transfom:uppercase;">{{$pedido->client->localidad}} / {{$pedido->client->provincia}}</p>
						<p style="font-family:eraslight;">Dni/Cuit: {{$pedido->client->cuit}}</p>
						<p style="font-family:eraslight;">Dirección: {{$pedido->client->direccion}}</p>
						<p style="font-family:eraslight;">Celular: {{$pedido->client->celular}}</p>
						<h4>Envio: {{$pedido->client->formadeenvio}} </h4>
						@if($pedido->resumen && $pedido->resumen->observaciones != '')<p style="font-family:eraslight;">Notas: {{$pedido->resumen->observaciones}}</p>@endif
						<p><img  src="{{ asset('assets/img/logos/SINARMAR2021.svg') }}" alt="Logo del sitio" style="width: 200px;"></p>
					</td>
		@if($loop->index%2!=0)	
				</tr>
			</tbody>
		</table>
		@endif
		@endforeach
				@if(count($pedidos)%2!=0)
					<td></td>
				</tr>
			</tbody>
		</table>
		@endif
	@endif
</body>
</html>