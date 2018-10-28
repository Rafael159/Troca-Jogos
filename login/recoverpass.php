<html>
	<head>	
	<!--CHAMADA CSS-->
	<link rel="stylesheet" type="text/css" href="css/layout.css"/>

    <!--CSS BOOTSTRAP-->
    <link rel="stylesheet" href="..\bootstrap/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="..\bootstrap/css/bootstrap-theme.css"/>

	<title>Troca Games - Recuperar Senha</title>
	</head>
<body>
	<div id="top">
		<a href="../index.php"><img src="../imagens/backgrounds/logo.png" alt="TrocaJogos"></a>
    </div>
    <div class="row nopadding">
        <div class="control-form" id="boxRecover">
            <form method="POST" action="" name="form-acesso" class="form-acesso" id="form-logar"> 
                <div class="row">
                    <label class="col-lg-12">Informe o e-mail cadastrado no site</label>		
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <label for="email_recover">Email:</label>
                        <input type="text" name="email_recover" id="email_recover" placeholder="nome@exemplo.com" class="form-control"/>
                    </div>
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
                        <a href="../index.php" class="btn btn-danger">Voltar</a>                       
                        <button class="btn btn-success" name="btn-recover" id="btn-recover">Recuperar</button>
                    </div>
                </div>
                <div class="alert alert-danger" style="display:none">E-mail informado não encontrado. Informe o e-mail usado no cadastro</div>
            </form>
            
        </div>
    </div>
    <?php
       function __autoload($classe){
            require('../classes/'.$classe.'.class.php'); /*chama a classe automaticamente*/
        }
        $user = new Usuarios();
        $queries = array();
        $queries['email'] = 'pedrosilva@gmail.com';
        //$queries['id_user'] = '2';


        $row = $user->findEmail($queries);
        if(sizeof($row)==0){
           echo 'não retornou nada';
        }
        echo '<pre>';
        print_r($row);
    ?>
	<!--CHAMADA JAVASCRIPT-->		
	<script src="../js/jquery.js"></script>
    <script src="../js/script_recover.js"></script>
    
    <!--JS BOOTSTRAP-->
    <script src="..\bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
