<?php

namespace App\Http\Controllers;

use App\Logo;
use Illuminate\Http\Request;
use App\Extensions\Helpers;
use Redirect;

class LogoController extends Controller
{
    function listarLogos()
    {
        $logos = Logo::all();

        return view('adm.logos.logo.list',  compact('logos'));
    }

    function editarLogo($id)
    {
        $logo = Logo::find($id);

        return view('adm.logos.logo.edit', compact('logo', 'section'));
    }

    public function update(Request $request, Logo $logo)
    {
        $datos = $request->all();

        $file_save = Helpers::saveImage($request->file('imagen'), 'logos', $logo->id);
        $file_save ? $datos['imagen'] = $file_save : false;

        $logo->fill($datos);
        $logo->save();
        $success = 'Logo editado correctamente';
        return back()->with('success', $success);
    }
}
