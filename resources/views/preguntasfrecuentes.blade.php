@extends('layouts.front')

@section('title','Preguntasfrecuentes')

@section('main')
<!-- breadcrumb area start -->
  <div class="page-layout about" data-background="assets/img/page/About-us3.jpg">
      <div class="container">
          <div class="breadcrumb-area text-center">
              <h2 class="page-title">Preguntas frecuentes</h2>
              <p>Preguntas y respuestas más frecuentes</p>
          </div>
      </div>
  </div>
  <!-- breadcrumb area end -->


  <!-- faq area start  -->
  <div class="faq__area pt-110 mb-110">
      <div class="container">
          <div class="row">
              <div class="col-xl-6 col-lg-6">
                  <div class="title-5 mb-50 pl-20">Información de compras</div>
                  <div class="accordion mb-30">
                      <div class="accordion-item c-item ">
                        <h2 class="accordion-header">
                          <button class="accordion-button collapsed c-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                              ¿Info mayorista?
                          </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse">
                          <div class="accordion-body">
                            <p>Somos fabricantes de ropa deportiva por lo cuál realizamos venta mayorista a revendedores, y hacemos venta minorista (c/recargo) a clientes en nuestro local.</p>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="accordion mb-30">
                      <div class="accordion-item c-item ">
                        <h2 class="accordion-header">
                          <button class="accordion-button collapsed c-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseOne">
                              ¿Cuál es la compra mínima?
                          </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse">
                          <div class="accordion-body">
                            <p>La compra mínima en nuestra tienda online son 3 prendas (pueden ser surtidas en modelo, talles o color). Por eso el carrito de compras te habilita el boton de "finalizar la compra" una vez q cargas tu 3er producto.</p>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="accordion mb-30">
                      <div class="accordion-item c-item ">
                        <h2 class="accordion-header">
                          <button class="accordion-button collapsed c-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="true" aria-controls="collapseOne">
                              ¿Hacen envios al interior?
                          </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse">
                          <div class="accordion-body">
                            <p>Si, Hacemos envíos a todo el país. utilizamos correos o transportes que llegan a diferentes ciudades. </p>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="accordion mb-30">
                      <div class="accordion-item c-item ">
                        <h2 class="accordion-header">
                          <button class="accordion-button collapsed c-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="true" aria-controls="collapseOne">
                              ¿Con que transportes envian?
                          </button>
                        </h2>
                        <div id="collapseFour" class="accordion-collapse collapse">
                          <div class="accordion-body">
                            <p>Trabajamos con todos los transportes. Si tenes uno preferencial te lo enviamos por ahí. En envíos económico podemos ofrecerte correo argentino con envio a sucursal, 
