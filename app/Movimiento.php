<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    const TIPO_PEDIDO = 'PED';
    const TIPO_MANUAL = 'MAN';

    protected $fillable = [
        'pedido_id', 'usuario_id','concepto', 'tipo', 'monto', 'subtotal',
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
