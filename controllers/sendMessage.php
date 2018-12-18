<?php
function __autoload($classe){
    require('../classes/'.$classe.'.class.php');
}
@BD::conn();//conexão com o banco de dados	

$message = new Mensagens();
$user = new Usuarios();

session_start();

$mensagem = ($_POST['mensagem']) ? $_POST['mensagem'] : '';
$idfrom = ($_POST['idfrom']) ? $_POST['idfrom'] : '';
$idto = $_SESSION["id_user"];

$message->setMensagem($mensagem);
$message->setCodFrom($idfrom);
$message->setCodTo($idto);

if($message->insertMessage()){
   return true;
}else{
    return false;
}


