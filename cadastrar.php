<?php
function __autoload($classe){
	require('classes/' . $classe . '.class.php');
}
$user = new Usuarios();
$notice = new Notificacoes();

//validação e cadastro do usuário	
$nome = (isset($_POST['nome'])) ? trim($_POST['nome']) : '';
$celular = (isset($_POST['celular'])) ? trim($_POST['celular']) : '';
$telefone = (isset($_POST['telefone'])) ? trim($_POST['telefone']) : '';
$email = (isset($_POST['email'])) ? trim($_POST['email']) : '';
$senha = (isset($_POST['senha'])) ? trim($_POST['senha']) : '';
$conf_senha = (isset($_POST['conf_senha'])) ? trim($_POST['conf_senha']) : '';
$console = (isset($_POST['console'])) ? $_POST['console'] : '';
$cep = (isset($_POST['cep'])) ? $_POST['cep'] : '';
$rua = (isset($_POST['rua'])) ? trim($_POST['rua']) : '';
$numero = (isset($_POST['numero'])) ? trim($_POST['numero']) : '';
$bairro = (isset($_POST['bairro'])) ? trim($_POST['bairro']) : '';
$cidade = (isset($_POST['cidade'])) ? trim($_POST['cidade']) : '';
$estado = (isset($_POST['estado'])) ? trim($_POST['estado']) : '';
$complemento = (isset($_POST['complemento'])) ? trim($_POST['complemento']) : '';
$tipo = (isset($_POST['tipousuario'])) ? $_POST['tipousuario'] : 0;
//$mail = @BD::conn()->prepare('SELECT * FROM `usuarios` WHERE emailTJ = ? ');
//$mail->execute(array($email));	

$retorno = array();

if (empty($nome)) :
	$retorno = array('status' => '0', 'mensagem' => 'Campo recomendado! Insira seu nome');
	echo json_encode($retorno);
	exit();
endif;

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) :
	$retorno = array('status' => '0', 'mensagem' => 'Email incorreto! Insira um email válido');
	echo json_encode($retorno);
	exit();
endif;

$_row = $user->findEmail(array('email' => $email));
$qtd = count($_row);

if ($qtd >= '1') :
	$retorno = array('status' => '0', 'mensagem' => 'Email já existe, por favor insira outro');
	echo json_encode($retorno);
	exit();
endif;
if (empty($celular) && empty($telefone)) :
	$retorno = array('status' => '0', 'mensagem' => 'Informe pelo menos um telefone: celular ou fixo');
	echo json_encode($retorno);
	exit();
endif;

if (empty($senha) or strlen($senha) < 6) :
	$retorno = array('status' => '0', 'mensagem' => 'Senha deve possuir no mínimo 6 caracteres');
	echo json_encode($retorno);
	exit();
endif;
if (empty($conf_senha)) :
	$retorno = array('status' => '0', 'mensagem' => 'Confirme a senha');
	echo json_encode($retorno);
	exit();
endif;
if ($conf_senha != $senha) :
	$retorno = array('status' => '0', 'mensagem' => 'Senhas não coincidem. Informe a mesma senha');
	echo json_encode($retorno);
	exit();
endif;

if (empty($console) || !is_numeric($console)) :
	$retorno = array('status' => '0', 'mensagem' => 'Por favor informe um console');
	echo json_encode($retorno);
	exit();
endif;
$cep = $user::limpaCep($cep);

//criptografia da senha com BCRYPT
$custo = '08'; //ajuda no formação da senha única*/
$salto = 'Cf1f11ePArKlBJomM0F6aJ'; //garante que a senha não se repita
$senha = crypt($senha, '$2a$' . $custo . '$' . $salto . '$');

date_default_timezone_set('America/Sao_Paulo');
$logfirst = date('Y-m-d H:i:s');

//Setar valores na classe			
$user->setNome($nome);
$user->setEmail($email);
$user->setSenha($senha);
$user->setCelular($celular);
$user->setTelefone($telefone);
$user->setConsole($console);
$user->setCEP($cep);
$user->setRua($rua);
$user->setNumero($numero);
$user->setBairro($bairro);
$user->setCidade($cidade);
$user->setEstado($estado);
$user->setComplemento($complemento);
$user->setStatus('nao');
$user->setTipoUsuario((int)$tipo);
$user->setLogFirst(date('Y-m-d H:i'));
$user->setLogUsuario(null);
$sql = $user->insert();

//Se não cadastrar, mande uma mensagem de erro
if (!$sql) :
	$retorno = array('status' => '0', 'mensagem' => 'Ocorreu algum erro! Tente novamente mais tarde');
	echo json_encode($retorno);
	exit();
