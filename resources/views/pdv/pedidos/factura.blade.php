@php
	$total = 0;
@endphp
<!DOCTYPE html>
<html>
<head>
	<title>Detalle del pedido {{$pedido->id}}</title>
	<style type="text/css">
		html{
			font-family: Arial, Helvetica, sans-serif;
		}
		table{
			border-collapse: collapse;
			border:2px solid grey;
			margin: auto;
			font-size: 13px;
			width: 100%;
			/*559 x 794*/
		}
		tbody td,tfoot td{
			text-align: center;
			padding: 5px;
			border:1px solid grey;
		}
		thead td{
			text-align: center;
			padding: 5px;
		}
		thead .datos{
			border:1px solid grey;
			text-align: left;
		}
		td img{
			max-width: 100px;
			text-align: center;
		}
		p{
			margin: 0;
			font-size: 11px;
		}
		label{
			font-size: 10px;
		}
		tfoot{
			border-top:2px solid grey;
		}
		tbody tr:nth-child(odd), tfoot tr{
			background-color: #e8e8e8;
		}
	</style>
	<script src="https://use.fontawesome.com/c3d13979f5.js"></script>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>
	<table>
		<thead>
			<tr>
				<td colspan="2">
					<img src="{{ $fileHelper->getBase64('assets/img/logos/logoelknegro.jpg') }}">
				</td>
				<td colspan="2">
					{{$carbon->format("d/m/y")}}<br>
					<label>Documento no valido como factura</label>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<p>NOS MUDAMOS</p>
					<p>Av. Avellaneda 3593 | Flores</p>
				</td>
				<td colspan="2" rowspan="2">
					<p>Facebook: elk ideas deportivas</p>
					<p>Instagram: @elkideasdeportivas</p>
					<p>elkideasdeportivas.com.ar</p>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<p>Catálogo por Whatsapp:<br>(011) 15-3389-2786</p>
				</td>
			</tr>
			<tr>
				@if(isset($nombre))
				<td class="datos" colspan="4"><b>Para:</b> {{$nombre}}</td>
				@else
				<td class="datos" colspan="4">-</td>
				@endif
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><b>Cantidad</b></td>
				<td><b>Descripción</b></td>
				<td><b>Precio</b></td>
				<td><b>Importe</b></td>
			</tr>
			@foreach($resumen as $linea)
			<tr>
				@php
					$subtotal = $linea['cantidad']*$linea['precio'];
					$total += $subtotal;
				@endphp
				<td>{{$linea['cantidad']}}</td>
				<td>{{$linea['nombre']}}</td>
				<td>${{$linea['precio']}}</td>
				<td>${{$subtotal}}</td>
			</tr>
			@endforeach
			@if(count($resumen)<17)
			@for ($i = 0; $i<17-count($resumen); $i++)
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td>-</td>
			</tr>
			@endfor
			@endif
		</tbody>
		<tfoot>
			<tr>
				<td colspan="2"></td>
				<td><b>TOTAL</b></td>
				<td><b>${{$total}}</b></td>
			</tr>
		</tfoot>
	</table>
</body>
</html>