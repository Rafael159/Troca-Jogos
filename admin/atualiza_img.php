<?php
	function __autoload($classe){
		require ('..\classes/'.$classe.'.class.php');
	}
	$imagem  = new Imagens;

	$id = $_POST['id'];
	$jogo = $_POST['jogo'];
				
	$imagem->setNome($jogo);
	
	if($imagem->update($id)){
		
	}else{
		echo "Não foi possível atualizar imagem";		
	}
?>