<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'nombre', 'categoria_id', 'estilo_id', 'descripcion', 'precio', 'descuento', 'pdv', 'activado', 'front', 'catalogo', 'nuevo', 'mensaje_personalizado', 'stock', 'talles_disponibles',
    ];
    protected $dates = ['deleted_at'];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function estilo()
    {
        return $this->belongsTo(Estilo::class);
    }

    public function imagenes()
    {
        return $this->hasMany(Imagen::class);
    }

    public function talles(){
        return $this->belongsToMany(Talle::class);
    }

    public function promociones(){
        return $this->belongsToMany(Promocion::class);
    }

    public function tienePromocion(){
        return count($this->promociones()->get()) > 0;
    }

    public function stocks(){
        return $this->hasManyThrough(Stock::class, Imagen::class);
    }

    public function imagenesConStock($size = null, $id_almacen = Stock::WEB)
    {
        return $this->imagenes()->whereHas('stocks', function($q) use ($size, $id_almacen) {
            $q->where('almacen_id', $id_almacen)->where('stock', '>' , 0);
            if($size){
                $q->where('talle_id', $size);
            }
        })->get();
    }

    public function calcularTallesDisponibles(){
        $tallesDisponibles = [];
        foreach ($this->imagenesConStock() as $imagen) {
            foreach ($imagen->stock as $stock) {
                if ($stock->stock > 0 && $stock->talle) {
                    $tallesDisponibles[$stock->talle->orden] = $stock->talle->talle;
                }
            }
        }
        ksort($tallesDisponibles);
        $this->talles_disponibles = implode('-', $tallesDisponibles);
        $this->save();
    }

    public function precioMayorista(){
        return round($this->precio * (1 - env('DESCUENTO_MAYORISTA') / 100), -2);
    }

    public function precioConDescuento(){
        return $this->precio * (1 - $this->descuento / 100);
    }
    public function stockPDV(){
        return $this->hasManyThrough(Stock::class, Imagen::class)->where('almacen_id', Stock::PDV)->first();
    }
}
