<?php
spl_autoload_register(function($classe) {
	require(dirname(dirname(__FILE__)).'/classes/'.$classe.'.class.php');
});
$user = new Usuarios;

/*Get email e senha*/
$email = (isset($_POST['email'])) ? trim($_POST['email']) : '';
$senha = (isset($_POST['senha'])) ? trim($_POST['senha']) : '';
$confirm_pass = (isset($_POST['confirm_pass'])) ? trim($_POST['confirm_pass']) : '';

$tipo = (isset($_POST['tipo'])) ? $_POST['tipo'] : '';

$retorno = array();

if(empty($email)):
	$retorno = array('status'=>'0', 'mensagem'=>'Informe um email válido');
	echo json_encode($retorno);
	exit();
endif;

if($tipo && $tipo=='recuperar'){ 
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		$retorno = array('status'=>'0', 'mensagem'=>'Por favor informe um e-mail válido');
		echo json_encode($retorno);
		exit();
	}

	$mail = strip_tags(trim($email));
	$row = $user->getRegister(array('email'=>$mail));

	if(sizeof($row)==0){
		$retorno = array('status'=>'0', 'mensagem'=>'E-mail informado não encontrado. Informe o e-mail usado no cadastro');
		echo json_encode($retorno);
		exit();
	}else{
		// $retorno = array('status'=>'0', 'mensagem'=> 'cheguei aqui');
		// 	echo json_encode($retorno);	
		// 	exit();

		//gerar timestamp da hora atual
		date_default_timezone_set('America/Sao_Paulo');//timezone
		$dataatual = date('Y-m-d H:i:s');//pegar data e hora atual
		$dateTime = new DateTime($dataatual);//gerar timestamp
		$datatimestamp = $dateTime->getTimestamp();//pegar timestamp
				
		//enviar email
		require '../PHPMailer/PHPMailerAutoload.php';

		$mailer = new PHPMailer();
		$mailer->SMTPOptions = array(
			'ssl' => array(
				'verify_peer' => false,
				'verify_peer_name' => false,
				'allow_self_signed' => true
			)
		);

		$mailer->isSMTP();
		//Enviar email em HTML
		$mailer->isHTML(true);
		//aceita caracteres especiais    
		$mailer->CharSet = 'utf-8';

		//configurações
		$mailer->SMTPAuth = true;
		$mailer->SMTPSecure = 'tls';

		//nome do servidor
		$mailer->Host = 'smtp.hostinger.com.br';
		$mailer->Port = 587;

		//nome do usuário do email
		//nome do usuário do email
		$mailer->Username = 'suporte@restartgames.com.br';
		$mailer->Password = '@suporteRGames>2019';

		//E-mail remetente
		$mailer->From = 'suporte@restartgames.com.br';

		$mailer->FromName = 'Equipe Restart Games';

		//Assunto da mensagem
		$mailer->Subject = 'Recuperação de Senha - Restart Games';

		//Corpo da mensagem
		$mailer->Body = "
			<div style='margin: auto; padding-bottom: 30px; border: 0; font-size: 0px; font: inherit; vertical-align: baseline; position: relative; width: 550px; background-repeat: no-repeat; background:#ffffff;'>
				<table style='margin: auto; padding: 0; border: 0; font-size: 100%; font: inherit; vertical-align: baseline; border-collapse: collapse; border-spacing: 0; width: 100%; font-family: Arial, Calibri; color: #ffffff;'>
				<tr><th colspan='2'><h1 style='margin: 0;padding: 15px; border: 0; font-size: 0px; font: inherit; vertical-align: baseline; font-weight: bold; font-size: 1.7em; color: #ffffff; background: #069;text-align: center; '>Restart Games - Recuperação de senha</h1></th></tr>
				<tr><td colspan='2'><p style='margin: 0; padding: 0; border: 0; font-size: 0px; font: inherit; vertical-align: baseline; font-weight: normal; font-size: 1.3em; color: #000000; font-family: Calibri, Arial, sans-serif; margin:10px;'>Olá ".$row[0]->nomeUser.", <br>Recebemos uma requisição para alterar sua senha na <b style='color:#0074e1;'>Restart</b> <b>Games</b> através do email $email</p></tr></td>
				<tr><td colspan='2' style='background-color: #333333;'><h2 style='margin: 0; padding: 5px; border: 0; font-size: 0px; font: inherit; vertical-align: baseline; font-weight: bold; font-size: 15px; color:#ffffff; text-align:center;'>Para mudar sua senha, clique no link abaixo</h2></td></tr>
				<tr><td colspan='2' style='width:100%; text-align: center;'><br/><h2 style='margin: 0; padding: 0; border: 0; font-size: 0px; font: inherit; vertical-align: baseline; font-weight: bold; font-size: 30px; color: #000000;'><a href='http://www.restartgames.com.br/login/resetpassword.php?email=".$email."&ps=101&limit=".$datatimestamp."' style='color:#333; font-size:1em; text-decoration: underline' target='blink'>Mudar minha senha</a></h2><br/></td></tr></table>
				<h2 style='margin: 0; padding: 10px; border: 0; font-size: 0px; font: inherit; vertical-align: baseline; font-size:1em; color: #000000; font-family: Arial, Calibri; display: block;'>Esse link expirará em 24h. É preciso redefinir sua senha nesse prazo</h2>
				<h2 style='margin: 0; padding: 10px; border: 0; font-size: 0px; font: inherit; vertical-align: baseline; font-size:1em; color: #000000; font-family: Arial, Calibri; display: block;'>Você recebeu essa mensagem porque esse email foi listado como email de recuperação de senha da sua conta Restart Games.</h2>
				<h2 style='margin: 0; padding: 10px; border: 0; font-size: 0px; font: inherit; vertical-align: baseline; font-size:1em; color: #000000; font-family: Arial, Calibri; display: block;'> Se não foi você, por favor desconsidere esse email</h2>        
				<h4 style='margin: 0; padding: 0px 10px; border: 0; font-size: 0px; font: inherit; vertical-align: baseline; font-size:1em; color: #000000; font-family: Arial, Calibri; display: block;'>Atenciosamente,</h4>
				<h4 style='margin: 0; padding: 0px 10px; border: 0; font-size: 0px; font: inherit; vertical-align: baseline; font-size:1em; color: #000000; font-family: Arial, Calibri; display: block;'>Equipe de suporte Restart Games</h4>
			</div>";

		//Destinatário
		$mailer->addAddress($email);

		if ($mailer->Send()) {
			session_start();
			// $_SESSION['novo_usuario'] = $nome;
			// $_SESSION['novo_email'] = $email;
			$retorno = array('status'=>'1', 'mensagem'=> $email);
			echo json_encode($retorno);	
			exit();
		}else{
			$retorno = array('status'=>'0', 'mensagem'=> 'Houve um erro ao enviar o email. Por favor, tente novamente');
			echo json_encode($retorno);	
			exit();
		}	
	}

}elseif($tipo && $tipo == 'recuperasenha'){
	//verificação de campos
	if (empty($senha) or strlen($senha) < 6) :
		$retorno = array('status' => '0', 'mensagem' => 'Senha deve possuir no mínimo 6 caracteres');
		echo json_encode($retorno);
		exit();
	endif;

	if (empty($confirm_pass)) :
		$retorno = array('status' => '0', 'mensagem' => 'Confirme a senha');
		echo json_encode($retorno);
		exit();
	endif;

	if ($confirm_pass != $senha) :
		$retorno = array('status' => '0', 'mensagem' => 'Senhas não coincidem. Informe a mesma senha');
		echo json_encode($retorno);
		exit();
	endif;

	if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		$retorno = array('status'=>'0', 'mensagem'=>'Por favor informe um e-mail válido');
		echo json_encode($retorno);
		exit();
	}

	$mail = strip_tags(trim($email));

	$row = $user->getRegister(array('email'=>$mail));

	if(sizeof($row)==0){
		$retorno = array('status'=>'0', 'mensagem'=>'E-mail informado não encontrado. Informe o e-mail usado no cadastro');
		echo json_encode($retorno);
		exit();
	}

	//criptografia da senha com BCRYPT
	$custo = '08'; //ajuda no formação da senha única*/
	$salto = 'Cf1f11ePArKlBJomM0F6aJ'; //garante que a senha não se repita
	$senha = crypt($senha, '$2a$' . $custo . '$' . $salto . '$');

	if($user->updatePass($mail, $senha)){
		$retorno = array('status'=>'1', 'mensagem'=>'Senha atualizada com sucesso');
		echo json_encode($retorno);
		exit();
	}
	
}else{
	
	if(empty($senha)):
		$retorno = array('status'=>'0', 'mensagem'=>'Senha é campo obrigatório');
		echo json_encode($retorno);
		exit();
	endif;

	$custo = '08';//ajuda no formação da senha única*/
	$salto = 'Cf1f11ePArKlBJomM0F6aJ';//garante que a senha não se repita
	$senha = crypt($senha, '$2a$' . $custo . '$' . $salto . '$');//criar senha com suas variáveis estáveis

	$user->setEmail($email);//setar email
	$user->setSenha($senha);//setar senha
	
	$dados = $user->loginUser();//logar
	
	/*SE RETORNAR O USER*/
	if($dados):
		session_start();
		//definir sessões
		unset($dados->senha);
		unset($dados->logusuario);
		unset($dados->logfirst);
		
		$_SESSION['id_user'] = $dados->id_user;
		$_SESSION['emailTJ'] = $dados->emailTJ;
		$_SESSION['nomeTJ']  = $dados->nomeUser;				
		$_SESSION['status']  = $dados->tipousuario;
		$_SESSION['usuario'] = serialize($dados);

		$retorno = array('status'=>'1', 'mensagem'=>'Logado com sucesso', 'nivel'=>$dados->tipousuario);
		echo json_encode($retorno);
	else:
		$retorno = array('status'=>'0', 'mensagem'=>'Falha ao logar! Verifique seu email e/ou senha');
		echo json_encode($retorno);
		exit();
	endif;
}



?>