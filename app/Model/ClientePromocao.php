<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use App\Model\ClienteProduto;

class ClientePromocao extends Model
{
    use SoftDeletes;
    protected $table = 'cliente_promocao';
    public $timestamps = true;
    protected $primaryKey = 'id'; 
    // const CREATED_AT = 'creat';
    // const UPDATED_AT = 'updat';
    protected $guarded = [];

    /****** Atributos criados *******/

    public static function verficarPromocao($request)
    {
        $valor_total = ClienteProduto::where('cliente_id', $request->cliente_id)
        ->whereMonth('created_at', date('m'))
        ->whereYear('created_at', date('Y'))->sum('valor_total');
        //se o valor total for maior ou igual ao valor a atingir
        $promocao_obj = Promocao::find(1);
        if($valor_total >= $promocao_obj->valor_atingir){
            //verfica se o cliente ja foi cadastrado na lista de quem recebeu promocao nos mes atual
            //desse ano
            $existe = ClientePromocao::where('cliente_id',$request->cliente_id)
            ->whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))->exists();
            //caso ele nao exista
            if(!$existe){
                //cadastr ele na tabela de promocao
                ClientePromocao::create([
                    "cliente_id" =>$request->cliente_id,
                    "mes_antigido" => date('Y-m-d'),
                    "valor_atual" => $valor_total,
                    "promocao_id" => '1'
                ]);
            }

            return true;
        }else{ //caso valor total seja menor ele nao recebe promocao
            return false;
        }
    }
}
