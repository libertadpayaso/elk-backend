<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Imagen extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'producto_id', 'imagen', 'pdv', 'nombre', 'codigo',
    ];
    protected $dates = ['deleted_at'];

    const NO_DISPONIBLE = 'sin-imagen.jpg';

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function stock()
    {
        return $this->hasMany(Stock::class);
    }

    public function hasStock()
    {
        return $this->whereHas('stock', function($q) {
            $q->where('stock', '>' , 0);
        })->get();
    }
}
