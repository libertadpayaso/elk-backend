<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResumenPedido extends Model
{    
    protected $fillable = [
        'nombre_cliente', 'pedido_id', 'monto_total', 'fecha_pago', 'modo_pago', 'modo_envio', 'facturado','observaciones',
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }

    const MODO_PAGO = [
        1 => 'Pago en BancoHip', 
        2 => 'MP ELK', 
        3 => 'Pago en el Local', 
        4 => 'Pago en BancoLei',
        5 => 'MP EZE',
        6 => 'Pago en BancoMama'
        
        
    ];

    const MODO_ENVIO = [
        1 => 'Transporte', 
        2 => 'Correo', 
        3 => 'Retiro en el Local', 
        4 => 'Moto'
    ];
}
