<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Controllers\CarritoController;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Logo;
use App\Setting;
use App\Sexo;
use App\Categoria;
use App\Producto;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $formas_pago = [
            'Efectivo'              => 'Efectivo (Rapipago o Pago Fácil)',
            'Transferenciabancario' => 'Transferencia',
            'Depositobancario'      => 'Deposito',
            'TarjetaDebito'         => 'Tarjeta de Débito',
            'TarjetaCredito'        => 'Tarjeta de Crédito'
        ];
        $formas_envio = [
            'Moto'            => 'Moto (Capital y Alrededores)',
            'Viacargo'        => 'Vía cargo',
            'TransportesAnk'  => 'Transportes Ank',
            'CruceroExpress'  => 'Crucero Express',
            'BusPack'         => 'Bus Pack',
            'Ctc'             => 'Central de Cargas Terrestres',
            'EcaPack'         => 'Eca Pack',
            'NuevoExpreso'    => 'Nuevo Expreso',
            'ExpresoDemonte'  => 'Expreso Demonte',
            'ElRapido'        => 'El Rápido',
            'ElVasquito'      => 'El Vasquito',
            'Tascar'          => 'Expreso Tascar',
            'CorreoArgentino' => 'Correo Argentino',
            'Andreani'        => 'Andreani',
            'Oca'             => 'Correo Oca',
            'Otro'            => 'Otro (Consulto alternativas)<',
        ];
        $negro = Logo::find(1);
        $blanco = Logo::find(1);
        $favicon = Logo::find(3);
        $sexos = Sexo::all();
        $tienda = Setting::find(1);
        $categorias_menu = [];
        $categorias_ids = Categoria::where('activado', 1)->get()->pluck('nombre', 'id');
        foreach ($categorias_ids as $id => $nombre) {
            $categorias_menu[$id]['nombre'] = $nombre;
            $categorias_menu[$id]['productos'] = Producto::where('categoria_id', $id)->where('activado', 1)->limit(5)->get()->pluck('descripcion', 'id');
        }

        return view()->share(
            compact(
                'negro', 
                'blanco', 
                'favicon', 
                'sexos', 
                'tienda', 
                'categorias_menu',
                'formas_pago',
                'formas_envio'
            )
        );
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
