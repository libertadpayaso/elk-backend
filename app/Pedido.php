<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pedido extends Model
{
    use SoftDeletes;

    const ESTADOS_PEDIDO = [
        0  => 'Sin procesar',
        1  => 'Entregado',
        2  => 'Contactado',
        3  => 'Cancelado',
        4  => 'Completo y pagado',
        5  => 'inCompleto',
        6  => 'Pagado SIN ARMAR',
        7  => 'Retira y Paga en local',
        8  => 'Pagado y Retira en local',
        9  => 'Completo F/PAGO',
        10 => 'Enviado al local'
    ];

    const COLORES_ESTADO = [
        0  => '#fefe8b',
        1  => '#b4ffb4',
        2  => '#d3cfff',
        3  => '#FF0000',
        4  => '#7fffd4',
        5  => '#fdcb6e',
        6  => '#dfe6e9',
        7  => '#33EEFF',
        8  => '#d8ffad',
        9  => '#ff9ee0',
        10 => '#4f8ee8'
    ];
    
    protected $fillable = [
        'client_id', 'fecha', 'estado', 'monto', 'subtotal', 'subtotal',
    ];
    
    protected $dates = ['deleted_at'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function lineas()
    {
        return $this->HasMany(Linea::class);
    }

    public function resumen()
    {
        return $this->hasOne(ResumenPedido::class);
    }

    public function calcularMonto()
    {
        $monto = 0;

        foreach ($this->lineas()->get() as $linea) {
            $monto += $linea->precio * $linea->cantidad;
        }

        return $monto;
    }
}
