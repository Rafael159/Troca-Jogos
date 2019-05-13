<html>
	<head>	
	<!--CHAMADA CSS-->
	<link rel="stylesheet" type="text/css" href="css/layout.css"/>
	<!--CSS BOOTSTRAP-->
    <link rel="stylesheet" href="..\bootstrap/css/bootstrap.min.css"/>
	<link rel="stylesheet" href="..\bootstrap/css/bootstrap-theme.css"/>
	<link rel="shortcut icon" type="image/x-icon" href="../favicon.ico">
	
	<title>Entre agora mesmo !</title>
	</head>
<body>
	<div id="top">
		<a href="../index.php"><img src="../imagens/icones/logo.png" alt="Restart Games"></a>
	</div>
	<div class="row nopadding">
		<div class="control-form" id="box_logar">
			<form method="POST" action="" name="form-acesso" class="form-acesso" id="form-logar">
				<div class="row"> 			
					<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<label for="email_login" class="title-create-account">Email:</label>
						<input type="text" name="email" id="email" placeholder="nome@exemplo.com" class="form-control field-signin"/>
					</div>
					<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<label for="senha_login" class="title-create-account">Senha:</label>
						<input type="password" name="senha" id="senha" placeholder="*************" class="form-control field-signin"/>
					</div>
					<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<a href="../index.php" class="btn btn-danger" id="btn-voltar">Voltar <span class="glyphicon glyphicon-home"></span></a>  					
						<button class="btn btn-success" name="btn-recover" id="btn_enviar">Entrar <span class="glyphicon glyphicon-log-in"></span></button>
					</div>
				</div>
				<div class="alert alert-danger" id="result"></div>
			</form>
			<div class="box-create-account">					
				<span>Não possui uma conta? <a href="../cadastro.php">Criar agora</a></span><br>
					
				<span><a href="../login/recoverpass.php">Esqueceu a senha?</a></span>	
			</div>
		</div>
	</div>
	<!--CHAMADA JAVASCRIPT-->		
	<script src="../js/jquery.js"></script>
	<script src="../js/funcoes.js"></script>
</body>
</html>
