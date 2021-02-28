<div id="cliente-selecao">
    <div class="row" id="">
        <div class="col-md-12">
            <div class="scroll">
                <table id="tabela-clientes">
                    <thead class="orange">
                        <tr>
                            <td>#ID#</td>
                            <td>Nome</td>
                            <td>Rua</td>
                            <td>Bairro</td>
                            <td>Casa(Número)</td>
                            <td>Idade</td>
                            <td>Nascimento</td>
                            <td>Telefones</td>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $calculo = new App\Model\Cliente();
                        @endphp
                        @forelse ($clientes as $cliente)
                        @php
                            $idade = $calculo->calcularIdade((string) $cliente->data_nasc);
                        @endphp
                        <tr data-id="{{$cliente->id}}">
                            <td>{{$cliente->id}}</td>
                            <td>{{$cliente->nome}}</td>
                            <td>{{$cliente->rua}}</td>
                            <td>{{$cliente->bairro}}</td>
                            <td>{{$cliente->numero_casa}}</td>
                            <td>{{$idade}}</td>
                            <td>{{date('d/m/Y', strtotime($cliente->data_nasc))}}</td>
                            <td>
                                <a href="{{route('cliente.getTelefonesLista', ['id' => $cliente->id])}} " target="_blank">Telefones</a>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="8">Sem Clientes Cadastrados!</td>
                            </tr>   
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-6" style="position:relative;">
                <h4 style="font-weight: bold;">{{$registros}} / {{$clientes->total()}}</h4>
        </div>
        <div class="col-md-6 d-flex justify-content-end paginador">
            @if(isset($filtro))
                {{$clientes->appends($filtro)->links()}}
            @else
                {{$clientes->links()}}
            @endif
        </div>
    </div>
</div>

<script>
//paginador ative
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
            $("#cliente-selecao").empty().html(e);
        },
        complete: function(e){
            $("div#load-page").fadeOut('fast');
        },
        error: function (e) {

        }
    });
});

//selecionar cliente da compra
$("table#tabela-clientes tbody tr").on('dblclick',function(e){
    let id = parseInt($(this).attr('data-id'));
    $("table#tabela-clientes tbody tr").removeClass("selecionado");
    $(this).addClass("selecionado");
    $("input#id_cliente").val(id);
    // $("div#load-page").fadeIn('fast');
    if($("input#cliente_anonimo").prop('checked')){
        $("input#cliente_anonimo").prop('checked',false);
    }
    //verficar se cliente tem promocao
    $.ajax({
        type: "POST",
        url: "{{route('venda.ajax.verficarPromocao')}}",
        data:{
            "id":id,
            "_token": "{{ csrf_token() }}",
        },
        success: function (e) {
            if(e == "false"){
                $.msgbox({
                'message': "O Cliente não possui promoção",
                'type': "info",
                });
            }else{
                promocao = JSON.parse(e);
                $("span#promocao").html("Promoção: "+promocao.desconto_porcento+"%");
            }
        },
        error: function(e){
            console.log(e);
        }
    });
});
</script>