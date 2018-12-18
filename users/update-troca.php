<?php
	function __autoload($classe){
        require('..\classes/'.$classe.'.class.php');
	}
	
	date_default_timezone_set('America/Sao_Paulo');

    $trocas = new Trocas();
    $idtroca = (isset($_POST['idtroca']) ? $_POST['idtroca'] : '');//ID da troca
    $tipo = (isset($_POST['type']) ? $_POST['type'] : '');//tipo da troca

    $retorno = array();
    if(empty($idtroca) || empty($tipo)){
    	$retorno = array('status'=>'0', 'mensagem'=>':( Ocorreu um erro. Tente novamente!');
    	echo json_encode($retorno);
    	exit;
    }else{
		$troca = $trocas->getTrocas(array('id'=>$idtroca));
		echo json_encode($troca);
		die();
    	$trocas->setId($idtroca);
    	$trocas->setStatus($tipo);
    	$trocas->setlogData(date("Y-m-d H:i:s"));

    	if($trocas->changeStatus()){
    		$retorno = array('status'=>'1', 'obj'=>$troca);
    		echo json_encode($retorno);
    	}
    }
