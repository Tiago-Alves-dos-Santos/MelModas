@extends('layout.template_admin')

@section('titulo', 'Painel Administrativo')


@section('titulo_pagina', 'Estoque')


@section('conteudo')
<div class="row mb-5">
    <form method="POST" action="{{route('produto.ajax.filtrar')}}" id="filtro-produto">
        @csrf
        <div class="form-row">
            <div class="col-md-4">
                <label>Código: </label>
                <input type="text" name="codigo" placeholder="Ex: 734234636" class="form-control"/>
            </div>
            <div class="col-md-4">
                <label>Nome: </label>
                <input type="text" name="nome" placeholder="Ex: Kaike, Sabonete" class="form-control"/>
            </div>
            <div class="col-md-4">
                <label>Marca: </label>
                <input type="text" name="marca" placeholder="Ex: Lacoste, Natura" class="form-control"/>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-6">
                <label> </label>
                <input type="submit"  value="Buscar" class="btn btn-success btn-block" />
            </div>
            <div class="col-md-6">
                <label> </label>
                <a href="" id="produto-voltar" class="btn btn-primary btn-block" >Voltar</a>
            </div>
        </div>
    </form>
</div>
@include('includes.produto.tabela_produto')
<script>
//buscar todos os produtos
$("a#produto-voltar").on('click', function(e){
    e.preventDefault();
    $("div#load-page").fadeIn('fast');
    $.ajax({
        url: "{{route('produto.view.principal')}}",
        type: 'GET',
        complete: function(e){
            $("div#load-page").fadeOut('fast');
        },
        success: function(e){
            $("#tabela-produto").empty().html(e);
        },
        error: function(e){
            console.log(e);
        }
    });
});
//filtrar, buscar produtos
$("form#filtro-produto").on('submit', function(e){
    e.preventDefault();
    let dados = $(this).serialize();
    $("div#load-page").fadeIn('fast');
    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: dados,
        complete: function(e){
            $("div#load-page").fadeOut('fast');
        },
        success: function(e){
            $("#tabela-produto").empty().html(e);
        },
        error: function(e){
            console.log(e);
        }
    });
});
</script>
@endsection