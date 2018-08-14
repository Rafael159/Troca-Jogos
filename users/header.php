<?php
	//@BD::conn();//conexão com o banco de dados
	$categoria = new Consoles();		
?>
<!DOCTYPE HTML>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/header.css"/>
	<link rel="stylesheet" type="text/css" href="../css/etilo.css"/>

	<script type="text/javascript" src="js/jquery.js"></script><!--chama o arquivo principal do jquery-->
</head>
<body>
	<div class="overlay"></div>
	<header class="clearfix">
		<div class="user-space">
			<ul class="user-acao">
				<?php
					if(isset($_SESSION['emailTJ'])){
						$emailLogado = $_SESSION['emailTJ'];
						$usuario  = $_SESSION['nomeTJ'];
						$status = $_SESSION['tipousuario'];
						if($status == 0){
				?>
				<li class="logado"><a href="users/dashboard.php">Área de controle</a></li>
				<?php }else{ ?>
				<li class="logado"><a href="admin/admin.php">Área de controle</a></li>
				<?php } ?>
				<li class="logado"><a href="#">Bem vindo <?php echo $usuario;?></a></li>
				<li class="logado"><a href="sair.php">Sair</a></li>
				<?php }else{ ?>
					<li class="logado" id="user-entrar"><a href="#">Entrar</a></li>
					<li class="logado" id="user-cadastrar"><a href="#">Criar conta</a></li>
				<?php } ?>
			</ul>
		</div>

		<div class="lupa"><img id="icon-lupa" src="../imagens/icones/lupa.png" autocomplete="off" ></div>

		<form id="box_pesquisa" methoad="POST" action="..\pesquisa.php">
			<div class="input_container">
				<input type="text" name="pesquisa" id="id_pesquisa" autocomplete="off" placeholder="Faça sua pesquisa"/>					
			</div>
			<input type="submit" name="enviar" id="btn-enviar" value="Pesquisar"/>
		</form><br/>

		<div id="logo"><a href="../index.php"><img src="../imagens/backgrounds/logo.png"></a></div>			
	</header>		
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
</body>
</html>