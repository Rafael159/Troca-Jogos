<?php

function __autoload($classe){
	require '..\classes/'.$classe.'.class.php';
}
//recebe o id da troca
$cod = (isset($_POST['codigo'])? $_POST['codigo'] : '');

//instancia classe
$troca = new Trocas();
$troca->setId($cod);//seta valor do id

$retorno = array();

if(!$troca->deleteTroca()):
	$retorno = array('status'=>'0', 'mensagem'=>'Falha ao excluir essa troca. Tente novamente!');
	echo json_encode($retorno);
	exit();
else:
	$retorno = array('status'=>'1', 'mensagem'=>'Troca excluída com sucesso');
	echo json_encode($retorno);
endif;