else :
	/***CONFIRMAÇÃO DE CADASTRO POR EMAIL***/
	//inicio da confirmação por email
	require 'PHPMailer/PHPMailerAutoload.php';

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
	$mailer->Host = 'smtp.live.com';
	$mailer->Port = 587;

	//nome do usuário do email
	$mailer->Username = 'rafael-hyuga@hotmail.com';
	$mailer->Password = '08597rafah@';

	//E-mail remetente
	$mailer->From = 'rafael-hyuga@hotmail.com';

	$mailer->FromName = 'Restart Games';

	//Assunto da mensagem
	$mailer->Subject = 'Boas-vindas à Restart Games';

	//Corpo da mensagem
	$mailer->Body = "
				<div style='margin: auto; padding: 0; border: 0; font-size: 0px; border: 1px solid #ccc; font: inherit; vertical-align: baseline; position: relative; width: 600px; background-repeat: no-repeat;'>
				<table style='margin: auto; padding: 0; border: 0; font-size: 100%; font: inherit; vertical-align: baseline; border-collapse: collapse; border-spacing: 0; width: 550px; text-align: center; font-family: 'Arial', 'Calibri'; color: #ffffff;'>
				<tr><th colspan='2'><h1 style='margin: 0;padding: 0; border: 0; font-size: 0px; font: inherit; vertical-align: baseline; font-weight: bold; font-size: 20px; color: #000000;  margin-top: 45px; '>Bem Vindo, $nome!</h1></th></tr>
				<tr><td colspan='2'><p style='margin: 0; padding: 0; border: 0; font-size: 0px; font: inherit; vertical-align: baseline; font-weight: normal; font-size: 1.3em; color: #000000; font-family: Calibri, Arial, sans-serif;'>Seu cadastro na <b style='color:#0074e1;'>Restart</b> <b>Games</b> foi efetuado com sucesso.</p></tr></td>
				<tr><td colspan='2' style='background-color: #000000;'><h2 style='margin: 0; padding: 5px; border: 0; font-size: 0px; font: inherit; vertical-align: baseline; font-weight: bold; font-size: 15px; color:#ffffff;'>Para ativar sua conta, click no link abaixo</h2></td></tr>
				<tr><td colspan='2' style='width:100%; text-align: center;'><br/><h2 style='margin: 0; padding: 0; border: 0; font-size: 0px; font: inherit; vertical-align: baseline; font-weight: bold; font-size: 30px; color: #000000;'><a href='http://www.restartgames.com.br/account_activation.php?email=$email&nome=$nome' style='color:#333; font-size:1em;' target='blink'>Ativar minha conta agora</a></h2><br/></td></tr></table>
				<h2 style='margin: 0; padding: 0; border: 0; font-size: 0px; font: inherit; vertical-align: baseline; font-weight: bold; font-size: 12px; color: #000000; text-align: center; font-family: 'Arial', 'Calibri'; display: block;'>ATENÇÃO: Esse email foi enviado para $email, <br/> pois o mesmo foi usado no cadastro da conta na Restart Games.<br>Se não é você ou você não fez esse cadastro, favor desconsiderar esse e-mail</h2>
				<table style='margin-top: 20px; color:#fff; background: #333; padding: 1%; border: 0; font-size: 100%; font: inherit; vertical-align: baseline; border-collapse: collapse; border-spacing: 0; width: 98%; text-align: center; font-family: 'Arial', 'Calibri'; color: #ffffff; display: block;'>
					<tr><th colspan='2' style='width: 200px;'><h1 style='margin: 0; padding: 0; border: 0; font-size: 0px; font: inherit; vertical-align: baseline; font-weight: bold; font-size: 20px;'>CONTATOS</h1></th></tr>
					<tr><td colspan='2'><h2 style='margin: 0; padding: 0; border: 0; font-size: 0px; font: inherit; vertical-align: baseline; font-weight: regular; font-size: 1em;'>contato@restartgames.com</h2></td></tr>
					<tr><td colspan='2'><h3 style='margin: 0; padding: 0; border: 0; font-size: 0px; font: inherit; vertical-align: baseline; font-weight: regular; font-size: .9em;'>SIGA-NOS NA REDES SOCIAIS</h3></td></tr>
					<tr><td colspan='2'>
					<a href='https://www.instagram.com/?hl=pt-br' style='margin: 0; padding: 0; border: 0; font-size: 0px; font: inherit; vertical-align: baseline; display: inline-block; float: right; margin-left: 8px; width: 20px; height: 20px; background-image: url('http://www.mirandataxi.com.br/icon-inst-email.png'); background-repeat: no-repeat;'></a>
					<a href='https://www.facebook.com/' style='margin: 0; padding: 0; border: 0; font-size: 0px; font: inherit; vertical-align: baseline; display: inline-block; float: right; width: 20px; height: 20px; background-image: url('http://www.mirandataxi.com.br/icon-face-email.png'); background-repeat: no-repeat;'></a></td></tr>
					<tr><td colspan='2'><h4 style='margin: 0; padding: 0; border: 0; font-size: 0px; font: inherit; vertical-align: baseline; font-weight: regular; font-size: .8em;'>© RestartGames. All rights reserved.</h4></td></tr>
				</table>
			</div>
			";

	//Destinatário
	$mailer->addAddress($email);

	
	if ($mailer->Send()) {
		session_start();
		
		/**
		 * BOAS-VINDAS
		*/
		$lastinserted = (int)$sql;//garantir que valor seja inteiro
		$notice->setTitulo("Bem vindo à Restast Games");
		$notice->setTipo("info");
		$notice->setMensagem("Seja bem-vindo jogador! Aproveite o máximo da Restart Games. Essa plataforma foi feita para você");
		$notice->setReceptor($lastinserted);
		$notice->setLido("nao");
		$notice->setDataalert(date('Y-m-d H:i:s'));
		$notice->insertNotificacao();

		$_SESSION['novo_usuario'] = $nome;
		$_SESSION['novo_email'] = $email;
		$retorno = array('status' => '1', 'mensagem' => '');
		echo json_encode($retorno);
	} else {
		$retorno = array('status' => '0', 'mensagem' => 'Houve um erro ao efetuar o cadastro');
		echo json_encode($retorno);
	}
endif;

