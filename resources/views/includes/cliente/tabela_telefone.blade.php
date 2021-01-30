<div class="row" id="tabela-telefone">
    <div class="col-md-12">
        <div class="scroll">
            <table>
                <thead class="orange">
                    <tr>
                        <td>#ID#</td>
                        <td>Telefone</td>
                        <td>Criado</td>
                        <td>Alterado</td>
                        <td>Ações</td>
                    </tr>
                </thead>
                <tbody id="conteudo-telefone">
                    @if(isset($telefones))
                        @forelse ($telefones as $telefone)
                            <tr>
                                <td>{{$telefone->id}}</td>
                                <td>{{$telefone->telefone}}</td>
                                <td>{{date('d/m/Y', strtotime($telefone->created_at))}}</td>
                                <td>{{date('d/m/Y', strtotime($telefone->updated_at))}}</td>
                                <td>
                                    <a data-id-telefone="{{$telefone->id}}" href="" class="btn btn-sm btn-danger excluir-telefone">Excluir</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5">Sem telefones! Erro!</td>
                            </tr>
                        @endforelse
                    @else
                    <tr>
                        <td colspan="5">Selecione um cliente!</td>
                    </tr>
                    @endif

                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
//excluir telefone especifico    
$("a.excluir-telefone").on('click', function(e){
    e.preventDefault();
    let id = $(this).attr('data-id-telefone');

    $.msgbox({ 
        'message' : 'Você realmente deseja excluir este número?',
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
                    url: "{{route('cliente.ajax.deletarTelefone')}}",
                    type: 'POST',
                    data:{
                        "_token": "{{ csrf_token() }}",
                        "id_telefone": id
                    },
                    complete: function(e){
                        $("div#load-page").fadeOut('fast');
                    },
                    success: function(e){
                        if(e == 2){
                            $.msgbox({
                            'message': "Não pode ser excluido, o cliente só possui esse número!",
                            });
                        }else{
                            $("#tabela-telefone").empty().html(e);
                        }
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
