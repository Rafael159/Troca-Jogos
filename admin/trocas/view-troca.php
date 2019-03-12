<?php
	function __autoload($classe){
		require ('../../classes/'.$classe.'.class.php');
	}
	session_start();

	$troca = new Trocas();
	$jogo = new Jogos();
	$user = new Usuarios();

	//$user_id = (isset($_SESSION['id_user'])) ? $_SESSION['id_user'] : '';
	$idTroca = (isset($_POST['idTroca'])) ? $_POST['idTroca'] : '';
	
	//se não tiver valores retornar um erro
	if(empty($idTroca)):
		$retorno = array('status'=> '0','mensagem'=>'Desculpe, ocorreu algum erro. Tente novamente mais tarde!');
		echo json_encode($retorno);
		exit;
	endif;

	$troca->setId($idTroca);
	//$troca->setByUser($user_id);

	$dados = $troca->showByID();
	
	//pegar ID da outra pessoa
	foreach ($dados as $chave => $dt) {
		$other_user_id = (($dt->idUm != $dt->by_user) ? $dt->idUm : $dt->idDois);
	}
	$user->setIdUser($other_user_id);
	$usuario = $user->findRegister();//dados usuario
	
	//pegar informações do jogo pretendido
	//@codigo - recebe o id do jogo dois
	foreach ($dados as $key => $value) {
		$codigo = $value->jogodois;
	}
	$jogo->setID($codigo);
	$game = $jogo->listaJogoById();//dados jogo

	if(empty($dados) || empty($usuario) || empty($game)):
		$retorno = array('status'=> '0','mensagem'=>'Desculpe, ocorreu algum erro. Tente novamente mais tarde!');
		echo json_encode($retorno);
		exit;
	endif;

	$retorno = array('status'=>'1', 'dados_troca'=> $dados, 'dados_jogo'=> $game, 'dados_user'=>$usuario);
	echo json_encode($retorno);
?>