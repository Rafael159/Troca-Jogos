<?php
	spl_autoload_register(function($classe) {
		require(dirname(dirname(__FILE__)).'/classes/'.$classe.'.class.php');
	});
	$imagem  = new Imagens;

	$id = $_POST['id'];
	$jogo = $_POST['jogo'];
	
	$imagem->setNome($jogo);
	$imagem->setIdImagem($id);
	
	if($imagem->update()){
		echo json_encode(array('status'=>'sucesso'));
	}else{
		echo json_encode(array('status'=>'erro'));		
	}
?>