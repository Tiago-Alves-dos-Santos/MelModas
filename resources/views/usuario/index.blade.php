@extends('layout.template_admin')

@section('titulo', 'Painel Administrativo')


@section('titulo_pagina', 'Usúarios')


@section('conteudo')
<div class="row">
    <div class="col-md-12">
        <a href="{{route('admin.view.create')}}" class="btn btn-block btn-success">Adicionar</a>
    </div>
</div>
@include('includes.usuario.tabela')

<script>

</script>
@endsection