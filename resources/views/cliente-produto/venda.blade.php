@extends('layout.template_admin')

@section('titulo', 'Painel Administrativo')


@section('titulo_pagina', 'Efetuar Venda')


@section('conteudo')
<style type="text/css">
    #form_vender fieldset:not(:first-of-type) {
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

        <form id="form_vender" novalidate action="action.php"  method="post">
          <fieldset>
            <h2>Selecione o cliente</h2>
            <div class="form-row">
                {{-- Input important --}}
                <input type="hidden" name="id_cliente" value="" id="id_cliente"/>
                {{-- Input important --}}
                <div class="col-md-5">
                    <label for="email">Nome:</label>
                    <input type="email" class="form-control" id="nome"  placeholder="Nome">
                </div>
                <div class="col-md-5">
                    <label for="email">Telefone:</label>
                    <input type="email" class="form-control telefone-mask" id="telefone" placeholder="(88) 9 9966-7788">
                </div>
                <div class="col-md-2">
                    <label for="email"> </label>
                    <a href="" style="margin-top: 5px" class="btn btn-block btn-primary" id="buscarCliente"> Buscar</a>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-12">
                    <div class="custom-control custom-checkbox">
                        <input style="cursor: pointer"  type="checkbox" class="custom-control-input" id="cliente_anonimo">
                        <label class="custom-control-label" style="cursor: pointer" for="cliente_anonimo">Cliente não cadastrado</label>
                      </div>
                    <input type="text" id="cliente_anonimo_input" class="form-control" placeholder="Ex: Cliente Nome" style="margin-bottom: 10px" readonly/>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-12" id="selecao_cliente">
                    {{-- @include('includes.cliente_produto.cliente_tabela_selecao') --}}
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-12 proxima">
                    <input type="button" name="password" class="next btn btn-success" value="Seguir" style="top:10px" />
                </div>
            </div>
          </fieldset>
          <fieldset>
            <h2>Lista de Produtos - <span class="text-success">Total:</span>
                <span class="text-success" id="total-venda"></span></h2>
            <div class="form-row">
                <div class="col-md-4">
                    <label>Código</label>
                    <input type="text" id="codigo-input" class="form-control" placeholder="Ex: 765479723423"/>
                </div>
                <div class="col-md-2">
                    <label>Quantidade</label>
                    <input type="number" id="quantidade-input" class="form-control" min="1" step="1" placeholder="Ex: 1"/>
                </div>
                <div class="col-md-2">
                    <label></label>
                    {{-- <input type="submit" class="form-control" value="adcionar"/> --}}
                    <a href="" style="margin-top: 5px; margin-bottom: 10px" class="btn btn-success btn-block" id="add-produto">Adicionar</a>
                </div>
                <div class="col-md-2">
                    <label>Configuracão</label>
                    <select class="custom-select" id="configuracao-leitor">
                        <option value="2">Inserir Quantidade</option>
                        <option value="3">Quantidade Automática</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label></label>
                    {{-- <input type="submit" class="form-control" value="adcionar"/> --}}
                    <a href="" style="margin-top: 5px; margin-bottom: 10px" class="btn btn-danger btn-block" id="remover-todos">Remover Tds.</a>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-12">
                    @include('includes.cliente_produto.produto_tabela_lista')
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
                    <select class="custom-select" id="forma_pagamento">
                        <option>Selecione a forma de pagamento</option>
                        <option>A Vista</option>
                        <option>Cartão</option>
                        <option>Fiado</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label>Valor Recebido</label>
                    <input type="number" id="valor_recebido" placeholder="32,60" class="form-control" min="1" step="0.01"/>
                </div>
                <div class="col-md-2">
                    <label>Parcelamento em:</label>
                    <input type="number" id="parcelamento" placeholder="12" class="form-control" max="12" step="1"/>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-12">
                    <label>Desconto(%):
                        <span id="valor_desconto" class="text-success">R$</span>
                    </label>
                    <input type="number" id="desconto" placeholder="100" class="form-control" min="0" max="100" step="1"/>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-12">
                    <label>Descreva algo sobre a venda!</label>
                    <textarea name="descricao" id="descricao" rows="10" class="form-control">

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
$("a#buscarCliente").on('click', function(e){
    e.preventDefault();
    let dados = {
        "nome": $("input#nome").val(),
        "telefone": $("input#telefone").val(),
        "_token": "{{ csrf_token() }}"
    };
    $("div#load-page").fadeIn('fast');
    $.ajax({
        url: "{{route('venda.ajax.getClientesSelect')}}",
        type: 'POST',
        data:dados,
        complete: function(e){
            $("div#load-page").fadeOut('fast');
        },
        success: function(e){
            $("#selecao_cliente").empty().html(e);
        },
        error: function(e){
            console.log(e);
        }
    });
});
//verficar se e um cliente anonimo
$("input#cliente_anonimo").on('click', function(e){
    if($(this).prop('checked')){
        $("input#cliente_anonimo_input").val("");
        $("input#cliente_anonimo_input").removeAttr('readonly');
        $("input#cliente_anonimo_input").attr('required',"");
        $("input#cliente_anonimo_input").focus();
        //retira caso exista algum cliente selecionado
        $("table#tabela-clientes tbody tr").removeClass("selecionado");
        $("input#id_cliente").val(0);
    }else{
        $("input#cliente_anonimo_input").val("");
        $("input#cliente_anonimo_input").prop('readonly', true);
        $("input#cliente_anonimo_input").removeAttr('required');
    }
});

