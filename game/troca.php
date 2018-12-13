<?php
	date_default_timezone_set('America/Sao_Paulo');
	function __autoload($classe){
		require ('..\classes/'.$classe.'.class.php');
	}
	$troca = new Trocas();//chama a classe Troca
	$jogos = new Jogos();
	
	$retorno = array();

	$codUm = (isset($_POST['idUserUm'])) ? $_POST['idUserUm'] : '';	
	$idJogo = (isset($_POST['idJogo'])) ? $_POST['idJogo'] : '';
	$idTroca = (isset($_POST['idTroca'])) ? $_POST['idTroca'] : '';
	$tipoTroca = (isset($_POST['optradio'])) ? $_POST['optradio'] : '';
	$valor = (isset($_POST['valor'])) ? $_POST['valor'] : '';
	$mensagem = (isset($_POST['mensagem']) && $_POST['mensagem'] != '') ? $_POST['mensagem'] : '';

	if(empty($codUm)){
		$retorno = array('status'=>'0', 'mensagem'=>'Escolha o jogo que desejar ter');
		echo json_encode($retorno);
		exit;
	}
	if(empty($idJogo)){
		$retorno = array('status'=>'0', 'mensagem'=>'Escolha o jogo que desejar ter');
		echo json_encode($retorno);
		exit;
	}

	if(empty($idTroca)){
		$retorno = array('status'=>'0', 'mensagem'=>'Escolha o seu jogo para trocar');
		echo json_encode($retorno);
		exit;
	}
	
	if($tipoTroca=='0' || $tipoTroca=='2'){
		if(empty($valor)){
			$retorno = array('status'=>'0', 'mensagem'=>'Insira o valor da troca');
			echo json_encode($retorno);
			exit;
		}
	}
	$jogos->setID($idTroca);
	foreach ($jogos->listaJogoById() as $indice => $dados) {
		$codDois = $dados->id_user;
	} 
	
	//setar campos
	$troca->setIdUserUm($codUm);
	$troca->setIdUserDois($codDois);
	$troca->setJogoUm($idJogo);
	$troca->setJogoDois($idTroca);
	$troca->setTipoTroca($tipoTroca);
	$troca->setValor($valor);
	$troca->setMensagem($mensagem);
	$troca->setStatus("Pendente");
	$troca->setByUser($codDois);//quem requisita é quem está logado
	$troca->setlogCriacao(date("Y-m-d H:i:s"));
	$troca->setlogData(date("Y-m-d H:i:s"));

	//GRAVAR DADOS
	if(!$troca->insert()){
		$retorno = array('status'=>'0', 'mensagem'=>'Ocorreu algum erro ao cadastrar a troca');
		echo json_encode($retorno);
		exit;
	}else{
		$retorno = array('status'=>'1', 'mensagem'=>'Troca cadastrada com sucesso!');
		echo json_encode($retorno);
	}

?>