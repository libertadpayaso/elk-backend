<!DOCTYPE html>

<head>
	<style type="text/css">
		body
		{
			font-family: 'arial';
		}
		p img{
			max-width: 130px;
		}
	</style>
</head>
<html>
	<body>
		<h2>Elk Ideas Deportivas</h2>
		<h3>Comprobante de Compra</h3> 

		<p>Hola {{$nombre}}, te adjuntamos el comprobante de compra del dia {{$fecha}}</p>
		<p>Gracias por tu compra, te esperamos nuevamente.</p>
		<br>
		<p><img src="{{ asset('assets/img/logos/logoelknegro.jpg') }}"></p>
	</body>
</html>