@extends('layout.template_admin')

@section('titulo', 'Painel Administrativo')


@section('titulo_pagina', 'Clientes')


@section('conteudo')
<div class="row" style="margin-bottom: 30px">
            <form action="{{route('cliente.ajax.filtro')}}" method="post" id="filtrar-cliente">
                @csrf
                <div class="form-row">
                    <div class="col-md-4">
                        <label>Nome:</label>
                        <input type="text" placeholder="Nome do Cliente" class="form-control" name="nome"/>
                    </div>
                    <div class="col-md-4">
                        <label>Número(Celular):</label>
                        <input id="numero" id="numero" type="text" name="telefone" class="form-control limpar telefone-mask" maxlength="16" minlength="16" placeholder="(11) 9 3333-4444"/>
                    </div>
    
                    <div class="col-md-2 d-flex justify-content-start">
                        <label> </label>
                        <input type="submit" value="Filtrar" class="btn btn-success btn-block" style="margin-top: 5px"/>
                    </div>
                    <div class="col-md-2 d-flex justify-content-start">
                        <label> </label>
                        <a href="{{route('cliente.view.principal')}}" class="btn btn-primary btn-block" style="margin-top: 5px">Voltar</a>
                    </div>  
                </div>
            </form>
</div>
@include('includes.cliente.tabela_consultar')

<div class="row">
    <div class="col-md-12">
        <h3>Telefones</h3>
        <hr/>
    </div>
</div>
@include('includes.cliente.tabela_telefone')

<script>
$("form#filtrar-cliente").on('submit', function(e){
    e.preventDefault();
    $("div#load-page").fadeIn('fast');
    let dados = $(this).serialize();
    $.ajax({
        url: $(this).attr('action'),
        type:'POST',
        data: dados,
        complete: function(e){
            $("div#load-page").fadeOut('fast');
        },
        success: function(e){
            $("#tabela-cliente").empty().html(e);
        },
        error: function(e){
            console.log(e);
            let erros = new Array("nulo");
                    if (e.status == 422) { // when status code is 422, it's a validation issue
                        $.each(e.responseJSON.errors, function (i, error) {
                            // console.log(error[0]);
                            erros[1] += error[0]+'<br>\n';
                        });
                        erros[1] = erros[1].replace('undefined','');
                        $.msgbox({
                            'message': erros[1],
                        });

                    }
        }
    });
});
    
</script>
@endsection

