@extends('layouts.pdv')

@section('title','Lista de Pedidos')
 
@section('main')
		<main>
			<div class="container">
				<div class="row">
					<div class="col 12 miga">
						<p>
							Pedidos
						</p>
					</div>
				</div>
				<div class="row">
					<div class="col s12">
						<a href="{{ url('admin/pdv/pedidos/nuevo') }}">
							<button class="btn waves-effect waves-light right">Nuevo
								<i class="material-icons right">add_to_photos</i>
							</button>
						</a>
					</div>
				</div>
				<div class="row">
					@isset($pedido_id)
					<div class="col s12 card-panel green lighten-4 green-text text-darken-4 center">
						El pedido <b>#{{$pedido_id}}</b> fue creado
					</div>
					@endisset
					<div class="col s12">
						<table class="highlight bordered responsive-table" >
							<thead >
								<td>Nº</td>
								<td>Fecha</td>
								<td>Estado</td>
								<td>Ver</td>
							</thead>
							<tbody>
								@foreach($pedidos as $pedido)
								<tr style="background-color: {{ $colores[$pedido->estado] }}">
									<td >
										#{{ $pedido->id }}
									</td>
									<td >
										{{ $pedido->created_at }}
									</td>
									<td >
										<select name="estado" pedido="{{ $pedido->id }}" @if($pedido->estado==3) disabled @endif>
											@foreach($estados as $key => $estado)
											<option value="{{$key}}" @if($key==$pedido->estado) selected @endif>{{$estado}}</option>
											@endforeach
										</select>
									</td>
									<td >
										<a href="{{ url('admin/pdv/pedidos/ver/'.$pedido->id) }}"><i class="material-icons">remove_red_eye</i></a>
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
			$('select[name=estado]').change(function(event) {
				var id = $(this).attr('pedido');
				var estate = $(this).val();
				var index = $('select[name=estado]').index(this);
				if (estate==3)
				{				
					if(confirm('¿Seguro desea cancelar la operacion? Este es un proceso irreversible'))
					{
						update(id, estate, index);
						$(this).attr('disabled');
					}
				}
				else
				{
					update(id, estate, index);

				}
			});

			function update(id, estate, index){
				
				$.ajax({
					url: '{{ url('admin/pedido') }}/'+id,
					type: 'POST',
					data: {
						estado: estate,
						_method: 'PUT',
						_token: '{{ csrf_token() }}'
					},
				})
				.done(function(data) {
					$('table.responsive-table tbody tr').eq(index).css('background-color', data);
				});
			}

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