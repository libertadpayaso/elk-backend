											@if($stocks->count() > 0)
											@foreach($stocks as $stock)
												<div class="size pt-10">
						                        	<span><input type="checkbox" name="talle[]" value="{{$stock->talle_id}}"> Talle {{$stock->talle->talle}}</span>
						                            <span><input type="number" name="cantidad[]" min="1" max="{{$stock->stock}}" value="1" disabled></span>
						                            <span>Stock: {{$stock->stock}}</span>
						                        </div>
											@endforeach
											@else
												<div class="size pt-10">
						                            <span>Sin stock disponible</span>
						                        </div>
											@endif