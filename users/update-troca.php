<?php
	function __autoload($classe){
        require('..\classes/'.$classe.'.class.php');
	}
	
	date_default_timezone_set('America/Sao_Paulo');

	$trocas = new Trocas();
	$jogos = new Jogos();
	$notice = new Notificacoes();

    $idtroca = (isset($_POST['idtroca']) ? $_POST['idtroca'] : '');//ID da troca
    $tipo = (isset($_POST['type']) ? $_POST['type'] : '');//tipo da troca

	$retorno = array();	

    if(empty($idtroca) || empty($tipo)){
    	$retorno = array('status'=>'0', 'mensagem'=>':( Ocorreu um erro. Tente novamente!');
    	echo json_encode($retorno);
    	exit;
    }else{
		$troca = $trocas->getTrocas(array('id'=>$idtroca));
		$troca = $troca[0];		
    	$trocas->setId($idtroca);
    	$trocas->setStatus($tipo);
    	$trocas->setlogData(date("Y-m-d H:i:s"));
	
    	if($trocas->changeStatus()){
			$dados = (object)$troca;
			
			if($tipo == 'Finalizada'){
				//quem receberá notificação
				$notice->setReceptor($dados->idUm);
			}
			if($tipo == 'Recusado'){
				//quem receberá notificação
				$notice->setReceptor($dados->idDois);
			}
			if($tipo == 'Aceito'){
												
				$jogos->changeStatus($dados->jogoum, 'Inativo');
				$jogos->changeStatus($dados->jogodois, 'Inativo');
				
				$trocas->changeStatusInGroup(array("id"=>$dados->jogoum, "oldStatus"=>"Pendente", "newStatus"=>"Recusado", "logdata"=>date("Y-m-d H:i:s")));
				$trocas->changeStatusInGroup(array("id"=>$dados->jogodois, "oldStatus"=>"Pendente", "newStatus"=>"Recusado", "logdata"=>date("Y-m-d H:i:s")));
				
				//quem receberá notificação
				$notice->setReceptor($dados->idDois);
			}
			if($tipo == 'Cancelada'){
				
				$jogos->changeStatus($dados->jogoum, 'Ativo');
				$jogos->changeStatus($dados->jogodois, 'Ativo');

				//notificação para
				$notice->setReceptor($dados->idUm);
			}

			//mandar notificação sobre o status da troca
			$notice->setTitulo("Atualização da troca");
			$notice->setTipo("info");
			$notice->setMensagem("Uma de troca suas trocas foi atualizada para o status: $tipo");			
			$notice->setLido("nao");
			$notice->setDataalert(date('Y-m-d H:i:s'));
			$notice->insertNotificacao();

    		$retorno = array('status'=>'1', 'obj'=>$troca);
    		echo json_encode($retorno);
    	}
    }
