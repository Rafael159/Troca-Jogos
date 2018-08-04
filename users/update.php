<?php
	function __autoload($classe){
		require ('..\classes/'.$classe.'.class.php');
	}
	session_start();

	$jogo = new Jogos();//chamada da CLASSE JOGOS
	$console = new Consoles();//classe CONSOLES
	$user = new Usuarios();//chamada da CLASSE USUÁRIOS
	$image = new Imagens();
	$jogocategoria = new JogoCategoria();

	//recebendo os valores vindo do form
	$id_gamer = (isset($_SESSION['id_user']) ? $_SESSION['id_user'] : "");
	$cod_jogo = (isset($_POST['idJogo']) ? $_POST['idJogo'] : "");
	//$console_id = (isset($_POST['console']) ? $_POST['console'] : "");//id do console
	$nome_jogo = (isset($_POST['nomeJogo']) ? trim($_POST['nomeJogo']) : "");//nome do jogo
	$img_id  = (isset($_POST['img_update']) ? $_POST['img_update'] : "");//id da imagem
	$genero  = (isset($_POST['upgenero']) ? $_POST['upgenero'] : "");//array com os gêneros do jogo
	$descricao = (isset($_POST['descricaoJogo']) ? trim($_POST['descricaoJogo']) : ""); //descrição do jogo
	$infoExtra = (isset($_POST['infoJogo']) ? trim($_POST['infoJogo']) : "");//opcional - informação extra

	$retorno = array();//retornará o status e mensagem

	/*if(!$console_id):
		$retorno = array('flag'=>'0', 'mensagem'=>'Selecione o console');
		echo json_encode($retorno);
		exit();
	endif;//fim valida console*/
	
	if(!$nome_jogo):
		$retorno = array('flag'=>'0', 'mensagem'=>'Insira o nome do jogo');
		echo json_encode($retorno);
		exit();
	endif;//fim valida nome do jogo

	if(empty($genero)){
		$retorno = array('flag'=>'0', 'mensagem'=>'Selecione o(s) gênero(s) do jogo');
		echo json_encode($retorno);
		exit();
	}

	if(!$descricao):
		$retorno = array('flag'=>'0', 'mensagem'=>'Insira uma breve descrição do seu jogo');
		echo json_encode($retorno);
		exit();
	endif;


	/*if(empty($img_id)):
		if($_FILES['imagem']['error'] == 4){
			$retorno = array('status'=>'0', 'mensagem'=>'Selecione uma imagem ou faça o upload');
			echo json_encode($retorno);
			exit();
		}
	endif;//fim valida campo imagem*/	
			
	//SETAR TODOS OS CAMPOS
	$jogo->setID($cod_jogo);//id do jogo
	$jogo->setIdGamer($id_gamer);//id user
	//$jogo->setIdCons($console_id);//id do console	
	$jogo->setNome($nome_jogo);//nome do jogo
	$jogo->setImagem($img_id);//id imagem
	//$jogo->setJogoT($jogoDesejado);
	//$jogo->setIdJogoT($idJogoDesejado);
	//$jogo->setData(date('dd/mm/YY'));		
	$jogo->setDescricao($descricao);
	$jogo->setInfoExtra($infoExtra);

	//armazena se houver erros
	$error = false;//começa sem erro
	
	$back = $jogo->update();//ATUALIZAR O JOGO
	
	if(!$back){
		$error = true;//tem erro
	}

	/*atualizar os gêneros do jogo*/
	$jogocategoria->setJogoID($cod_jogo);//setar ID do jogo
	$checkboxgenero = $jogocategoria->findAllByID();//array com gêneros do jogo selecionado

	$all_checks = array();
	foreach ($checkboxgenero as $value){
		array_push($all_checks, $value->categoria_id); //isolar os ID's dos gêneros vindos do banco
	}
	$num = count($all_checks);//contar todos os gêneros

	/*excluir gêneros desmarcados*/
	for($i=0; $i<$num; $i++) {
		
		if(!in_array((int)$all_checks[$i], $genero)){
		  	$jogocategoria->setJogoID($cod_jogo);//setar código do jogo
			$jogocategoria->setCategoriaID($all_checks[$i]);//setar a categoria 

			$jogocategoria->delete();//método que deleta o gênero				
		}			
	}

	/*adicionar novos gêneros, caso tenha*/
	$qtnGenero = count($genero);
	for($i=0; $i<$qtnGenero; $i++){
		$jogocategoria->setJogoID($cod_jogo);
		$jogocategoria->setCategoriaID((int)$genero[$i]);

		$rst = $jogocategoria->findByGameGenre();//busca gênero no banco
		/*se não existir, insira*/			
		if($rst == 0){
			$jogocategoria->insert();
		}
	}
	/*VERIFICA SE HOUVE ERRO*/			
	if($error==false){	
		$retorno = array('status'=>'1', 'mensagem'=>'Jogo atualizado com sucesso!');
		echo json_encode($retorno);
	}else{
		$retorno = array('status'=>'0', 'mensagem'=>'Ops :( Houve um erro ao atualizar o jogo');
		echo json_encode($retorno);
		exit();
	}	
?>