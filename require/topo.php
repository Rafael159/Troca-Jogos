<!--CHAMADA CSS-->
<?php
	@BD::conn();//conexão com o banco de dados
	$categoria = new Consoles();	
?>
<header class="tj-top">
	<div class="inf clearfix">
		<span id="logo" class="clearfix"><a href="index.php"><img src="imagens/icones/logo.png" alt="Logo"/></a></span>
		<div class="user-space">
			<ul class="user-acao">
				<?php
					if(isset($_SESSION['emailTJ'])){
						$emailLogado = $_SESSION['emailTJ'];
						$usuario  = $_SESSION['nomeTJ'];
						$status = $_SESSION['status'];
						if($status == 0){
				?>
				<li class="logado"><a href="users/dashboard.php">Área de controle</a></li>
				<?php }else{ ?>
				<li class="logado"><a href="admin/admin.php">Área de controle</a></li>
				<?php } ?>
				<li class="logado"><a href="#">Bem vindo <?php echo $usuario;?></a></li>
				<li class="logado"><a href="sair.php">Sair</a></li>
				<?php }else{ ?>
					<li class="logado access-login" id="user-entrar"><a href="#">Entrar</a></li>
					<li class="logado access-register" id="user-cadastrar"><a href="#">Criar conta</a></li>
				<?php } ?>
			</ul>
		</div>
	</div>
	<!--Box que receberá login e cadastro-->
		<div id="overlay"></div><!--fundo-->
		<div class="box-login-cadastro">
			<div id="box-login" class="cx_content">
				<label class="btn_cancela_acesso" id="cancelar_login"><b>X</b></label>
				<!--formulário de LOGIN-->
				<div class="titulo-acesso">Faça seu login utilizando sua conta cadastrada na Restart Games</div>
				<form method="POST" action="" name="form-acesso" class="form-acesso" id="form-acesso">
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
							<button name="logar" id="btn-logar">Logar  <i class="fa fa-sign-in" aria-hidden="true"></i></button>
							<!-- <input type="button" name="logar" value="Logar" id="btn-logar"/>									 -->
						</label>								
					<p>
						<label>
							<a href="cadastro.php">Cadastre-se</a>
							<a href="login/recoverpass.php" id="forgetPass">Esqueci minha senha</a>
						</label>
					</p>
				</form>				
			</div><!--box-login-->

			<div id="box-cadastro" class="cx_content">
				<label class="btn_cancela_acesso" id="cancelar_login"><b>X</b></label>
				<!--formulário CADASTRO-->
				<div class="titulo-acesso">Para se cadastrar informe seu e-mail e senha nos campos indicados</div>
				<form method="POST" action="cadastro.php" name="cadastro" class="form-acesso" enctype="multipart/form-data">
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
							<button class="Cadastro" id="btn-cadastrar">Cadastrar <i class="fa fa-user-plus" aria-hidden="true"></i></button>
							<input type="hidden" name="envio" value="enviado"/>								
						</label>								
					</p>
				</form>
				<div id="status"></div>
				<!-- <button class="facebook" id="cadastrar_facebook">Cadastrar com o Facebook</button> -->
			</div><!--box-cadastro-->			
		</div><!--box-login-cadastro-->

		
		<div id="main-menu">
			<nav class="navs">
				<ul>
					<?php 
						foreach($categoria->listarTodos() as $value):
					?>
					<li class="cns-menu"><a href="console.php?codigo=<?php echo $value->id_console?>&nome_console=<?php echo $value->nome_console?>" class="link"><?php echo $value->nome_console?></a></li>
					<?php endforeach;?>
				</ul>	
			</nav>
		</div>
</header>
