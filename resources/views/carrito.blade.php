                @php
                    $totalReal = 0;
                @endphp
                <div class="cart-icon">
                    <i class="fal fa-times"></i>
                </div>

                <div class="cart-text" id="cart-text">
                    <h3 class="mb-40">Carrito de Compra</h3>
                    @if(Cart::count() > 0)
                    @foreach(Cart::content()  as $row)
                    <div class="add_cart_product">
                        <div class="add_cart_product__thumb">
                            <img src="{{ asset('assets/img/imagenes/'.$row->options->archivo) }}" alt="">
                        </div>
                        <div class="add_cart_product__content">
                            <h5>
                                <a href="{{ url('p/'.$row->options->producto.'/'.$row->options->url) }}">
                                    {{$row->name}}<br>Talle {{$row->options->talle}}
                                </a>
                            </h5>
                            <p>{{$row->qty}} × ${{$row->price}} @if($row->options->es_promocion)(Precio oferta)@endif</p>
                            <a href="#!" id="{{ $row->rowId }}" class="delete-item">
                                <button class="cart_close"><i class="fal fa-times"></i></button>
                            </a>
                        </div>
                        @php
                            if ($row->options->precio_descuento > 0) {
                                $totalReal += $row->options->precio_descuento * $row->qty;
                            } else {
                                $totalReal += $row->options->precio_original * $row->qty;
                            }
                        @endphp
                    </div>
                    @endforeach
                    @endif
                </div>

                <div class="cart-bottom">
                    <div class="cart-bottom__text">
                        <span>Total:</span>
                        <span class="end">${{ $total }}@if(!$esMayorista)*@endif</span>
                        @if($esMayorista)
                        <span><small>Total real:</small></span>
                        <span class="end"><small><del>${{ $totalReal }}<del></small></span>
                        @endif
                        <a href="{{ url('carrito/ver') }}">Ver Carrito</a>
                        <a href="{{ url('carrito/vaciar') }}">Vaciar Carrito</a>

                        @if(Auth::check())
                        <a href="{{ url('carrito/confirmar') }}" class="espere">Finalizar Compra</a>
                        @else
                        <a href="{{ url('carrito/solicitar') }}" class="espere">Finalizar Compra</a>
                        @endif
                    </div>
                     @if(!$esMayorista)
                    <br>
                    <p class="info">*Te faltan ${{ env("MONTO_MAYORISTA") - Cart::subtotal(0,'','') }} para obtener envío gratis por Correo Argentino</p>
                    @endif
                    <input type="hidden" name="cantidad" value="{{ Cart::count() }}"> 
                </div>