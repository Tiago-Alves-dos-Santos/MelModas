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
                            <td>Valor(Compra)</td>
                            <td>Valor(Venda)</td>
                            <td>Quantidade</td>
                            <td>Ações</td>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($produtos as $produto)
                        <tr data-id="{{$produto->id}}">
                            <td>{{$produto->id}}</td>
                            <td>{{$produto->codigo}}</td>
                            <td>{{$produto->nome}}</td>
                            <td>{{$produto->valor_compra}}</td>
                            <td>{{$produto->valor_venda}}</td>
                            <td>{{$produto->quantidade}}</td>
                            <td>
                                <a href="" 
                                class="btn btn-sm btn-warning">Alterar</a>
                            <a href="" data-id="{{$produto->id}}" class="btn btn-sm btn-danger excluir-cliente">Excluir</a>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="7">Sem Produtos Cadastrados!</td>
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