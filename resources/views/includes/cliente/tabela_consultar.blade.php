<div id="tabela-cliente">
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
                        <td>Ações</td>
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
                            @if($cliente->id != 1)
                            <a href="{{route('cliente.view.alterar', [
                                'id' => base64_encode($cliente->id),
                                'url' => base64_encode($clientes->currentPage())
                                ])}}" 
                                class="btn btn-sm btn-warning">Alterar</a>
                            <a href="" data-id="{{$cliente->id}}" class="btn btn-sm btn-danger excluir-cliente">Excluir</a>
                            @endif
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
            {{-- <div style="position: absolute; right:0;">
                <h5 style="float: left;">{{$registros}} / {{$clientes->total()}}</h5>
            </div> --}}
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

<div class="row">
    <form action="{{route('cliente.ajax.addTelefone')}}" style="margin-bottom: 30px" id="add_numero">
        @csrf
        <input type="hidden" id="cliente_id" name="id_cliente" value=""/>
        <div class="form-row">
            <div class="col-md-10">
                <label>Adicionar Número

                    <span class="text-danger" id="aviso-numero">Número já existente no sistema!</span>
                </label>
                <input id="numero-add" type="text" name="telefone_add" class="form-control limpar telefone-mask" maxlength="16" minlength="16" required placeholder="(11) 9 3333-4444"/>
            </div>
            <div class="col-md-2">
                <label></label>
                <input type="submit" value="Adicionar" class="btn btn-success btn-block" style="margin-top: 5px"/>
            </div>
        </div>
    </form>
</div>

<div class="row margim-tp">
    <div class="col-md-12">
        <div class="block-text" style="margim-top:10px">
            <h3 style="text-align: center">Complemento</h3>
            {{-- <p>
                It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using
            </p> --}}
            <div id="complemento-cliente">

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
            $("#tabela-cliente").empty().html(e);
        },
        complete: function(e){
            $("div#load-page").fadeOut('fast');
        },
        error: function (e) {

        }
    });
});


//buscar telefone e complemento apos selecionar cliente
$("table#tabela-clientes tbody tr").on('dblclick',function(e){
    let id = parseInt($(this).attr('data-id'));
    $("table#tabela-clientes tbody tr").removeClass("selecionado");
    $(this).addClass("selecionado");
    $("input#cliente_id").val(id);
    $("div#load-page").fadeIn('fast');
    // mudar complemento
    $.ajax({
        url: "{{route('cliente.ajax.getCliente')}}",
        type: 'POST',
        data:{
            "_token": "{{ csrf_token() }}",
            "id": id
        },
        success: function(e){
            e = JSON.parse(e);
            $("div#complemento-cliente").html(e.complemento);
            alert(teste.complemento);
            console.log(e);
        },
        error: function(e){
            console.log(e);
        }
    });

    //mudar telefones
    $.ajax({
        url: "{{route('cliente.ajax.listarTelfones')}}",
        type: 'POST',
        data: {
            "_token": "{{ csrf_token() }}",
            "id_cliente": id,
        },
        complete: function(e){
            $("div#load-page").fadeOut('fast');
        },
        success: function(e){
            $("#tabela-telefone").empty().html(e);
        },
        error: function(e){
            console.log(e);
        }
    });
});
//verficar se numero do cliente é existente no banco
$("span#aviso-numero").hide();
$("input#numero-add").on('keyup', function(e){
    let numero = $(this).val();
    $.ajax({
        url: "{{route('cliente.ajax.verficar')}}",
        type: 'POST',
        data: {
            "_token": "{{ csrf_token() }}",
            "coluna": "telefone",
            "valor" : numero
        },
        success: function(e){
            if(e == "true"){
                $("span#aviso-numero").fadeIn('fast');
            }else{
                $("span#aviso-numero").fadeOut('fast');
            }
        },
        error: function(e){
            cnsole.log(e);
        }
    });
});

//adcionar numero ao cliente selecionado
$("form#add_numero").on('submit', function(e){
    e.preventDefault();
    $("div#load-page").fadeIn('fast');
    let dados = $(this).serialize();
    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: dados,
        complete: function(e){
            $("div#load-page").fadeOut('fast');
        },
        success: function(e){
            if(e == 2){
                $.msgbox({
                'message': "Número já existente no sistema!",
                'type': "error",
                });
            }else if(e == 3){
                $.msgbox({
                'message': "Não permitido cadastrar número em cliente anonimo.",
                'type': "error",
                });
            }else{
                $("#tabela-telefone").empty().html(e);
                $.msgbox({
                'message': "Número adicionado com sucesso!",
                'type': "info",
                });
            }
        },
        error: function(e){
            console.log(e);
            let erros = new Array("nulo");
                    if (e.status == 422) { // when status code is 422, it's a validation issue
                        $.each(e.responseJSON.errors, function (i, error) {
                            // console.log(error[0]);
                            erros[1] += error[0]+'<br>\n';
                        });
                        erros[1] = erros[1].replace('undefined','');
                        $.msgbox({
                            'message': erros[1],
                        });

                    }
        }
    });
});
//excluir cliente e seus telefones
$("a.excluir-cliente").on('click', function(e){
    e.preventDefault();
    let id = $(this).attr('data-id');

    $.msgbox({ 
        'message' : 'Você realmente deseja excluir este cliente?',
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
                    url: "{{route('cliente.delete')}}",
                    type: 'POST',
                    data:{
                        "_token": "{{ csrf_token() }}",
                        "id_cliente": id
                    },
                    complete: function(e){
                        $("div#load-page").fadeOut('fast');
                    },
                    success: function(e){
                        console.log(e);
                        $.msgbox({
                            'message': "Cliente deletado com sucesso!",
                            'type':'info'
                        });
                        getRouteAjax("{{route('cliente.view.principal')}}", "#tabela-cliente", "{{$clientes->currentPage()}}");
                        // $("#tabela-cliente").empty().html(e);
                        
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