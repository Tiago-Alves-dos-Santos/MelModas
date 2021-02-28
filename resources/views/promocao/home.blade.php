@extends('layout.template_admin')

@section('titulo', 'Painel Administrativo')


@section('titulo_pagina', 'Promoção')


@section('conteudo')
<div class="row">
    <div class="col-md-4 d-flex justify-content-center">
        <h2>Desconto: {{$promocao->desconto_porcento}}%</h2>
    </div>
    <div class="col-md-4 d-flex justify-content-center">
        <h2>Meta(R$): {{$promocao->valor_atingir}}</h2>
    </div>
    <div class="col-md-4 d-flex justify-content-center">
        <a href="{{route('promocao.ajax.viewEditar')}}" style="display: block">
            <h2>Editar</h2>
        </a>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <h3>Clientes na promoção ({{date('m/Y')}})</h3>
    </div>
    {{-- tabela --}}
    <div class="col-md-12">
        @include('includes.promocao.tabela_promocao')
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <h3>Verificar Clientes</h3>
    </div>
    {{-- tabela --}}
    <div class="col-md-12">
        @include('includes.promocao.tabela_verifcarPromocao')
    </div>
</div>
<script>
  
</script>
@endsection

