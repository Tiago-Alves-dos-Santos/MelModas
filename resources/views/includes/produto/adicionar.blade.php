<style>
div#produto-existente{
    position: relative;
    box-sizing: border-box;
    padding: 5px 15px;
    border: 1px solid rgba(255, 170, 0,1);
}
div#produto-existente h3{
    text-align: center;
}
</style>

<form method="post" action="{{route('produto.ajax.addQuantidade')}}" id="add-quantidade">
    @csrf
    <input type="hidden" name="id" value="{{$produto->id}}"/>
    <div class="form-row">
        <div class="col-md-12">
            <label>Quantidade a ser adicionada: <span class="text-danger">*</span></label>
            <input type="number" name="quantidade" step="1" min="1" class="form-control"/>
        </div>
    </div>
    <div class="form-row">
        <div class="col-md-12">
            <label>Alterar peso(Kg): <span class="text-danger">*</span></label>
            <input type="number" value="{{$produto->peso}}" name="peso_venda" step="0.001" min="0.001"  class="form-control"/>
        </div>
    </div>
    <div class="form-row">
        <div class="col-md-12">
            <input type="submit" value="Salvar" class="btn btn-success btn-block" style="margin-top: 30px; margin-bottom: 30px"/>
        </div>
    </div>
</form>

<div class="row">
    <div class="col-md-12">
        <div id="produto-existente">
            <h3>{{$produto->nome}}</h3>
            <div class="row">
                <div class="col-md-6">
                    <ul style="list-style-type: none">
                        <li><span style="font-weight: bold">Código:</span> {{$produto->codigo}}</li>
                        <li><span style="font-weight: bold">Marca:</span> {{$produto->marca}}</li>
                        @if($produto->peso != null)
                        <li><span style="font-weight: bold">Peso:</span> {{$produto->peso}}</li>
                        @else
                        <li><span style="font-weight: bold">Quantidade:</span> {{$produto->quantidade}}</li>
                        @endif
                        
                    </ul>
                </div>
                <div class="col-md-6">
                    <ul style="list-style-type: none">
                        @if ($produto->peso == null)
                        <li><span style="font-weight: bold">Valor(Compra) R$:</span> {{$produto->valor_compra}}</li>
                        <li><span style="font-weight: bold">Valor(Venda) R$:</span> {{$produto->valor_venda}}</li>
                        @else
                        <li><span style="font-weight: bold">Valor Grama(Compra) R$:</span> {{$peso_venda->valor_compra}}</li>
                        <li><span style="font-weight: bold">Valor Grama(Venda) R$:</span> {{$peso_venda->valor_venda}}</li>  
                        @endif
                        

                        
                    </ul>
                </div>
            </div>
            <hr/>
            <p style="margin-top: 50px; text-align: center">
                {{$produto->descricao}}
            </p>
        </div>
    </div>
</div>

<script>
//adicionar mais quantidade a um produto
$("form#add-quantidade").on('submit', function(e){
    e.preventDefault();
    let dados = $(this).serialize();
    $("div#load-page").fadeIn('fast');
    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: dados,
        complete: function(e){
            $("div#load-page").fadeOut('fast');
        },
        success: function(e){
            $("input#btn-consultar-codigo").trigger('click');
        },
        error: function(e){
            console.log(e);
        }
    });
});
</script>