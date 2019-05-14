<?php
spl_autoload_register(function($classe) {
    require('../classes/'.$classe.'.class.php');
});
@BD::conn();//conexão com o banco de dados	

$message = new Mensagens();
$user = new Usuarios();

session_start();

$acao = $_POST['acao'];

switch ($acao) {
	case 'get':
		$para = ($_POST['para']) ? $_POST['para'] : '';

		$idFrom = $_SESSION['id_user'];
		$message->setCodFrom($idFrom);
		$message->setCodTo($para);
		
		$mensagens = '';

		$allMessage = $message->showMessage();
		foreach ($allMessage as $msg) {
				
			if($msg->cod_from == $idFrom){
				$mensagens .= '<div class="msg-from msgs"><p>'.$msg->mensagem.'</p></div>';
			}else{
				$mensagens .= '<div class="msg-to msgs"><p>'.$msg->mensagem.'</p></div>';			
			}
		}			
		echo $mensagens;

	break;
	case 'inserir':
		$idFrom = $_SESSION['id_user'];
		$idTo = (isset($_POST['para']) ? $_POST['para'] : '');
	    $mensagem = strip_tags($_POST['mensagem']);

		if(strlen($mensagem) <= 0){
			echo '<div class="msg-erro">Mensagem não enviada</div>';
			break;
		}

		//verificar se os usuários já são amigos
		$friend = new Friendships();
		$row = Friendships::getFriendsHelper(array('who_sent'=>$idFrom, 'who_accepted'=>$idTo));
		
		if(count($row) == 0){
			$friend->setWhoSent($idFrom);
			$friend->setWhoAccepted($idTo);
			$friend->setStatus("Pendente");
			$friend->setDataAtivacao(null);
			$friend->setExcluido("nao");
			$friend->insert();
		}

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
					$mensagens .= '<div class="msg-from msgs"><p>'.$msg->mensagem.'</p></div>';
				}else{
					$mensagens .= '<div class="msg-to msgs"><p>'.$msg->mensagem.'</p></div>';			
				}
			}
			$new = json_encode($mensagens, $qtd);
			echo $new;
	    }else{
	    	echo json_encode('');
	    }
	break;
	case 'leitura':
		$para = (isset($_POST['para'])) ? $_POST['para'] : '';

	    if(!empty($para)){
	    	$idFrom = $_SESSION['id_user'];
	    	$message->setCodFrom($idFrom);
	    	$message->setCodTo($para);

	    	if($message->updateMessageRead()){
				$array = array('status'=>'1');
				echo json_encode($array);	
	    	}
	    }else{
			$array = array('status'=>'0');
			echo json_encode($array);
		}	    
	break;
	case 'excluir':
		$para = (isset($_POST['para'])) ? $_POST['para'] : '';
		$de = (isset($_POST['de'])) ? $_POST['de'] : '';

		if($para > 0 AND $de > 0){
			$message->setCodFrom($de);
			$message->setCodTo($para);
			
			if($message->deleteMessage()){
				$array = array('status'=>'1');
				echo json_encode($array);
			}else{
				$array = array('status'=>'0', 'mensagem'=>'Não foi possível excluir as mensagens');
				echo json_encode($array);
			}
		}
	break;
}