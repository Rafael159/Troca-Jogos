<?php
	spl_autoload_register(function($classe) {
		require ('..\classes/'.$classe.'.class.php');
	});
	
	$jogo  = new Jogos();

	$id = (isset($_POST['id'])? $_POST['id'] : "");
	$retorno = array();
	
	$jogo->setID($id);
	if($jogo->delete()){
		$retorno = array('status'=>'1', 'mensagem'=>'Jogo excluído com sucesso!');
		echo json_encode($retorno);
	}else{
		$retorno = array('status'=>'0', 'mensagem'=>'Falha ao deletar o jogo');
		echo json_encode($retorno);
		exit();
	}
?>