@extends('layouts.back')
@section('title','Facturación de Pedidos')

@section('main')
		<main>
			<div class="container-fluid">
				<div class="row">
					<div class="col s12 miga">
						<p>Facturación de Pedidos</p>
					</div>
				</div>
                <div class="row">
					<form method="GET" action="{{ url('admin/clientes/pedidos/listar-facturacion') }}" id="filtros">
						<div class="col s3 input-field">
							<select name="periodo">
								@foreach($periodos as $periodo)
								<option value="{{ $periodo->periodo }}" @if($periodo->periodo == $parametros['periodo_actual']) selected @endif>{{ $periodo->periodo }}</option>
								@endforeach
							</select>
                            <label>Periodo de Facturación</label>
						</div>
                        <div class="col s3 input-field">
							<select name="cuenta">
								@foreach($cuentas as $key => $value)
								<option value="{{ $key }}" @if($key == $parametros['cuenta_elegida']) selected @endif>{{ $value }}</option>
								@endforeach
                                <option value="0" @if(0 == $parametros['cuenta_elegida']) selected @endif>Sin Cuenta</option>
							</select>
                            <label>Cuenta de Facturación</label>
						</div>
						<input type="hidden" name="_token" value="{{ csrf_token() }}" />
					</form>
                    <form method="post" action="{{ url('admin/clientes/pedidos/descargar-facturacion') }}" id="descarga">
                        <div class="col s3 input-field">
                            <input type="submit" class="btn" value="Descargar"/>
                        </div>
                        <input type="hidden" name="periodo_elegido" value="{{ $parametros['periodo_actual'] }}" />
                        <input type="hidden" name="cuenta_elegida" value="{{ $parametros['cuenta_elegida'] }}" />
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
					</form>
				</div>
				<div class="row" >
					<div class="col s12">
						<table class="highlight bordered responsive-table" >
							<thead>
                                <th>Pedido</th>
                                <th>Fecha</th>
                                <th>Cliente</th>
                                <th>DNI/CUIT</th>
                                <th>Provincia</th>
                                <th>Monto Pedido</th>
                                <th>Monto Envío</th>
                                <th>Monto Total</th>
                                <th>Ver</th>
							</thead>
							<tbody>
								@foreach($pedidos as $pedido)
								<tr>
                                    <td># {{ $pedido->id }}</td>
                                    <td>{{ $pedido->created_at->format('d-m-Y') }}</td>
									<td>{{ $pedido->client->nombre }}</td>
									<td>{{ $pedido->client->cuit }}</td>
									<td>{{ $pedido->client->provincia }}</td>
									<td>${{ $pedido->movimiento->monto - $pedido->movimiento->costo_envio }}</td>
									<td>${{ $pedido->movimiento->costo_envio }}</td>
									<td>${{ $pedido->movimiento->monto }}</td>
                                    <td>
										<a target="_blank" href="{{ url('admin/clientes/pedidos/ver/'.$pedido->id) }}"><i class="material-icons">remove_red_eye</i></a>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>            
					</div>
				</div>
			</div>
		</main>
@endsection

@section('javascript')
		<script type="text/javascript">
			$('select[name=periodo]').change(function(event) {
				$('#filtros').submit();
			});
            $('select[name=cuenta]').change(function(event) {
				$('#filtros').submit();
			});
		</script>
@endsection