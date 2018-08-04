<?php
function __autoload($classe){
    require('../classes/'.$classe.'.class.php');
}
@BD::conn();//conexão com o banco de dados	

$message = new Mensagens();
$user = new Usuarios();

session_start();

 	$para = 13;

	$idFrom = $_SESSION['id_user'];
	
	$message->setCodFrom($idFrom);
	$message->setCodTo($para);
	$qtd = $message->countMessageRead('nao');


	echo $qtd;

	/*$message->setCodFrom($idFrom);
	$message->setCodTo($para);

	$dados_user = $user->findRegister();

    foreach ($dados_user as $data) {
    	$nome = $data->nomeUser;
    }
	
	$allMessage = $message->showMessage();
	$mensagens = '';

	foreach ($allMessage as $msg) {
		if($msg->cod_from == $idFrom){
			$mensagens .= '<div class="msg-from msgs"><span class="name-from">Você</span> : '.$msg->mensagem.'</div>';
		}else{
			$mensagens .= '<div class="msg-to msgs"><span class="name-from">Outro</span> : '.$msg->mensagem.'</div>';			
		}		 
	}
	echo $mensagens;*/