<!DOCTYPE html>
<html lang="pt_Br">
<head>
    @component('componentes.metatags')
    @endcomponent
    <title>Mel Modas</title>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="plugins/tela-login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="plugins/tela-login/fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="plugins/tela-login/vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="plugins/tela-login/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="plugins/tela-login/vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="plugins/tela-login/vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="plugins/tela-login/vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="plugins/tela-login/css/util.css">
	<link rel="stylesheet" type="text/css" href="plugins/tela-login/css/main.css">
<!--===============================================================================================-->
@component('componentes.head')
@endcomponent
</head>
<body>
	@component('componentes.load')
	@endcomponent
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form class="login100-form validate-form" method="post" action="{{route('admin.login')}}" id="form-login">
					@csrf
					<span class="login100-form-title p-b-26" id="titulo-boas-vindas">
						Bem Vindo!
					</span>
					@php
					use SimpleSoftwareIO\QrCode\Facades\QrCode;
					$link = null;
					$porta = 8000;
					$ipLocal = getHostByName(getHostName());
					if (!empty($_SERVER['HTTPS'])){
						$link = "https://";
					}else{
						$link = "http://";
					}
					$link .= "$ipLocal:$porta";
					@endphp
					<div style="width: 100%; display: flex; justify-content: center; flex-wrap: wrap">
						{{QrCode::encoding('UTF-8')->size(125)->style('round')->color(255, 91, 3)->generate($link)}}
					</div>
					<div style="width: 100%">
						<h5 class="text-success" style="text-align: center">Abra pelo celular!</h5>
					</div>
					<span class="login100-form-title p-b-48">
                        {{-- <i class="zmdi zmdi-font"></i> --}}
                        <img src="{{asset('img/logo.jpg')}}" class="img-fluid" style=""/>
					</span>

					<div class="wrap-input100 validate-input" data-validate = "E-mail inválido!">
						<input class="input100" type="email" name="email" required>
                        <span class="focus-input100" data-placeholder="E-mail"></span>
                    </div>

					<div class="wrap-input100 validate-input" data-validate="Senha inválida!">
						<span class="btn-show-pass">
							<i class="zmdi zmdi-eye"></i>
						</span>
						<input class="input100" type="password" name="senha" required>
						<span class="focus-input100" data-placeholder="Senha"></span>
                    </div>
                    
                    <div style="position: relative; top: -20px; text-align: center;" class="bg-success text-white" id="login-caps-lock">
                        <span style="display: block; font-size: 16px">Caixa alta ativada!</span>
                    </div>

					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button class="login100-form-btn">
								Entrar
							</button>
						</div>
					</div>

					{{-- <div class="text-center p-t-115">
						<span class="txt1">
							Não possui uma conta?
						</span>

						<a class="txt2" href="#">
							Cadastre-se!
						</a>
					</div> --}}
				</form>
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>
	
<!--===============================================================================================-->
	<script src="plugins/tela-login/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="plugins/tela-login/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="plugins/tela-login/vendor/bootstrap/js/popper.js"></script>
	<script src="plugins/tela-login/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="plugins/tela-login/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="plugins/tela-login/vendor/daterangepicker/moment.min.js"></script>
	<script src="plugins/tela-login/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="plugins/tela-login/vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
    <script src="plugins/tela-login/js/main.js"></script>
    @component('componentes.footer')
	<script src="{{asset('js/login.js')}}"></script>
    @endcomponent

	@component('componentes.msgPhp')
	@endcomponent
</body>
</html>