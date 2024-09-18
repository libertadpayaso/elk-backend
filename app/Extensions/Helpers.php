<?php

namespace App\Extensions;

class Helpers
{
 	public static function saveImage($file, $route, $id = null)
 	{
 		if ($file) {
            if ($file->isValid()) {
		        $path = public_path('assets/img/'.$route.'/');
		        $route_file = $route.'_'.$id."_".$file->getClientOriginalName();
		        $file->move($path, $route_file);

		        return $route_file;
            }
        }
        return false;
    }

    public static function cleanString($string)
 	{
 		$specChars = array(",", "-", "/","`", "'", '"',"(", ")", "=","!", "¡", "¿","?", "·", "#","$", "%", "&", ";",":"," ","___","__");
        foreach ($specChars as $i => $char) {
        	$string = str_replace($char, "_", $string);
        }
        return $string;
    }
}
