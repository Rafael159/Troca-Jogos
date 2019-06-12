<?php	
	$categoria = new Consoles();	
?>

<nav class="navbar navbar-expand-md navbar-dark">
	<a href="index.php" class="navbar-brand"><img src="imagens/icones/logo.png" alt="Restart Games" id="brandNew"/></a></a>
	<button class="navbar-toggler" data-toggle="collapse" data-target="#navbarMenu">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarMenu">
		<ul class="navbar-nav ml-auto">
			<?php
				$user = Usuarios::getUsuario();
				
				if(!empty($user)):
					$emailLogado = $user->emailTJ;
					$usuario  = $user->nomeUser;
					$status = $user->tipousuario;
					if($status == 0):
			?>
					<li class="logado nav-item"><a href="users/dashboard.php" class="nav-link">Dashboard <i class="fa fa-home"></i></a></li>
				<?php else: ?>
					<li class="logado nav-item"><a href="admin/admin.php" class="nav-link">Dashboard <i class="fa fa-home"></i></a></li>
				<?php endif; ?>
					<li class="logado nav-item"><a href="#" class="nav-link">Bem vindo <?php echo $usuario;?></a></li>
					<li class="logado nav-item"><a href="sair.php" class="nav-link">Sair <i class="fa fa-sign-out"></i></a></li>
			<?php else: ?>
				<li class="logado  nav-item access-login" id="user-entrar"><a href="#" class="nav-link"><i class="fa fa-sign-in" aria-hidden="true"></i> Entrar </a></li>
				<li class="logado nav-item access-register" id="user-cadastrar"><a href="#" class="nav-link"><i class="fa fa-user-plus" aria-hidden="true"></i> Criar conta</a></li>
			<?php endif; ?>
		</ul>
	</div>            
</nav>

<header class="tj-top">	
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
			</div><!--box-cadastro-->			
		</div><!--box-login-cadastro-->

</header>
<div class="row">
	<div id="main-menu">
		<nav class="navs">
			<ul class="nav">
				<?php 
					foreach($categoria->listarTodos() as $value):
				?>
				<li class="cns-menu nav-item"><a href="console.php?codigo=<?php echo $value->id_console?>&nome_console=<?php echo $value->nome_console?>" class="link nav-link"><?php echo $value->nome_console?></a></li>
				<?php endforeach;?>
			</ul>	
		</nav>
	</div>
</div>