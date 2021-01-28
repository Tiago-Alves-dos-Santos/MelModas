@extends('layout.template_admin')

@section('titulo', 'Painel Administrativo')


@section('titulo_pagina', 'Cadastrar(Adicionar) Produto ao Estoque')


@section('conteudo')
<form action="" method="" id="consultar-codigo">
    <div class="form-row">
        <div class="col-md-10">
            <label>Código:</label>
            <input type="text" id="codigo" placeholder="Ex: 123456789" class="form-control"/>
        </div>
        <div class="col-md-2">
            <label>  </label>
            <input type="submit" value="Consultar" class="btn btn-block btn-primary" style="margin-top: 5px" id="btn-consultar-codigo"/>
        </div>
    </div>
</form>
<div id="includes">
    {{-- @include('includes.produto.cadastro_form') --}}
</div>

<script>
    $("form#consultar-codigo").on('submit', function(e){
        e.preventDefault();
        let codigo = $("input#codigo").val();
        let dados = {
            "_token": "{{ csrf_token() }}",
            "codigo": codigo
        };
        $("div#load-page").fadeIn('fast');
        $.ajax({
            url: "{{route('produto.ajax.cadastrarAtualizar')}}",
            type: 'POST',
            data: dados,
            complete: function(e){
                $("div#load-page").fadeOut('fast');
            },
            success: function(e){
                $("#includes").empty().html(e);
            },
            error: function(e){
                console.log(e);
            }
        });
    });
</script>
@endsection