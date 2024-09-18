@extends('layouts.front')

@section('title','Inicio')
 
@section('encabezado')




        <div class="texto-encabezado text-xs-center">
            <div class="container">
                <h1 class="display-4 wow bounceIn">COMPRA MÍNIMA</h1>
                <p></p>
                <h1 class="display-4 wow bounceIn">$8000</h1>
                <div class="subtitulo" data-wow-delay=".3s">- envíos a todo el país.</div>
                <a href="{{ url('catalogo') }}" class="btn btn-primary btn-lg">Realizá tu compra</a>
                <!-- <a href="{{ url('pregfrecuentes') }}" class="btn btn-primary btn-lg">Más info</a> -->
            </div>
        </div>
        <!-- <div class="flecha-bajar text-xs-center">
            <a data-scroll href="#agencia" style="background-color: black;font-size: 2rem;font-weight: 300;
    line-height: 1.2;font-family: 'trebuchetitalic';padding: 15px;">+INFO <i class="fa fa-angle-down" aria-hidden="true"></i></a>
        </div> -->
@endsection

@section('main')




    <section class="preferencias">
        <!-- <article class="video">
            <video src="video/Institucional.mp4" autoplay muted loop ></video>
        </article> -->
        <div class="fotos">
            <img src="../pdf/03-2021ok-01.jpg">
            
        </div>
        <div class="fotos">
            <img src="../pdf/03-2021ok-02.jpg">
        </div>
        <div class="fotos">
            <img src="../pdf/03-2021ok-03.jpg">
            
        </div>
        <div class="fotos">
            <img src="../pdf/03-2021ok-04.jpg">
            
        </div>
        <div class="fotos">
            <img src="../pdf/03-2021ok-05.jpg">
            
        </div>
        <div class="fotos">
            <img src="../pdf/03-2021ok-06.jpg">
            
        </div>
        <div class="fotos">
            <a href="pdf/03-2021ok.pdf"class="btn btn-primary btn-lg"   download="Lista-ELK-2021-MARZO.pdf">Descargar pdf</a>
            
        </div>

        
        
        

		
    </section>
    <article class="video">
        <!-- <embed src="pdf/ListaELKweb.pdf" type="application/pdf" width="100%" height="500px" /> -->
        <video src="video/Institucional.mp4" autoplay muted loop ></video>
        </article>

    
        



    

    
    <section class="preferencias">
        <!-- <article class="video">
            <video src="video/Institucional.mp4" autoplay muted loop ></video>
        </article> -->
        

		
    </section>




	

    


    
    

    <section class="tu-mejor-eleccion pt-5">
        <div class="container">

            <h2 class="h3 text-xs-center font-weight-bold">¿Porque somos <span>tu mejor elección?</span></h2>
            <p class="text-xs-center">
                Somos fabricantes, realizamos indumentaria de primera calidad.
            </p>

            <div class="row">
                <ul class="col-xs-6 col-lg-4 text-xs-center text-lg-left">
                    <li class="wow zoomIn" data-wow-duration=".3s" data-wow-delay=".3s">
                        <i class="fa  fa-check-square-o" aria-hidden="true"></i>

                        <div class="contenedor-eleccion">
                            <h4>¿CUÁL ES LA COMPRA MÍNIMA?</h4>
                            <p class="titilonormal">La compra mínima para envíos es de $5.000. Para importes menores dirigirse a nuestro local (Cuando finalice la cuarentena) en: <div class="titilo">Av. Avellaneda 3640, Capital Federal, Galeria Universo, Local 9 de lunes a viernes de 7.00 a 16.00 hs y sábados de 8.00 a 14.00 hs.</p></div> 
                        </div>
                    </li>
                    <li class="wow zoomIn" data-wow-duration=".3s" data-wow-delay=".7s">
                        <i class="fa  fa-check-square-o" aria-hidden="true"></i>
                        <div class="contenedor-eleccion">
                            <h4>¿CUÁLES SON LAS FORMAS DE PAGO?</h4>
                            <p class="titilonormal"> 1- Transferencia o deposito en nuestra cuenta bancaria</p>
                            <p class="titilonormal"> 2- Efectivo en Rapipago o Pago facil</p>
                            <p class="titilonormal"> 3- Tarjeta débito o crédito por mercado de pago (6% de recargo del sistema mercado de pago)</p>
                            
                        </div>
                    </li>
                    <li class="wow zoomIn" data-wow-duration=".3s" data-wow-delay=".7s">
                        <i class="fa  fa-check-square-o" aria-hidden="true"></i>
                        <div class="contenedor-eleccion">
                            <h4>¿TABLA DE TALLES?</h4>
                            <img src="images/tabladetalles.svg" alt="Mundo movil2">
                            
                        </div>
                    </li>
                    

                    
                </ul>

                <div class="hidden-md-down col-lg-4">
                    <img src="images/mundo.svg" alt="Mundo movil">
                </div>
                

                 <ul class="col-xs-6 col-lg-4 text-xs-center text-lg-right">
                    <li class="wow zoomIn" data-wow-duration=".3s" data-wow-delay=".5s">
                        <i class="fa  fa-check-square-o" aria-hidden="true"></i>
                        <div class="contenedor-eleccion">
                            <h4>¿CÓMO SE REALIZAN LOS ENVÍOS?</h4>
                            <p class="titilonormal">Los envíos se realizan a todo el país. Los envíos corren por cuenta del cliente. Transportes frecuentes: <div class="titilo">Crucero express, Via cargo, Buspack, Transportes ank, Central de cargas, Nuevo expreso, y otros mas... También utilizamos para envíos los correos, andre ani, oca, correo argentino.</p></div>
                        </div>
                    </li>
                    <li class="wow zoomIn" data-wow-duration=".3s" data-wow-delay=".9s">
                        <i class="fa  fa-check-square-o" aria-hidden="true"></i>
                        <div class="contenedor-eleccion">
                            <h4>¿COSTO DE ENVÍOS?</h4>
                            <p class="titilonormal">Los transportes hacen la cotización del envío según peso, medidas, distancia de provincia o ciudad, y el valor asegurado del paquete. Por lo general nuestros clientes una compra mínima que pesa hasta 5kg están pagando alrededor de $400 a $600.</p>
                            
                        </div>
                    </li>
                    <li class="wow zoomIn" data-wow-duration=".3s" data-wow-delay="1.3s">
                        <i class="fa  fa-check-square-o" aria-hidden="true"></i>
                        <div class="contenedor-eleccion">
                            <h4>¿DEMORAS Y TIEMPOS DE ENTREGA?</h4>
                            <p class="titilonormal">Nosotros realizamos despacho los días lunes, miércoles y viernes. Una vez realizado el pedido en nuestra pagina demoramos entre 24hs para armar pedido, corroborar pagos, confirmar datos para envios, etc. por eso es importante  para agilizar los tiempos que nos envien: <div class="titilo">- Nombre completo - Comprobante de pago -Transporte preferido.</div> <p class="titilonormal">Una vez despachado en los respectivos transportes, desde ahí dependemos de la logística de cada empresa que están tardando 24hs, 48hs, 72hs hábiles.</p></div>
                        </div>
                    </li>
                </ul> 
            </div>          

        
    </section>

    

    
@endsection