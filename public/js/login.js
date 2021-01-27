/**************************************** Funções *****************************************/
//Texto de boas vinda no painel login
function boasVindas(){
    var data = new Date();
    let hora = data.getHours();
    let texto = $("#titulo-boas-vindas");
    if(hora >= 0 && hora < 6){
        $(texto).html('Boa Madrugada!');
    }else if(hora >= 6 && hora < 12){
        $(texto).html('Bom Dia!');
    }else if(hora >= 12 && hora < 18){
        $(texto).html('Boa Tarde!');
    }else if(hora >= 18 && hora < 23){
        $(texto).html('Boa Noite!');
    }
}
/**************************************** Execução *****************************************/
$(function(){
    //Texto de boas vinda no painel login
    boasVindas();
    //esconde msg de caps lock ligado(fonte, caixa alta ativada)
    $("#login-caps-lock").hide();
    //verifica se caps lock ou shift é pressionado para mandar a msg
    $(document).on('keydown keyup',function (e) {
        //verifca se CapsLock ou SHIFT esta ligado, retorna true ou false
        //para deixar apenas o Shift ou capsLock é so remover um dos dois
        //nesse caso é pq quero verficar os dois, se um dos dois esta ativo
        var capsLock = event.getModifierState && event.getModifierState('CapsLock') || event.getModifierState('Shift');
        if (capsLock) {
            //capsLock ligado
            $("#login-caps-lock").fadeIn('slow');
        }else{
            //capsLock desligado
            $("#login-caps-lock").fadeOut('slow');
        }
    });

    //load no form login
    $("form#form-login").on('submit', function(e){
        $("div#load-page").fadeIn('fast');
    });
});