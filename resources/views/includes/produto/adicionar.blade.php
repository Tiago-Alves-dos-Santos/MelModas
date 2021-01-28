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
            <label>Quantidade a ser adicionada:</label>
            <input type="number" name="quantidade" step="1" min="1" required class="form-control"/>
        </div>
    </div>
    <div class="form-row">
        <div class="col-md-12">
            <input type="submit" value="Adicionar" class="btn btn-success btn-block" style="margin-top: 30px; margin-bottom: 30px"/>
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
                        <li>Código: {{$produto->codigo}}</li>
                        <li>Qauntidade: {{$produto->quantidade}}</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <ul style="list-style-type: none">
                        <li>Valor(Compra) R$: {{$produto->valor_compra}}</li>
                        <li>Valor(Venda) R$: {{$produto->valor_venda}}</li>
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