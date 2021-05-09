<?php

namespace App\Http\Controllers\Controller;

use PDF;
use App\Model\Cliente;
use App\Model\Produto;
use App\Model\Promocao;
use App\Model\Telefone;
use App\Model\PesoVenda;
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
        $peso_venda = PesoVenda::find(1);
        return view('cliente-produto.venda', compact('peso_venda'));
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
        $vendas = ClienteProduto::join('cliente', 'cliente_produto.cliente_id', '=', 'cliente.id')
        ->join('produto','cliente_produto.produto_id', '=', 'produto.id')
        ->join('telefone','cliente.id', '=', 'telefone.cliente_id')
        ->where('cliente.nome', 'like',"%{$request->nome}%")
        ->where('telefone.telefone', 'like',"%{$request->telefone}%")
        ->where('forma_pagamento','like',"%{$request->forma_pagamento}%")
        ->where('cliente_produto.estado_compra','like',"%{$request->estado_venda}%")
        ->where('cliente_produto.created_at','like',"%{$request->datas}%")
        ->where('cliente_produto.id','like',"%{$request->codigo}%")
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
        $vendas = ClienteProduto::join('cliente', 'cliente_produto.cliente_id', '=', 'cliente.id')
        ->join('produto', 'cliente_produto.produto_id', '=', 'produto.id')
        ->select('cliente.nome','cliente.id as id_cliente','cliente_produto.*', 'produto.*')
        ->where('cliente_produto.cliente_id', $request->id)
        ->where('cliente_produto.created_at', $request->data)
        ->orderBy('cliente_produto.created_at', 'desc')
        ->get();
        // dd($vendas);
        foreach($vendas as $value){
            $peso_venda = PesoVenda::find(1);
            echo "<ul>";
                echo "<li>Código: {$value->codigo}</li>";
                echo "<li>Nome: {$value->nome}</li>";
                echo "<li>Quantidade Vendida: {$value->quantidade_vendida}</li>";
                echo "<li>Peso Vendido: {$value->peso_vendido}</li>";
                if($value->nv_vl_unitario > 0 && $value->peso_vendido == 0){
                    echo "<li>Valor: R$ {$value->nv_vl_unitario}</li>";
                    echo "<li>Total: R$ ".$value->nv_vl_unitario * $value->quantidade_vendida."</li>";
                }else if($value->nv_vl_unitario > 0 && $value->peso_vendido !=0){
                    echo "<li>Valor: R$ {$value->nv_vl_unitario} p/g </li>";
                    echo "<li>Total: R$ ".$value->nv_vl_unitario * ($value->peso_vendido * 1000)."</li>";
                }else if($value->nv_vl_unitario <= 0 && $value->peso_vendido !=0){
                    echo "<li>Valor: R$ {$value->valor_venda} p/g</li>";
                    echo "<li>Total: R$ ".$value->valor_venda * ($value->peso_vendido * 1000)."</li>";
                }else if($value->nv_vl_unitario <= 0 && $value->peso_vendido ==0){
                    echo "<li>Valor: R$ {$value->valor_venda}</li>";
                    echo "<li>Total: R$ ".$value->valor_venda * $value->quantidade_vendida."</li>";
                }
                
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
        $peso_venda = PesoVenda::find(1);
        $peso_total = 0;
        //verfica se cliente nao foi selecionado
        if($request->cliente_id == null || $request->cliente_id == 0){
            return json_encode("erro 1");
        }else if(!is_array($request->codigos) || (is_array($request->codigos) && count($request->codigos) == 0)){//verfica se produto foi selecionado
            return json_encode("erro 2");
        }else if($request->cliente_id != null && $request->cliente_id > 1){//caso cliente seja selecionado
            //pega o valor total que aquele cliente gastou no mes atual desse ano
            $promocao = ClientePromocao::verficarPromocao($request);
        }
        //recebe um array de codigos
        $codigos = $request->codigos;
        //quantidade a ser vendida, respetiva aoa array de codigos
        $valores = $request->quantidade_vendas;

        $valor_bruto = [];
        //percorre todos os codigos
        for($i=0; $i < count($codigos); $i++){
            //retorna o produto de acordo com codigo
            $alterar = Produto::where('codigo', $codigos[$i])->first();
            //diminui a quantidade do produto de acordo com a qauntidade a ser vendida
            if($valores[$i] > 0){
                $alterar->quantidade = ((int) $valores[$i]) - $alterar->quantidade;
                $valor_bruto[] += $alterar->valor_compra * (int)$valores[$i];
                if($alterar->quantidade < 0){
                    $alterar->quantidade *= (-1);
                }
            }else{
                $valor_bruto[] += $peso_venda->valor_compra * ((double)$request->pesos[$i]*1000);
            }
            //salva alteração
            $alterar->save();
        }
        //somar peso total
        for($i=0; $i < count($request->pesos); $i++){
            $peso_total += (double)$request->pesos[$i]; 
        }

        //verfica descontos,caso haja desconto, não tem promocao
        if($request->desconto != null && $request->desconto != 0){
            $valor_total = $request->valor_total - $request->desconto;
        }else if($promocao && ($request->desconto == null || $request->desconto == 0)){//caso haja promocao sem desconto a promocao ocorre 
            $promocao = Promocao::find(1);
            $valor_total = $request->valor_total * ((100 - $promocao->desconto_porcento)/100);
        }else{//caso nao haja nenhuma de ambas o valor vem bruto
            $valor_total = $request->valor_total;
        }

        if($request->valor_recebido < $valor_total){
            return json_encode("erro 3");
        }
        if($peso_total > $peso_venda->peso_total){
            return json_encode("erro 4");
        }
        // $codigos_unicos = array_unique($codigos, SORT_REGULAR);
        $cont = 0;
        foreach ($codigos as $value) {
            $produto = Produto::where('codigo', $value)->first();
            $estado_venda = null;
            if($request->parcelamento == null){
                $request->parcelamento =0;
            }

            if($request->forma_pagamento == "cartão" && $request->parcelamento > 0){
                $estado_venda = "andamento";
            }else if($request->forma_pagamento == "fiado"){
                $estado_venda = "andamento";
            }else if ($request->forma_pagamento == "A vista" || ($request->forma_pagamento == "cartão" && $request->parcelamento == 0 ) || $request->forma_pagamento == "permuta") {
                $estado_venda = "concluida";
            }
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            ClienteProduto::create([
                "cliente_id" => $request->cliente_id,
                "produto_id" => $produto->id,
                "nv_vl_unitario" => $request->precos_unitarios_array[$cont],
                "valor_total" =>$valor_total,
                "valor_bruto" => $valor_bruto[$cont],
                "forma_pagamento" => $request->forma_pagamento,
                "parcelamento" => $request->parcelamento,
                "estado_compra" => $estado_venda,
                "peso_vendido" => $request->pesos[$cont],
                "quantidade_vendida" => $valores[$cont++],
                "descricao" => $request->descricao,
                "cliente_anonimo" => ""
                
            ]);
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
        $peso_venda->peso_total = $peso_venda->peso_total - (double)$peso_total; 
        $peso_venda->save();
        

        if($request->cliente_id != null && $request->cliente_id > 1){
            ClientePromocao::verficarPromocao($request); 
        }
        if($request->valor_recebido >= $valor_total){
            $calculo = $request->valor_recebido - $valor_total;
            return json_encode(number_format($calculo, 3, '.', ','));
        }
        //falta desabilitar foreng keys
        
    }
    //emitir comprovante de venda
    public function comprovanteVenda(Request $request)
    {
        $peso_venda = PesoVenda::find(1);
        $vendas = ClienteProduto::leftJoin('cliente', 'cliente_produto.cliente_id', '=', 'cliente.id')
        ->leftJoin('produto', 'cliente_produto.produto_id', '=', 'produto.id')
        ->select('cliente.nome','cliente.id as id_cliente','cliente_produto.*', 'produto.*')
        ->where('cliente_produto.cliente_id', $request->id)
        ->where('cliente_produto.created_at', $request->data)
        ->orderBy('cliente_produto.created_at', 'desc')
        ->get();
        $cliente = Cliente::find($request->id);
        $pdf = PDF::loadView('cliente-produto.comprovante_pdf', compact('vendas', 'cliente', 'peso_venda'));
        $pdf->setPaper('A6', 'portrait');
        return $pdf->stream('comprovante_venda.pdf');
    }
    //resetar venda, venda não ocorrida
    public function resetarVenda(Request $request)
    {
        $vendas = ClienteProduto::join('cliente', 'cliente_produto.cliente_id', '=', 'cliente.id')
        ->join('produto', 'cliente_produto.produto_id', '=', 'produto.id')
        ->select('cliente.nome','cliente.id as id_cliente','cliente_produto.id as id_venda','cliente_produto.*', 'produto.*')
        ->where('cliente_produto.cliente_id', $request->id)
        ->where('cliente_produto.created_at', $request->dia)
        ->orderBy('cliente_produto.created_at', 'desc')
        ->get();
        $peso_venda = PesoVenda::find(1);
        // dd($vendas);
        foreach($vendas as $value){
            $produto = Produto::where('codigo', $value->codigo)->first();
            $produto->quantidade += $value->quantidade_vendida;
            $produto->save();
            $peso_venda->peso_total += $value->peso_vendido;
            $peso_venda->save();
            ClienteProduto::where('id', $value->id_venda)->forceDelete();
        }
        return json_encode(true);
    }
    public function concluirVenda(Request $request)
    {
        $vendas = ClienteProduto::join('cliente', 'cliente_produto.cliente_id', '=', 'cliente.id')
        ->join('produto', 'cliente_produto.produto_id', '=', 'produto.id')
        ->select('cliente.nome','cliente.id as id_cliente','cliente_produto.id as id_venda','cliente_produto.*', 'produto.*')
        ->where('cliente_produto.cliente_id', $request->id)
        ->where('cliente_produto.created_at', $request->dia)
        ->orderBy('cliente_produto.created_at', 'desc')
        ->get();
        // dd($vendas);
        foreach($vendas as $value){

            ClienteProduto::where('id', $value->id_venda)->update([
                "estado_compra" => "concluida"
            ]);
        }
        return json_encode(true);
    }
    /**********************************Crud*********************************************/
}
