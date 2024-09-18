@extends('layouts.front')

@section('title','Contacto')

@section('main')
    <!-- contact area 2 start -->
    <div class="contact__area_2" data-background="{{ asset('assets/img/about/Contactelk3.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col xl-12 col-lg-12 col-md-12">
                    <div class="contact__inner_2 text-center">
                        <h2 class="mb-80">Contacto</h2>
                        <p>Envianos un mensaje y nos pondremos en contacto</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- contact area 2 end -->

    <!-- contact info area start -->
    <div class="contact__info_2 mb-70 pt-70">
        <div class="container">
            <div class="row text-center">
                <h2 class="mb-4">Datos de contacto</h2>
            </div>
            <div class="row">
                <div class="col-xl-4 col-lg-4 col-md-4">
                    <div class="contact-single text-center">
                        <div class="contact-single__thumb">
                            <i class="fab fa-whatsapp"></i>
                        </div>
                        <div class="contact-single__content">
                            <h3>WhatsApp</h3>
                            <h5><a href="https://api.whatsapp.com/send?phone=5491130638568">(011) 15-3063-8568</a></h5>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4">
                    <div class="contact-single text-center">
                        <div class="contact-single__thumb">
                            <i class="fab fa-instagram"></i>
                        </div>
                        <div class="contact-single__content">
                            <h3>Instagram</h3>
                            <h5><a href="https://www.instagram.com/elkideasdeportivas">instagram.com/elkideasdeportivas</a></h5>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4">
                    <div class="contact-single text-center border-0">
                        <div class="contact-single__thumb">
                            <i class="fab fa-facebook-f"></i>
                        </div>
                        <div class="contact-single__content">
                            <h3>Facebook</h3>
                            <h5><a href="https://www.facebook.com/elkideasdeportivas/">facebook.com/elkideasdeportivas</a></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- contact info area end -->

    <div class="map-2">
        <div class="google-map contact-map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d488.0261587833656!2d-58.47999599657139!3d-34.62854115386501!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1savenida%20avellaneda%203593!5e0!3m2!1ses-419!2sar!4v1616124859975!5m2!1ses-419!2sar" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </div>

    <div class="company__social text-center">
            <h3>Av. Avellaneda 3593 - Flores</h3>
        </div>
@endsection