<?php

namespace App\Http\Controllers\Controller;

use App\Model\Usuario;
use Illuminate\Http\Request;
use App\Classes\Configuracao;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
    public function viewConfig(Request $request)
    {
        $usuarios = Usuario::orderBy('created_at')->paginate(Configuracao::PAGINAS);
        if($request->ajax()){
            return view('includes.usuario.tabela', compact('usuarios'));
        }
        return view('usuario.index', compact('usuarios'));
    }
    public function viewCreate(Request $request)
    {
        return view('usuario.cadastrar');
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
            session(['tipo' => $usuario->tipo_user]);
            session(['login' => true]);
            session(['tipo_users'=>[
                "admin","gerenciador","atendente"
            ]]);
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
    public function create(Request $request)
    {
        $existe = Usuario::where('email', $request->email)
        ->where('senha', $request->senha)->exists();
        if(!$existe){
            $usuario = Usuario::create([
                "nome" => $request->nome,
                "email" => $request->email,
                "senha" => $request->senha,
                "tipo_user" => $request->tipo_user
            ]);
            $ususario = $usuario->fresh();
            session(['msg' => [
                'tipo' => 'info',
                'texto' => 'Usuário '.$usuario->nome.' cadastrado com sucesso!'
            ]]);
            return redirect()->route('admin.view.config');
        }else {
            session(['msg' => [
                'tipo' => 'error',
                'texto' => 'Email e senha já existentes na tabela usuarios'
            ]]);
            return redirect()->back();
        } 
    }
    public function delete(Request $request)
    {
        $usuario = Usuario::where('id', $request->id)->delete();
        return json_encode($usuario);
    }
}
