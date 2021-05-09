@extends('layout.template_admin')

@section('titulo', 'Painel Administrativo')


@section('titulo_pagina', 'Depositos')


@section('conteudo')
<div class="row">
    <div class="col-md-12">
        <a href="{{route('deposito.view.create')}}" class="btn btn-block btn-success">Adicionar</a>
    </div>
</div>
@include('includes.depositos.tabela')

<script>

</script>
@endsection