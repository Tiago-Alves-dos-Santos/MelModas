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
        @forelse ($vendas as $item)
        <div class="col-md-8" style="margin-top: 40px">
            <div class="lista-venda">
                <h4>{{($item->cliente_anonimo == null ?$item->nome:$item->cliente_anonimo)}} || R${{$item->valor_total}} ({{$item->forma_pagamento}}) {{$item->parcelamento}}/12</h4>
                <h5>{{$telefones[$loop->index]}}</h5>
                <h3>{{date('d/m/Y', strtotime($item->created_at))}}</h3>

                <p>
                    {{$item->descricao}}
                </p>
            </div>                
            <div style="clear: both"></div>
        </div>
        <div class="col-md-4" style="margin-top: 40px">
            <div class="lista-venda" style="text-align: center">
                <h4>
                    <a href="{{route('venda.listarProdutos', [
                        'id' => (isset($item->id_cliente)?$item->id_cliente:null),
                        'data' => $item->created_at
                    ])}}" target="_blank">Lista de Produtos</a>
                </h4>
            </div>
        </div>
        @empty
        <div class="col-md-8">
            <div class="lista-venda">
                <h4>Sem Vendas Realizadas!</h4>
                
            </div>                
            <div style="clear: both"></div>
        </div>
        <div class="col-md-4">
            <div class="lista-venda" style="text-align: center">
                <h4>
                    <a href="#">Vazio</a>
                </h4>
            </div>
        </div>
        @endforelse
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
</script>