//configurar leitor para tirar o submit
$("select#configuracao-leitor").on('change', function(e){
    if($(this).val() == 2){
        $("input#quantidade-input").val("");
        $("input#quantidade-input").prop('readonly', false);
    }else if($(this).val() == 3){
        $("input#quantidade-input").val(1);
        $("input#quantidade-input").prop('readonly', true);
    }
});

//impedir q cadastre duas vezes maquina de ler codigo
let cont = 0;
$("input#codigo-input").on('keydown keyup', function(e){
    if(e.which == 13 && $("select#configuracao-leitor").val() == 2) {
        //cancela a ação padrão
        e.preventDefault();
        $("input#quantidade-input").focus();
    }else if(e.which == 13 && $("select#configuracao-leitor").val() == 3) {
        e.preventDefault();
    let codigo = $("input#codigo-input").val();
    let quantidade_vender = $("input#quantidade-input").val();
    cont++;
    if(cont == 2){
        cont = 0;
        return;
    }
    $.ajax({
        url: "{{route('venda.ajax.addProduto')}}",
        type: 'POST',
        data:{
            "codigo": codigo,
            "_token": "{{ csrf_token() }}",
        },
        success: function(e){
            let produto = JSON.parse(e);
            $("table#tabela-lista-produtos tbody").append("<tr data-id=''><td>"+produto.id+"</td><td class='codigo-valor'>"+produto.codigo+"</td><td>"+produto.nome+"</td><td>"+produto.marca+"</td><td>"+produto.valor_venda+"</td><td class='quantidade_venda'>"+quantidade_vender+"</td><td class='total-valor'>"+(produto.valor_venda*quantidade_vender)+"</td><td><a href='' class='btn btn-danger excluir-produto' data-total='"+(produto.valor_venda*quantidade_vender)+"' >Remover</a></td></tr>");
            let valores = $("td.total-valor");
            let total=0;
            for(let i=0; i< valores.length; i++){
                let campo = $(valores).eq(i).html();
                total += parseFloat(campo);
            }
            $("span#total-venda").html(total);
            $("a.excluir-produto").on('click' , function(e){
                e.preventDefault();
                let total_produto = parseFloat($(this).attr('data-total'));
                total -=  total_produto;
                $("span#total-venda").html(total);
                $(this).parents("tr").remove();
            });
            $("input#codigo-input").val("");
            $("input#codigo-input").focus();
        },
        error: function(e){
            console.log(e);
        }
    });

    }
});
//adicionar produto
$("a#add-produto").on('click', function(e){
    e.preventDefault();
    let codigo = $("input#codigo-input").val();
    let quantidade_vender = $("input#quantidade-input").val();
    $.ajax({
        url: "{{route('venda.ajax.addProduto')}}",
        type: 'POST',
        data:{
            "codigo": codigo,
            "_token": "{{ csrf_token() }}",
        },
        success: function(e){
            let produto = JSON.parse(e);
            $("table#tabela-lista-produtos tbody").append("<tr data-id=''><td>"+produto.id+"</td><td class='codigo-valor'>"+produto.codigo+"</td><td>"+produto.nome+"</td><td>"+produto.marca+"</td><td>"+produto.valor_venda+"</td><td class='quantidade_venda'>"+quantidade_vender+"</td><td class='total-valor'>"+(produto.valor_venda*quantidade_vender)+"</td><td><a href='' class='btn btn-danger excluir-produto' data-total='"+(produto.valor_venda*quantidade_vender)+"' >Remover</a></td></tr>");
            let valores = $("td.total-valor");
            let total=0;
            for(let i=0; i< valores.length; i++){
                let campo = $(valores).eq(i).html();
                total += parseFloat(campo);
            }
            $("span#total-venda").html(total);
            $("a.excluir-produto").on('click' , function(e){
                e.preventDefault();
                let total_produto = parseFloat($(this).attr('data-total'));
                total -=  total_produto;
                $("span#total-venda").html(total);
                $(this).parents("tr").remove();
            });
            $("input#quantidade-input").val("");
            $("input#codigo-input").val("");
            $("input#codigo-input").focus();
        },
        error: function(e){
            console.log(e);
        }
    });
});
$("a#remover-todos").on('click', function(e){
    e.preventDefault();
    $("table#tabela-lista-produtos tbody").html("");
    $("span#total-venda").html(0);
});

