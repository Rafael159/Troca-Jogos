<html>
	<head>	
	<!--CHAMADA CSS-->
	<link rel="stylesheet" type="text/css" href="css/layout.css"/>

    <!--CSS BOOTSTRAP-->
    <link rel="stylesheet" href="..\bootstrap/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="..\bootstrap/css/bootstrap-theme.css"/>

	<title>Restart Games - Recuperar Senha</title>
	</head>
<body>
	<div id="top">
		<a href="../index.php"><img src="../imagens/icones/logo.png" alt="TrocaJogos"></a>
    </div>
    
    <div class="row nopadding">
        <div class="control-form" id="boxNewPass">
        <?php
                $email = ($_GET['email']) ? $_GET['email'] : '';
                $limite = ($_GET['limit']) ? $_GET['limit'] : '';
                if(empty($email) || empty($limite)){
                    header('Location:../index.php');
                } 
                           
                date_default_timezone_set('America/Sao_Paulo');
                $data1 = date('Y-m-d H:i:s', $limite);
                $datatime1 = new DateTime($data1);
                $datatime2 = new DateTime('now');

                $data2  = $datatime2->format('Y-m-d H:i:s');
                
                $diff = $datatime1->diff($datatime2);
                $horas = $diff->h + ($diff->days * 24);
                $minutos = $horas * 60;
                
                if($horas >= 24):                
            ?>
               <span>Esse link expirou. Requisite um novo link clicando aqui <a href="recoverpass.php">Recuperar senha</a></span>

            <?php else:?>
                <form method="POST" action="" name="form-acesso" class="form-acesso" id="form-logar"> 
                    <div class="row nopadding">
                        <input type="hidden" name="email" id="email" value="<?php echo ($_GET['email']) ? $_GET['email'] : ''; ?>"/>
                        
                        <label class="lbl_info" id="titlerecover">Recuperar senha</label>
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label for="new_pass" class="lbl_info">Nova senha:</label>
                            <input type="password" name="new_pass" id="new_pass" placeholder="*************" class="form-control" required/>
                        </div>
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label for="confirm_pass" class="lbl_info">Confirmar senha:</label>
                            <input type="password" name="confirm_pass" id="confirm_pass" placeholder="*************" class="form-control" required/>
                        </div>
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
                            <button class="btn btn-success" name="btn-recoverpass" id="btn-recoverpass">Recuperar</button>
                        </div>
                    </div>
                    <div class="alert" id="return_msg"></div>
                </form>
            <?php endif;?>       
        </div>
    </div>
   
	<!--CHAMADA JAVASCRIPT-->		
	<script src="../js/jquery.js"></script>
    <script src="../js/script_recover.js"></script>
    
    <!--JS BOOTSTRAP-->
    <script src="..\bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
