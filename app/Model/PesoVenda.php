<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PesoVenda extends Model
{
    use SoftDeletes;
    protected $table = 'peso_venda';
    public $timestamps = true;
    protected $primaryKey = 'id'; 
    // const CREATED_AT = 'creat';
    // const UPDATED_AT = 'updat';
    protected $guarded = [];
}
