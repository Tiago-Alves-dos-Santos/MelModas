<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Caixa extends Model
{
    use SoftDeletes;
    protected $table = 'caixa';
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $guarded = [];
}
