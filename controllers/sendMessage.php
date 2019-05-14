<?php
spl_autoload_register(function($classe) {
    require('../classes/'.$classe.'.class.php');
});
@BD::conn();//conexão com o banco de dados	

    $message = new Mensagens();
    $user = new Usuarios();

    //session_start();
    $mensagem = ($_POST['mensagem']) ? $_POST['mensagem'] : '';
    $idfrom = Usuarios::getUsuario('id_user');
    $idto = ($_POST['idto']) ? $_POST['idto'] : '';

    $message->setMensagem($mensagem);
    $message->setCodFrom($idfrom);
    $message->setCodTo($idto);

if($message->insertMessage()){
   echo json_encode('OK');
}else{
    echo json_encode('FALHA');
}


