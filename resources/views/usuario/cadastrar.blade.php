@extends('layout.template_admin')
@section('titulo', 'Painel Administrativo')


@section('titulo_pagina', 'Adicionar Depositos')


@section('conteudo')
<div class="row">
    <div class="col-md-12">
        <form method="POST" action="{{route('admin.create')}}" id="form_user">
            @csrf
            <div class="form-row">
                <div class="col-md-12">
                    <label>Nome:</label>
                    <input type="text" name="nome" placeholder="Nome Fulano" class="form-control"/>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-6">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" placeholder="fulano@email.com"/>
                </div>
                <div class="col-md-6">
                    <label>Senha</label>
                    <input type="password" name="senha" class="form-control" placeholder="Senha"/>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-12">
                    <label>Tipo usúario</label>
                    <select name="tipo_user" id="" class="custom-select">
                        <option value="admin">Admin</option>
                        <option value="gerenciador">Gerenciador</option>
                        <option value="atendente">Atendente</option>
                    </select>
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
$("#form_user").on('submit',function(e){
    $("div#load-page").fadeIn('fast');
});
</script>
@endsection