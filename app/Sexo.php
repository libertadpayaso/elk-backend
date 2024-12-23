<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sexo extends Model
{
    protected $fillable = [
        'nombre'
    ];

    public function categorias()
    {
        return $this->hasMany(Categoria::class);
    }

    public function categoriasConStock()
    {
        return $this->categorias()->whereHas('productos.imagenes.stock', function($q) {
            $q->where('stock', '>' , 0);
        })->where('activado' , 1)->get();
    }

    public function disponibles()
    {
        return $this->categorias()->where('stock', '>' , 0)->where('activado' , 1)->get();
    }
}
