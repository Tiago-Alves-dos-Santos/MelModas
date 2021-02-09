<?php

namespace App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Model\ClientePromocao;
use App\Http\Controllers\Controller;

class ClientePromocaoC extends Controller
{
    public function __construct()
    {
        $this->middleware('login');
    }

    /**********************************Ajax**********************************************/
    public function verficarPromocao(Request $request)
    {
        $existe = ClientePromocao::where('cliente_id', $request->id)
        ->whereMonth('created_at', date('m'))
        ->whereYear('created_at', date('Y'))->exists();
        return json_encode($existe);
    }
}
