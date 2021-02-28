function paginaAtual(pagina){
    pagina = $('.pagination').find('.active').find('span').html();
}

function getRouteAjax(rota,id_html,pagina_atual, load = false){
    if(load){
        $("div#load-page").fadeIn('fast');
    }
    $.ajax({
        type: 'GET',
        url: rota+"?page="+pagina_atual,
        success: function (e) {
            $(id_html).empty().html(e);
        },
        complete: function(e){
            $("div#load-page").fadeOut('fast');
        },
        error: function (e) {
            console.log(e);
        }
    });
}