<?php
	@BD::conn();//conexão com o banco de dados
	$categoria = new Consoles();		
?>

<div class="overlay"></div>
<header class="clearfix">
<!--BOX LOGIN-->
	<div id="overlay"></div><!--fundo-->
	<div class="box-login-cadastro">
		<div id="box-login">
			<label class="btn_cancela_acesso" id="cancelar_login"><b>X</b></label>
			<!--formulário de LOGIN-->
			<div class="titulo-acesso">Faça seu login utilizando sua conta do Facebook ou insira seus dados de acesso nos campos indicados.</div>
			<form method="POST" action="" name="form-acesso" class="form-acesso" id="form-logar">
				<div id="result"></div>
				<p>
					<label for="email_login">Email:</label>
					 <input type="text" name="email" id="email_login"/>
				</p>
				<p>
					<label for="senha_login">Senha:</label>
					 <input type="password" name="senha" id="senha_login"/>
				</p>
				<p>
					<label>
						<input type="button" name="logar" value="ENTRAR" id="btn-login"/>									
					</label>								
				<p>
					<label>
						<a href="..\cadastro.php">Cadastre-se</a>
						<a href="#user-cadastrar">Esqueci minha senha</a>
					</label>								
				</p>
			</form>
			<button class="facebook" id="logar_facebook">Logar com o Facebook</button>
		</div><!--box-login-->

		<div id="box-cadastro">
			<label class="btn_cancela_acesso" id="cancelar_login"><b>X</b></label>
			<!--formulário CADASTRO-->
			<div class="titulo-acesso">Para se cadastrar utilize uma conta do Facebook ou informe seu nome e e-mail nos campos indicados.</div>
			<form method="POST" action="../cadastro.php" name="cadastro" class="form-acesso" enctype="multipart/form-data">
				<p>
					<label for="email_cadastro">Email:</label>
					 <input type="text" name="email" id="email_cadastro"/>
				</p>
				<p>
					<label for="senha_cadastro">Senha:</label>
					 <input type="password" name="senha" id="senha_cadastro"/>
				</p>
				<p>
					<label>
						<input type="submit" name="Cadastro" value="Cadastrar" id="btn-cadastrar"/>	
						<input type="hidden" name="envio" value="enviado"/>								
					</label>								
				</p>
			</form>
			<button class="facebook" id="cadastrar_facebook">Cadastrar com o Facebook</button>
		</div><!--box-cadastro-->
	</div>
	<!--FIM BOX LOGIN-->		
	<div class="user-space">
		<ul class="user-acao">
				<?php

					$emailLogado = (isset($_SESSION['emailTJ'])) ? $_SESSION['emailTJ'] : '';
					$usuario = (isset($_SESSION['nomeTJ'])) ? $_SESSION['nomeTJ'] : '';
					$status = (isset($_SESSION['status'])) ? $_SESSION['status'] : '';

					if($emailLogado){
						if($status == 0){
				?>
				<li class="logado"><a href="../users/dashboard.php">Área de controle</a></li>
				<?php }else{ ?>
				<li class="logado"><a href="admin/admin.php">Área de controle</a></li>
				<?php } ?>
				<li class="logado"><span>Bem vindo <?php echo $usuario;?></span></li>
				<li class="logado"><a href="../sair.php">Sair</a></li>
				<?php }else{ ?>
					<li class="logado" id="user-entrar"><a href="#">Entrar</a></li>
					<li class="logado" id="user-cadastrar"><a href="#">Criar conta</a></li>
				<?php } ?>
			</ul>
	</div>

	<div class="lupa"><img id="icon-lupa" src="../imagens/icones/lupa.png" autocomplete="off" ></div>

	<form class="box_pesquisa" methoad="POST" action="..\pesquisa.php">
		<div class="input_container">
			<input type="text" name="pesquisa" id="id_pesquisa" autocomplete="off" placeholder="Faça sua pesquisa"/>					
		</div>
		<ul id="opcao_jogo"></ul>
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
			<li><a href="../console.php?codigo=<?php echo $value->id_console?>&nome_console=<?php echo $value->nome_console?>" class="link"><?php echo $value->nome_console?></a></li>
			<?php endforeach;?>
		</ul>					
	</nav>
</div>