<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
class Cliente extends Model
{
    use SoftDeletes;
    protected $table = 'cliente';
    public $timestamps = true;
    protected $primaryKey = 'id'; 
    // const CREATED_AT = 'creat';
    // const UPDATED_AT = 'updat';
    protected $guarded = [];

    /****** Atributos criados *******/
}
