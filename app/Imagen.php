<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Imagen extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'producto_id', 'imagen_id', 'nombre', 'codigo', 'imagen'
    ];
    protected $dates = ['deleted_at'];

    const NO_DISPONIBLE = 'sin-imagen.jpg';

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public static function fromAlmacen($almacen_id = Stock::WEB)
    {
        return self::whereHas('stocks', function($q) use ($almacen_id) {
            $q->where('almacen_id', $almacen_id);
        });
    }
}
