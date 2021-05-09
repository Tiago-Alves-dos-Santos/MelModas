@extends('layout.template_admin')

@section('titulo', 'Painel Administrativo')


@section('titulo_pagina', "Configurar Peso")


@section('conteudo')
<div class="row">
    <div class="col-md-12">
        <form method="POST" action="{{route('peso.create')}}" id="config_peso">
            @csrf
            <div class="form-row">
                <div class="col-md-4">
                    <label>Valor Grama(Compra)</label>
                    <input type="number" min="0.0000" name="valor_compra" step="0.0001" class="form-control" required value="{{$peso_venda->valor_compra}}"/>
                </div>
                <div class="col-md-4">
                    <label>Valor Grama(Venda)</label>
                    <input type="number" min="0.0000" name="valor_venda" step="0.0001" class="form-control" required value="{{$peso_venda->valor_venda}}"/>
                </div>
                <div class="col-md-4">
                    <label>Entrada peso</label>
                    <input type="number" min="0.001" name="peso" step="0.001" class="form-control" disabled value="{{$peso_venda->peso_total}}"/>
                </div>
            </div>
            <div class="form-row" style="margin-top: 15px">
                <div class="col-md-12">
                    <input type="submit" class="btn btn-success btn-block mt-5" value="Salvar"/>
                </div>
            </div>
        </form>
    </div>
</div>
<script>

//cadastrar cliente
$("form#config_peso").on('submit', function(e){
    $("div#load-page").fadeIn('fast');
});
</script>
@endsection

