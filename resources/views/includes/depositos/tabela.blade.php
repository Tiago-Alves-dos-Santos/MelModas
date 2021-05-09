<div id="tabela-deposito">
    <div class="row" id="">
        <div class="col-md-12">
            <div class="scroll">
                <table id="tabela-clientes">
                    <thead class="orange">
                        <tr>
                            <td>#ID#</td>
                            <td>Local</td>
                            <td>Descrição</td>
                            <td>Valor(R$)</td>
                            <td>Depositado</td>
                            <td>Ações</td>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($depositos as $deposito)
                        <tr data-id="{{$deposito->id}}">
                            <td>{{$deposito->id}}</td>
                            <td>{{$deposito->local}}</td>
                            <td>{{$deposito->descricao}}</td>
                            <td>{{$deposito->valor}}</td>
                            <td>{{date('d/m/Y H:i:s', strtotime($deposito->created_at))}}</td>
                            <td>
                                <a href="{{route('deposito.delete')}}" data-id="{{$deposito->id}}" class="btn btn-danger excluir">Excluir</a>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="6">Sem depósitos!</td>
                            </tr>   
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="d-flex flex-row justify-content-end">
                {{$depositos->links()}}
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
                $("#tabela-deposito").empty().html(e);
            },
            complete: function(e){
                $("div#load-page").fadeOut('fast');
            },
            error: function (e) {
    
            }
        });
    });
    $("a.excluir").on('click', function(e){
        e.preventDefault();
        let id = $(this).attr('data-id');
        let urls = $(this).attr('href');
        $.msgbox({ 
        'message' : 'Deseja prosseguir com a exclusão?',
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
                    type: 'DELETE',
                    url: urls,
                    data:{
                        "_token": "{{ csrf_token() }}",
                        "id": id
                    },
                    complete: function(e){
                        $("div#load-page").fadeOut('fast');
                    },
                    success: function(e){
                        $.msgbox({
                        'message': "Total de "+e+" registro deletado",
                        'type': "info",
                        });
                        getRouteAjax("{{route('deposito.view.index')}}", "#tabela-deposito", "{{$depositos->currentPage()}}");
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

