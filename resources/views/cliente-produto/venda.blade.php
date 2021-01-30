@extends('layout.template_admin')

@section('titulo', 'Painel Administrativo')


@section('titulo_pagina', 'Efetuar Venda')


@section('conteudo')
<style type="text/css">
    #regiration_form fieldset:not(:first-of-type) {
      display: none;
    }
    .progress-bar{
        background-color: orange !important;
    }
    .proxima input, .proxima a{
        position: absolute;
        z-index: 200;
        right: 15px;
        margin-top: 10px;
        margin-bottom: 10px;
    }
</style>

<div class="row">
    <div class="col-md-12">
        <div class="progress">
            <div class="progress-bar bg-warning" role="progressbar" style="width: 75%"  aria-valuemin="0" aria-valuemax="100"></div>
        </div>

        <form id="regiration_form" novalidate action="action.php"  method="post">
          <fieldset>
            <h2>Selecione o cliente</h2>
            <div class="form-row">
                <div class="col-md-5">
                    <label for="email">Nome:</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                </div>
                <div class="col-md-5">
                    <label for="email">Telefone:</label>
                    <input type="email" class="form-control telefone-mask" id="email" name="email" placeholder="(88) 9 9966-7788">
                </div>
                <div class="col-md-2">
                    <label for="email"> </label>
                    <a href="" style="margin-top: 5px" class="btn btn-block btn-primary"> Buscar</a>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-12">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="customCheck1">
                        <label class="custom-control-label" for="customCheck1">Cliente não cadastrado</label>
                      </div>
                    <input type="text" name="password" class="form-control" placeholder="Ex: Cliente Nome" style="margin-bottom: 10px" readonly/>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-12">
                    @include('includes.cliente_produto.cliente_tabela_selecao')
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-12 proxima">
                    <input type="button" name="password" class="next btn btn-success" value="Seguir" />
                </div>
            </div>
          </fieldset>
          <fieldset>
            <h2>Lista de Produtos</h2>
            <div class="form-row">
                <div class="col-md-8">
                    <label>Código</label>
                    <input type="text" class="form-control" placeholder="Ex: 765479723423"/>
                </div>
                <div class="col-md-2">
                    <label>Quantidade</label>
                    <input type="number" class="form-control" min="1" step="1" placeholder="Ex: 1"/>
                </div>
                <div class="col-md-2">
                    <label></label>
                    {{-- <input type="submit" class="form-control" value="adcionar"/> --}}
                    <a href="" style="margin-top: 5px" class="btn btn-success btn-block">Adicionar</a>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-12">
                    <div>

                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-12 proxima">
                    <input type="button" name="password" class="next btn btn-success" value="Seguir" />
                    <input type="button" name="previous" class="previous btn btn-default" value="Voltar" style="right: 100px"/>
                </div>
            </div>
          </fieldset>
          <fieldset>
            <h2>Informações Obrigatorias</h2>
            <div class="form-row">
                <div class="col-md-6">
                    <label for="mob">Forma de Pagamento</label>
                    <select class="custom-select">
                        <option>Selecione a forma de pagamento</option>
                        <option>A Vista</option>
                        <option>Cartão</option>
                        <option>Fiado</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label>Valor Recebido</label>
                    <input type="number" placeholder="32,60" class="form-control" min="1" step="0.01"/>
                </div>
                <div class="col-md-2">
                    <label>Parcelamento em:</label>
                    <input type="number" placeholder="12" class="form-control" max="12" step="1"/>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-12">
                    <label>Descreva algo sobre a venda!</label>
                    <textarea name="descricao" rows="10" class="form-control">

                    </textarea>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-12 proxima">
                    <input type="submit" name="submit" class="submit btn btn-success" value="Efetuar Venda" />
                    <input type="button" name="previous" class="previous btn btn-default" value="Voltar" style="right: 150px"/>
                </div>
            </div>
            
          </fieldset>
        </form>
    </div>
</div>


<script src="{{asset('js/form-etapa.js')}}"></script>
<script>
//buscar cliente para selecionar
</script>
@endsection