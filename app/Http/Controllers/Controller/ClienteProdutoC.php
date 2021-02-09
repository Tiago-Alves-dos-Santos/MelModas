<?php

namespace App\Http\Controllers\Controller;

use App\Model\Cliente;
use App\Model\Produto;
use App\Model\Promocao;
use App\Model\Telefone;
use Illuminate\Http\Request;
use App\Classes\Configuracao;
use App\Model\ClienteProduto;
use App\Model\ClientePromocao;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ClienteProdutoC extends Controller
{
    public function __construct()
    {
        $this->middleware('login');
    }
    public function viewVenda(Request $request)
    {
        return view('cliente-produto.venda');
    }
    //view da tela de vendas realizadas
    public function viewVendas(Request $request)
    {
        $vendas = ClienteProduto::leftJoin('cliente', 'cliente_produto.cliente_id', '=', 'cliente.id')
        ->leftJoin('produto', 'cliente_produto.produto_id', '=', 'produto.id')
        ->select('cliente.nome','cliente.id as id_cliente','cliente_produto.*')
        ->groupBy('cliente_produto.cliente_id','cliente_produto.created_at')
        ->orderBy('cliente_produto.created_at', 'desc')
        ->paginate(Configuracao::PAGINAS);
        $telefones = [];
        foreach($vendas as $item){
            if(Telefone::where('cliente_id', $item->id_cliente)->exists()){
                $numero = Telefone::where('cliente_id', $item->id_cliente)->first();
                $telefones[] = $numero->telefone;
            }else{
                $telefones[] = "(??) ? ????-????";
            }
            
        }
        $registros = Configuracao::mapPaginate($vendas);
        if($request->ajax()){
            return view('includes.cliente_produto.lista_vendas',compact('vendas','telefones', 'registros'));
        }
       return view('cliente-produto.vendas_realizadas', compact('vendas','telefones','registros'));
    }
    //filtrr vendas ocorridas(ajax)
    public function filtrar(Request $request)
    {
        $vendas = ClienteProduto::crossJoin('cliente')
        ->leftJoin('produto', 'cliente_produto.produto_id', '=', 'produto.id')
        ->crossJoin('telefone')
        ->where('cliente.nome', 'like',"%{$request->nome}%")
        ->whereDate('cliente_produto.created_at', 'like',"%{$request->datas}%")
        ->where('telefone.telefone', 'like',"%{$request->telefone}%")
        ->select('cliente.nome','cliente.id as id_cliente','cliente_produto.*')
        ->groupBy('cliente_produto.cliente_id','cliente_produto.created_at')
        ->orderBy('cliente_produto.created_at', 'desc')
        ->paginate(Configuracao::PAGINAS);
        // dd($vendas->toSql());
        $telefones = [];
        foreach($vendas as $item){
            if(Telefone::where('cliente_id', $item->id_cliente)->exists()){
                $numero = Telefone::where('cliente_id', $item->id_cliente)->first();
                $telefones[] = $numero->telefone;
            }else{
                $telefones[] = "(??) ? ????-????";
            }
            
        }
        $filtro = $request->except(['_token']);
        $registros = Configuracao::mapPaginate($vendas);
        if($request->ajax()){
            return view('includes.cliente_produto.lista_vendas',compact('vendas','telefones','filtro', 'registros'));
        }
       return view('cliente-produto.vendas_realizadas', compact('vendas','telefones','filtro', 'registros'));
    }
    //listar produtos da compra
    public function listarProdutos(Request $request)
    {
        $vendas = ClienteProduto::leftJoin('cliente', 'cliente_produto.cliente_id', '=', 'cliente.id')
        ->leftJoin('produto', 'cliente_produto.produto_id', '=', 'produto.id')
        ->select('cliente.nome','cliente.id as id_cliente','cliente_produto.*', 'produto.*')
        ->where('cliente_produto.cliente_id', $request->id)
        ->where('cliente_produto.created_at', $request->data)
        ->orderBy('cliente_produto.created_at', 'desc')
        ->get();
        // dd($vendas);
        foreach($vendas as $value){
            echo "<ul>";
                echo "<li>Código: {$value->codigo}</li>";
                echo "<li>Nome: {$value->nome}</li>";
                echo "<li>Quantidade Vendida: {$value->quantidade_vendida}</li>";
                echo "<li>Valor: R$ {$value->valor_venda}</li>";
                echo "<li>Total: R$ ".$value->valor_venda * $value->quantidade_vendida."</li>";
            echo "</ul>";
            echo "<h3>=====================================</h3>";
        }

    }
    /**********************************Ações Ajax*********************************************/
    //buscar clientes para selecionar um
    public function getClientesSelect(Request $request)
    {
        $cliente = Cliente::join('telefone', 'cliente.id', '=','telefone.cliente_id')
        ->where('cliente.nome','like',"%{$request->nome}%")
        ->where('telefone.telefone','like',"%{$request->telefone}%")
        ->select('cliente.*')
        ->get();
        $ids = [];
        foreach ($cliente as $valor) {
            $ids[] = $valor->id;
        }
        $ids = array_unique($ids, SORT_REGULAR);
        $clientes = Cliente::whereIn('id',$ids)->paginate(Configuracao::PAGINAS);
        $registros = Configuracao::mapPaginate($clientes);
        $filtro = $request->except(['_token']);
        if($request->ajax()){
            return view('includes.cliente_produto.cliente_tabela_selecao', compact('clientes','registros','filtro'));
        }
    }
    public function addProduto(Request $request)
    {
        return json_encode(Produto::where('codigo', $request->codigo)->first());
    }
    public function vender(Request $request)
    {
        $cliente = null;
        $promocao = false;
        //verfica se cliente nao foi selecionado
        if($request->cliente_id == null && $request->cliente_anonimo_nome == null){
            return json_encode("erro 1");
        }else if(!is_array($request->codigos) || (is_array($request->codigos) && count($request->codigos) == 0)){//verfica se produto foi selecionado
            return json_encode("erro 2");
        }else if($request->cliente_id != null && $request->cliente_anonimo_nome == null){//caso cliente seja selecionado
            //pega o valor total que aquele cliente gastou no mes atual desse ano
            $promocao = ClientePromocao::verficarPromocao($request);
        }
        //recebe um array de codigos
        $codigos = $request->codigos;
        //quantidade a ser vendida, respetiva aoa array de codigos
        $valores = $request->quantidade_vendas;
        //percorre todos os codigos
        for($i=0; $i < count($codigos); $i++){
            //retorna o produto de acordo com codigo
            $alterar = Produto::where('codigo', $codigos[$i])->first();
            //diminui a quantidade do produto de acordo com a qauntidade a ser vendida
            $alterar->quantidade = ((int) $valores[$i]) - $alterar->quantidade;
            if($alterar->quantidade < 0){
                $alterar->quantidade *= (-1);
            }
            //salva alteração
            $alterar->save();
        }
        //verfica descontos,caso haja desconto, não tem promocao
        if($request->desconto != null && $request->desconto != 0){
            $valor_total = $request->valor_total * ((100 - $request->desconto)/100);
        }else if($promocao && ($request->desconto == null || $request->desconto == 0)){//caso haja promocao sem desconto a promocao ocorre 
            $promocao = Promocao::find(1);
            $valor_total = $request->valor_total * ((100 - $promocao->desconto_porcento)/100);
        }else{//caso nao haja nenhuma de ambas o valor vem bruto
            $valor_total = $request->valor_total;
        }

        // $codigos_unicos = array_unique($codigos, SORT_REGULAR);
        $cont = 0;
        foreach ($codigos as $value) {
            $produto = Produto::where('codigo', $value)->first();
            if($request->cliente_id != null && $request->cliente_anonimo_nome == null){
                DB::statement('SET FOREIGN_KEY_CHECKS=0;');
                ClienteProduto::create([
                    "cliente_id" => $request->cliente_id,
                    "produto_id" => $produto->id,
                    "valor_total" =>$valor_total,
                    "forma_pagamento" => $request->forma_pagamento,
                    "parcelamento" => $request->parcelamento,
                    "estado_compra" => "concluida",
                    "quantidade_vendida" => $valores[$cont++],
                    "descricao" => $request->descricao,
                    "cliente_anonimo" => ""
                ]);
                DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            }else if($request->cliente_anonimo_nome != null){
                DB::statement('SET FOREIGN_KEY_CHECKS=0;');
                ClienteProduto::create([
                    "cliente_id" => null,
                    "produto_id" => $produto->id,
                    "valor_total" =>$valor_total,
                    "forma_pagamento" => $request->forma_pagamento,
                    "parcelamento" => $request->parcelamento,
                    "estado_compra" => "concluida",
                    "quantidade_vendida" => $valores[$cont++],
                    "descricao" => $request->descricao,
                    "cliente_anonimo" => $request->cliente_anonimo_nome
                ]);
                DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            }
        }
        ClientePromocao::verficarPromocao($request); 
        if($request->valor_recebido >= $valor_total){
            return json_encode(($request->valor_recebido - $valor_total));
        }else if($request->valor_recebido < $valor_total){
            return json_encode("erro 3");
        }
        //falta desabilitar foreng keys
        
    }
    /**********************************Crud*********************************************/
}
