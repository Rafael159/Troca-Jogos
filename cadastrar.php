<?php
	function __autoload($classe){
        require('classes/'.$classe.'.class.php');
    }
	$user = new Usuarios();	
	
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
	$cidade = (isset($_POST['cidade'])) ? trim($_POST['cidade']) : '';
	$estado = (isset($_POST['estado'])) ? trim($_POST['estado']) : '';
	$complemento = (isset($_POST['complemento'])) ? trim($_POST['complemento']) : '';	
	$tipo = (isset($_POST['tipousuario'])) ? $_POST['tipousuario'] : 0;
	//$mail = @BD::conn()->prepare('SELECT * FROM `usuarios` WHERE emailTJ = ? ');
	//$mail->execute(array($email));	

	$retorno = array();

	if(empty($nome)):
		$retorno = array('status'=>'0', 'mensagem'=>'Campo recomendado! Insira seu nome');
		echo json_encode($retorno);
		exit();
	endif;

	if(!filter_var($email, FILTER_VALIDATE_EMAIL)):
		$retorno = array('status'=>'0', 'mensagem'=>'Email incorreto! Insira um email válido');
		echo json_encode($retorno);
		exit();
	endif;

	$_row = $user->findEmail(array('email'=>$email));
	$qtd = count($_row);

	if($qtd >= '1'):
		$retorno = array('status'=>'0', 'mensagem'=>'Email já existe, por favor insira outro');
		echo json_encode($retorno);
		exit();		
	endif;
	if(empty($celular) && empty($telefone)):
		$retorno = array('status'=>'0', 'mensagem'=>'Informe pelo menos um telefone: celular ou fixo');
		echo json_encode($retorno);
		exit();
	endif;

	if(empty($senha) or strlen($senha) < 6):
		$retorno = array('status'=>'0', 'mensagem'=>'Senha deve possuir no mínimo 6 caracteres');
		echo json_encode($retorno);
		exit();
	endif;
	if(empty($conf_senha)): 
		$retorno = array('status'=>'0', 'mensagem'=>'Confirme a senha');
		echo json_encode($retorno);
		exit();
	endif;
	if($conf_senha != $senha): 
		$retorno = array('status'=>'0', 'mensagem'=>'Senha não coincidem. Informe a mesma senha');
		echo json_encode($retorno);
		exit();
	endif;

	if(empty($console) || !is_numeric($console)):
		$retorno = array('status'=>'0', 'mensagem'=>'Por favor informe um console');
		echo json_encode($retorno);
		exit();
	endif;
		$cep = $user::limpaCep($cep);
		
		//criptografia da senha com BCRYPT
		$custo = '08';//ajuda no formação da senha única*/
		$salto = 'Cf1f11ePArKlBJomM0F6aJ';//garante que a senha não se repita
		$senha = crypt($senha, '$2a$' . $custo . '$' . $salto . '$');
		
		date_default_timezone_set('America/Sao_Paulo');
		$logfirst = date('Y-m-d H:i:s');
		
		/*CONFIRMAÇÃO DE CADASTRO
		 *NECESSÁRIO ENVIO POR EMAIL
		 *QUANDO ESTIVER HOSPEDADO NECESSÁRIO TERMINAR 
		 */

		/*
			$ConexaoEmail = mysql_query("SELECT * FROM cadastro WHERE nome = '$nome'");
			$array = mysql_fetch_array($ConexaoEmail);
			$id = $array['id'];

			/*Envia email para confirmação de cadastro
			$assunto = "Confirmar cadastro";
			$mensagem = "Confirmar cadastro através desse link, http://trocaJogos/index.php?id=".$id;
			$headers = "rafael-hyuga@hotmail.com";

			mail($email, $assunto, $mensagem, $headers);*/
				
		$user->setNome($nome);
		$user->setEmail($email);
		$user->setSenha($senha);
		$user->setCelular($celular);
		$user->setTelefone($telefone);
		$user->setConsole($console);
		$user->setCEP($cep);
		$user->setRua($rua);
		$user->setNumero($numero);
		$user->setCidade($cidade);
		$user->setEstado($estado);
		$user->setComplemento($complemento);
		$user->setStatus('sim');
		$user->setTipoUsuario((int)$tipo);
		$user->setLogFirst(date('Y-m-d H:i'));
		$user->setLogUsuario('');
		
		
		if(!$user->insert()):
			$retorno = array('status'=>'0', 'mensagem'=>'Ocorreu algum erro! Tente novamente mais tarde');
			echo json_encode($retorno);
			exit();
		else:
			session_start();
			$_SESSION['novo_usuario'] = $nome;
			$_SESSION['novo_email'] = $email;
			$retorno = array('status'=>'1', 'mensagem'=>'');
			echo json_encode($retorno);
		endif;