<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = [
        'imagen_id', 'talle_id', 'stock',
    ];

    public function imagen()
    {
        return $this->belongsTo(Imagen::class);
    }

    public function talle()
    {
        return $this->belongsTo(Talle::class);
    }
}
