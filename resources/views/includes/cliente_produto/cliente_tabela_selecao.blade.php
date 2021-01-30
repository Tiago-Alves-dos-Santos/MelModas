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
                        {{-- @php
                            $calculo = new App\Model\Cliente();
                        @endphp
                        @forelse ($clientes as $cliente)
                        @php
                            $idade = $calculo->calcularIdade((string) $cliente->data_nasc);
                        @endphp --}}
                        <tr data-id="">
                            <td>5</td>
                            <td>Teste</td>
                            <td>Rua 102</td>
                            <td>teste</td>
                            <td>55</td>
                            <td>34</td>
                            <td>0202</td>
                            <td>
                                <a href="">Telefones</a>
                            </td>
                        </tr>
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