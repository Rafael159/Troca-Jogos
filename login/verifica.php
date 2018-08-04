<?php
function __autoload($classe){
	require('../classes/'.$classe.'.class.php'); /*chama a classe automaticamente*/
}
$user = new Usuarios();

/*Get email e senha*/
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$senha = isset($_POST['senha']) ? trim($_POST['senha']) : '';

$retorno = array();

if(empty($email) || empty($senha)){
	$retorno = array('status'=>'0', 'mensagem'=>'Preencher email e senha');
	echo json_encode($retorno);
	exit();
}else{

	$custo = '08';//ajuda no formação da senha única*/
	$salto = 'Cf1f11ePArKlBJomM0F6aJ';//garante que a senha não se repita
	$senha = crypt($senha, '$2a$' . $custo . '$' . $salto . '$');//criar senha com suas variáveis estáveis

	$user->setEmail($email);//setar email
    $user->setSenha($senha);//setar senha
	
	$dados = $user->loginUser();//tentar logar
	
	/*SE RETORNAR O USER*/
	if($dados){ 
		session_start();
		//definir sessões
		$_SESSION['id_user'] = $dados->id_user;
		$_SESSION['emailTJ'] = $dados->emailTJ;
		$_SESSION['nomeTJ']  = $dados->nomeUser;				
		$_SESSION['status']  = $dados->status;

		$retorno = array('status'=>'1', 'mensagem'=>'Logado com sucesso', 'nivel'=>$dados->status);
		echo json_encode($retorno);
	}else{
		$retorno = array('status'=>'0', 'mensagem'=>'Falha ao logar! Verifique seu email e/ou senha');
		echo json_encode($retorno);
		exit();
	}
}
?>