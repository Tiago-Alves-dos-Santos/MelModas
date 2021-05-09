<div id="load-page" class="">
    <div style="position: absolute; top:15%">
        <img src="{{asset('img/load.gif')}}" class="img-fluid" style="width:170px;"/>
        <h3 style="color:white">Aguarde...</h3>
    </div>
</div>

<script>
    $(function(){
        $("div#load-page").delay(2000).fadeOut("slow");
        $(window).on('load',function(){
            $("div#load-page").delay(2000).fadeOut("slow");
        });
    });
</script>