@extends('layout.template_admin')

@section('titulo', 'Painel Administrativo')


@section('titulo_pagina', "Aniversariantes do dia")


@section('conteudo')
<div class="row">
    <div class="col-md-12">
        <div class="scroll">
            <table id="tabela-clientes">
                <thead class="orange">
                    <tr>
                        <td>#ID#</td>
                        <td>Nome</td>
                        <td>Nascimento</td>
                        <td>Idade</td>
                        <td>Telefones</td>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $calculo = new App\Model\Cliente();
                    @endphp
                    @forelse ($clientesDay as $cliente)
                    @php
                        $idade = $calculo->calcularIdade((string) $cliente->data_nasc);
                    @endphp
                    <tr data-id="{{$cliente->id}}">
                        <td>{{$cliente->id}}</td>
                        <td>{{$cliente->nome}}</td>
                        <td>{{date('d/m/Y', strtotime($cliente->data_nasc))}}</td>
                        <td>{{$idade}}</td>
                        <td>
                            <a href="{{route('cliente.getTelefonesLista', ['id' => $cliente->id])}} " target="_blank">Telefones</a>
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="5">Sem aniversariantes por hoje!</td>
                        </tr>   
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <h3>Aniversariantes do mês!</h3>
        <hr/>
    </div>
</div>

<div class="row">


    <div class="col-md-12">
        <div class="scroll">
            <table id="tabela-clientes">
                <thead class="orange">
                    <tr>
                        <td>#ID#</td>
                        <td>Nome</td>
                        <td>Nascimento</td>
                        <td>Idade</td>
                        <td>Telefones</td>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $calculo = new App\Model\Cliente();
                    @endphp
                    @forelse ($clientesMont as $cliente)
                    @php
                        $idade = $calculo->calcularIdade((string) $cliente->data_nasc);
                    @endphp
                    <tr data-id="{{$cliente->id}}">
                        <td>{{$cliente->id}}</td>
                        <td>{{$cliente->nome}}</td>
                        <td>{{date('d/m/Y', strtotime($cliente->data_nasc))}}</td>
                        <td>{{$idade}}</td>
                        <td>
                            <a href="{{route('cliente.getTelefonesLista', ['id' => $cliente->id])}} " target="_blank">Telefones</a>
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="5">Sem aniversariantes por hoje!</td>
                        </tr>   
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>

</script>
@endsection

