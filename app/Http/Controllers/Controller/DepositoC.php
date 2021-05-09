<?php

namespace App\Http\Controllers\Controller;

use App\Model\Depositos;
use Illuminate\Http\Request;
use App\Classes\Configuracao;
use App\Http\Controllers\Controller;

class DepositoC extends Controller
{
    public function __construct()
    {
        $this->middleware('login');
    }

    public function viewIndex(Request $request)
    {
        $depositos = Depositos::orderBy('created_at', 'desc')->paginate(Configuracao::PAGINAS);
        if($request->ajax()){
            return view('includes.depositos.tabela', compact('depositos'));
        }
        return view('depositos.index', compact('depositos'));
    }
    public function viewCadastrar(Request $request)
    {
        return view('depositos.cadastrar'); 
    }
    public function create(Request $request)
    {
        Depositos::create([
            "local" => $request->local,
            "valor" => $request->deposito,
            "descricao" => $request->descricao
        ]);
        session(['msg' => [
            'tipo' => 'info',
            'texto' => 'Depósito adicionado com sucesso!'
        ]]);
        return redirect()->route('deposito.view.index');
    }

    public function delete(Request $request)
    {
        $deposito = Depositos::where('id', $request->id)->delete();
        return json_encode($deposito);
    }
}
