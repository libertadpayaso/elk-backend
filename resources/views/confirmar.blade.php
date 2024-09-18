@extends('layouts.front')

@section('title','Confirmar Transacción')

@section('main')
    <div class="checkout_area pt-80">
        <div class="container">
            <div class="notification__message">
                <p><i class="fal fa-check-circle"></i>Tu pedido se ha realizado satisfactoriamente</p>
            </div>
            <p>* En breve te contactaremos por whatsapp para corroborar pagos y finalizar la compra.</p>
            <div class="row">
                <div class="col-md-12">
                    <div class="cart__acount">
                        <h5>Formas de Pago que podés realizar</h5>
                        <div class="row">
                            <div class="col-md-8 offset-md-2 col-xs-12">
                                <div class="checkout__accordion mt-30">
                                    <div class="accordion" id="accordionExample">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingOne">
                                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Transferencia Bancaria(Sin recargo)</button>                                            
                                            </h2>
                                            
                                            
                                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <img src="{{ asset('assets/images/pagos/logobanco.svg') }}">
                                                    <p class="chicoo">Realiza el pago por medio de TRANSFERENCIA o DEPÓSITO (Sin recargos)</p>
                                                    <p class="chicoo">TENEMOS BANCO HIPOTECARIO Y BANCO PROVINCIA</p>
                                                    <a target="_blank" href="https://api.whatsapp.com/send?phone=5491130638568"><button>Pedir datos</button></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingTwo">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Efectivo en nuestro local(Sin recargo)</button>
                                            </h2>
                                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <img src="{{ asset('assets/images/pagos/Pagarefectivo.svg') }}">
                                                    <p>Pagá y retira tu pedido en nuestro local. Recibimos comisionistas.</p>
                                                    <a target="_blank" href="https://api.whatsapp.com/send?phone=5491130638568">
                                                        <button>Mas información</button></a>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingThree">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">Tarjetas crédito/debito, rapipago, pagofacil (+10% adicional)</button>
                                            </h2>
                                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <img src="{{ asset('assets/images/pagos/MercadoPago2.svg') }}">
                                                    <p>Si querés pagar por tarjeta credito, debito, rapipago, pagofácil te ofrecemos el sistema de MercadoPago (+10% adicional)</p>
                                                     <a target="_blank" href="https://api.whatsapp.com/send?phone=5491130638568"><button>Pedir lINK DE PAGO </button></a>
<!--                                                    <a target="_blank" href="{{url('carrito/mercadopago/' . $pedido_id)}}"><button>Pagar</button></a>-->
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="terms pb-20">
                            <img src="{{ asset('assets/images/LogosArgentina.png') }}">
                            <h5>¿Cuáles son los pasos a seguir?</h5>
                            <p>Nosotros te contáctaremos para corroborar los pagos, y confirmar la forma de envío</p>
                            <h5>Una vez que pago, ¿cuando me envian el paquete?</h5>
                            <p>Si el pago esta realizado antes del medio día, tu pedido lo despachamos ese mismo día(Tiene que ser dia hábil)</p>
                            <h5>¿Como es el tema de los envíos?</h5>
                            <p>Trabajamos con todos los transportes.Si tenes uno preferencial te lo enviamos por ahi.En envio económico podemos ofrecerte por correo argentino (a sucursal), 
aparte de ser económico llega mas rápido (3 días hábiles). Vas a pagar de $3500 a $4500</p>
                            <h5>¿Puedo contáctarme directamente con mi vendedor?</h5>
                            <p>Sí, cualquier inquietud o consulta que quieras hacer sobre tu pedido realizado podés hacerlo con nuestra linea directa:<br><a href="https://api.whatsapp.com/send?phone=5491130638568"><i class="fab fa-whatsapp"></i> (011) 15 3063-8568</a></p>
                        </div>
                    </div>    
                </div>
            </div>
        </div>
    </div>
@endsection