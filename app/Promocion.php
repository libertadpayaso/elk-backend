<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promocion extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nombre', 'cantidad', 'precio', 'activa'
    ];
    protected $table = 'promociones';
    protected $dates = ['deleted_at'];

    public function productos(){
        return $this->belongsToMany(Producto::class);
    }
}
