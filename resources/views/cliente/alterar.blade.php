@extends('layout.template_admin')

@section('titulo', 'Painel Administrativo')


@section('titulo_pagina', "Alterar Cliente - ID $cliente->id")


@section('conteudo')
<div class="row">
    <div class="col-md-12">
        <form action="{{route('cliente.alterar')}}" method="post" id="alterar_cliente">
            @csrf
            <input type="hidden" name="id_cliente" value="{{$cliente->id}}"/>
            <input type="hidden" name="url" value="{{$url}}"/>
            <div class="form-row">
                <div class="col-md-6">
                    <label>Nome: <span class="text-danger">*</span>  
                        <span class="text-warning" id="aviso-nome">Nome já existente no sistema!</span>
                    </label>
                    <input type="text" name="nome" placeholder="Nome do cliente" class="form-control limpar" id="nome" value="{{$cliente->nome}}" required/>
                    
                </div>
                <div class="col-md-6">
                    <label>Data de Nascimento: <span class="text-danger">*</span>
                    </label>
                    <input type="date" value="{{$cliente->data_nasc}}"   name="data_nasc" class="form-control" required/>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-4">
                    <label>Rua: <span class="text-danger">*</span></label>
                    <input type="text" name="rua" placeholder="Ex: Rua 133" class="form-control limpar" required value="{{$cliente->rua}}" />
                </div>
                <div class="col-md-4">
                    <label>Bairro: <span class="text-danger">*</span></label>
                    <input type="text" name="bairro" placeholder="Ex: Bairro Apelido" class="form-control limpar" required value="{{$cliente->bairro}}" />
                </div>
                <div class="col-md-4">
                    <label>Número: <span class="text-danger">*</span></label>
                    <input type="number" min="0" step="1" name="numero_casa" placeholder="Número da casa" class="form-control limpar" required value="{{$cliente->numero_casa}}" />
                </div>
            </div>
            <div class="form-row">
                <style>
                    #cke_complemento{
                        margin-bottom: 20px;
                    }
                </style>    
                <div class="col-md-12">
                    <label>Complemento:</label>
                    <textarea rows="15" class="form-control limpar" name="complemento" id="complemento">
                       {{trim($cliente->complemento)}} 
                    </textarea>   
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-12">
                    <input type="submit" value="Salvar Alterações" class="btn btn-success btn-block"/>  
                </div>
            </div>
        </form>
    </div>
</div>

<script>
//esconder campos
$("span#aviso-nome").hide();
//verficar se nome de cliente ja existente no banco  de dados
$("input#nome").on('keyup', function(e){
    let palavra = $(this).val();
    $.ajax({
        url: "{{route('cliente.ajax.verficar')}}",
        type: 'POST',
        data: {
            "_token": "{{ csrf_token() }}",
            "coluna": "nome",
            "valor" : palavra
        },
        success: function(e){
            if(e == "true"){
                $("span#aviso-nome").fadeIn('fast');
            }else{
                $("span#aviso-nome").fadeOut('fast');
            }
        },
        error: function(e){
            cnsole.log(e);
        }
    });
});
//cadastrar cliente
$("form#alterar_cliente").on('submit', function(e){
    $("div#load-page").fadeIn('fast');
});
</script>
@endsection

