<!--
	*****SITE TROCA JOGOS						********
	*****Programador : RAFAEL ALVES CARDOSO     ********
	*****DATA: 05/07/2016                       ********
-->
<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="UTF-8">
		<!--CSS BOOTSTRAP-->
		<link rel="stylesheet" type="text/css" href="..\bootstrap/css/bootstrap.min.css"/>
		<link rel="stylesheet" type="text/css" href="../font-awesome/css/font-awesome.css"/>
		<!--CHAMADA CSS-->
		<link type="text/css" href="../css/fonts.css" rel="stylesheet"/>
		<link type="text/css" href="css/imagens.css" rel="stylesheet"/>
		<link type="text/css" href="css/trocas.css" rel="stylesheet"/>
		<link type="text/css" href="css/jogos.css" rel="stylesheet"/>

		<!--CHAMADA CSS-->
		<link rel="stylesheet" type="text/css" href="css/estilo.css"/>
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	</head>
	<body>
		<?php 
			session_start();
			function __autoload($classe){
		        require('../classes/'.$classe.'.class.php');
		    }
		    @BD::conn();//conexão com o banco de dados
			
			$user = Usuarios::getUsuario();//pegar usuário online						
			/**	NÍVEL 1 - ADMINISTRADOR
			*	NÍVEL 0 - USUÁRIO NORMAL*/
			$acesso = ($user) ? $user->tipousuario : 0;
			
			if($acesso == 0){
				echo $msg = '<script type="text/javascript">
					alert("Você não tem acesso a essa página e será redirecionado...");
					window.location.href=("../index.php");
				</script>';				
			}
		?>
		<header id="cabecalho">
			<img id="logo" class="brand" src="../imagens/backgrounds/logo.png" alt="TROCA JOGOS"/>
			<div class="user-space">
				<ul class="user-acao">
					<?php						
						if(isset($_SESSION['emailTJ'])){
							$emailLogado = $_SESSION['emailTJ'];
							$usuario  = $_SESSION['nomeTJ'];										
					?>
					<li class="logado"><a href="#">Bem vindo <?php echo $usuario;?></a></li>
					<li class="logado"><a href="#"><a href="../sair.php">Sair</a></li>
					<?php }else{?>
						<li id="user-entrar"><a href="#">Entrar</a></li>
						<li id="user-cadastrar"><a href="#">Criar conta</a></li>
					<?php }?>
				</ul>
			</div>
		</header>
		<div id="container">
			<div id="esquerda">
				<ul class="mn_admin">
					<li class="mn_opcao dashboard"><a href="" class="link"><i class="fa fa-dashboard" aria-hidden="true"></i> Dashboard</a></li>
					<li class="mn_opcao jogo"><a href="jogos/index.php" class="link"><i class="fa fa-gamepad" aria-hidden="true"></i> Jogos</a></li>
					<li class="mn_opcao console"><a href="consoles.php" class="link"><i class="fa fa-database" aria-hidden="true"></i> Consoles</a></li>
					<li class="mn_opcao imagem"><a href="imagens.php" class="link"><i class="fa fa-picture-o" aria-hidden="true"></i> Imagens</a></li>
					<li class="mn_opcao troca"><a href="trocas/index.php" class="link"><i class="fa fa-exchange" aria-hidden="true"></i> Trocas</a></li>
					<li class="mn_opcao config"><a href="" class="link"><i class="fa fa-cogs" aria-hidden="true"></i> Configuração</a></li>
				</ul>
			</div>
			<div id="conteudo_principal"></div>
		</div>
		<!--CHAMADA JS-->		
		<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	    <script src="js/funcoes.js"></script>
		<script src="..\bootstrap/js/bootstrap.min.js"></script>
	</body>
</html>