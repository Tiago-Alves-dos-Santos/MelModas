<?php

namespace App\Http\Controllers\Controller;

use App\Model\Caixa;
use Illuminate\Http\Request;
use App\Classes\Configuracao;
use App\Http\Controllers\Controller;

class CaixaC extends Controller
{
    public function __construct()
    {
        $this->middleware('login');
    }
    public function viewIndex(Request $request)
    {
        $caixas = Caixa::orderBy('created_at','desc')->paginate(20);
        $registros = Configuracao::mapPaginate($caixas);
        return view('caixa.index', compact('caixas','registros'));
    }
    public function open(Request $request)
    {
        $caixa_aberto = Caixa::where('status_caixa',1)->exists();
        $caixa_do_dia = Caixa::whereDate('created_at', date('Y-m-d'))->exists();
        if(!$caixa_aberto && !$caixa_do_dia){
            $caixa = Caixa::create([
                "dinheiro_inicio" => $request->dinheiro,
                "moeda_inicio" => $request->moeda,
                "status_caixa" => 1
            ]);
        }else if($caixa_do_dia){
            session(['msg' => [
                'tipo' => 'alerta',
                'texto' => 'Um caixa já foi aberto e fechado hoje. Se desejar reabra o caixa!'
            ]]);
        }else{
            session(['msg' => [
                'tipo' => 'alerta',
                'texto' => 'O caixa já esta aberto!'
            ]]);
        }
        return redirect()->route('caixa.view.index');
    }
    public function close(Request $request)
    {
        Caixa::where('id', $request->id)->update([
            'dinheiro_fim' => $request->dinheiro,
            'moeda_fim' => $request->moeda,
            'hora_fechado' => date('H:i:s'),
            'status_caixa' => 0
        ]);
        $caixa = Caixa::find($request->id);
        $caixa->lucro_dia = ($caixa->dinheiro_fim + $caixa->moeda_fim) - ($caixa->dinheiro_inicio + $caixa->moeda_inicio);
        $caixa->lucro_dia = number_format($caixa->lucro_dia, 3, '.', ',');
        $caixa->save();
        return json_encode(route('caixa.view.index'));
    }
    public function reOpen(Request $request)
    {
        Caixa::where('id', $request->id)->update([
            'dinheiro_fim' => null,
            'moeda_fim' => null,
            'hora_fechado' => null,
            'lucro_dia' => 0,
            'status_caixa' => 1
        ]);
        return json_encode(route('caixa.view.index'));
    }
    public function delete(Request $request)
    {
        Caixa::where('id', $request->id)->update([
            'status_caixa' => 0
        ]);
        Caixa::where('id', $request->id)->delete();
        return json_encode(route('caixa.view.index'));
    }
    public function check(Request $request)
    {
        $id = Caixa::max('id');
        if($id == null){
            return json_encode('nulo');
        }
        return json_encode((bool)Caixa::find($id)->status_caixa);
    }
}
