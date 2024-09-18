<?php

namespace App\Http\Controllers;

use App\Client;
use App\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class ClientController extends Controller
{
    use AuthenticatesUsers;
    
    function perfil(){
        Auth::setDefaultDriver('client');
        if (Auth::check()) {
            return view('perfil', [
                'pedidos' => Pedido::where('client_id', Auth::user()->id)->get(), 
                'estados' => Pedido::ESTADOS_PEDIDO, 
                'colores' => Pedido::COLORES_ESTADO
            ]);
        }else{
            return redirect('/');
        }
    }

    function redirect(Request $request){
        session()->forget('redirect');
        session()->flush();
        session(['redirect' => $request->redirect]);
        return $request->url;
    }

    function logout()
    {
        Auth::setDefaultDriver('client');
        Auth::logout();
        return back();
    }
    
    function ingresar(Request $request)
    {
        $credentials = $request->only('usuario', 'password');

        $client = Client::where('usuario', $request->usuario)->first();
        if($client){
            if (Auth::guard('client')->attempt($credentials)) {
                
                Auth::setDefaultDriver('client');
                
                if ($client->tipo==2) {
                    return redirect('admin/pdv/pedidos');
                }elseif(session('redirect')!=null){
                    return redirect(session('redirect'));
                }else{
                    return redirect()->intended('catalogo');
                }

            }
            else
            {
                return back()->with('error', "Contraseña invalida");
            }
        }else{
            return back()->with('error', "Su usuario no existe en nuestra base de datos");
        }
    }

    protected function guard()
    {
        return Auth::guard('client');
    }

    function crearClient()
    {
        return view('adm.clients.client.create');
    }

    function listarClients(Request $request)
    {
        $cantidad = 500;
        $pagina = 1;
        
        if ($request->page) {
            $pagina = $request->page;
        }

        if ($request->cant) {
            $cantidad = $request->cant;
        }
        
        $total = Client::count();
        $paginas = (int) ceil( $total/$cantidad );
        $inicio = $cantidad * $pagina - $cantidad;

        $query  = Client::offset($inicio)->limit($cantidad);

        return view('adm.clients.client.list', [
            'clients' => $query->orderBy('nombre', 'asc')->get(),
            'total'   => $total,
            'paginas' => $paginas
        ]);
    }

    function editarClient($id)
    {
        $client = Client::find($id);

        return view('adm.clients.client.edit', compact('client'));
    }

    public function store(Request $request)
    {
        if(Client::where('usuario', $request->usuario)->first()){
            return back()->with('error', "El cliente con el nombre '".$request->usuario."' ya existe. Por favor, elija otro.");
        }else{
            $datos = $request->all();
            $datos['password'] = Hash::make($datos['password']);
            Client::create($datos);

            return redirect('registro-exitoso');
        }
    }

    public function update(Request $request, Client $client)
    {
        $datos = $request->all();
        if($datos['newPassword']!='')
        {
            $datos['password'] = Hash::make($datos['newPassword']);
        }
        $client->fill($datos);
        $client->save();
        $success = 'Cliente editado correctamente';
        return back()->with('success', $success);
    }

    public function destroy(Client $client)
    {
        $client->delete();
        $success = 'Cliente eliminado correctamente';
        return back()->with('success', $success);
    }
    
    public function autenticado()
    {
        Auth::setDefaultDriver('client');  
        return response()->json([
            'auth' => Auth::check()
        ]);
    }
}
