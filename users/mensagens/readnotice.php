<?php
    spl_autoload_register(function($classe) {
        require(dirname(dirname(dirname(__FILE__))).'/classes/'.$classe.'.class.php');
    });
    $notes = new Notificacoes();

    $idnote = $_POST['idnote'];
    
    $notes->setID($idnote);
    $notes->setLido('sim');

    $retorno = array();

    if($notes->updateNotificacaoRead()){
        $retorno = array('status'=>'1', 'mensagem'=>'Notificação lida');
    	echo json_encode($retorno);
    }else{
        $retorno = array('status'=>'0', 'mensagem'=>'Falha ao ler notificação');
    	echo json_encode($retorno);
    }

?>