<?php

namespace App\Http\Controllers;

use App\Client;
use App\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class ApiController extends Controller
{
	use AuthenticatesUsers;

	public function verify($name)
	{        
		if(Client::where('usuario', $name)->first()){
            $response = new Collection(['valid' =>  false]);
        }else{
            $response = new Collection(['valid' =>  true]);
        }
        return $response->toJson();
	}

	public function product($id)
	{        
		$product = Producto::with('talles', 'imagenes', 'categoria')->where('id', $id)->get();
		return response()->json($product);
	}
}