<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Talle extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'id', 'talle', 'orden'
    ];

    protected $dates = ['deleted_at'];

    public function productos(){
        return $this->belongsToMany(Producto::class);
    }
}
