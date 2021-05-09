<div id="tabela-users">
    <div class="row" id="">
        <div class="col-md-12">
            <div class="scroll">
                <table id="tabela-clientes">
                    <thead class="orange">
                        <tr>
                            <td>#ID#</td>
                            <td>Nome</td>
                            <td>Email</td>
                            <td>Senha</td>
                            <td>Tipo</td>
                            <td>Ações</td>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($usuarios as $user)
                        <tr data-id="{{$user->id}}">
                            <td>{{$user->id}}</td>
                            <td>{{$user->nome}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->senha}}</td>
                            <td>{{$user->tipo_user}}</td>
                            <td>
                                <a href="{{route('admin.delete')}}" data-id="{{$user->id}}" class="btn btn-danger excluir">Excluir</a>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="6">Sem usuarios cadastrados!</td>
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
                {{$usuarios->links()}}
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
                $("#tabela-users").empty().html(e);
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
                        getRouteAjax("{{route('admin.view.config')}}", "#tabela-users", "{{$usuarios->currentPage()}}");
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

