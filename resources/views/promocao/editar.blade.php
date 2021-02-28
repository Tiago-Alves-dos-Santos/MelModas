@extends('layout.template_admin')

@section('titulo', 'Painel Administrativo')


@section('titulo_pagina', 'Editar Promoção')


@section('conteudo')
<div class="row">
    <div class="col-md-12">
        <h3 class="text-danger">
            *Clientes que já obtiveram a promoção do mês {{date('m/Y')}} não serão removidos por qualquer
            alteração na promoção!!*
        </h3>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <form action="{{route('promocao.alterar')}}" method="post">
            @csrf
            <input type="hidden" name="id" value="{{$promocao->id}}"/>
            <div class="form-row">
                <div class="col-md-4">
                    <label>Valor densconto</label>
                    <input type="number" min="1" name="desconto" max="100" step="1" required class="form-control" placeholder="1" value="{{$promocao->desconto_porcento}}"/>
                </div>
                <div class="col-md-4">
                    <label>Valor a atingir: R$</label>
                    <input type="number" name="valor_atingir" min="1" step="0.01" required class="form-control" placeholder="1" value="{{$promocao->valor_atingir}}"/>
                </div>
                <div class="col-md-4">
                    <label></label>
                    <input type="submit" value="Salvar" class="btn btn-block btn-success"/>
                </div>
            </div>
        </form>
    </div>
</div>
 
<script>
  
</script>
@endsection
