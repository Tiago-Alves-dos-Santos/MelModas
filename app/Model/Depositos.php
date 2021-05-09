<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Depositos extends Model
{
    use SoftDeletes;
    protected $table = 'depositos';
    public $timestamps = true;
    protected $primaryKey = 'id'; 
    // const CREATED_AT = 'creat';
    // const UPDATED_AT = 'updat';
    protected $guarded = [];
}
