<div id="tabela-caixa">
    <div class="row">
        <div class="col-md-12">
            <div class="scroll">
                <table>
                    <thead class="orange">
                        <tr>
                            <td colspan="3" style="background-color: green">
                                Ao abrir
                            </td>
                            <td colspan="2" style="background-color: red">
                                Ao fechar
                            </td>
                            <td colspan="3" style="background-color: blue">
                                Caixa fechado
                            </td>
                        <tr>
                        <tr>
                            <td>#ID#</td>
                            <td>Dinheiro</td>
                            <td>Moeda</td>
                            <td>Dinheiro</td>
                            <td>Moeda</td>
                            <td>Estado</td>
                            <td>Hora Fechado</td>
                            <td>Lucro</td>
                            <td>Dia fluxo</td>
                            <td>Ações</td>
                        </tr>
                    </thead>
                    <tbody id="conteudo-telefone">
                        @forelse ($caixas as $caixa)
                        <tr>
                            <td>{{$caixa->id}}</td>
                            <td>{{$caixa->dinheiro_inicio}}</td>
                            <td>{{$caixa->moeda_inicio}}</td>
                            <td>{{$caixa->dinheiro_fim}}</td>
                            <td>{{$caixa->moeda_fim}}</td>
                            @if ($caixa->status_caixa == 1)
                                <td style="background-color: green;color:white">Aberto</td>
                            @else
                                <td style="background-color: red;color:white">Fechado</td>
                            @endif
                            @if ($caixa->hora_fechado != null)
                            <td>{{date('H:i:s', strtotime($caixa->hora_fechado))}}</td>
                            @else  
                            <td>Ainda aberto</td>
                            @endif
                            @if ($caixa->lucro_dia > 0)
                                <td>{{$caixa->lucro_dia}}</td>
                            @elseif($caixa->lucro_dia == 0)  
                                <td style="background-color: yellow; color:white">{{$caixa->lucro_dia}}</td>  
                            @else
                                <td style="background-color: red; color:white">{{$caixa->lucro_dia}}</td>
                            @endif
                            <td>{{date('d/m/Y', strtotime($caixa->created_at))}}</td>
                            <td>
                                @php
                                    $data = date('d-m-Y', strtotime($caixa->created_at));
                                @endphp
                                @if ($caixa->status_caixa == 1)
                                <a href="" data-id="{{$caixa->id}}" class="btn btn-warning fechar_caixa">Fechar</a>
                                @elseif($caixa->status_caixa == 0 && strtotime($data) == strtotime(date('d-m-Y')))
                                <a href="" class="btn btn-primary reabrir_caixa" data-id="{{$caixa->id}}">Reabrir</a>
                                @endif
    
                                <a href="" class="btn btn-danger excluir" data-id="{{$caixa->id}}">Excluir</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10">Nenhum registro encontrado!</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6" style="position:relative;">
                <h4 style="font-weight: bold;">{{$registros}} / {{$caixas->total()}}</h4>
        </div>
        <div class="col-md-6 d-flex justify-content-end paginador">
            @if(isset($filtro))
                {{$caixas->appends($filtro)->links()}}
            @else
                {{$caixas->links()}}
            @endif
        </div>
    </div>
    <script>
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
            $("#tabela-caixa").empty().html(e);
        },
        complete: function(e){
            $("div#load-page").fadeOut('fast');
        },
        error: function (e) {

        }
    });
});        
        $("a.fechar_caixa").on('click', function(e){
        e.preventDefault();
        let moeda = $("#moeda").val();
        let dinheiro = $("#dinheiro").val();
        let id = $(this).attr('data-id');
        if(moeda == ""){
            $.msgbox({ 
            'message' : 'Campo moeda vazio!',
            }); 
            return;
        }
        if(dinheiro == ""){
            $.msgbox({ 
            'message' : 'Campo dinheiro vazio!',
            }); 
            return;
        }
        $.msgbox({ 
        'message' : 'Você realmente deseja fechar o caixa?',
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
                    url: "{{route('caixa.close')}}",
                    type: 'POST',
                    data:{
                        "_token": "{{ csrf_token() }}",
                        "dinheiro": dinheiro,
                        "moeda":moeda,
                        'id': id
                    },
                    complete: function(e){
                        $("div#load-page").fadeOut('fast');
                    },
                    success: function(e){
                        window.location.reload();
                    },
                    error: function(e){
                        console.log(e);
                    }
                });
            }
        } 
    });
        });


    $("a.reabrir_caixa").on('click', function(e){
        e.preventDefault();
        let id = $(this).attr('data-id');
        $.msgbox({ 
        'message' : 'Você realmente deseja reabrir o caixa?',
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
                    url: "{{route('caixa.reOpen')}}",
                    type: 'POST',
                    data:{
                        "_token": "{{ csrf_token() }}",
                        'id': id
                    },
                    complete: function(e){
                        $("div#load-page").fadeOut('fast');
                    },
                    success: function(e){
                        window.location.reload();
                    },
                    error: function(e){
                        console.log(e);
                    }
                });
            }
        } 
    });
        });  



        $("a.excluir").on('click', function(e){
        e.preventDefault();
        let id = $(this).attr('data-id');
        $.msgbox({ 
        'message' : 'Você realmente deseja excluir o caixa?',
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
                    url: "{{route('caixa.delete')}}",
                    type: 'POST',
                    data:{
                        "_token": "{{ csrf_token() }}",
                        'id': id
                    },
                    complete: function(e){
                        $("div#load-page").fadeOut('fast');
                    },
                    success: function(e){
                        window.location.reload();
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
</div>


