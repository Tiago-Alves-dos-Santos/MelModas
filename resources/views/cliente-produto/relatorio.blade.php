@extends('layout.template_admin')

@section('titulo', 'Painel Administrativo')


@section('titulo_pagina', 'Relatório de Vendas')


@section('conteudo')
<div class="row">
    <div class="col-md-12">
        <h3>Selecione um intervalo de datas!</h3>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <form action="{{route('relatorio.emitirRelatorio')}}" method="POST">
            @csrf
            <div class="form-row">
                <div class="col-md-4">
                    <label>Data inicio:</label>
                    <input type="date" class="form-control" name="data_inicio" required/>
                </div>
                <div class="col-md-4">
                    <label>Data final:</label>
                    <input type="date" class="form-control" name="data_final" required/>
                </div>
                <div class="col-md-4">
                    <label> </label>
                    <input type="submit" class="btn btn-block btn-success" value="Emitir Relatório" formtarget="_blank"/>
                </div>
            </div>
        </form>
    </div>
</div>
<script>

</script>
@endsection

