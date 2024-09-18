<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    function index()
    {
        return view('adm/panel');
    }

    function login()
    {
        return view('adm.login');
    }

    function logout()
    {
        Auth::logout();
        return redirect('admin');
    }

    function ingresar(Request $request)
    {   
        //dd(Hash::make($request->password));
        $credentials = $request->only('usuario', 'password');

        if (Auth::guard('web')->attempt($credentials)) {
            return redirect('admin/panel');
        }
        else
        {
            $error = "Usuario y/o Contraseña invalidos";
            return back()->with('error', $error);
        }

    }

    function crearUser()
    {
        return view('adm.users.user.create');
    }

    function listarUsers()
    {
        $users = User::all();

        return view('adm.users.user.list',  compact('users'));
    }

    function editarUser($id)
    {
        $user = User::find($id);

        return view('adm.users.user.edit', compact('user'));
    }

    public function store(Request $request)
    {
        $datos = $request->all();
        $datos['password'] = Hash::make($datos['password']);
        User::create($datos);
        $success = 'User creado correctamente';

        return back()->with('success', $success);
    }

    public function update(Request $request, User $user)
    {
        $datos = $request->all();
        if($datos['newPassword']!='')
        {
            $datos['password'] = Hash::make($datos['newPassword']);
        }
        $user->fill($datos);
        $user->save();
        $success = 'User editado correctamente';
        return back()->with('success', $success);
    }

    public function destroy(User $user)
    {
        $user->delete();
        $success = 'User eliminado correctamente';
        return back()->with('success', $success);
    }
}
