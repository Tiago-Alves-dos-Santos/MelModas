<form method="POST" action="{{route('produto.ajax.create')}}" enctype="multipart/form-data" id="cadastrar-produto">
    @csrf
    <div class="form-row">
        <div class="col-md-6">
            <label>Nome: <span class="text-danger">*</span></label>
            <input type="text" name="nome" placeholder="Ex: Perfume, Blusa..." class="form-control" required/>
        </div>
        <div class="col-md-6">
            <label>Marca: <span class="text-danger">*</span></label>
            <input type="text" name="marca" placeholder="Ex: Natura, Lacoste..." class="form-control" required/>
        </div>
    </div>
    <div class="form-row">
        <div class="col-md-6">
            <label>Valor(Compra): </label>
            <input type="number" name="valor_compra" placeholder="35.00" class="form-control" step="0.0001"/>
        </div>
        <div class="col-md-6">
            <label>Valor(Venda): </label>
            <input type="number" name="valor_venda" placeholder="35.50" class="form-control" step="0.0001"/>
        </div>
    </div>
    <div class="form-row">
        <div class="col-md-12">
            <label>Entrada Peso(Kg): </label>
            <input type="number" name="peso_entrada" placeholder="35" class="form-control" step="0.001"/>
        </div>
    </div>
    <div class="form-row">
        <div class="col-md-12">
            <label>Quantidade: </label>
            <input type="number" step="1" name="quantidade" placeholder="5" class="form-control"/>
        </div>
    </div>
    <div class="form-row">
        <div class="col-md-12">
            <label>Descrição:</label>
            <textarea class="form-control" name="descricao" rows="15">

            </textarea>
        </div>
    </div>

    <div class="form-row">
        <div class="col-md-12">
            <input type="submit" class="btn btn-block btn-success" value="Cadastrar Produto"/>
        </div>
    </div>

</form>

<script>
//cadastrar um produto
$("form#cadastrar-produto").on('submit', function(e){
    e.preventDefault();
    let codigo = $("input#codigo").val();
    let dado = {'codigo': codigo};
    let dados = $(this).serialize() +"&codigo=" + dado.codigo;
    $("div#load-page").fadeIn('fast');
    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: dados,
        complete: function(e){
            $("div#load-page").fadeOut('fast');
        },
        success: function(e){
            if(e == "2"){
                $("div#includes").empty().html("");
                $.msgbox({
                'message': "Produto "+dado.codigo+" cadastrado com sucesso!",
                'type': "info",
                });
            }else if(e == "3"){
                $.msgbox({
                'message': "Código "+dado.codigo+" já é um produto cadastrado!",
                'type': "error",
                });
            }
        },
        error: function(e){
            console.log(e);
        }
    });
});
</script>