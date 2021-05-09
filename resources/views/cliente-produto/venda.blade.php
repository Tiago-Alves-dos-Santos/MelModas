@extends('layout.template_admin')

@section('titulo', 'Painel Administrativo')


@section('titulo_pagina', 'Total R$')


@section('conteudo')
<style type="text/css">
    #form_vender fieldset:not(:first-of-type) {
      display: none;
    }
    .progress-bar{
        background-color:purple !important;
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
            <div class="progress-bar" role="progressbar" style="width: 75%;"  aria-valuemin="0" aria-valuemax="100"></div>
        </div>

        <form id="form_vender" novalidate action="action.php"  method="post">
            {{-- <input type="hidden" name="id_cliente" value="1" id="id_cliente"/> --}}
            {{-- <!-- --}}
          <fieldset>
            <h2>Selecione o cliente</h2>
            <div class="form-row">
                {{-- Input important --}}
                <input type="hidden" name="id_cliente" value="1" id="id_cliente"/>
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
                        <input style="cursor: pointer"  type="checkbox" class="custom-control-input" id="cliente_anonimo" checked>
                        <label class="custom-control-label" style="cursor: pointer" for="cliente_anonimo">Cliente não cadastrado</label>
                      </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-12" id="selecao_cliente">
                    {{-- @include('includes.cliente_produto.cliente_tabela_selecao') --}}
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-12 proxima">
                    <input type="button" name="password" class="next btn btn-success btn-lg" value="Seguir" style="top:10px" />
                </div>
            </div>
          </fieldset>
        {{-- --> --}}
          <fieldset id="fild_adicionar">
            <style>
                .fonte{
                    font-size:18px;
                    font-weight: bold;
                }
            </style>
            <h2>Lista de Produtos - <span class="text-success">Total:</span>
                <span class="text-success" id="total-venda"></span>
                <span class="text-danger" id="promocao"></span>
            </h2>
            <div class="form-row">
                <div class="col-md-4">
                    <label>Código</label>
                    <input type="text" id="codigo-input" class="form-control fonte" placeholder="Ex: 765479723423"/>
                </div>
                <div class="col-md-4">
                    <label>Peso(Grama)</label>
                    <input type="number" id="grama" step="0.001" class="form-control fonte" placeholder="Ex: 0.375"/>
                </div>
                <div class="col-md-4">
                    <label>Quantidade</label>
                    <input type="number" id="quantidade-input" class="form-control fonte" min="1" step="1" placeholder="Ex: 1"/>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-12">
                    @if(session('tipo') == session('tipo_users.0'))
                    <label>Vl.Unitario</label>
                    <input type="number" min="0.000" step="0.001" id="vlUnitario" class="form-control fonte" placeholder="Ex: 23,50"/>
                    @else
                    <label>Vl.Unitario</label>
                    <input type="number" min="0.000" step="0.001" id="vlUnitario" class="form-control" placeholder="Ex: 23,50" disabled/>
                    @endif
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-6">
                    <label>Configuracão</label>
                    <select class="custom-select fonte" id="configuracao-leitor">
                        <option value="2">Inserir Quantidade</option>
                        <option value="3">Quantidade Automática</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label></label>
                    {{-- <input type="submit" class="form-control" value="adcionar"/> --}}
                    <a href="" style="margin-top: 5px; margin-bottom: 10px" class="btn btn-success btn-block" id="add-produto">Adicionar <img src="{{asset('img/load.gif')}}" class="img-fluid" style="width:30px; height:30px" id="load_add"/></a>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-12">
                    <label></label>
                    {{-- <input type="submit" class="form-control" value="adcionar"/> --}}
                    <a href="" style="margin-top: 5px; margin-bottom: 10px" class="btn btn-danger btn-block" id="remover-todos">Remover Todos.</a>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-12">
                    @include('includes.cliente_produto.produto_tabela_lista')
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-12 proxima">
                    <input type="button" name="password" class="next btn btn-success btn-lg" value="Seguir" />
                    <input type="button" name="previous" class="previous btn btn-default btn-lg" value="Voltar" style="right: 115px"/>
                </div>
            </div>
          </fieldset>
          <fieldset>
            <h2>Informações Obrigatorias</h2>
            <div class="form-row">
                <div class="col-md-6">
                    <label for="mob">Forma de Pagamento</label>
                    <select class="custom-select fonte" id="forma_pagamento">
                        <option value="">Selecione a forma de pagamento</option>
                        <option value="A vista">A Vista</option>
                        <option value="cartão">Cartão</option>
                        <option value="permuta">Permuta</option>
                        <option value="fiado">Fiado</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label>Valor Recebido</label>
                    <input type="number" id="valor_recebido" placeholder="32,60" class="form-control fonte" min="1" step="0.01"/>
                </div>
                <div class="col-md-2">
                    <label>Parcelamento em:</label>
                    <input type="number" id="parcelamento" placeholder="12" class="form-control fonte" max="12" min="2" step="1"/>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-12">
                    <label>Desconto(%):
                        <span id="valor_desconto" class="text-success">R$</span>
                    </label>
                    <input type="number" id="desconto" placeholder="100" class="form-control fonte" min="0.01"  step="0.01"/>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-12">
                    <label>Descreva algo sobre a venda!</label>
                    <textarea name="descricao" id="descricao" rows="10" class="form-control fonte">

                    </textarea>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-12 proxima">
                    <input type="button" name="vender" class="submit btn btn-success btn-lg" value="Efetuar Venda(F9)" id="btn-venda" />
                    <input type="button" name="previous" class="previous btn btn-default btn-lg" value="Voltar" style="right: 200px"/>
                </div>
            </div>
            
          </fieldset>
        </form>
    </div>
</div>


<script src="{{asset('js/form-etapa.js')}}"></script>
<script>
$(document).on('keypress keydown',function (e) {
    if (e.which === 13) {
        $("a#add-produto").focus();
    }else if(e.which === 120){
        var evt = $.Event( "keypress", { which: 13 } );
        $("input#btn-venda").trigger('click');
    }
});
//enviar formulario
 
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
let id_cliente = null;
$("input#cliente_anonimo").on('click', function(e){
    if($(this).prop('checked')){
        //retira caso exista algum cliente selecionado
        $("table#tabela-clientes tbody tr").removeClass("selecionado");
        $("input#id_cliente").val(0);
        id_cliente = 1;
    }else{
        id_cliente = 0;
    }
    $("input#id_cliente").val(id_cliente);
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
    let valor_novo = $("#vlUnitario").val();
    let quantidade_grama = $("#grama").val();
    // let peso_venda = parseFloat("{{$peso_venda->valor_venda}}");
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
            if(e == "false"){
                $.msgbox({
                'message': "Código não encotrado",
                'type': "error",
                });
                return;
            }
            let produto = JSON.parse(e);
            let calc = 0;
            if(valor_novo > 0 && produto.peso != null){
                calc = valor_novo*(quantidade_grama * 1000);
                $("table#tabela-lista-produtos tbody").append("<tr data-id=''><td>"+produto.id+"</td><td class='codigo-valor'>"+produto.codigo+"</td><td>"+produto.nome+"</td><td>"+produto.marca+"</td><td class='vl-unitario'>"+valor_novo+"</td><td class='quantidade_venda'>"+quantidade_vender+"</td><td class='quantidade_grama'>"+quantidade_grama+"</td><td class='total-valor'>"+calc.toFixed(2)+"</td><td><a href='' class='btn btn-danger excluir-produto' data-total='"+calc.toFixed(2)+"' >Remover</a></td></tr>");
            }else if(valor_novo > 0 && !produto.peso){
                calc = valor_novo*quantidade_vender;
                $("table#tabela-lista-produtos tbody").append("<tr data-id=''><td>"+produto.id+"</td><td class='codigo-valor'>"+produto.codigo+"</td><td>"+produto.nome+"</td><td>"+produto.marca+"</td><td class='vl-unitario'>"+valor_novo+"</td><td class='quantidade_venda'>"+quantidade_vender+"</td><td class='quantidade_grama'>"+quantidade_grama+"</td><td class='total-valor'>"+calc.toFixed(2)+"</td><td><a href='' class='btn btn-danger excluir-produto' data-total='"+calc.toFixed(2)+"' >Remover</a></td></tr>");
            }else if(!valor_novo && !produto.peso){
                calc = produto.valor_venda*quantidade_vender;
                $("table#tabela-lista-produtos tbody").append("<tr data-id=''><td>"+produto.id+"</td><td class='codigo-valor'>"+produto.codigo+"</td><td>"+produto.nome+"</td><td>"+produto.marca+"</td><td class='vl-unitario'>"+produto.valor_venda+"</td><td class='quantidade_venda'>"+quantidade_vender+"</td><td class='quantidade_grama'>"+quantidade_grama+"</td><td class='total-valor'>"+calc.toFixed(2)+"</td><td><a href='' class='btn btn-danger excluir-produto' data-total='"+calc.toFixed(2)+"' >Remover</a></td></tr>");
            }else if(!valor_novo && produto.peso != null){
                calc = produto.valor_venda*(quantidade_grama * 1000);
                $("table#tabela-lista-produtos tbody").append("<tr data-id=''><td>"+produto.id+"</td><td class='codigo-valor'>"+produto.codigo+"</td><td>"+produto.nome+"</td><td>"+produto.marca+"</td><td class='vl-unitario'>"+produto.valor_venda+"</td><td class='quantidade_venda'>"+quantidade_vender+"</td><td class='quantidade_grama'>"+quantidade_grama+"</td><td class='total-valor'>"+calc.toFixed(2)+"</td><td><a href='' class='btn btn-danger excluir-produto' data-total='"+calc.toFixed(2)+"' >Remover</a></td></tr>");
            }
            let valores = $("td.total-valor");
            let total=0;
            for(let i=0; i< valores.length; i++){
                let campo = $(valores).eq(i).html();
                total += parseFloat(campo);
            }
            $("span#total-venda").html(total.toFixed(2));
            $("a.excluir-produto").on('click' , function(e){
                e.preventDefault();
                let total_produto = parseFloat($(this).attr('data-total'));
                total -=  total_produto;
                $("span#total-venda").html(total.toFixed(2));
                $(this).parents("tr").remove();
            });
            $("input#quantidade-input").val("");
            $("input#codigo-input").val("");
            $("input#vlUnitario").val("");
            $("input#grama").val("");
            $("input#codigo-input").focus();
        },
        error: function(e){
            console.log(e);
        }
    });

    }
});
//adicionar produto
$("#load_add").hide();
$("a#add-produto").on('click', function(e){
    e.preventDefault();
    $("#load_add").show();
    $(this).prop('disabled',true);
    let codigo = $("input#codigo-input").val();
    let quantidade_vender = $("input#quantidade-input").val();
    let valor_novo = $("#vlUnitario").val();
    let quantidade_grama = $("#grama").val();
    // let peso_venda = parseFloat("{{$peso_venda->valor_venda}}");
    $.ajax({
        url: "{{route('venda.ajax.addProduto')}}",
        type: 'POST',
        data:{
            "codigo": codigo,
            "_token": "{{ csrf_token() }}",
        },
        complete:function(e){
            if(e != "false"){
                $("#load_add").hide();
                $(this).prop('disabled',false);
            }
        },
        success: function(e){
            if(e == "false"){
                $.msgbox({
                'message': "Código não encotrado",
                'type': "error",
                });
                return;
            }
            let produto = JSON.parse(e);
            let calc = 0;
            if(valor_novo > 0 && produto.peso != null){
                calc = valor_novo*(quantidade_grama * 1000);
                $("table#tabela-lista-produtos tbody").append("<tr data-id=''><td>"+produto.id+"</td><td class='codigo-valor'>"+produto.codigo+"</td><td>"+produto.nome+"</td><td>"+produto.marca+"</td><td class='vl-unitario'>"+valor_novo+"</td><td class='quantidade_venda'>"+quantidade_vender+"</td><td class='quantidade_grama'>"+quantidade_grama+"</td><td class='total-valor'>"+calc.toFixed(2)+"</td><td><a href='' class='btn btn-danger excluir-produto' data-total='"+calc.toFixed(2)+"' >Remover</a></td></tr>");
            }else if(valor_novo > 0 && !produto.peso){
                calc = valor_novo*quantidade_vender;
                $("table#tabela-lista-produtos tbody").append("<tr data-id=''><td>"+produto.id+"</td><td class='codigo-valor'>"+produto.codigo+"</td><td>"+produto.nome+"</td><td>"+produto.marca+"</td><td class='vl-unitario'>"+valor_novo+"</td><td class='quantidade_venda'>"+quantidade_vender+"</td><td class='quantidade_grama'>"+quantidade_grama+"</td><td class='total-valor'>"+calc.toFixed(2)+"</td><td><a href='' class='btn btn-danger excluir-produto' data-total='"+calc.toFixed(2)+"' >Remover</a></td></tr>");
            }else if(!valor_novo && !produto.peso){
                calc = produto.valor_venda*quantidade_vender;
                $("table#tabela-lista-produtos tbody").append("<tr data-id=''><td>"+produto.id+"</td><td class='codigo-valor'>"+produto.codigo+"</td><td>"+produto.nome+"</td><td>"+produto.marca+"</td><td class='vl-unitario'>"+produto.valor_venda+"</td><td class='quantidade_venda'>"+quantidade_vender+"</td><td class='quantidade_grama'>"+quantidade_grama+"</td><td class='total-valor'>"+calc.toFixed(2)+"</td><td><a href='' class='btn btn-danger excluir-produto' data-total='"+calc.toFixed(2)+"' >Remover</a></td></tr>");
            }else if(!valor_novo && produto.peso != null){
                calc = produto.valor_venda*(quantidade_grama * 1000);
                $("table#tabela-lista-produtos tbody").append("<tr data-id=''><td>"+produto.id+"</td><td class='codigo-valor'>"+produto.codigo+"</td><td>"+produto.nome+"</td><td>"+produto.marca+"</td><td class='vl-unitario'>"+produto.valor_venda+"</td><td class='quantidade_venda'>"+quantidade_vender+"</td><td class='quantidade_grama'>"+quantidade_grama+"</td><td class='total-valor'>"+calc.toFixed(2)+"</td><td><a href='' class='btn btn-danger excluir-produto' data-total='"+calc.toFixed(2)+"' >Remover</a></td></tr>");
            }
            let valores = $("td.total-valor");
            let total=0;
            for(let i=0; i< valores.length; i++){
                let campo = $(valores).eq(i).html();
                total += parseFloat(campo);
            }
            $("span#total-venda").html(total.toFixed(2));
            $("a.excluir-produto").on('click' , function(e){
                e.preventDefault();
                let total_produto = parseFloat($(this).attr('data-total'));
                total -=  total_produto;
                $("span#total-venda").html(total.toFixed(2));
                $(this).parents("tr").remove();
            });
            $("input#quantidade-input").val("");
            $("input#codigo-input").val("");
            $("input#vlUnitario").val("");
            $("input#grama").val("");
            $("input#codigo-input").focus();
        },
        error: function(e){
            // console.log(e.message);
            $("#load_add").hide();
            $(this).prop('disabled',false);
            $.msgbox({
                'message': "Código não encotrado",
                'type': "error",
            });
        }
    });
});
$("a#remover-todos").on('click', function(e){
    e.preventDefault();
    $("table#tabela-lista-produtos tbody").html("");
    $("span#total-venda").html(0);
});

