<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
class Telefone extends Model
{
    use SoftDeletes;
    protected $table = 'telefone';
    public $timestamps = true;
    protected $primaryKey = 'id'; 
    // const CREATED_AT = 'creat';
    // const UPDATED_AT = 'updat';
    protected $guarded = [];

    /****** Releacionamentos *******/

    /****** Atributos criados *******/

    /****** Metodos criados *******/
    public function verificarNumero($numero,$cliente_especifico = false)
    {
        if(!$cliente_especifico){
            return Telefone::where('telefone', $numero)->exists();
        }
    }
}
