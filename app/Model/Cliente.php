<?php

namespace App\Model;

use App\Model\Cliente;
use App\Model\Telefone;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use SoftDeletes;
    protected $table = 'cliente';
    public $timestamps = true;
    protected $primaryKey = 'id'; 
    // const CREATED_AT = 'creat';
    // const UPDATED_AT = 'updat';
    protected $guarded = [];
    /****** Releacionamentos *******/

    /****** Atributos criados *******/

    /****** Metodos criados *******/
    public function verificarExistencia($coluna,$valor)
    {
        if($coluna == "telefone"){
            $telefone = new Telefone();
            return $telefone->verificarNumero($valor);
        }else{
            return Cliente::where($coluna,$valor)->exists();
        }
        
    }

    function calcularIdade($data_nasc){
            $date = $data_nasc;
            $time = strtotime($date);
            if($time === false){
                return 5;
            }
            $year_diff = '';
            $date = date('Y-m-d', $time);
            list($year,$month,$day) = explode('-',$date);
            $year_diff = date('Y') - $year;
            $month_diff = date('m') - $month;
            $day_diff = (date('d') - $day) * -1;
            if ($month_diff < 0 || ($month == date('m') && $day > date('d')) ){
                $year_diff--;
                
            }
            return $year_diff;
            // echo $year_diff." ".$month_diff." ".$day_diff;
    }

    public function getTelefones()
    {
        return Telefone::where('cliente_id', $this->id)->get();
    }


}
