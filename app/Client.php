<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;

class Client extends \Eloquent implements Authenticatable
{
    use AuthenticableTrait;

    protected $fillable = [
        'nombre', 'celular', 'localidad', 'provincia', 'direccion','cuit','usuario', 'password', 'habilitado', 'tipo', 'formadepago', 'formadeenvio', 'codigo_postal', 'email'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }
}
