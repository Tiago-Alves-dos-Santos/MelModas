<?php

namespace App\Http\Controllers\Controller;

use App\Model\Produto;
use App\Model\PesoVenda;
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
        $produtos = Produto::orderBy('nome')->paginate(Configuracao::PAGINAS);
        $registros = Configuracao::mapPaginate($produtos);
        if($request->ajax()){
            return view('includes.produto.tabela_produto', compact('produtos','registros'));
        }
        return view('produto.consulta', compact('produtos','registros'));
    }
    //filtrar produtos
    public function filtro(Request $request)
    {
        $produtos = Produto::where('codigo', 'like', "%{$request->codigo}%")
        ->where('nome', 'like', "%{$request->nome}%")
        ->where('marca', 'like', "%{$request->marca}%")
        ->orderBy('nome')->paginate(Configuracao::PAGINAS);
        $filtro = $request->except(['_token']);
        $registros = Configuracao::mapPaginate($produtos);
        if($request->ajax()){
            return view('includes.produto.tabela_produto', compact('produtos','registros','filtro'));
        }
        return view('produto.consulta', compact('produtos','registros', 'filtro'));
    }
    public function verificarCodigo(Request $request)
    {
        return json_encode(Produto::where('id', '!=', base64_decode($request->id))
        ->where('codigo', $request->codigo)->exists());
    }
    public function viewAlterar(Request $request)
    {
        $produto = Produto::find(base64_decode($request->id));
        $url = $request->url;
        return view('produto.alterar', compact('produto','url'));
    }
    public function viewCadastro(Request $request)
    {
        return view('produto.cadastro');
    }
    /*******************************Ações Ajax************************************/
    //retorna um componente de cadastrar ou atualizar(adicionar) quantidade a um produto existente
    public function cadastrarAtualizar(Request $request)
    {
        $existe = Produto::where('codigo', $request->codigo)->exists();
        if($existe){
            $produto = Produto::where('codigo', $request->codigo)->first();
            $peso_venda = PesoVenda::find(1);
            return view('includes.produto.adicionar', compact('produto','peso_venda'));
        }else{
            return view('includes.produto.cadastro_form');
        }
    }
    //retorna um objeto produto
    public function getProduto(Request $request)
    {
        return json_encode(Produto::find($request->id));
    }
    //altera(adiciona) quaintidade de um produto existente
    public function adicionarQuantidade(Request $request)
    {
        $produto = Produto::find($request->id);
        $produto->quantidade += $request->quantidade;
        $produto->peso = $request->peso_venda;
        $produto->save();
        return json_encode(true);
    }
    /*******************************Crud************************************/
    public function create(Request $request)
    {
        $existe = Produto::where('codigo', $request->codigo)->exists();
        if(!$existe){
            $produto = Produto::create([
                "codigo" => $request->codigo,
                "nome" => $request->nome,
                "marca" => $request->marca,
                "valor_compra" => $request->valor_compra,
                "valor_venda"=> $request->valor_venda,
                "quantidade" => $request->quantidade,
                "descricao" => $request->descricao,
                "peso" => $request->peso_entrada
            ]);
            $produto = $produto->fresh();
            $pesovenda = PesoVenda::find(1);
            $pesovenda->peso_total += $produto->peso;
            $pesovenda->save();
            return json_encode(2);
        }else{
            return json_encode(3);
        }
    }
    public function alterar(Request $request)
    {
        $existe = Produto::where('id', '!=', base64_decode($request->id))
        ->where('codigo', $request->codigo)->exists();
        if(!$existe){
            Produto::where('id', base64_decode($request->id))->update([
                "codigo" => $request->codigo,
                "nome" => $request->nome,
                "marca" => $request->marca,
                "valor_compra" => $request->valor_compra,
                "valor_venda"=> $request->valor_venda,
                "quantidade" => $request->quantidade,
                "descricao" => $request->descricao,
                "peso" => $request->peso_venda    
            ]);
            return redirect(route('produto.view.principal')."?page=".base64_decode($request->url));
        }else{
            session(['msg' => [
                'tipo' => 'error',
                'texto' => 'O  código '.$request->codigo.' já existente no sistema!'
            ]]);
            return redirect()->back();
        }
        
        
    }
    public function delete(Request $request)
    {
        Produto::where('id', $request->id)->delete();
        //Configuracao::PAGINAS 
        $produtos = Produto::orderBy('nome')->paginate(Configuracao::PAGINAS);
        $registros = Configuracao::mapPaginate($produtos);
        if($request->ajax()){
            return view('includes.produto.tabela_produto', compact('produtos','registros'));
        }
        return view('produto.consulta', compact('produtos','registros'));
    }
}
