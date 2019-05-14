<?php
spl_autoload_register(function($classe) {
    require('../classes/'.$classe.'.class.php');
});
@BD::conn();//conexão com o banco de dados	

$message = new Mensagens();
$user = new Usuarios();

session_start();

$mensagem = 'Bom dia';
$idfrom = '22';
$idto = '10';


$idto = ($idto) ? $idto : $_SESSION["id_user"];

$message->setCodFrom($idfrom);
$message->setCodTo($idto);
$message->setMensagem($mensagem);

if($message->insertMessage()){
	echo 'Sucesso';
}else{
	echo 'Falha';
}
