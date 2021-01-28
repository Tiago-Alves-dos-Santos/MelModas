@extends('layout.template_admin')

@section('titulo', 'Painel Administrativo')


@section('titulo_pagina', 'Estoque')


@section('conteudo')
<div class="row mb-5">
    <form>
        <div class="form-row">
            <div class="col-md-6">
                <label>Código: </label>
                <input type="text" name="codigo" placeholder="Ex: 734234636" class="form-control"/>
            </div>
            <div class="col-md-3">
                <label> </label>
                <input type="submit"  value="Buscar" class="btn btn-success btn-block" style="margin-top: 5px"/>
            </div>
            <div class="col-md-3">
                <label> </label>
                <a href="" class="btn btn-primary btn-block" style="margin-top: 5px">Voltar</a>
            </div>
        </div>
    </form>
</div>
@include('includes.produto.tabela_produto')
<script>

</script>
@endsection