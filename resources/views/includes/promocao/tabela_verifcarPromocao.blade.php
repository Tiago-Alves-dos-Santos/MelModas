<div id="tabela-cliente">
    <div class="row" id="">
        <div class="col-md-12">
            <div class="scroll">
                <table id="tabela-clientes">
                    <thead class="orange">
                        <tr>
                            <td>Nome</td>
                            <td>Rua</td>
                            <td>Bairro</td>
                            <td>Casa(Número)</td>
                            <td>Idade</td>
                            <td>Nascimento</td>
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
                            <td>{{$cliente->nome}}</td>
                            <td>{{$cliente->rua}}</td>
                            <td>{{$cliente->bairro}}</td>
                            <td>{{$cliente->numero_casa}}</td>
                            <td>{{$idade}}</td>
                            <td>{{date('d/m/Y', strtotime($cliente->data_nasc))}}</td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="6">Sem clientes cadastrados</td>
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
                <h4 style="font-weight: bold;">{{$registros_cliente}} / {{$clientes->total()}}</h4>
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
    $("table tbody tr").on('dblclick', function(){
        let id = parseInt($(this).attr('data-id'));
        $("div#load-page").fadeIn('fast');
        $.ajax({
            type: 'GET',
            url: "{{route('promocao.ajax.valorTotalMes')}}",
            data: {
                "id": id
            },
            success: function(e){
                let valor = JSON.parse(e);
                $.msgbox({
                    'message': "O cliente possui até o momento um valor de: R$ "+valor,
                    'type':'info'
                });
            },
            complete: function(e){
                $("div#load-page").fadeOut('fast');
            },
            error: function(e){
                console.log(e);
            }
        });
    });
</script>