//realizar venda
$("input#btn-venda").on('click', function(e){
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

    let precos_unitarios = $("td.vl-unitario");
    let precos_unitarios_array = [];
    for(let i=0; i< precos_unitarios.length; i++){
        precos_unitarios_array.push($(precos_unitarios).eq(i).html());
    }

    let valores_venda = $("td.quantidade_venda");
    let valores_total = [];
    for(let i=0; i< valores_venda.length; i++){
        let campo = $(valores_venda).eq(i).html();
        valores_total.push(campo);
    }
    //campos_gramas
    let peso = $("td.quantidade_grama");
    let pesos = [];
    for(let i=0; i< peso.length; i++){
        let campo = parseFloat($(peso).eq(i).html());
        pesos.push(campo);
    }
    // console.log(pesos);
    //campos variados
    let valor_recebido = $("input#valor_recebido").val();
    let parcelamento = $("input#parcelamento").val();
    if(parcelamento == null){
        parcelamento = 0;
    }
    let desconto = $("input#desconto").val();
    let descricao = $("#descricao").val();
    let forma_pagamento = $("select#forma_pagamento").val();
    if(forma_pagamento ==""){
        $.msgbox({
                'message': "Selecione a forma de pagamento",
                'type': "error",
                });
                return;
    }
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
            "forma_pagamento": forma_pagamento,
            "precos_unitarios_array": precos_unitarios_array,
            "pesos": pesos
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
            }else if(e == "erro 4"){
                $.msgbox({
                'message': "Quantidade em peso armazenada insuficiente para efetuar a venda desejada!",
                'type': "error",
                });
            }
        },
        error: function(e){
            console.log(e);
        }
    });

});  
$("form#form_vender").on('submit', function(e){
    e.preventDefault();
    

});
//calcular o desconto 
$("input#desconto").on('keydown keyup', function(e){
    let total = parseFloat($("span#total-venda").html());
    // let desconto = parseInt($(this).val());
    // let valor_atual = total * ((100 - desconto)/100);
    let desconto = parseFloat($(this).val());
    let valor_atual = total - desconto;
    $("span#valor_desconto").html("R$ "+valor_atual);
});
</script>
@endsection