<?php
	header("Content-type: text/html;charset=utf-8");
	spl_autoload_register(function($classe) {
		require ('..\classes/'.$classe.'.class.php');
	});
	// DEFINE O FUSO HORARIO COMO O HORARIO DE BRASILIA
	date_default_timezone_set('America/Sao_Paulo');
	
	$img = new Imagens();
	
	//recebe os dados
	$id = $_POST['idConso']; //id do console
	$nome = $_POST['nome']; //nome do jogo que a imagem pertence
	$imagem = $_POST['imagem']; //nome da imagem

	$img->setIdConsole($id);
	$img->setNome($nome);
	$img->setImagem($imagem);
	$img->setDatacriacao(date("Y:m:d H:i:s"));

	if(!$img->insert()){
		echo "Ocorreu um erro! Tente mais tarde";
	}else{}
?>