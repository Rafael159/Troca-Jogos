<nav class="navbar navbar-expand-lg navbar-dark nav-container">
	<a href="index.php" class="navbar-brand navbar-logo"><img src="imagens/icones/logo.png" alt="Restart Games"  id="brandNew"/></a></a>
	<button class="navbar-toggler" data-toggle="collapse" data-target="#navbarMenu">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarMenu">		
		<form id="box_pesquisa" class='form-inline my-auto d-inline search-field' method="GET" action="pesquisa.php">
			<?php  
				$q = (isset($_GET['pesquisa']) AND !empty($_GET['pesquisa'])) ? $_GET['pesquisa'] : '';			
				if(isset($_GET['pag'])){
					$pag = $_GET['pag'];
					if($pag >= 2){
						$q = "";
					}
				}
			?>
			<div class="input_container">
				<div class="control-group">
					<input type="text" name="pesquisa" id="id_pesquisa" class="form-control border border-right-0 pesquisa" onkeyup="autoCompletar(this)" autocomplete="off" value="<?php if(isset($q)){echo $q;}else{}?>"/>
					<button type="submit" name="enviar" class="search-btn">Pesquisar</button>
				</div>
				<ul id="opcao_jogo"></ul>
			</div>
		</form>
		<ul class="navbar-nav ml-auto">
			<?php
				$user = Usuarios::getUsuario();
				
				if(!empty($user)):
					$emailLogado = $user->emailTJ;
					$usuario  = $user->nomeUser;
					$status = $user->tipousuario;
					if($status == 0):
			?>
					<li class="logado nav-item"><a href="users/dashboard.php" class="nav-link"> <i class="fa fa-home"></i></a></li>
				<?php else: ?>
					<li class="logado nav-item"><a href="admin/admin.php" class="nav-link"> <i class="fa fa-home"></i></a></li>
				<?php endif; ?>
					<li class="logado nav-item"><a href="#" class="nav-link"><?php echo $usuario;?></a></li>
					<li class="logado nav-item"><a href="sair.php" class="nav-link">Sair <i class="fa fa-sign-out"></i></a></li>
			<?php else: ?>
				<li class="logado  nav-item access-login" id="user-entrar"><a href="#" class="nav-link"><i class="fa fa-sign-in" aria-hidden="true"></i> Entrar </a></li>
				<li class="logado nav-item access-register" id="user-cadastrar"><a href="#" class="nav-link"><i class="fa fa-user-plus" aria-hidden="true"></i> Criar conta</a></li>
			<?php endif; ?>
		</ul>
	</div>            
</nav>


<header class="clearfix">
	<div id="anuncios"></div>
	
	<!--Box que receberá login e cadastro-->
	<div id="overlay"></div><!--fundo-->
	<div class="box-login-cadastro">
		<div id="box-login">
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
						<a href="login/recoverpass.php">Esqueci minha senha</a>
					</label>								
				</p>
			</form>
			<!-- <button class="facebook" id="logar_facebook">Logar com o Facebook</button> -->
		</div><!--box-login-->

		<div id="box-cadastro">
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
						<!-- <input type="submit" name="Cadastro" value="Cadastrar" id="btn-cadastrar"/>	 -->
						<input type="hidden" name="envio" value="enviado"/>								
					</label>								
				</p>
			</form>
			<!-- <button class="facebook" id="cadastrar_facebook">Cadastrar com o Facebook</button> -->
		</div><!--box-cadastro-->
	</div><!--box-login-cadastro-->	
</header>

