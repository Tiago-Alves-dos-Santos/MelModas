<style>
div.lista-venda{
    position: relative;
    box-sizing: border-box;
    background-color: rgba(252, 139, 2,1);
    color:white;
    padding: 10px 20px;
}
div.lista-venda h3, div.lista-venda h4{
    display: inline-block;
}
div.lista-venda h3{
    float: right;
    margin-top: -50px;
}
div.lista-venda a{
    color:white;
}
</style>
<div id="lista-vendas">
    <div class="row">
        <div class="scroll">
            <table id="tabela-produtos" style="margin-top: 15px">
                <thead class="orange">
                    <tr>
                        <td>#ID#</td>
                        <td>Nome</td>
                        <td>Telefone</td>
                        <td>Valor Total(R$)</td>
                        <td>Forma Pagamento</td>
                        <td>Parcelamento</td>
                        <td>Estado</td>
                        <td>Data</td>
                        <td>Descrição</td>
                        <td>Ações</td>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($vendas as $item)
                    <tr data-id="">
                        <td>{{$item->id}}</td>
                        <td>{{($item->cliente_anonimo == null ?$item->nome:$item->cliente_anonimo)}}</td>
                        <td>{{$telefones[$loop->index]}}</td>
                        <td>{{$item->valor_total}}</td>
                        <td>{{$item->forma_pagamento}}</td>
                        <td>{{$item->parcelamento}}/12</td>
                        @if ($item->estado_compra == "concluida")
                        <td style="background-color: green; color:white">{{$item->estado_compra}}</td>
                        @else
                        <td style="background-color: red; color:white">{{$item->estado_compra}}</td> 
                        @endif
                        <td>{{date('d/m/Y', strtotime($item->created_at))}}</td>
                        <td>{{$item->descricao}}</td>
                        <td>
                            <a href="{{route('venda.listarProdutos', [
                            'id' => (isset($item->id_cliente)?$item->id_cliente:null),
                            'data' => $item->created_at
                            ])}}" target="_blank">Lista de Produtos</a>

                            <a target="_blank" href="{{route('venda.comprovanteVenda', [
                                "nome" => ($item->cliente_anonimo == null ?$item->nome:$item->cliente_anonimo),
                                "data" => $item->created_at,
                                "id" => ($item->id_cliente == null ?0:$item->id_cliente)
                            ])}}">/ Comprovante</a>

                            <a data-idcl="{{$item->id_cliente}}" data-dia="{{$item->created_at}}" id="venda_reseta" href="#">/ Resetar</a>
                            @if($item->forma_pagamento == "fiado" && $item->estado_compra == "andamento")
                            <a id="venda_concluir" href="#" data-idcl="{{$item->id_cliente}}" data-dia="{{$item->created_at}}">
                                / Concluir
                            </a>
                            @endif
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="9">Venda não encontrada!</td>
                        </tr>   
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6" style="position:relative;">
                {{-- <div style="position: absolute; right:0;">
                    <h5 style="float: left;">{{$registros}} / {{$clientes->total()}}</h5>
                </div> --}}
                <h4 style="font-weight: bold;">{{$registros}} / {{$vendas->total()}}</h4>
        </div>
        <div class="col-md-6 d-flex justify-content-end paginador">
            @if(isset($filtro))
                {{$vendas->appends($filtro)->links()}}
            @else
                {{$vendas->links()}}
            @endif
        </div>
    </div>
    

<script>
//colocar classe active no link clicado
$('span.page-link').click(function () {
    $('.pagination').find('.active').removeClass('active');
    $(this).parent().addClass('active');
});
//paginação ajax
$('.pagination .page-link').click(function (e) {
    e.preventDefault();
    $("div#load-page").fadeIn('fast');
    let urls = $(this).attr('href');
    $.ajax({
        type: 'GET',
        url: urls,
        success: function (e) {
            $("#lista-vendas").empty().html(e);
        },
        complete: function(e){
            $("div#load-page").fadeOut('fast');
        },
        error: function (e) {

        }
    });
});

$("a#venda_reseta").on('click',function(e){
    e.preventDefault();
    let id_cliente = $(this).attr('data-idcl');
    let dia = $(this).attr('data-dia');
    $.msgbox({ 
        'message' : 'Você realmente deseja resetar esta venda?',
        'type' : 'confirm', 
        'buttons' : [
            {'type' : 'yes', 'value': 'Sim'},
            {'type' : 'no', 'value': 'Não'},
            {'type' : 'close', 'value': 'Cancelar' }
        ],
        'callback' : function(result){
            if(result){
                $("div#load-page").fadeIn('fast');
                $.ajax({
                    type: 'POST',
                    url: "{{route('venda.ajax.resetarVenda')}}",
                    data:{
                        "id": id_cliente,
                        "dia": dia,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function (e) {
                        console.log(e);
                        if(e == "true"){
                            getRouteAjax("{{route('venda.view.viewVendas')}}", "#lista-vendas", "{{$vendas->currentPage()}}");
                        }
                    },
                    complete: function(e){
                        $("div#load-page").fadeOut('fast');
                    },
                    error: function (e) {
                        console.log(e);
                    }
                });
            }
        } 
    });
    
});
$("a#venda_concluir").on('click',function(e){
    e.preventDefault();
    let id_cliente = $(this).attr('data-idcl');
    let dia = $(this).attr('data-dia');
    $.msgbox({ 
        'message' : 'Você realmente deseja concluir esta venda?',
        'type' : 'confirm', 
        'buttons' : [
            {'type' : 'yes', 'value': 'Sim'},
            {'type' : 'no', 'value': 'Não'},
            {'type' : 'close', 'value': 'Cancelar' }
        ],
        'callback' : function(result){
            if(result){
                $("div#load-page").fadeIn('fast');
                $.ajax({
                    type: 'POST',
                    url: "{{route('venda.ajax.concluirVenda')}}",
                    data:{
                        "id": id_cliente,
                        "dia": dia,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function (e) {
                        console.log(e);
                        if(e == "true"){
                            getRouteAjax("{{route('venda.view.viewVendas')}}", "#lista-vendas", "{{$vendas->currentPage()}}");
                        }
                    },
                    complete: function(e){
                        $("div#load-page").fadeOut('fast');
                    },
                    error: function (e) {
                        console.log(e);
                    }
                });
            }
        } 
    });
    
});
</script>