aparte de ser económico llega mas rápido. Vas a pagar de $600 a $800 (Esta cotización la realiza el correo).</p>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="accordion mb-30">
                      <div class="accordion-item c-item ">
                        <h2 class="accordion-header">
                          <button class="accordion-button collapsed c-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="true" aria-controls="collapseOne">
                              ¿Envian por moto?
                          </button>
                        </h2>
                        <div id="collapseFive" class="accordion-collapse collapse">
                          <div class="accordion-body">
                            <p>El sevicio de motomensajeria es tercerizado, nosotros una vez q esta abonado el pedido, le pasamos los datos a los chicos para q coordinen el pago del viaje y la entrega. (Una vez que le entregan el paquete le pagan a ellos el costo de envio ya acordado con anticipación)</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  <div class="accordion mb-30">
                      <div class="accordion-item c-item ">
                        <h2 class="accordion-header">
                          <button class="accordion-button collapsed c-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="true" aria-controls="collapseOne">
                              ¿Que es compra por curva?
                          </button>
                        </h2>
                        <div id="collapseSix" class="accordion-collapse collapse">
                          <div class="accordion-body">
                            <p>Comprar por curva es que compras de un modelo una por talle. Puede ser colores surtido pero tiene que ser una por toda la curva de talles. Ejemplo: Las calzas generalmente vienen del 1 al 6, serían 6 prendas(una de cada talle)</p>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="accordion mb-30">
                      <div class="accordion-item c-item ">
                        <h2 class="accordion-header">
                          <button class="accordion-button collapsed c-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="true" aria-controls="collapseOne">
                              ¿Si compro por curvas de talles obtengo mejor precio?
                          </button>
                        </h2>
                        <div id="collapseSix" class="accordion-collapse collapse">
                          <div class="accordion-body">
                            <p>Si tu compra es por curva de talles podemos ofrecerte un descuento del 10% en el monto final. Solo tenes q mandarnos: 1- Número de articulo 2- Cantidad de curvas por articulo</p>
                              <p>En este caso se ponen colores surtidos dependiendo el modelo, sino podés elegir todo de un mismo color tambien.</p>
                          </div>
                        </div>
                      </div>
                    </div>

              </div>
              <div class="col-xl-6 col-lg-6">
                  <div class="title-5 mb-50 pl-20">Información del pago</div>
                  <div class="accordion mb-30">
                      <div class="accordion-item c-item ">
                        <h2 class="accordion-header">
                          <button class="accordion-button collapsed c-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapsseven" aria-expanded="true" aria-controls="collapseOne">
                              ¿Que formas de pago aceptan?
                          </button>
                        </h2>
                        <div id="collapsseven" class="accordion-collapse collapse">
                          <div class="accordion-body">
                            <p>Los pedidos de la web aceptamos transferencia(sin recargo), si quieren pagar con tarjeta de crédito/débito, rapipago, pagofacil le enviamos un link de mercado pago(c/recargo del 10%) en donde van a poder seleccionar cualquiera de esas formas de pago.</p>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="accordion mb-30">
                      <div class="accordion-item c-item ">
                        <h2 class="accordion-header">
                          <button class="accordion-button collapsed c-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseeight" aria-expanded="true" aria-controls="collapseOne">
                              ¿Cuánto tardará la entrega?
                          </button>
                        </h2>
                        <div id="collapseeight" class="accordion-collapse collapse">
                          <div class="accordion-body">
                            <p>Ni bien corroboramos el pago, despachamos tu pedido(Si el pago ingresa por la mañana se realiza ese mismo día) Luego dependerá de la logística del transporte o correo, que generalmente tardan de 3 a 7 días hábiles</p>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="accordion mb-30">
                      <div class="accordion-item c-item ">
                        <h2 class="accordion-header">
                          <button class="accordion-button collapsed c-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapsenne" aria-expanded="true" aria-controls="collapseOne">
                              ¿Qué sucede exactamente después de realizar el pedido?
                          </button>
                        </h2>
                        <div id="collapsenne" class="accordion-collapse collapse">
                          <div class="accordion-body">
                            <p>Una vez que ingresa tu pedido a nuestro sistema, te contáctamos al número de whatsapp que regístraste, te enviamos el detalle y los datos para transferencia. una vez corroborado el pago realizamos el depacho de tu pedido y te enviamos el número de seguimiento de pedido.</p>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="accordion mb-30">
                      <div class="accordion-item c-item ">
                        <h2 class="accordion-header">
                          <button class="accordion-button collapsed c-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseten" aria-expanded="true" aria-controls="collapseOne">
                              ¿Tienen lista de precios?
                          </button>
                        </h2>
                        <div id="collapseten" class="accordion-collapse collapse">
                          <div class="accordion-body">
                            <p><a href="{{ url('catalogo/lista-de-precios') }}">VER LISTA DE PRECIOS </a></p>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="accordion mb-30">
                      <div class="accordion-item c-item ">
                        <h2 class="accordion-header">
                          <button class="accordion-button collapsed c-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseeleven" aria-expanded="true" aria-controls="collapseOne">
                              ¿Tienen catálogo?
                          </button>
                        </h2>
                        <div id="collapseeleven" class="accordion-collapse collapse">
                          <div class="accordion-body">
                            <p>Decidimos que la mejor forma que tiene un revendedor para comprar es directo de la página web ya que actualizamos el stock todo el tiempo, en nuestra tienda online podés mirar los modelos, fotos, colores, talles, cantidad de prendas por talle y precios. Comparado con un catalogo(pdf) que queda desactualizado en poco tiempo, y hay que renovarlo constantemente. Por eso recomendamos que ingresen a la pagina y hagan su pedido de ahi mismo.</p>
                              <p>Hace tu pedido, mira los modelos, fotos, colores, talles y precios en el siguiente link <a href="{{ url('https://elkideasdeportivas.com.ar/productos') }}" class="alert-link">Tienda</a></p>                              
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="accordion mb-30">
                      <div class="accordion-item c-item ">
                        <h2 class="accordion-header">
                          <button class="accordion-button collapsed c-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapsetwelve" aria-expanded="true" aria-controls="collapseOne">
                             ¿Puedo pasar mi pedido por whatsapp?
                            </button>
                        </h2>
                        <div id="collapsetwelve" class="accordion-collapse collapse">
                          <div class="accordion-body">
                            <p>Claro que sí, solo requerimos que sea en orden. Tienen que mandarnos la foto, el talle y cantidad. Luego nosotros le armamos el detalle y se lo mandamos con el total</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  
                  <div class="accordion mb-30">
                      <div class="accordion-item c-item ">
                        <h2 class="accordion-header">
                          <button class="accordion-button collapsed c-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapsetwelve" aria-expanded="true" aria-controls="collapseOne">
                             ¿Puedo realizar cambios?
                            </button>
                        </h2>
                        <div id="collapsetwelve" class="accordion-collapse collapse">
                          <div class="accordion-body">
                            <p>Si, toda nuestra mercaderia tiene cambio. Los cambios se realizan únicamente en el local ubicado en Av. Avellaneda 3593. El cambio es por talle unicamnete, sin excepción</p>
                          </div>
                        </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <!-- faq area end  -->
    
@endsection