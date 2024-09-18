@php
	$csrf_token = csrf_token();
	$parameters = [];
    $parameters['page'] = (isset($_GET['page'])) ? $_GET['page'] : 1 ;
@endphp
@extends('layouts.back')
@section('title','Resumenes de Pedidos')

@section('main')
		<main>
			<div class="container-fluid">
				<div class="row">
					<div class="col s12 miga">
						<p>Resumenes de Pedidos</p>
					</div>
					@if(count($errors) > 0)
					<div class="col s12 card-panel red lighten-4 red-text text-darken-4">
						<ul>
							@foreach($errors->all() as $error)
								<li>{!!$error!!}</li>
							@endforeach
						</ul>
					</div>
					@endif
					@if(session('success'))
					<div class="col s12 card-panel green lighten-4 green-text text-darken-4">
						{{ session('success') }}
					</div>
					@endif
				</div>
				<div class="row">
					<div class="col s12">
						<ul class="pagination center">
							<li class="@if($parameters['page'] == 1) disabled @else waves-effect @endif">
								<a href="{{ url('admin/clientes/pedidos') . updateURL($parameters, ['page' => 1]) }}">
									<i class="material-icons">chevron_left</i>
								</a>
							</li>
							@for ($i = 1; $i <= $paginas; $i++)
							<li class="@if($parameters['page'] == $i) active @else waves-effect @endif">
								<a href="{{ url('admin/clientes/pedidos') . updateURL($parameters, ['page' => $i]) }}">{{ $i }}</a>
							</li>
							@endfor
							<li class="@if($parameters['page'] == $paginas) disabled @else waves-effect @endif">
								<a href="{{ url('admin/clientes/pedidos') . updateURL($parameters, ['page' => $paginas]) }}">
									<i class="material-icons">chevron_right</i>
								</a>
							</li>
						</ul>
					</div>
				</div>
				<!-- <button type="button" onclick="javascript:imprim2();">Imprimir</button> -->
				<div class="row" >
					<div class="col s12">
						<table class="highlight bordered responsive-table" >
							<thead >
								<td>Cliente</td>
								<td>Pedido</td>
								<td>Monto Total</td>
								<td>Fecha de Alta</td>
								<td>Fecha de Pago</td>
								<td>Modo de Pago</td>
								<td>Modo de Envio</td>
								<td>Facturación</td>
								<td>Ver</td>
							</thead>
							<tbody>
								@foreach($resumenes as $resumen)
								<tr>
									<td >
										{{ $resumen->nombre_cliente }}
									</td>
									<td >
										# {{ $resumen->pedido_id }}
									</td>
									<td>
										{{ $resumen->monto_total }}
									</td>
									<td >
										@if($resumen->created_at){{ \Carbon\Carbon::parse($resumen->created_at)->format('d-m-Y') }}@endif
									</td>
									<td >
										@if($resumen->fecha_pago){{ \Carbon\Carbon::parse($resumen->fecha_pago)->format('d-m-Y') }}@endif
									</td>
									<td >
										@if($resumen->modo_pago && isset($modosPago[$resumen->modo_pago])) {{ $modosPago[$resumen->modo_pago] }} @endif
									</td>
									<td >
										@if($resumen->modo_envio && isset($modosEnvio[$resumen->modo_envio])) {{ $modosEnvio[$resumen->modo_envio] }} @endif
									</td>
									<td >
										@if($resumen->facturado == 1) Facturado @endif
									</td>
									<td >
										<a href="{{ url('admin/clientes/pedidos/resumen/'.$resumen->id) }}" target="_blank"><i class="material-icons">remove_red_eye</i></a>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>            
					</div>
				</div>
				<div class="row">
					<div class="col s12">
						<ul class="pagination center">
							<li class="@if($parameters['page'] == 1) disabled @else waves-effect @endif">
								<a href="{{ url('admin/clientes/pedidos') . updateURL($parameters, ['page' => 1]) }}">
									<i class="material-icons">chevron_left</i>
								</a>
							</li>
							@for ($i = 1; $i <= $paginas; $i++)
							<li class="@if($parameters['page'] == $i) active @else waves-effect @endif">
								<a href="{{ url('admin/clientes/pedidos') . updateURL($parameters, ['page' => $i]) }}">{{ $i }}</a>
							</li>
							@endfor
							<li class="@if($parameters['page'] == $paginas) disabled @else waves-effect @endif">
								<a href="{{ url('admin/clientes/pedidos') . updateURL($parameters, ['page' => $paginas]) }}">
									<i class="material-icons">chevron_right</i>
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</main>
@endsection

@section('javascript')
		<script type="text/javascript">
			$('input[name=filter]').keyup(function(event) {
				var filter = $(this).val().toLowerCase();
				// Loop through all table rows, and hide those who don't match the search query
				$('tbody tr').each(function(index, el) {
					if (el.children['1'].innerText.toLowerCase().indexOf(filter) > -1) {
						$(this).css('display', '');
					} else {

						$(this).css('display', 'none');
					}
				});
				celdas = $('table tbody tr:visible').length;
				if (celdas == 0) {
					$('tfoot').css('display', '');
				} else {
					$('tfoot').css('display', 'none');
				}
			});
		</script>
@endsection