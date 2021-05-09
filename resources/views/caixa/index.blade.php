@extends('layout.template_admin')

@section('titulo', 'Painel Administrativo')


@section('titulo_pagina', "Caixa")


@section('conteudo')
<div class="row">
   <div class="col-md-12">
        <form action="{{route('caixa.abrir')}}" method="post">
            @csrf
            <div class="form-row">
                <div class="col-md-4">
                    <label>Dinheiro(R$)</label>
                    <input type="number" id="dinheiro" name="dinheiro" step="0.01" class="form-control" required/>
                </div>
                <div class="col-md-4">
                    <label>Moedas(R$)</label>
                    <input type="number" id="moeda" name="moeda" step="0.01" class="form-control" required/>
                </div>
                <div class="col-md-4">
                    <label></label>
                    <input type="submit" value="Abrir Caixa" class="btn btn-block btn-success"/>
                </div>
            </div>
        </form>
   </div>
</div>
<div style="margin:15px 0;"></div>
<div class="row">
    <div class="col-md-12">
        @include('includes.caixa.tabela')
    </div>
</div>

<script>

</script>
@endsection

