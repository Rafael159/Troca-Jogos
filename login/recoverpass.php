<!DOCTYPE HTML>
<html>
	<head>	
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">	

	<!--CHAMADA CSS-->
	<link rel="stylesheet" type="text/css" href="css/layout.css"/>

    <!--CSS BOOTSTRAP-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" href="../font-awesome/css/font-awesome.css"/>
	<link rel="stylesheet" href="../css/fonts.css"/> 
    <link rel="shortcut icon" type="image/x-icon" href="../favicon.ico">
	<link rel="stylesheet" type="text/css" href="../css/style-footer.css"/>   

	<title>Restart Games - Recuperar Senha</title>
	</head>
<body>
	<div class="container-fluid nopadding">
        <nav class="navbar navbar-expand-md navbar-dark justify-content-center">
			<a href="../index.php" class="navbar-brand navbar-logo"><img src="../imagens/icones/logo.png" alt="Restart Games"/></a></a>					          
		</nav>
        <div class="row nopadding justify-content-center">
			<div class="col-sm-10 col-md-8 col-lg-5">
                <div class="control-form" id="boxRecover">
                    <form method="POST" action="" name="form-acesso" class="form-acesso" id="form-logar"> 
                        <div class="row">                            
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label for="email_recover" class="lbl_info">Email</label>
                                <input type="text" name="email_recover" id="email_recover" placeholder="nome@exemplo.com" class="form-control" required/>
                            </div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
                                <a href="../index.php" class="btn btn-danger" id="btn-voltar"><i class="fa fa-home"></i> Voltar</a>                       
                                <button class="btn btn-success" name="btn-recover" id="btn-recover"><i class="fa fa-sign-in"></i> Recuperar</button>
                            </div>
                        </div>
                        <div class="alert" id="return_msg"></div>
                    </form>
                    <div id="progress"><img src="../imagens/icones/loading.gif" alt="Carregando" id="loading"></div>
                </div>
            </div>
        </div>

        <div class="footer footer-recover">
			<div class="row nopadding">
				<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 nopadding">
					<div class="boxes">
						<p class="text-bold">Sobre</p>
						<ul>
							<li><a href="../termos_privacidade.php" target="_blank">Termos de uso</a></li>
						</ul>
					</div>
				</div>  
				<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 nopadding">
					<div class="boxes">
						<p class="text-bold">Redes</p>
						<ul>                       
							<li><a href="https://www.facebook.com/Restart-Games-2294753787408578/?modal=admin_todo_tour" target="blind"><i class="fa fa-facebook-square fa-2x"></i></a></li>            
						</ul>
					</div>
				</div>  
				<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 nopadding">
					<div class="boxes">               
						<img src="../imagens/icones/logo.png" alt="Restart Games" class="brand">
						<p class="text-bold">© RestartGames <?php echo date('Y'); ?></p>
					</div>
				</div>  
			</div>
		</div>
    </div>
   
	<!--CHAMADA JAVASCRIPT-->		
	<script src="../js/jquery.js"></script>
    <script src="../js/script_recover.js"></script>
    
    <!--JS BOOTSTRAP-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
