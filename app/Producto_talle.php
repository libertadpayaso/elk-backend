<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto_talle extends Model
{
    protected $fillable = [
        'producto_id', 'talle_id',
    ];
}
