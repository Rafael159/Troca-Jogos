<?php
function __autoload($classe){
	require('../classes/'.$classe.'.class.php'); /*chama a classe automaticamente*/
}
$user = new Usuarios();

/*Get email e senha*/
$email = (isset($_POST['email'])) ? trim($_POST['email']) : '';
$senha = (isset($_POST['senha'])) ? trim($_POST['senha']) : '';

$tipo = (isset($_POST['tipo'])) ? $_POST['tipo'] : '';

$retorno = array();

if(empty($email)):
	$retorno = array('status'=>'0', 'mensagem'=>'Informe um email válido');
	echo json_encode($retorno);
	exit();
endif;

if($tipo && $tipo=='recuperar'){
	$queries = array();

	if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		$retorno = array('status'=>'0', 'mensagem'=>'Por favor informe um e-mail válido');
		echo json_encode($retorno);
		exit();
	}

	$queries['email'] = strip_tags(trim($email));

	$row = $user->findEmail($queries);

	if(sizeof($row)==0){
		$retorno = array('status'=>'0', 'mensagem'=>'E-mail informado não encontrado. Informe o e-mail usado no cadastro');
		echo json_encode($retorno);
		exit();
	}else{
		$retorno = array('status'=>'1', 'mensagem'=> $email);
		echo json_encode($retorno);			
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
	
	$dados = $user->loginUser();//tentar logar
	
	/*SE RETORNAR O USER*/
	if($dados):
		session_start();
		//definir sessões
		$_SESSION['id_user'] = $dados->id_user;
		$_SESSION['emailTJ'] = $dados->emailTJ;
		$_SESSION['nomeTJ']  = $dados->nomeUser;				
		$_SESSION['status']  = $dados->tipousuario;

		$retorno = array('status'=>'1', 'mensagem'=>'Logado com sucesso', 'nivel'=>$dados->tipousuario);
		echo json_encode($retorno);
	else:
		$retorno = array('status'=>'0', 'mensagem'=>'Falha ao logar! Verifique seu email e/ou senha');
		echo json_encode($retorno);
		exit();
	endif;
}



?>