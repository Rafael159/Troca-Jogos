<!DOCTYPE HTML>
<html>	
	<head>
		<meta charset="UTF-8">
		<meta name="description" content="Troque seus jogos antigos por jogos que ainda não teve"/>
		<meta name="description" content="Troque jogos - divirta-se sem gastar mais"/>
		<meta name="keywords" content="Troca,Jogo,Games,Jogadores"/>

		<!--CHAMADA CSS-->
		<link rel="stylesheet" type="text/css" href="css/estilo.css"/>
	</head>
<body>
	<?php
		@BD::conn();//conexão com o banco de dados
		$categoria = new Categorias();		
	?>
	<header class="tj-top">gfgf
		<div class="inf clearfix">
			<span id="logo" class="clearfix"><a href="index.php"><img src="imagens/logo.png" alt="Logo"/></a></span>
			<div class="user-space">
				<ul class="user-acao">
					<?php
						if(isset($_SESSION['emailTJ'])){
							$emailLogado = $_SESSION['emailTJ'];
							$usuario  = $_SESSION['nomeTJ'];										
					?>
					<li class="logado"><a href="#">Bem vindo <?php echo $usuario;?></a></li>
					<li class="logado"><a href="#"><a href="sair.php">Sair</a></li>
					<?php }else{?>
						<li id="user-entrar"><a href="#">Entrar</a></li>
						<li id="user-cadastrar"><a href="#">Criar conta</a></li>
					<?php }?>
				</ul>
			</div>
		</div>
		<div id="main-menu">
			<nav class="nav">
				<ul>
					<?php 
						foreach($categoria->listarTodos() as $value):
					?>
					<li><a href="console.php?id=<?php echo $value->id_console?>&nome_console=<?php echo $value->nome_console?>" class="link"><?php echo $value->nome_console?></a></li>
					<?php endforeach;?>
				</ul>	
			</nav>
		</div>	
	</header>
</body>
</html>