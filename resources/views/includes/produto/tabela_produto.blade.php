<div id="tabela-produto">
    <div class="row" id="">
        <div class="col-md-12">
            <div class="scroll">
                <table id="tabela-produtos" style="margin-top: 15px">
                    <thead class="orange">
                        <tr>
                            <td>#ID#</td>
                            <td>Código</td>
                            <td>Nome</td>
                            <td>Marca</td>
                            <td>Valor(Compra)</td>
                            <td>Valor(Venda)</td>
                            <td>Quantidade</td>
                            <td>Peso Kg</td>
                            <td>Ações</td>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($produtos as $produto)
                        <tr data-id="{{$produto->id}}">
                            <td>{{$produto->id}}</td>
                            <td>{{$produto->codigo}}</td>
                            <td>{{$produto->nome}}</td>
                            <td>{{$produto->marca}}</td>
                            <td>{{$produto->valor_compra}}</td>
                            <td>{{$produto->valor_venda}}</td>
                            <td>{{$produto->quantidade}}</td>
                            <td>{{$produto->peso}}</td>
                            <td>
                                <a href="{{route('produto.view.alterar', [
                                    'id' => base64_encode($produto->id),
                                    'url' => base64_encode($produtos->currentPage())
                                ])}}" 
                                class="btn btn-sm btn-warning">Alterar</a>
                            <a href="" data-id="{{$produto->id}}" class="btn btn-sm btn-danger excluir-produto">Excluir</a>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="8">Sem Produtos Cadastrados!</td>
                            </tr>   
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6" style="position:relative;">
                <h4 style="font-weight: bold;">{{$registros}} / {{$produtos->total()}}</h4>
        </div>
        <div class="col-md-6 d-flex justify-content-end paginador">
            @if(isset($filtro))
                {{$produtos->appends($filtro)->links()}}
            @else
                {{$produtos->links()}}
            @endif
        </div>
    </div>
    
    
    <div class="row margim-tp">
        <div class="col-md-12">
            <div class="block-text" style="margim-top:10px">
                <h3 style="text-align: center">Descrição</h3>
                <div id="descricao-produto">
    
                </div>
            </div>
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
            $("#tabela-produto").empty().html(e);
        },
        complete: function(e){
            $("div#load-page").fadeOut('fast');
        },
        error: function (e) {

        }
    });
});    
//busca descrição de produto, atraves de um objeto produto retornado
$("table#tabela-produtos tbody tr").on('dblclick', function(e){
    let id = parseInt($(this).attr('data-id'));
    $("table#tabela-produtos tbody tr").removeClass("selecionado");
    $(this).addClass("selecionado");
    $("div#load-page").fadeIn('fast');
    $.ajax({
        url: "{{route('produto.ajax.getProduto')}}",
        type: 'POST',
        data:{
            "_token": "{{ csrf_token() }}",
            "id": id
        },
        complete: function(e){
            $("div#load-page").fadeOut('fast');
        },
        success: function(e){
            let produto = JSON.parse(e);
            $("div#descricao-produto").html(produto.descricao);
        },
        error: function(e){
            console.log(e);
        } 
    });
});
//excluir produto
$("a.excluir-produto").on('click', function(e){
    e.preventDefault();
    let id = $(this).attr('data-id');
    $.msgbox({ 
        'message' : 'Realmente deseja excluir esse produto?',
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
                    url: "{{route('produto.ajax.delete')}}",
                    type: 'POST',
                    data:{
                        "_token": "{{ csrf_token() }}",
                        "id": id
                    },
                    complete: function(e){
                        $("div#load-page").fadeOut('fast');
                    },
                    success: function(e){
                        $.msgbox({
                            'message': "Produto excluido com sucesso",
                            'type': 'info'
                        });
                        getRouteAjax("{{route('produto.view.principal')}}", "#tabela-produto", "{{$produtos->currentPage()}}");
                        // $("#tabela-produto").empty().html(e);
                    },
                    error: function(e){
                        console.log(e);
                    }
                });
            }
        } 
    });
});
</script>