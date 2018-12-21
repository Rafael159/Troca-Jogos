<?php
function __autoload($classe){
	require('../classes/'.$classe.'.class.php'); /*chama a classe automaticamente*/
}
	//session_start();
	// unset($_SESSION['usuario']['senha']);
	// echo '<pre>';
	// print_r($_SESSION['usuario']);

	$iduser = Usuarios::getUsuario('id_user');
	print_r($iduser);
?>