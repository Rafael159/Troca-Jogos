<?php
	function __autoload($classe){
        require('..\classes/'.$classe.'.class.php');
    }
    $trocas = new Trocas();
    $idtroca = (isset($_POST['idtroca']) ? $_POST['idtroca'] : '');//ID da troca
    $tipo = (isset($_POST['type']) ? $_POST['type'] : '');//tipo da troca

    $retorno = array();
    if(empty($idtroca) || empty($tipo)){
    	$retorno = array('status'=>'0', 'mensagem'=>':( Ocorreu um erro. Tente novamente!');
    	echo json_encode($retorno);
    	exit;
    }else{
    	$trocas->setId($idtroca);
    	$trocas->setStatus($tipo);

    	if($trocas->changeStatus()){
    		$retorno = array('status'=>'1', 'mensagem'=>'');
    		echo json_encode($retorno);
    	}
    }
