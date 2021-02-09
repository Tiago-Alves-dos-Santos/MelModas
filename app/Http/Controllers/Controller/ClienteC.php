<?php

namespace App\Http\Controllers\Controller;

use App\Model\Cliente;
use App\Model\Telefone;
use Illuminate\Http\Request;
use App\Classes\Configuracao;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ClienteC extends Controller
{
    public function __construct()
    {
        $this->middleware('login');
    }
    public function viewPrincipal(Request $request)
    {
        //Configuracao::PAGINAS
        $clientes = Cliente::orderBy('nome')->paginate(Configuracao::PAGINAS);
        $registros = Configuracao::mapPaginate($clientes);
        if($request->ajax()){
            return view('includes.cliente.tabela_consultar', compact('clientes','registros'));
        }
        return view('cliente.consultar', compact('clientes','registros'));
    }

    //filtrar cliente na viewPrincipal
    public function filtrar(Request $request)
    {
        $cliente = Cliente::join('telefone', 'cliente.id', '=','telefone.cliente_id')
        ->where('cliente.nome','like',"%{$request->nome}%")
        ->where('telefone.telefone','like',"%{$request->telefone}%")
        ->select('cliente.*')
        ->get();
        $ids = [];
        foreach ($cliente as $valor) {
            $ids[] = $valor->id;
        }
        $ids = array_unique($ids, SORT_REGULAR);
        $clientes = Cliente::whereIn('id',$ids)->paginate(Configuracao::PAGINAS);
        $registros = Configuracao::mapPaginate($clientes);
        $filtro = $request->except(['_token']);
        if($request->ajax()){
            return view('includes.cliente.tabela_consultar', compact('clientes','registros','filtro'));
        }
        return view('cliente.consultar', compact('clientes','registros','filtro'));
    }

    public function viewCadastro(Request $request)
    {
        return view('cliente.cadastro');
    }
    public function viewAlterar(Request $request)
    {
        $cliente = Cliente::find(base64_decode($request->id));
        $url = $request->url;
        return view('cliente.alterar', compact('cliente','url'));
    }
    //aniversariantes
    public function viewAniversarios(Request $request)
    {
        $clientesDay = Cliente::whereDay('data_nasc', '=', date('d'))->
        whereMonth('data_nasc', date('m'))->get();
        $clientesMont = Cliente::whereMonth('data_nasc', date('m'))->get();
        return view('cliente.aniversarios', compact('clientesDay', 'clientesMont'));
    }
    /************************** Operaçoes *********************************/
    public function aniversariantesCount(Request $request)
    {
        return json_encode(Cliente::whereMonth('data_nasc', date('m'))->count());
    }
    public function verficarExistencias(Request $request)
    {
        $cliente = new Cliente();
        $existe = $cliente->verificarExistencia($request->coluna, $request->valor);
        return json_encode($existe);
    }
    //listar telfones de um cliente selecionado
    public function listarTelefones(Request $request)
    {
        $cliente= new Cliente();
        $cliente->id = $request->id_cliente;
        $telefones = $cliente->getTelefones();
        return view('includes.cliente.tabela_telefone', compact('telefones'));
    }
    //retorna um atributo de um cliente, atraves de um objeto cliente
    public function getCliente(Request $request)
    {
        return json_encode(Cliente::find($request->id));
    }
    //adcionar um telefone ao cliente
    public function addTelefone(Request $request)
    {
        $validacao = $request->validate([
            'telefone_add' => 'required',
        ]);
        $cliente = new Cliente();
        if($cliente->verificarExistencia('telefone', $request->telefone_add)){
            return 2;
        }else{
            Telefone::create([
                "cliente_id" => $request->id_cliente,
                "telefone" => $request->telefone_add
            ]);
            return $this->listarTelefones($request);
        }
    }
    //deletar telefone especifico
    public function deletarTelefone(Request $request)
    {
        $telefone = Telefone::find($request->id_telefone);
        $quantidade = Telefone::where('cliente_id',$telefone->cliente_id)->count();
        if($quantidade > 1){
            $id_cliente = $telefone->cliente_id;
            $telefone->forceDelete();
            $cliente= new Cliente();
            $cliente->id = $id_cliente;
            $telefones = $cliente->getTelefones();
            return view('includes.cliente.tabela_telefone', compact('telefones'));
        }else{
            return 2;
        }
    }
    /************************** Variados *********************************/
    public function getTelefonesLista(Request $request)
    {
        $telefones = Telefone::where('cliente_id', $request->id)->get();
        echo "<h1>Pressione <span style='color:red'>CTRL+F</span> para fazer uma busca nos numeros abaixo</h1>";
        foreach ($telefones as $value) {
            echo "<h4>{$value->telefone}</h4>";
        }
    }
    /************************** CRUD *********************************/
    public function create(Request $request){
        $validacao = $request->validate([
            'nome' => 'required',
            'telefone' => 'required',
            'rua' => 'required',
            'bairro' => 'required',
            'numero_casa' => 'required|min:1',
            'data_nasc' => 'required'
        ]);
        $cliente = new Cliente();
        if($cliente->verificarExistencia('telefone', $request->telefone)){
            return 2;
        }else{
            $cliente = Cliente::create([
                "nome" => $request->nome,
                "rua" => $request->rua,
                "bairro" => $request->bairro,
                "numero_casa" => $request->numero_casa,
                "complemento" => $request->complemento,
                "data_nasc" => $request->data_nasc
            ]);
            $cliente = $cliente->fresh();
            Telefone::create([
                "cliente_id" => $cliente->id,
                "telefone" => $request->telefone
            ]);
            return 3;
        }
    }
    public function alterar(Request $request)
    {
        Cliente::where('id', $request->id_cliente)->update([
            "nome" => $request->nome,
            "rua" => $request->rua,
            "bairro" => $request->bairro,
            "numero_casa" => $request->numero_casa,
            "complemento" => $request->complemento,
            "data_nasc" => $request->data_nasc
        ]);
        session(['msg' => [
            'tipo' => 'info',
            'texto' => 'Atual usuário '.$request->nome.' foi alterado com sucesso!'
        ]]);
        return redirect(route('cliente.view.principal')."?page=".base64_decode($request->url));
    }
    public function delete(Request $request)
    {
        $cliente = Cliente::find($request->id_cliente);
        Telefone::where('cliente_id', $cliente->id)->delete();
        $cliente->delete();
        $clientes = $clientes = Cliente::orderBy('nome')->paginate(Configuracao::PAGINAS);;
        return view('includes.cliente.tabela_consultar', compact('clientes'));
    }
}
