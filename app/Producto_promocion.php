<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto_promocion extends Model
{
    protected $fillable = [
        'producto_id', 'promocion_id',
    ];
}
