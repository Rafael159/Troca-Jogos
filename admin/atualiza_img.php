<?php
	function __autoload($classe){
		require ('..\classes/'.$classe.'.class.php');
	}
	$imagem  = new Imagens;

	$id = $_POST['id'];
	$jogo = $_POST['jogo'];
				
	$imagem->setNome($jogo);
	$imagem->setIdImagem($id);
	
	if($imagem->update($id)){
		echo json_encode(array('status'=>'sucesso'));
	}else{
		echo json_encode(array('status'=>'erro'));		
	}
?>