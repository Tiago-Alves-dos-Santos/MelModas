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
                        <a href="{{route('cliente.view.viewAniversarios')}}"><i class="fas fa-calendar-day"></i> Aniversariantes  <span class="badge" id="aniversariantes-mes">0</span></a>
                    </li>
                    <li>
                        @if(isset($_SERVER['HTTP_REFERER']))
                        <a href="{{$_SERVER['HTTP_REFERER']}}"><i class="fas fa-arrow-alt-circle-left"></i> Voltar</a>
                        @endif
                    </li>
                    
                </ul>
                            </div>

        </nav>


        <!-- /. NAV SIDE  -->

        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-lg-12">
                     <h2>@yield('titulo_pagina')</h2>   
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
                $("span#aniversariantes-mes").html(e);
            },
            error: function(e){
                console.log(e);
            }
        });
    },1000);
    </script>
</body>
</html>
