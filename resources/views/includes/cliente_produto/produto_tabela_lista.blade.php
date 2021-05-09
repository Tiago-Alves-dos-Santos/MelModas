<div id="lista-produtos">
    <div class="row" id="">
        <div class="col-md-12">
            <div class="scroll" style="max-height: 1200px; overflow-y: auto">
                <table id="tabela-lista-produtos">
                    <thead class="orange">
                        <tr>
                            <td>#ID#</td>
                            <td>Código</td>
                            <td>Nome</td>
                            <td>Marca</td>
                            <td>Valor Unitario(R$)</td>
                            <td>Quantidade</td>
                            <td>Gramas</td>
                            <td>Total(R$)</td>
                            <td>Remoção</td>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @forelse ($clientes as $cliente) --}}
                        {{-- <tr data-id=''>
                            <td>5</td>
                            <td>45689237</td>
                            <td>Alcool</td>
                            <td>Baby</td>
                            <td>5</td>
                            <td>3</td>
                            <td>15</td>
                            <td>
                                <a href='' class='btn btn-danger excluir-produto'>Remover</a>
                            </td>
                        </tr> --}}
                        {{-- @empty
                            <tr>
                                <td colspan="8">Sem Clientes Cadastrados!</td>
                            </tr>   
                        @endforelse --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<script>

</script>