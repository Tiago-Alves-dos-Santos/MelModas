<?php

namespace App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Model\ClienteProduto;
use App\Http\Controllers\Controller;
use DateTime;
use Illuminate\Support\Facades\Cookie;

class RotinasC extends Controller
{
    public function vendasConcluidas(Request $request)
    {
        $linhas_afetadas =0;
        //listar as vendas por vendas nao concluidas
        $vendas = ClienteProduto::join('cliente', 'cliente_produto.cliente_id', '=', 'cliente.id')
        ->join('produto', 'cliente_produto.produto_id', '=', 'produto.id')
        ->where('estado_compra', "andamento")
        ->where('forma_pagamento', "cartão")
        ->select('cliente.nome','cliente.id as id_cliente','cliente_produto.*')
        ->groupBy('cliente_produto.cliente_id','cliente_produto.created_at')
        ->orderBy('cliente_produto.created_at', 'desc')->get();
        //verficar as condiões
        foreach($vendas as $value){
            $data_inicio = $value->created_at;
            $data_hoje = date('Y-m');
            if ( $value->parcelamento  >= 2 ) {
                $data_final = date('Y-m', strtotime("+".$value->parcelamento." month", strtotime($data_inicio)));
                if(strtotime($data_hoje) > strtotime($data_inicio)){
                     if (strtotime($data_hoje) >= strtotime($data_final)) {
                       $linhas_afetadas =  ClienteProduto::where('cliente_id', $value->cliente_id)
                        ->where('created_at', $value->created_at)
                        ->groupBy('cliente_produto.cliente_id','cliente_produto.created_at')
                        ->update([
                            "estado_compra" => "concluida",
                            "parcelamento" => 0
                        ]);
                    }
                }
            }
        }
        // $tempo = time() + (3 * 24 * 3600);
        // Cookie::queue(Cookie::make('vendas_concluidas', $linhas_afetadas,  $tempo));
        return json_encode($linhas_afetadas);
    }
    //autlização, lucro do dia?
}
