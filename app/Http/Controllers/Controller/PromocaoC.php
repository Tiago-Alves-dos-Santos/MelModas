<?php

namespace App\Http\Controllers\Controller;

use App\Model\Cliente;
use App\Model\Promocao;
use Illuminate\Http\Request;
use App\Classes\Configuracao;
use App\Model\ClienteProduto;
use App\Model\ClientePromocao;
use App\Http\Controllers\Controller;

class PromocaoC extends Controller
{
    public function __construct()
    {
        $this->middleware('login');
    }
    public function viewPrincipal(Request $request)
    {
        $promocao = Promocao::find(1);
        $cliente_promocao = ClientePromocao::join('cliente', 'cliente.id', '=','cliente_promocao.cliente_id')->orderBy('mes_antigido', 'desc')->paginate(Configuracao::PAGINAS);
        $clientes = Cliente::orderBy('nome')->paginate(30);
        $registros = Configuracao::mapPaginate($cliente_promocao);
        $registros_cliente = Configuracao::mapPaginate($clientes);
        return view('promocao.home', compact('promocao', 'cliente_promocao','clientes','registros','registros_cliente'));
    }
    public function viewEditar(Request $request)
    {
        $promocao = Promocao::find(1);
        return view('promocao.editar', compact('promocao'));
    }
    public function alterar(Request $request)
    {
        Promocao::where('id', $request->id)->update([
            "desconto_porcento" => $request->desconto,
            "valor_atingir" => $request->valor_atingir,
        ]);
        return  redirect()->route('promocao.view.principal');
    }
    /***************************** Ajax *********************************/
    public function valorTotalMes(Request $request)
    {
        $valor_total = ClienteProduto::where('cliente_id', $request->id)
        ->whereMonth('created_at', date('m'))
        ->whereYear('created_at', date('Y'))->sum('valor_total');
        return json_encode($valor_total);
    }
}
