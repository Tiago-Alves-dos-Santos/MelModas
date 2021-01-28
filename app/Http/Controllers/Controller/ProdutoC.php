<?php

namespace App\Http\Controllers\Controller;

use App\Model\Produto;
use Illuminate\Http\Request;
use App\Classes\Configuracao;
use App\Http\Controllers\Controller;

class ProdutoC extends Controller
{
    public function __construct()
    {
        $this->middleware('login');
    }
    public function viewPrincipal(Request $request)
    {
        //Configuracao::PAGINAS
        $produtos = Produto::orderBy('nome')->paginate(2);
        $registros = Configuracao::mapPaginate($produtos);
        if($request->ajax()){
            return view('includes.produto.tabela_produto', compact('produtos','registros'));
        }
        return view('produto.consulta', compact('produtos','registros'));
    }
    public function viewCadastro(Request $request)
    {
        return view('produto.cadastro');
    }
    /*******************************Ações Ajax************************************/
    public function cadastrarAtualizar(Request $request)
    {
        $existe = Produto::where('codigo', $request->codigo)->exists();
        if($existe){
            $produto = Produto::where('codigo', $request->codigo)->first();
            return view('includes.produto.adicionar', compact('produto'));
        }else{
            return view('includes.produto.cadastro_form');
        }
    }
    public function adicionarQuantidade(Request $request)
    {
        $produto = Produto::find($request->id);
        $produto->quantidade += $request->quantidade;
        $produto->save();
        return json_encode(true);
    }
    /*******************************Crud************************************/
    public function create(Request $request)
    {
        $existe = Produto::where('codigo', $request->codigo)->exists();
        if(!$existe){
            Produto::create([
                "codigo" => $request->codigo,
                "nome" => $request->nome,
                "valor_compra" => $request->valor_compra,
                "valor_venda"=> $request->valor_venda,
                "quantidade" => $request->quantidade,
                "descricao" => $request->descricao
            ]);
            return json_encode(2);
        }else{
            return json_encode(3);
        }
    }
}