//realizar venda
$("form#form_vender").on('submit', function(e){
    e.preventDefault();
    //cliente q vai comprar
    let cliente_id = $("input#id_cliente").val();
    //cliente anoanimo
    let cliente_anonimo_nome = $("input#cliente_anonimo_input").val();
    //ver qual cliente esta selcionado
    let valores = $("td.codigo-valor");
    let codigos = [];
    for(let i=0; i< valores.length; i++){
        let campo = $(valores).eq(i).html();
        codigos.push(campo);
    }
    let valores_venda = $("td.quantidade_venda");
    let valores_total = [];
    for(let i=0; i< valores_venda.length; i++){
        let campo = $(valores_venda).eq(i).html();
        valores_total.push(campo);
    }
    //campos variados
    let valor_recebido = $("input#valor_recebido").val();
    let parcelamento = $("input#parcelamento").val();
    let desconto = $("input#desconto").val();
    let descricao = $("#descricao").val();
    let forma_pagamento = $("select#forma_pagamento").val();
    let valor_total = parseFloat($("span#total-venda").html());
    $("div#load-page").fadeIn('fast');
    $.ajax({
        url: "{{route('venda.ajax.vender')}}",
        type: 'POST',
        data:{
            "_token": "{{ csrf_token() }}",
            "cliente_id": cliente_id,
            "cliente_anonimo_nome": cliente_anonimo_nome,
            "codigos": codigos,
            "quantidade_vendas": valores_total,
            "valor_recebido": valor_recebido,
            "parcelamento": parcelamento,
            "desconto": desconto,
            "descricao": descricao,
            "valor_total": valor_total,
            "forma_pagamento": forma_pagamento
        },
        complete: function(e){
            $("div#load-page").fadeOut('fast');
        },
        success: function(e){
             e = JSON.parse(e);
            let numero = parseFloat(e);
            if(typeof numero === "number" && !isNaN(numero)){
                $.msgbox({ 
                    'message' : 'Troco: '+numero+'\n Deseja efetuar outra venda?',
                    'type' : 'confirm', 
                    'buttons' : [
                        {'type' : 'yes', 'value': 'Sim'},
                        {'type' : 'no', 'value': 'Não'},
                        {'type' : 'close', 'value': 'Cancelar' }
                    ],
                    'callback' : function(result){
                        if(result){
                            window.location.href= "{{route('venda.view.venda')}}";
                        }else{
                            window.location.href= "{{route('admin.view.dashboard')}}";
                        }
                    }
                });
            }else if(e == "erro 1"){
                $.msgbox({
                'message': "Cliente não foi selecionado!",
                'type': "error",
                });
            }else if(e == "erro 2"){
                $.msgbox({
                'message': "Nenhum Produto foi selecionado!",
                'type': "error",
                });

            }else if(e == "erro 3"){
                $.msgbox({
                'message': "Valor recebido é insuficiente para efetuar a compra",
                'type': "error",
                });
            }
        },
        error: function(e){
            console.log(e);
        }
    });


});
//calcular o desconto 
$("input#desconto").on('keydown keyup', function(e){
    let total = parseFloat($("span#total-venda").html());
    let desconto = parseInt($(this).val());
    let valor_atual = total * ((100 - desconto)/100);
    $("span#valor_desconto").html("R$ "+valor_atual);
});
</script>
@endsection