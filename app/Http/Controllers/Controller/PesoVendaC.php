<?php

namespace App\Http\Controllers\Controller;

use App\Model\Produto;
use App\Model\PesoVenda;
use Illuminate\Http\Request;
use App\Classes\Configuracao;
use App\Http\Controllers\Controller;

class PesoVendaC extends Controller
{
    public function __construct()
    {
        $this->middleware('login');
    }
    public function viewIndex(Request $request)
    {
        $peso_venda = PesoVenda::find(1);
        return view('peso-venda.index', compact('peso_venda'));
    }

    public function create(Request $request)
    {
        PesoVenda::updateOrCreate(
            [
                "id" => 1
            ],
            [
                "valor_compra" => $request->valor_compra,
                "valor_venda" => $request->valor_venda,
                "peso_total" => $request->peso
            ]
        );
        return redirect()->route('admin.view.dashboard');
    }

    public function revisarPeso(Request $request)
    {
        $produtos = Produto::where('peso', '!=', null)->get();
        $pesovenda = PesoVenda::find(1);
        $soma_pesos = 0;
        foreach ($produtos as $value) {
            $soma_pesos += $value->peso;
        }
        $pesovenda->peso_total = $soma_pesos;
        $pesovenda->save();
        return json_encode($pesovenda->peso_total);
    }
    public function alertaPeso(Request $request)
    {
        $peso = PesoVenda::find(1);
        if($peso->peso_total <= Configuracao::ALERTA_PESO){
            return json_encode($peso->peso_total);
        }else{
            return json_encode(false);
        }
    }
}
