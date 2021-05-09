@extends('layout.template_admin')
@section('titulo', 'Painel Administrativo')


@section('titulo_pagina', 'Adicionar Depositos')


@section('conteudo')
<div class="row">
    <div class="col-md-12">
        <form method="POST" action="{{route('deposito.create')}}" id="form_deposito">
            @csrf
            <div class="form-row">
                <div class="col-md-6">
                    <label>Localização Loja</label>
                    <input type="text" name="local" class="form-control" placeholder="Loja Cidade"/>
                </div>
                <div class="col-md-6">
                    <label>Valor Depositado</label>
                    <input type="number" name="deposito" step="0.01" class="form-control" placeholder="700,54"/>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-12">
                    <textarea placeholder="Descreva alguma informação" class="form-control" name="descricao" rows="6"></textarea>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-12">
                    <input type="submit" class="btn btn-block btn-success" value="Adicionar"/>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
$("#form_deposito").on('submit',function(e){
    $("div#load-page").fadeIn('fast');
});
</script>
@endsection