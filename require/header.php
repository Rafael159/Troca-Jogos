<header class="clearfix">			
	<div class="lupa"><img id="icon-lupa" src="imagens/icones/lupa.png" autocomplete="off" ></div>
	<form id="box_pesquisa" class='search-field' method="GET" action="pesquisa.php">
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
			<input type="text" name="pesquisa" id="id_pesquisa" class="pesquisa" onkeyup="autoCompletar(this)" autocomplete="off" value="<?php if(isset($q)){echo $q;}else{}?>"/>
			<ul id="opcao_jogo"></ul>
			<button type="submit" name="enviar" class="search-btn">Pesquisar</button>						
		</div>
		
	</form><br/>
	<div id="logo"><a href="index.php"><img src="imagens/backgrounds/logo.png"></a></div>
	<div class="lg-box">
		<ul class="lg-acao">
			<?php
				if(!isset($_SESSION)) session_start();
				if(isset($_SESSION['emailTJ'])){
					$emailLogado = $_SESSION['emailTJ'];
					$usuario  = $_SESSION['nomeTJ'];
					$status = $_SESSION['status'];	
					if($status == 0){
			?>
			<li class="user-logged"><a href="users/dashboard.php">Área de controle</a></li>
			<?php }else{ ?>
			<li class="user-logged"><a href="admin/admin.php">Área de controle</a></li>
			<?php } ?>
			<li class="user-logged"><a href="#">Bem vindo <?php echo $usuario;?></a></li>
			<li class="user-logged"><a href="#"><a href="sair.php">Sair</a></li>
			<?php }else{ ?>
				<li class="user-logged access-register" id="user-cadastrar"><a href="#">Criar conta</a></li>				
				<li class="user-logged access-login" id="user-entrar"><a href="#">Entrar</a></li>
			<?php } ?>
		</ul>
	</div>
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
						<input type="button" name="logar" value="Logar" id="btn-logar"/>									
					</label>								
				<p>
					<label>
						<a href="cadastro.php">Cadastre-se</a>
						<a href="#user-cadastrar">Esqueci minha senha</a>
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

