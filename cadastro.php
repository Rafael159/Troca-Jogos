<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="description" content="Criar conta no Troque Jogos"/>
		<meta name="description" content="Seja um usuário do Troque Jogos"/>
		<meta name="keywords" content="Cadastro,Jogos,Games,Jogadores, Novo Usuário, Criar conta"/>
		
		<!--CHAMADA CSS-->
		<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="bootstrap/css/bootstrap-theme.css"/>		
		<link rel="stylesheet" href="css/cadastro.css"/>
		<link rel="stylesheet" href="font-awesome/css/font-awesome.css"/>
		<link rel="stylesheet" href="css/fonts.css"/> 
		<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
		<title>Restart Games - Crie sua conta</title>		
	</head>
	<body>
		<?php	
			if(isset($_POST['envio']) && ($_POST['envio'] == 'enviado')){
				$email = $_POST['email'];
				$senha = $_POST['senha'];
			}
		?>
		<main class="main">
		<div class="container-fluid nopadding">
			<div class="row top">
				<a href="index.php" class="brand"><img src="imagens/icones/logo.png" alt="TrocaJogos"></a>
				<span><a href="login/logar.php" class="btn pull-right btn-success"> Entrar <span class="glyphicon glyphicon-log-in"></span></a></span>
			</div>			
			<div class="row nopadding">
				<div id="box" class="col-lg-6 col-md-6 col-sm-8 col-lg-push-3 col-md-push-3 col-sm-push-2">					
					<div id="formulario">							
						<form method="POST" id="form-cadastro" action="" class="form">	
							<label class="faixa"><h3 class="first_title">Faça seu cadastro e entre para o mundo dos games </h3></label>					

							<div class="cleafix">
								<div class="steps" id="first-step">
									<h3 class="title_steps">Dados de acesso <i class="fa fa-address-card" aria-hidden="true"></i></i></h3>
									<div class="row">
										<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
											<label for="nome"><i class="fa fa-user fa-lg" aria-hidden="true"></i> Nome</label>
											<input type="text" name="nome" id="nome" placeholder="Nome" class="form-control"/>
										</div>
										<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
											<label for="email"><i class="fa fa-envelope fa-lg"></i> Email</label>
											<input type="text" name="email" id="email" placeholder="Email" value="<?php if(isset($email)){echo $email;}else{};?>" class="form-control"/>
										</div>
										<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
											<label for="celular"><i class="fa fa-mobile fa-lg"></i> Celular</label>
											<input type="text" name="celular" id="celular" placeholder="Celular" class="form-control"/>
										</div>	
										<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
											<label for="telefone"><i class="fa fa-phone fa-lg"></i> Telefone</label>
											<input type="text" name="telefone" id="telefone" placeholder="Telefone (opcional)" class="form-control"/>
										</div>										 
										<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
											<label for="senha"><i class="fa fa-key fa-lg"></i> Senha</label>
											<input type="password" name="senha" id="senha" placeholder="Senha" value="<?php if(isset($senha)){echo $senha;}else{};?>" class="form-control"/>
										</div>
										<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
											<label for="conf-senha"><i class="fa fa-key fa-fw"></i> Confirmar senha</label>
											<input type="password" name="conf_senha" id="conf_senha" placeholder="Confirmar Senha" class="form-control"/>										
										</div>																			
									</div>									
								</div>
								<div class="steps" id="second-step">	
									<h3 class="title_steps">Qual video game você possui ou tem mais interesse? <i class="fa fa-gamepad" aria-hidden="true"></i></h3>
									<div class="row">
										<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
											<select id="console" class="form-control" name="console" class="required">
												<option value="">Seu console</option>												
											</select>
										</div>
									</div>													
								</div>
								</div><!--/ fim do second step-->
								<div class="steps" id="third-step">
									<h3 class="title_steps">Dados de entrega <i class="fa fa-paper-plane" aria-hidden="true"></i> <i>(opcional)</i> </h3>
									<div class="row">				
										<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
											<label for="rua">CEP</label>
											<input type="text" name="cep" id="cep" placeholder="CEP" class="form-control"/>
											<small id="erro_cep"></small>
										</div>
										<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
											<label for="rua">Rua</label>
											<input type="text" name="rua" id="rua" placeholder="Rua" class="form-control"/>
										</div>
										<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
											<label for="numero">Número</label>
											<input type="text" name="numero" id="numero" placeholder="Número" pattern="\([0-9]{2}\) [0-9]{4,6}-[0-9]{3,4}$" class="form-control"/>
										</div>
										<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
											<label for="bairro">Bairro</label>
											<input type="text" name="bairro" id="bairro" placeholder="Bairro" class="form-control"/>
										</div>
										<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
											<label for="cidade">Cidade</label>
											<input type="text" name="cidade" id="cidade" placeholder="Cidade" class="form-control"/>
										</div>
										<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
											<label for="estado">Estado</label>
											<select type="text" name="estado" id="estado" class="form-control">
												<option value="">Estado</option>																				
											</select>									
										</div>
										<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
											<label for="complemento">Complemento</label>
											<input type="text" name="complemento" id="complemento" placeholder="Complemento" class="form-control"/>
										</div>
										<div id="retorno"></div><!--recebe a mensagem de erro-->

										<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
											<section class="information"><a href="#" id="linkExplica" data-toggle="modal" data-target="#show-reason">Por que informar o endereço?</a></section>
										</div>
										<div class="col-lg-12 col-md-6 col-sm-6 col-xs-12">
											<h5><input type="checkbox" name="termos" value="Termos" id="termos"/>Ao clicar em Cadastrar você concorda com os <a href="termos_privacidade.php" target="blank">Termos de Política e Privacidade</a> do Troca Jogos</h5>										
											<div class="alert alert-danger" id='msg_error'>
												<strong></strong>
											</div>
											<div class="btn-group">
												<button name="btCancelar" class="btn btn-danger" id="btCancelar">Cancelar</button>	
												<button type="submit" name="btCadastrar" class="btn btn-success" id="btCadastrar">Cadastrar</button>	
											</div>										
										</div>
									</div>	
								</div><!--/ fim da third step-->
							<div>							
						</form><!--fim form de cadastro -->	
					</div>	<!-- / fim id formulário-->	
				</div>
			</div>

			<!--MODAL EXPLICA O PORQUÊ PREENCHER O ENDEREÇO-->
			<div class="modal fade" id="show-reason">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h1 class="title_modal">Por que preencher o endereço?</h1>
						</div>
						<div class="modal-body">							
							<p>A visão do Restart Games é possibilitar que jogadores do Brasil possam se encontrar na nossa plataforma e trocar os seus jogos</p>
							<p>Pensando nisso, nada melhor do que saber onde entregar o jogo quando uma troca for acordada entre os players</p>
							<br>
							<p>Você não é obrigado a informar o seu endereço. Apenas garanta que a comunicação entre os interessados possa proporcionar uma troca com 100% de sucesso</p>
							<br>
							<p>Divirta-se!!!</p>							
						</div>
					</div>	
				</div>				
			</div>

			<!--MODAL APÓS O CADASTRO SER FEITO-->
			<div class="modal fade" id="modal-register">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h1 class="title_modal">Parabéns, seu cadastro foi feito com sucesso!</h1>
						</div>
						<div class="modal-body">
							<small>
								<p>Apenas mais um passo e poderá acessar nossa plataforma</p>
								<p>Acesse seu e-mail e click no link que te mandamos e PRONTO!</p>								
							</small>
						</div>
					</div>	
				</div>				
			</div>
		</div>	
	</main>
		<script src="js/jquery.js"></script>
		<script src="js/jquery.mask.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.min.js"></script>
		<script src="js/funcoes.js"></script>
		<script src="js/validacao.js"></script>
		<script src="js/mascara.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>
	</body>
</html>