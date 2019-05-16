<html>
	<head>	
	<!--CHAMADA CSS-->
	<link rel="stylesheet" type="text/css" href="css/layout.css"/>

    <!--CSS BOOTSTRAP-->
    <link rel="stylesheet" href="..\bootstrap/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="..\bootstrap/css/bootstrap-theme.css"/>
	<link rel="shortcut icon" type="image/x-icon" href="../favicon.ico">

	<title>Restart Games - Recuperar Senha</title>
	</head>
<body>
	<div id="top">
		<a href="../index.php"><img src="../imagens/icones/logo.png" alt="TrocaJogos"></a>
    </div>
    
    <div class="row nopadding">
        <div class="control-form" id="boxRecover">
            <form method="POST" action="" name="form-acesso" class="form-acesso" id="form-logar"> 
                <div class="row">
                    <label class="col-lg-12" class="lbl_info">Informe o e-mail cadastrado no site</label>
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <label for="email_recover" class="lbl_info">Email:</label>
                        <input type="text" name="email_recover" id="email_recover" placeholder="nome@exemplo.com" class="form-control" required/>
                    </div>
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
                        <a href="../index.php" class="btn btn-danger" id="btn-voltar">Voltar</a>                       
                        <button class="btn btn-success" name="btn-recover" id="btn-recover">Recuperar</button>
                        <a href="../index.php" class="btn btn-info" name="btn-back" id="btn-back">Voltar a navegação</a>
                    </div>
                </div>
                <div class="alert" id="return_msg"></div>
            </form>
            <div id="progress"><img src="../imagens/icones/loading.gif" alt="Carregando" id="loading"></div>
        </div>
    </div>
   
	<!--CHAMADA JAVASCRIPT-->		
	<script src="../js/jquery.js"></script>
    <script src="../js/script_recover.js"></script>
    
    <!--JS BOOTSTRAP-->
    <script src="..\bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
