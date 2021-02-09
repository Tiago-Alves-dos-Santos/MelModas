<?php

namespace App\Model;

use Illuminate\Support\Facades\DB;
use Yadakhov\InsertOnDuplicateKey;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClienteProduto extends Model
{
    use SoftDeletes;
    use InsertOnDuplicateKey;
    protected $table = 'cliente_produto';
    public $timestamps = true;
    protected $primaryKey = 'id'; 
    // const CREATED_AT = 'creat';
    // const UPDATED_AT = 'updat';
    protected $guarded = [];

    /****** Atributos criados *******/
}
