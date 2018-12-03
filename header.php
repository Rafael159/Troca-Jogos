<header class="tj-top">
	<div class="inf clearfix">
		<span id="logo" class="clearfix"><a href="index.php"><img src="imagens/logo.png" alt="Logo"/></a></span>
		<div class="user-space">
			<ul class="user-acao">
				<?php
					if(isset($_SESSION['emailTJ'])):
						$emailLogado = $_SESSION['emailTJ'];
						$usuario  = $_SESSION['nomeTJ'];
				?>
				<li class="logado"><a href="#">Bem vindo <?php echo $usuario;?></a></li>
				<li class="logado"><a href="#"><a href="sair.php">Sair</a></li>
				<?php else :?>
					<li id="user-entrar"><a href="#">Entrar</a></li>
					<li id="user-cadastrar"><a href="#">Criar conta</a></li>
				<?php endif; ?>
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
<div class="clearfix">			
	<div class="lupa"><img id="icon-lupa" src="imagens/icones/lupa.png" autocomplete="off"></div>

	<form id="box_pesquisa" methoad="POST">
		<?php
			if(count($_GET) != 0){
				if(isset($_GET['pesquisa'])){
					$q = $_GET['pesquisa'];
				}
			}
			if(isset($_GET['pag'])){
				$pag = $_GET['pag'];
				if($pag >= 2){
					$q = "";
				}
			}
		?>		
		<div class="input_container">
			<input type="text" name="pesquisa" id="id_pesquisa" onkeyup="autoCompletar()" autocomplete="off" value="<?php if(isset($q)){echo $q;}else{}?>"/>
			<ul id="lista_jogos"></ul>							
		</div>
	</form><br/>

	<div id="logo"><a href="index.php"><img src="imagens/logo.png"></a></div>
	<div id="anuncios"></div>
</div>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/funcoes.js"></script>
<script type="text/javascript" src="js/events.js"></script>
<script type="text/javascript" src="js/global.js"></script>