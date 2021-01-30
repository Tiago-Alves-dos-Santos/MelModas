<?php

namespace App\Http\Controllers\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClienteProdutoC extends Controller
{
    public function __construct()
    {
        $this->middleware('login');
    }
    public function viewVenda(Request $request)
    {
        return view('cliente-produto.venda');
    }
    /**********************************Ações Ajax*********************************************/
    //buscar clientes para selecionar um
    public function getClientesSelect(Request $request)
    {
        # code...
    }
    /**********************************Crud*********************************************/
}
