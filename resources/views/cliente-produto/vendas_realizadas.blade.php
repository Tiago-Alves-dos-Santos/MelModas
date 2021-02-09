@extends('layout.template_admin')

@section('titulo', 'Painel Administrativo')


@section('titulo_pagina', "Vendas Realizadas")

@section('conteudo')
<form method="post" action="{{route('venda.ajax.filtrar')}}" id="filtrar">
    @csrf
    <div class="form-row">
        <div class="col-md-4">
            <label>Nome</label>
            <input type="text" name="nome" class="form-control" placeholder="Ex: Cliente Nome"/>
        </div>
        <div class="col-md-4">
            <label>Telefone</label>
            <input type="text" name="telefone" class="form-control telefone-mask " placeholder="(88) 9 9843-5123"/>
        </div>
        <div class="col-md-4">
            <label>Data</label>
            <input type="date" name="datas" class="form-control"/>
        </div>
    </div>
    <div class="form-row">
        <div class="col-md-6">
            <input type="submit" class="btn btn-success btn-block" value="Buscar" style="margin-top: 20px; margin-bottom: 20px"/>
        </div>
        <div class="col-md-6">
            <a href="" class="btn btn-primary btn-block" style="margin-top: 20px; margin-bottom: 20px" id="all-vendas">Todas as Vendas</a>
        </div>
    </div>
</form>
@include('includes.cliente_produto.lista_vendas')

<script>
//todas as vendas
$("a#all-vendas").on('click', function(e){
    e.preventDefault();
    $("div#load-page").fadeIn('fast');
    $.ajax({
        type: "GET",
        url: "{{route('venda.view.viewVendas')}}",
        complete: function(e){
            $("div#load-page").fadeOut('fast');
        },
        success: function (e) {
            $("#lista-vendas").empty().html(e)
        },
        error: function(e){
            console.log(e);
        }
    });
});    
//filtrar
$("form#filtrar").on('submit', function(e){
    e.preventDefault();
    let dados = $(this).serialize();
    $("div#load-page").fadeIn('fast');
    $.ajax({
        type: "POST",
        url: $(this).attr('action'),
        data: dados,
        complete: function(e){
            $("div#load-page").fadeOut('fast');
        },
        success: function (e) {
            $("#lista-vendas").empty().html(e);
        },
        error: function(e){
            console.log(e);
        }
    });
});
</script>
@endsection

