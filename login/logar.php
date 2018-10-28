<html>
	<head>	
	<!--CHAMADA CSS-->
	<link rel="stylesheet" type="text/css" href="css/layout.css"/>
	<!--CSS BOOTSTRAP-->
    <link rel="stylesheet" href="..\bootstrap/css/bootstrap.min.css"/>
	<link rel="stylesheet" href="..\bootstrap/css/bootstrap-theme.css"/>
	
	<title>Entre agora mesmo !</title>
	</head>
<body>
	<div id="top">
		<a href="../index.php"><img src="../imagens/backgrounds/logo.png" alt="TrocaJogos"></a>
	</div>
	<div class="row nopadding">
		<div class="control-form" id="box_logar">
			<form method="POST" action="" name="form-acesso" class="form-acesso" id="form-logar"> 			
				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<label for="email_login" class="title-create-account">Email:</label>
					<input type="text" name="email" id="email" placeholder="nome@exemplo.com" class="form-control"/>
				</div>
				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<label for="senha_login" class="title-create-account">Senha:</label>
					<input type="password" name="senha" id="senha" placeholder="*************" class="form-control"/>
				</div>
				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">					
					<img src="img/seta.png" id="btn_enviar"/></button>					
				</div>						
				<div class="btn-group">
					<a href="../index.php">Cancelar</a>
					<a href="#user-cadastrar">Esqueceu a senha?</a>
					<button class="btn btn-success" id="btn_enviar">Entrar</button>
				</div>
				<div id="result"></div>
			</form>
		</div>
	</div>
	<!--CHAMADA JAVASCRIPT-->		
	<script src="../js/jquery.js"></script>
	<script src="../js/funcoes.js"></script>
</body>
</html>
