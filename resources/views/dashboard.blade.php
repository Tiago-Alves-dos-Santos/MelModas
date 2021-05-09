@extends('layout.template_admin')

@section('titulo', 'Painel Administrativo')


@section('titulo_pagina', 'Painel Administrativo')


@section('conteudo')
<div class="row text-center pad-top">
    @if(\App\Model\PesoVenda::find(1)->peso_total > 0)
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6" id="abrir_venda">
        <div class="div-square">
            <a href="{{route('venda.view.venda')}}" >
            <i class="fas fa-cash-register fa-5x"></i>
            <h4>Abrir Venda</h4>
            </a>
        </div>
    
    
    </div> 
    @endif
    {{-- @if(session('tipo') == session('tipo_users.0')) --}}
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
        <div class="div-square">
            <a href="{{route('venda.view.viewVendas')}}" >
            <i class="fa fa-clipboard fa-5x"></i>
        <h4>Vendas Realizadas</h4>
        </a>
        </div>
    
    
    </div>
    {{-- @endif --}}

    @if(session('tipo') == session('tipo_users.0'))
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
        <div class="div-square">
            <a href="{{route('produto.view.cadastro')}}" >
            <i class="fas fa-cart-plus fa-5x"></i>
        <h4>Cadastrar Produtos</h4>
        </a>
        </div>
    
    
    </div>
    @endif

    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
        <div class="div-square">
            <a href="{{route('cliente.view.cadastro')}}" >
            <i class="fa fa-users fa-5x"></i>
        <h4>Cadastrar Cliente</h4>
        </a>
        </div>
    
    
    </div>

    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
        <div class="div-square">
            <a href="{{route('cliente.view.principal')}}" >
            <i class="fa fa-users fa-5x"></i>
        <h4>Clientes </h4>
        </a>
        </div>
    
    
    </div>
    @if(session('tipo') == session('tipo_users.0'))
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
        <div class="div-square">
            <a href="{{route('produto.view.principal')}}" >
            <i class="fas fa-shopping-cart fa-5x"></i>
        <h4>Estoque</h4>
        </a>
        </div>
    </div>
    @endif

</div>


<div class="row text-center pad-top">
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
        <div class="div-square">
            <a href="{{route('caixa.view.index')}}" >
            <i class="fas fa-cash-register fa-5x"></i>
            <h4>Caixa</h4>
            </a>
        </div>
    
    
    </div>
    {{-- <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
        <div class="div-square">
            <a href="blank.html" >
                <i class="fas fa-receipt fa-5x"></i>
            <h4>Notas Promissórias</h4>
            </a>
        </div>
    
    </div> --}}
    @if(session('tipo') == session('tipo_users.0'))
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
        <div class="div-square">
            <a href="https://www.invertexto.com/codigo-barras-lote" target="_blank">
                <i class="fas fa-barcode fa-5x"></i>
        <h4>Código de Barra</h4>
        </a>
        </div>    
    </div>
    @endif

    @if(session('tipo') == session('tipo_users.0'))
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
        <div class="div-square">
            <a href="{{route('peso.view.index')}}" >
                <i class="fas fa-weight fa-5x"></i>
        <h4>Configurações Peso</h4>
        </a>
        </div>
    
    
    </div>
    @endif

    @if(session('tipo') == session('tipo_users.0') || session('tipo') == session('tipo_users.1'))
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
        <div class="div-square">
            <a href="{{route('deposito.view.index')}}">
                <i class="far fa-money-bill-alt fa-5x"></i>
        <h4>Depositos</h4>
        </a>
        </div>    
    </div>
    @endif

    @if(session('tipo') == session('tipo_users.0'))
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
        <div class="div-square">
            <a href="{{route('admin.view.config')}}">
                <i class="fas fa-users-cog fa-5x"></i>
        <h4>Usúario</h4>
        </a>
        </div>    
    </div>
    @endif

    

    @if(session('tipo') == session('tipo_users.0'))
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
        <div class="div-square">
            <a href="{{route('promocao.view.principal')}}" >
                <i class="fas fa-bullhorn fa-5x"></i>
        <h4>Promoção</h4>
        </a>
        </div>
    
    
    </div> 
    @endif

</div>


<!-- /. ROW  --> 
</div>
<!-- /. PAGE INNER  -->
</div>
<script>
    
</script>
@endsection