<?php

namespace App\Http\Controllers\Controller;

use App\Model\Usuario;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
class UsuarioC extends Controller
{
    public function __construct()
    {
        $this->middleware('login',
            ['except' => [
                'login','logout','viewLogin'
            ]]);
    }
    public function viewLogin()
    {
        return view('logins');
    }
    public function viewDashboard()
    {
        return view('dashboard');
    }

    /******************* ********************/

    public function login(Request $request)
    {
        $existe = Usuario::where('email', $request->email)->where('senha', $request->senha)->exists();
        if($existe){
            $usuario = Usuario::where('email', $request->email)->where('senha', $request->senha)->first();
            session(['email' => $usuario->email]);
            session(['senha' => $usuario->senha]);
            session(['id' => $usuario->id]);
            session(['nome' => $usuario->nome]);
            session(['login' => true]);
            return redirect()->route('admin.view.dashboard');
        }else{
            session(['msg' => [
                'tipo' => 'info',
                'texto' => 'Usuário '.$request->email.' não foi encontrado na base de dados!'
            ]]);
            session(['login' => false]);
            return redirect()->back();
        }
    }
    public function logout(Request $request)
    {
        $nome = session('nome');
        if($request->validate != session('validate')){
            session(['msg' => [
                'tipo' => 'error',
                'texto' => 'Operção de logout inválida!'
            ]]);
                return redirect()->route('inicio');
        }
        session()->flush();
        session(['msg' => [
            'tipo' => 'info',
            'texto' => 'Usuário '.$nome.' deslogado com sucesso!'
        ]]);
        return redirect()->route('inicio');
    }
}
