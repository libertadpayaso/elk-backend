<?php

if (! function_exists('updateURL')) {
    function updateURL($parameters, $newParameters = []){

        foreach ($newParameters as $key => $value) {
            if ($value) {
                $parameters[$key] = $value;
            } else {
                unset($parameters[$key]);
            }
        }

        return '?' . http_build_query($parameters);
    }
}

if (! function_exists('name')) {
    function name($item){

    	if (is_string($item)) {
            $nombre = strtolower($item);
        } else if (get_class($item) == 'App/Producto') {
    		$nombre = strtolower($item->categoria()->first()->nombre.'-'.$item->nombre);
    	} else {
    		$nombre = strtolower($item->nombre);
    	}
        $nombre = str_replace(" ", "-", $nombre);
        $nombre = str_replace("---", "-", $nombre);
        $nombre = str_replace("/", "-", $nombre);
        return str_replace(".", "", $nombre);
    }
}

if (! function_exists('stock')) {
    function getStock($stock_id){

        $stock = \App\Stock::find($stock_id);
        return $stock->stock;
    }
}

if (! function_exists('actualizarStock')) {
    function actualizarStock($array = []){

        if (isset($array['categorias']) && isset($array['productos'])) {

            foreach (array_unique($array['categorias']) as $categoria_id) {
                
                $categoria = \App\Categoria::find($categoria_id);

                $categoria->stock = count($categoria->productosConStock());
                $categoria->save();
            }

            foreach (array_unique($array['productos']) as $producto_id) {
                
                $producto = \App\Producto::find($producto_id);

                $producto->stock = count($producto->imagenesConStock());
                $producto->save();
            }

        } else {
            
            foreach (\App\Categoria::all() as $categoria) {

                $categoria->stock = count($categoria->productosConStock());
                $categoria->save();

                foreach ($categoria->productos as $producto) {

                    $producto->stock = count($producto->imagenesConStock());
                    $producto->save();
                }
            }
        }

        return true;
    }
}