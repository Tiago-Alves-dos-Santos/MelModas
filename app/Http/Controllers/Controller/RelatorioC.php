<?php

namespace App\Http\Controllers\Controller;

use PDF;
use DateTime;
use Illuminate\Http\Request;
use App\Model\ClienteProduto;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class RelatorioC extends Controller
{
    public function viewRelatorio(Request $request)
    {
        return view('cliente-produto.relatorio');
    }

    public function emitirRelatorio(Request $request)
    {
        $vendas = ClienteProduto::join('cliente', 'cliente_produto.cliente_id', '=', 'cliente.id')
        ->join('produto', 'cliente_produto.produto_id', '=', 'produto.id')
        ->select('cliente.nome','cliente.id as id_cliente','cliente_produto.id as id_venda','cliente_produto.*', 'produto.*', DB::raw('SUM(cliente_produto.valor_bruto) as soma'))
        ->whereDate('cliente_produto.created_at',' >= ',$request->data_inicio)
        ->whereDate('cliente_produto.created_at',' <= ',$request->data_final)
        ->groupBy('cliente_produto.cliente_id','cliente_produto.created_at')
        ->orderBy('cliente_produto.created_at', 'desc')
        ->get();
        // dd($vendas);
        $valor_fiados_anadamento = 0;
        $valor_total = 0;
        $valor_bruto = 0;
        $valor_lucro = 0;
        //true apenas para parselas, false para acumular as parcelas
        $parcelas = true;
        foreach($vendas as $venda){
            $data_final_parcelamento = date('Y-m-d', strtotime("+".$venda->parcelamento." month", strtotime($venda->created_at)));
            
            if($venda->forma_pagamento == "cartão" && $venda->parcelamento >= 2){
                //caso data final do cartao seja menor ou igual que data atual(cartao total concluido)
                if(strtotime($data_final_parcelamento) <= strtotime($request->data_final)){
                    $valor_total += $venda->valor_total;
                    $valor_bruto += $venda->soma;
                    $valor_lucro += $valor_total - $valor_bruto;
                }else if(strtotime($data_final_parcelamento) > strtotime($request->data_final)){//cartao nao concluiu todas as parcelas
                    // dd("aq2");
                    //pegar quantidade de parcelas que falta(data atual - data final)
                    $data_inicio = new DateTime($request->data_final);
                    $data_final_calc = new DateTime($data_final_parcelamento);
    
                    $intervalo_restante = $data_inicio->diff($data_final_calc);
                    $parcelamento_restante = $intervalo_restante->m;
    
                    $parcelas_concluidas = $venda->parcelamento - $parcelamento_restante;

                    // $parcelas_concluidas
                    //pega valor que cartao da lucro por mes
                    $lucro_por_mes = $venda->valor_total / $venda->parcelamento;
                    $lucro_bruto_mes = $venda->soma / $venda->parcelamento;

                    
                    //acumula as parcelas
                    if(!$parcelas){
                        $lucro_obtido = $lucro_por_mes * $parcelas_concluidas;
                        $lucro_bruto_obitido = $lucro_bruto_mes * $parcelas_concluidas;
                    }else{
                        $lucro_obtido = $lucro_por_mes * 1;
                        $lucro_bruto_obitido = $lucro_bruto_mes * 1;
                    }

                    $lucro_oficial =  $lucro_obtido - $lucro_bruto_obitido;

                    $valor_total += $lucro_obtido;
                    $valor_bruto += $lucro_bruto_obitido;
                    $valor_lucro += $lucro_oficial;
                    // dd($parcelas_concluidas);
    
                }
            }else if($venda->forma_pagamento == "fiado" && $venda->estado_compra == "andamento"){
                $valor_fiados_anadamento += $venda->valor_total;
            }else{
                $valor_total += $venda->valor_total;
                $valor_bruto += $venda->soma;
                $valor_lucro += $valor_total - $valor_bruto;
            }
        }

        $vendas_separadas = ClienteProduto::join('cliente', 'cliente_produto.cliente_id', '=', 'cliente.id')
        ->join('produto', 'cliente_produto.produto_id', '=', 'produto.id')
        ->select('cliente.nome','cliente.id as id_cliente','cliente_produto.id as id_venda','cliente_produto.*', 'produto.*')
        ->where("forma_pagamento", "!=","fiado")
        ->orWhere('estado_compra', 'concluida')
        ->whereDate('cliente_produto.created_at',' >= ',$request->data_inicio)
        ->whereDate('cliente_produto.created_at',' <= ',$request->data_final)
        ->orderBy('cliente_produto.created_at', 'desc')
        ->get();
        $vendas_fiados_andamento = ClienteProduto::join('cliente', 'cliente_produto.cliente_id', '=', 'cliente.id')
        ->join('produto', 'cliente_produto.produto_id', '=', 'produto.id')
        ->select('cliente_produto.id as id_venda','cliente_produto.*', 'produto.*')
        ->whereDate('cliente_produto.created_at',' >= ',$request->data_inicio)
        ->whereDate('cliente_produto.created_at',' <= ',$request->data_final)
        ->where("forma_pagamento", "fiado")
        ->where("estado_compra", "andamento")
        ->orderBy('cliente_produto.created_at', 'desc')
        ->get();
        //retorna pdf
        $data_inicio = $request->data_inicio;
        $data_final = $request->data_final;
        $pdf = PDF::loadView('cliente-produto.relatorioPdf', compact('valor_total', 'valor_fiados_anadamento','vendas_separadas', 'vendas_fiados_andamento', 'data_inicio', 'data_final','valor_bruto', 'valor_lucro'));

        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('relatório_'.date('m', strtotime($request->data_inicio)).'-'.date('m', strtotime($request->data_final)).'/'.date('Y', strtotime($request->data_final)).'pdf');
    }
}
