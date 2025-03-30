<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    const TIPO_PEDIDO = 'PED';
    const TIPO_MANUAL = 'MAN';
    const CUENTAS = [
        1 => 'Cuenta 1',
        2 => 'Cuenta 2',
        3 => 'Cuenta 3'
    ];

    protected $fillable = [
        'pedido_id', 'usuario_id','concepto', 'tipo', 'monto', 'descuento', 'subtotal', 'costo_envio', 'cuenta_facturacion'
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }

    public function usuario()
    {
        return $this->hasOne(User::class);
    }
}
