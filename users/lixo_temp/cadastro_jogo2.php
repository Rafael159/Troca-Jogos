<!--
	*****SITE TROCA JOGOS						********
	*****Programador : RAFAEL ALVES CARDOSO     ********
	*****DATA: 06/03/2015                       ********
-->
<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="description" content="Cadastrar os jogos que possuem, troque e divirta-se"/>
		<meta name="keywords" content="cadastrar, jogos, games, novo jogo,"/>
		<!--CHAMADA CSS-->
		<link rel="stylesheet" type="text/css" href="css/jogos.css"/>
		<link rel="stylesheet" type="text/css" href="css/header.css"/>
		<link rel="stylesheet" type="text/css" href="css/style.css"/>
		<!--CHAMADA JAVASCRIPT-->		
		<script type="text/javascript" src="../javascript/jquery.js"></script><!--chama o arquivo principal do jquery-->
		<script type="text/javascript" src="js/acoes.js"></script>
		<title>Cadastro de Jogos</title>	
	</head>
<body>	
	<?php
		session_start();
		header("Content-type: text/html;charset=utf-8");
		spl_autoload_register(function($classe) {
			require ('..\classes/'.$classe.'.class.php');
		});

		$console = new Consoles();
		$imagem  = new Imagens();

	   @BD::conn();//conexão com o banco de dados
		$user = new Usuarios();
		
		//verificar o acesso 
		if(isset($_SESSION['emailTJ'])){
			$email = $_SESSION['emailTJ'];

			foreach($user->findEmail($email) as $usuario):
				$acesso = $usuario->status; //recupera o nível do usuário
			endforeach;
		}		
	?>
	</body>

