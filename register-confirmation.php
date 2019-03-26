<?php	
	function __autoload($classe){
		require('classes/'.$classe.'.class.php'); /*chama a classe automaticamente*/
	}

	@BD::conn();//conexão com o banco de dados
	$categoria = new Consoles();	
	$jogos = new Jogos();

	session_start();

	if(isset($_SESSION['novo_usuario']) && isset($_SESSION['novo_email'])){		
		$user_nome = $_SESSION['novo_usuario'];
		$user_email = $_SESSION['novo_email'];
	}else{
		header('Location:index.php');
	}
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="UTF-8">
		<!--CHAMADA CSS-->
		<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="bootstrap/css/bootstrap-theme.css"/>
        <link rel="stylesheet" href="css/register_confirmation.css"/>
		<title>Restart Games - Bem Vindo!</title>
	</head>
<body>
	<main class='main'>
		<div class='top'>
			<a href="index.php"><img src="imagens/backgrounds/logo.png" alt="TrocaJogos"></a>
			<span><a href="login/logar.php">Entrar</a></span>
		</div>
		<div class='container-fluid'>
			<div id='box_confirmation' class='col-lg-8 col-lg-push-2 nopadding'>
				<div class='alert alert-success'>
					<strong>Parabéns <?php echo $user_nome; ?>!</strong><small> Seu cadastro foi recebido com sucesso</small>
				</div>
				<div class='col-lg-12'>
					<p>Um e-mail de confirmação foi enviado para: <strong><?php echo $user_email?></strong></p>
					<p>Agora falta pouco. Acesse seu e-mail e confirme seu cadastro</p>
					<a href="index.php">Área principal</a>
				</div>
			</div>
			<?php 
				$games = Jogos::listarJogosHelper(array('status'=>'Ativo', 'limite'=>'10'));
				if($games): 
			?>
			<div id='first_content' class='col-lg-8 col-lg-push-2 nopadding'>
				<div class='alert alert-info'>
					<strong>Confira alguns dos jogos que te esperam</strong>
				</div>
				<?php
					foreach($games as $jogo=> $valor): ?>
						<div class='col-lg-3 col-md-6 col-sm-6 col-xs-12'>
							<div class='jogos'>
								<a href='game/game.php?codigo=<?php echo $valor->id;?>' class='col-sm-12 text-center'>
									<small><?php echo strtoupper(substr($valor->n_jogo, 0, 10))?></small>
									<img src='game/imagens/<?php echo str_replace(' ','',$valor->nome_console).'/'.$valor->imagem?>' alt='<?php echo $valor->n_jogo?>' class='img-responsive'/>
								</a>
							</div>
						</div>
					<?php endforeach; ?>
			</div>
			<?php endif; ?>
		</div>
	</main>
	<script src="js/jquery.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>