<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categoria extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'sexo_id', 'nombre', 'pdv', 'imagen', 'activado', 'catalogo', 'stock',
    ];
    protected $dates = ['deleted_at'];

    public function productos()
    {
        return $this->hasMany(Producto::class);
    }
    public function sexo()
    {
        return $this->belongsTo(Sexo::class);
    }

    public function stock()
    {
        return $this->productos()->whereHas('imagenes.stock', function($q) {
            $q->where('stock', '>' , 0);
        })->where('activado' , 1)->get();
    }

    public function disponibles()
    {
        return $this->productos()->where('activado', 1)->where('stock', '>' , 0)->get();
    }
}
