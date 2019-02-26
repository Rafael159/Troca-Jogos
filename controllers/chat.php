<?php
function __autoload($classe){
    require('../classes/'.$classe.'.class.php');
}
@BD::conn();//conexão com o banco de dados	

$message = new Mensagens();
$user = new Usuarios();

session_start();

$acao = $_POST['acao'];
$para = ($_POST['para']) ? $_POST['para'] : '';

switch ($acao) {
	case 'get':
		$idFrom = $_SESSION['id_user'];
		$message->setCodFrom($idFrom);
		$message->setCodTo($para);
		
		$mensagens = '';

		$allMessage = $message->showMessage();
		foreach ($allMessage as $msg) {
				
			if($msg->cod_from == $idFrom){
				$mensagens .= '<div class="msg-from msgs">'.$msg->mensagem.'</div>';
			}else{
				$mensagens .= '<div class="msg-to msgs">'.$msg->mensagem.'</div>';			
			}
		}			
		echo $mensagens;

	break;
	case 'inserir':
		$idFrom = $_SESSION['id_user'];
		$idTo = (isset($_POST['para']) ? $_POST['para'] : '');
	    $mensagem = strip_tags($_POST['mensagem']);

	    $message->setCodFrom($idFrom);
		$message->setCodTo($idTo);
		$message->setMensagem($mensagem);

		if($message->insertMessage()){
			echo '<div class="msg-from msgs">'.$mensagem.'</div>';
		}else{
			echo '<div class="msg-erro">Mensagem não enviada</div>';
		}
		break;
	case 'atualizar':
	
	    $para = (isset($_POST['idPara'])) ? $_POST['idPara'] : '';
	    if(!empty($para)){
	    	$idFrom = $_SESSION['id_user'];
	    	$message->setCodFrom($idFrom);
	    	$message->setCodTo($para);
	    	
	    	$allMessage = $message->showMessage();
			$mensagens = '';

			$qtd = $message->countMessageRead('nao');

			foreach ($allMessage as $msg) {
				
				if($msg->cod_from == $idFrom){
					$mensagens .= '<div class="msg-from msgs">'.$msg->mensagem.'</div>';
				}else{
					$mensagens .= '<div class="msg-to msgs">'.$msg->mensagem.'</div>';			
				}
			}			
			$new = json_encode($mensagens, $qtd);
			echo $new;
	    }else{
	    	echo '';
	    }
	break;
	case 'leitura':		
		$para = (isset($_POST['idPara'])) ? $_POST['idPara'] : '';
	    if(!empty($para)){
	    	$idFrom = $_SESSION['id_user'];
	    	$message->setCodFrom($idFrom);
	    	$message->setCodTo($para);

	    	if($message->updateMessageRead()){
				$array = array('status'=>'1');
				echo json_encode($array);	    		
	    	}
	    }
	    
	break;
}