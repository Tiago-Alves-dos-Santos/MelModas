<!DOCTYPE html>
<html lang="pt_Br">

<head>
    @component('componentes.metatags')
    @endcomponent
    <title>@yield('titulo')</title>
    @component('componentes.head',['bootstrap' => false])
    @endcomponent
	<!-- BOOTSTRAP STYLES-->
    <link href="{{asset('plugins/template-admin/assets/css/bootstrap.css')}}" rel="stylesheet" />
    
    <!-- CUSTOM STYLES-->
    <link href="{{asset('plugins/template-admin/assets/css/custom.css')}}" rel="stylesheet" />
     <!-- GOOGLE FONTS-->
   <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body>
     
    @component('componentes.load')
	@endcomponent   
    
    
    <div id="wrapper">
         <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="adjust-nav">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">
                        <img src="{{asset('img/logo.jpg')}}" class="img-fluid" style="width:50px"/>

                    </a>
                    
                </div>
              
                <span class="logout-spn" >
                    @php
                        session(['validate' => rand(10, 1000)]);
                    @endphp
                  <a href="{{route('admin.logout', ['validate' => session('validate')])}}" style="color:#fff;">Sair</a>  

                </span>
            </div>
        </div>
        <!-- /. NAV TOP  -->

        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
                 


                    <li class="active-link">
                        <a href="{{route('admin.view.dashboard')}}" ><i class="fa fa-desktop "></i> Painel Administrativo</a>
                    </li>
                   

                    {{-- <li>
                        <a href="ui.html"><i class="fas fa-user"></i>Perfil </a>
                    </li> --}}
                    <li>
                        <a href="{{route('cliente.view.viewAniversarios')}}"><i class="fas fa-calendar-day"></i> Aniversariantes  
                            <span class="badge" id="aniversariantes-mes">0</span>
                            <span class="badge" id="aniversariantes-dia" style="background-color:orangered ">0</span>
                        </a>
                    </li>
                    @if(session('tipo') == session('tipo_users.0'))
                    <li>
                        <a href="{{route('relatorio.inicio')}}"><i class="fas fa-file-invoice-dollar"></i>Relatório </a>
                    </li>
                    @endif
                    @if(session('tipo') == session('tipo_users.0'))
                    <li>
                        <a href="{{route('peso.ajax.revisarPeso')}}" id="reconfigurar-peso"><i class="fas fa-sync-alt"></i>Reconfigurar Peso </a>
                    </li>
                    @endif

                    <li>
                        @if(isset($_SERVER['HTTP_REFERER']))
                        <a href="{{$_SERVER['HTTP_REFERER']}}"><i class="fas fa-arrow-alt-circle-left"></i> Voltar</a>
                        @endif
                    </li>

                    <li>
                        <a href="#" style=" color:red" id="info_caixa">
                            Caixa fechado
                        </a>
                    </li>
                    
                </ul>
                {{-- <h5>Vendas(cartão) concluidas hoje: <span id="concluido_hoje"></span></h5> --}}
            </div>

        </nav>


        <!-- /. NAV SIDE  -->

        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-lg-12">
                     <h2>@yield('titulo_pagina') <span class="text-success" id="total-venda"></span>
                        <span class="text-danger" id="promocao"></span>
                    </h2>   
                    </div>
                </div>              
                 <!-- /. ROW  -->
                  <hr />
                  <!-- /. ROW  --> 
                    @yield('conteudo')
        </div>

    <div class="footer">
      
    
            <div class="row">
                <div class="col-lg-12" >
                    &copy;  2020 - {{date('Y')}} Mel Modas | Todos os direitos reservados a Tiago Alves- <a href="" style="color:#fff;" target="_blank">Telegram</a>
                </div>
            </div>
        </div>
          

     <!-- /. WRAPPER  -->
    <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
    <!-- JQUERY SCRIPTS -->
    <script src="{{asset('plugins/template-admin/assets/js/jquery-1.10.2.js')}}"></script>
      <!-- BOOTSTRAP SCRIPTS -->
    <script src="{{asset('plugins/template-admin/assets/js/bootstrap.min.js')}}"></script>
      <!-- CUSTOM SCRIPTS -->
    <script src="{{asset('plugins/template-admin/assets/js/custom.js')}}"></script>    
    @component('componentes.footer')
    @endcomponent

    @component('componentes.msgPhp')
    @endcomponent


    <script>
        
    setInterval(function () {
        $.ajax({
            type: 'GET',
            url: "{{route('cliente.ajax.aniversariantes')}}",
            success: function(e){
                $("span#aniversariantes-mes").html(e+"m");
            },
            error: function(e){
                console.log(e);
            }
        });
        $.ajax({
            type: 'GET',
            url: "{{route('cliente.ajax.aniversariantesDay')}}",
            success: function(e){
                $("span#aniversariantes-dia").html(e+"d");
            },
            error: function(e){
                console.log(e);
            }
        });
    },10000);

    $.ajax({
        type: 'GET',
        url: "{{route('rotinas.ajax.vendasConcluidas')}}",
        success: function(e){
            // $("span#concluido_hoje").html(e);
        },
        error: function(e){
             console.log(e);
        }
    });

    $("a#reconfigurar-peso").on('click', function(e){
        e.preventDefault();
        $("div#load-page").fadeIn('fast');
        $.ajax({
        type: 'PUT',
        url: $(this).attr('href'),
        data:{
            "_token": "{{ csrf_token() }}"
        },
        complete: function(e){
            $("div#load-page").fadeOut('fast');
        },
        success: function(e){
            if(typeof e == "string"){
                $.msgbox({
                'message': "Novo peso atualizado para "+e+" Kg",
                'type': "info",
                });
            }else{
                $.msgbox({
                'message': "Tipo de retorno '"+typeof e+"' inesperado",
                'type': "info",
                });
            }

        },
        error: function(e){
             console.log(e);
        }
    });
    });

    //comentar requisição abaixo caso loja nao use peso igual logica do açai
    $tempo = localStorage.setItem('tempo_peso_alerta', 60000);
    setInterval(function () {
        $.ajax({
            type: 'GET',
            url: "{{route('peso.ajax.alert')}}",
            success: function(e){
                if(e != "false" && e > 0){
                    $.msgbox({
                    'message': "O peso total esta em estado de alerta. Atingindo a quantidade de "+e+"Kg "
                    });
                }else if(e == 0){
                    $.msgbox({
                    'message': "O peso total atingiu a quantidade de 0Kg! Solicite reabastecimento! Vendas Bloqueadas!",
                    'type': "error",
                    });
                }else{
                    //peso esta em ordem
                }
            },
            error: function(e){
                console.log(e);
            }
        });
    },localStorage.getItem('tempo_peso_alerta'));



    $.ajax({
        type:'GET',
        url: "{{route('caixa.check')}}",
        success:function(e){
            if(e == "true"){
                $("#abrir_venda").show();
                $("a#info_caixa").css({'color':'green'});
                $("a#info_caixa").html('Caixa Aberto');
            }else if(e == "false"){
                $("#abrir_venda").hide();
                $("a#info_caixa").css({'color':'red'});
                $("a#info_caixa").html('Caixa Fechado');
            }else{
                $("#abrir_venda").hide();
                // alert("nenhum dado cadastrado");
            }
            console.log(e);
        },
        error: function(e){
            console.log(e);
        }
    });
    </script>
</body>
</html>
