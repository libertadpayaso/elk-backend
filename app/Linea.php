<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Linea extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'pedido_id', 'imagen_id', 'talle_id', 'cantidad', 'precio',
    ];
    protected $dates = ['deleted_at'];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }

    public function imagen()
    {
        return $this->belongsTo(Imagen::class);
    }

    public function talle()
    {
        return $this->belongsTo(Talle::class);
    }

    public function getImagen()
    {
        if ($this->imagen) {
            $imagen = $this->imagen->imagen;
        } else {
            $imagen = Imagen::NO_DISPONIBLE;
        }

        return $imagen;
    }
}
