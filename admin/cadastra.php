<?php
	header("Content-type: text/html;charset=utf-8");
	function __autoload($classe){
		require ('..\classes/'.$classe.'.class.php');
	}
	
	$img = new Imagens();
	
	//recebe os dados
	$id = $_POST['idConso']; //id do console
	$nome = $_POST['nome']; //nome do jogo que a imagem pertence
	$imagem = $_POST['imagem']; //nome da imagem

	$img->setIdConsole($id);
	$img->setNome($nome);
	$img->setImagem($imagem);

	if(!$img->insert()){
		echo "Ocorreu um erro! Tente mais tarde";
	}else{}
?>