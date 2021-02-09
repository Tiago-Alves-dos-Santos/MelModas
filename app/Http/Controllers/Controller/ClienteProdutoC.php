<?php

namespace App\Http\Controllers\Controller;

use App\Model\Cliente;
use App\Model\Produto;
use App\Model\Promocao;
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
                    "cliente_id" => 0,
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
