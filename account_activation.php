<?php
    function __autoload($classe){
        require('classes/' . $classe . '.class.php');
    }
    $usuario = new Usuarios();

    $email = (isset($_GET['email'])) ? $_GET['email'] : '';
    $nome = (isset($_GET['nome'])) ? $_GET['nome'] : '';
    
    if(empty($email)){
        header("Location: index.php");
    }
    
    $user = Usuarios::getRegisterHelper(array('email'=>$email, 'status'=>'nao'));
    if($user):
        $mudastatus = $usuario->changeStatus('sim', $user[0]->id_user);        
    endif;    
?>
<html>
	<head>	
	<!--CHAMADA CSS-->
	<link rel="stylesheet" type="text/css" href="login/css/layout.css"/>
	<!--CSS BOOTSTRAP-->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css"/>
	<link rel="stylesheet" href="bootstrap/css/bootstrap-theme.css"/>
	
	<title>Confirmação do email</title>
	</head>
<body>
	<div id="top">
		<a href="index.php"><img src="imagens/backgrounds/logo.png" alt="Restart Games"></a>
	</div>
	<div class="row nopadding">        
		<div class="control-form" id="box_logar">
            <?php if($user):?>
                <div class="alert alert-success">
                    <b>Olá <?php echo ($nome) ? $nome : ''; ?>! Seu cadastro foi confirmado com sucesso</b><br/>
                    Acesse agora mesmo e aproveite o máximo na Restart Games
                </div>
            <?php else:?>
                <div class="alert alert-danger">
                    <b>Email não encontrado ou já verificado. Tente fazer login usando seu email e senha</b>
                </div>
            <?php endif;?>
            <form method="POST" action="" name="form-acesso" class="form-acesso" id="form-logar">
				<div class="row">
					<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<label for="email_login" class="title-create-account">Email:</label>
						<input type="text" name="email" id="email" placeholder="nome@exemplo.com" value="<?php echo ($_GET['email']) ? $_GET['email'] : ''?>" class="form-control field-signin"/>
					</div>
					<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<label for="senha_login" class="title-create-account">Senha:</label>
						<input type="password" name="senha" id="senha" placeholder="*************" class="form-control field-signin"/>
					</div>
					<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<a href="index.php" class="btn btn-danger" id="btn-voltar">Voltar <span class="glyphicon glyphicon-home"></span></a>  					
						<button class="btn btn-success" name="btn-recover" id="btn_enviar">Entrar <span class="glyphicon glyphicon-log-in"></span></button>
					</div>
				</div>
				<div class="alert alert-danger" id="result"></div>
			</form>
			<div class="box-create-account">					
				<span>Não possui uma conta? <a href="cadastro.php">Criar agora</a></span><br>
					
				<span><a href="login/recoverpass.php">Esqueceu a senha?</a></span>	
			</div> 
		</div>
	</div>
	<!--CHAMADA JAVASCRIPT-->		
	<script src="js/jquery.js"></script>
	<script src="js/jquery.js"></script>
    <script>
        $(document).ready(function(){
            $("#btn_enviar").bind('click',function (ev) {
                ev.preventDefault();
                frm = $('#form-logar');//formulário de login
                //logar_user(frm, 1, 'login/verifica.php', 'admin/','users/');

                $.ajax({
                    method:'POST',
                    url: 'login/verifica.php',
                    dataType:'json',
                    data: frm.serialize(),
                    success: function(dados){
                                        
                        if(dados.status == '0'){
                            $('#result').text(dados.mensagem).fadeIn();//error
                        }else{
                            window.location.href=("users/dashboard.php");//Dashboard usuário comum
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>

