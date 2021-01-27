@extends('layout.template_admin')

@section('titulo', 'Painel Administrativo')


@section('titulo_pagina', 'Cadastrar Cliente')


@section('conteudo')
<div class="row">
    <div class="col-md-12">
        <form action="{{route('cliente.create')}}" method="post" id="cadastro_cliente">
            @csrf
            <div class="form-row">
                <div class="col-md-4">
                    <label>Nome: <span class="text-danger">*</span>  
                        <span class="text-warning" id="aviso-nome">Nome já existente no sistema!</span>
                    </label>
                    <input type="text" name="nome" placeholder="Nome do cliente" class="form-control limpar" id="nome" required/>
                    
                </div>
                <div class="col-md-4">
                    <label>Número(Celular): <span class="text-danger">*</span>
                        <span class="text-danger" id="aviso-numero">Número já existente no sistema!</span>
                    </label>
                    <input id="numero" id="numero" type="text" name="telefone" class="form-control limpar telefone-mask" maxlength="16" minlength="16" required placeholder="(11) 9 3333-4444"/>
                </div>
                <div class="col-md-4">
                    <label>Data de Nascimento: <span class="text-danger">*</span>
                    </label>
                    <input type="date" name="data_nasc" class="form-control" required/>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-4">
                    <label>Rua: <span class="text-danger">*</span></label>
                    <input type="text" name="rua" placeholder="Ex: Rua 133" class="form-control limpar" required/>
                </div>
                <div class="col-md-4">
                    <label>Bairro: <span class="text-danger">*</span></label>
                    <input type="text" name="bairro" placeholder="Ex: Bairro Apelido" class="form-control limpar" required/>
                </div>
                <div class="col-md-4">
                    <label>Número: <span class="text-danger">*</span></label>
                    <input type="number" min="0" step="1" name="numero_casa" placeholder="Número da casa" class="form-control limpar" required/>
                </div>
            </div>
            <div class="form-row">
                <style>
                    #cke_complemento{
                        margin-bottom: 20px;
                    }
                </style>    
                <div class="col-md-12">
                    <label>Complemento:</label>
                    <textarea rows="15" class="form-control limpar" name="complemento" id="complemento">

                    </textarea>   
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-12">
                    <input type="submit" value="Cadastrar" class="btn btn-success btn-block"/>  
                </div>
            </div>
        </form>
    </div>
</div>

<script>
//configurações
// CKEDITOR.editorConfig = function( config ){
//     config.entities = false;
// };
// CKEDITOR.replace( 'complemento',{
//     skin: 'office2013',
// });
//esconder campos
$("span#aviso-nome").hide();
$("span#aviso-numero").hide();
//verficar se nome de cliente ja existente no banco  de dados
$("input#nome").on('keyup', function(e){
    let palavra = $(this).val();
    $.ajax({
        url: "{{route('cliente.ajax.verficar')}}",
        type: 'POST',
        data: {
            "_token": "{{ csrf_token() }}",
            "coluna": "nome",
            "valor" : palavra
        },
        success: function(e){
            if(e == "true"){
                $("span#aviso-nome").fadeIn('fast');
            }else{
                $("span#aviso-nome").fadeOut('fast');
            }
        },
        error: function(e){
            cnsole.log(e);
        }
    });
});
//verficar se numero(telefone) de cliente ja existente no banco  de dados
$("input#numero").on('keyup', function(e){
    let numero = $(this).val();
    $.ajax({
        url: "{{route('cliente.ajax.verficar')}}",
        type: 'POST',
        data: {
            "_token": "{{ csrf_token() }}",
            "coluna": "telefone",
            "valor" : numero
        },
        success: function(e){
            if(e == "true"){
                $("span#aviso-numero").fadeIn('fast');
            }else{
                $("span#aviso-numero").fadeOut('fast');
            }
        },
        error: function(e){
            cnsole.log(e);
        }
    });
});
//cadastrar cliente
$("form#cadastro_cliente").on('submit', function(e){
    e.preventDefault();
    $("div#load-page").fadeIn('fast');
    // let ck = {'complemento': CKEDITOR.instances['complemento'].getData()}
    // let dados = $(this).serialize() + ck["complemento"];
    let dados = $(this).serialize();
    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: dados,
        complete: function(){
            $("div#load-page").fadeOut('fast');
            $('.limpar').val("");
            CKEDITOR.instances['complemento'].setData("");  
        },
        success: function(e){
            if(e == 2){
                $.msgbox({
                'message': "O número "+$("#numero").val()+" já esta em uso!",
                'type': "error",
                });
            }else if(e == 3){
                $.msgbox({
                'message': "Cliente cadastrado com sucesso!",
                'type': "info",
                });
            }
        },
        error:function(e){
            let erros = new Array("nulo");
                    if (e.status == 422) { // when status code is 422, it's a validation issue
                        $.each(e.responseJSON.errors, function (i, error) {
                            // console.log(error[0]);
                            erros[1] += error[0]+'<br>\n';
                        });
                        erros[1] = erros[1].replace('undefined','');
                        $.msgbox({
                            'message': erros[1],
                        });

                    }
        }
    });
});
</script>
@endsection

