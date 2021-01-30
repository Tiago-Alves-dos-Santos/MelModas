@extends('layout.template_admin')

@section('titulo', 'Painel Administrativo')


@section('titulo_pagina', 'Cadastrar(Adicionar) Produto ao Estoque')


@section('conteudo')
<form method="POST" action="{{route('produto.alterar')}}" enctype="multipart/form-data" id="cadastrar-produto">
    @csrf
    <input type="hidden" value="{{$url}}" name="url"/>
    <input type="hidden" value="{{base64_encode($produto->id)}}" name="id"/>
    <div class="form-row">
        <div class="col-md-4">
            <label>Código:</label>
            <span class="text-danger" id="aviso-codigo">Código já existente no sistema!</span>
            <input type="text" id="codigo" name="codigo" placeholder="Ex: Perfume, Blusa..." class="form-control" required value="{{$produto->codigo}}"/>
        </div>
        <div class="col-md-4">
            <label>Nome:</label>
            <input type="text" name="nome" placeholder="Ex: Perfume, Blusa..." class="form-control" required value="{{$produto->nome}}"/>
        </div>
        <div class="col-md-4">
            <label>Marca:</label>
            <input type="text" name="marca" placeholder="Ex: Natura, Lacoste..." class="form-control" required value="{{$produto->marca}}"/>
        </div>
    </div>
    <div class="form-row">
        <div class="col-md-6">
            <label>Valor(Compra):</label>
            <input type="number" name="valor_compra" placeholder="35." class="form-control" min="1" step="0.01" value="{{$produto->valor_compra}}"/>
        </div>
        <div class="col-md-6">
            <label>Valor(Venda):</label>
            <input type="number" name="valor_venda" placeholder="35.50" class="form-control" required min="1" step="0.01" value="{{$produto->valor_venda}}"/>
        </div>
    </div>
    <div class="form-row">
        <div class="col-md-12">
            <label>Quantidade:</label>
            <input type="number" min="1" step="1" name="quantidade" placeholder="5" class="form-control" required value="{{$produto->quantidade}}"/>
        </div>
    </div>
    <div class="form-row">
        <div class="col-md-12">
            <label>Descrição:</label>
            <textarea class="form-control" name="descricao" rows="15">
                {{$produto->descricao}}
            </textarea>
        </div>
    </div>

    <div class="form-row">
        <div class="col-md-12">
            <input type="submit" class="btn btn-block btn-success" value="Salvar Alterações"/>
        </div>
    </div>

</form>

<script>
$("span#aviso-codigo").hide();
$("input#codigo").on('keyup keydown', function(e){
    let codigo = $(this).val();
    $.ajax({
        url: "{{route('produto.ajax.verficarCodigo')}}",
        type: 'POST',
        data:{
            "_token": "{{ csrf_token() }}",
            "id": "{{$produto->id}}",
            'codigo': codigo
        },
        complete: function(e){

        },
        success: function(e){
            if(e == "true"){
                $("span#aviso-codigo").fadeIn('fast');
            }else{
                $("span#aviso-codigo").fadeOut('fast');
            }
        },
        error: function(e){
            console.log(e);
        }
    });
});
</script>
@endsection