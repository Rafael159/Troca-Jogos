<?php	
	session_start();
	function __autoload($classe){
		require ('..\classes/'.$classe.'.class.php');
	}
	
	$jogo = new Jogos();//chamada da CLASSE JOGOS
	$console = new Consoles();//classe CONSOLES
	$user = new Usuarios();//chamada da CLASSE USUÁRIOS
	$image = new Imagens();
	$jogocategoria = new JogoCategoria();


	$email = $_SESSION['emailTJ'];
	$user->setEmail($email);
	foreach($user->findEmail() as $usuario):
		$idUser = $usuario->id_user;
	endforeach;

	//recebendo os valores vindo do form
	$console_id = (isset($_POST['console']) ? $_POST['console'] : "");//id do console
	$nome_jogo = (isset($_POST['jogo']) ? trim($_POST['jogo']) : "");//nome do jogo
	$img_id  = (isset($_POST['img_id']) ? $_POST['img_id'] : "");//id da imagem
	$genero  = (isset($_POST['genero']) ? $_POST['genero'] : "");//array com os gêneros do jogo
	$descricao = (isset($_POST['descricao']) ? trim($_POST['descricao']) : ""); //descrição do jogo
	$infoExtra = (isset($_POST['infoExtra']) ? trim($_POST['infoExtra']) : "");//opcional - informação extra

	$retorno = array();//retornará o status e mensagem

	if(!$console_id):
		$retorno = array('status'=>'0', 'mensagem'=>'Selecione o console');
		echo json_encode($retorno);
		exit();
	endif;//fim valida console
	
	if(!$nome_jogo):
		$retorno = array('status'=>'0', 'mensagem'=>'Insira o nome do jogo');
		echo json_encode($retorno);
		exit();
	endif;//fim valida nome do jogo

	if(empty($img_id)):
		if($_FILES['imagem']['error'] == 4){
			$retorno = array('status'=>'0', 'mensagem'=>'Selecione uma imagem ou faça o upload');
			echo json_encode($retorno);
			exit();
		}
	endif;//fim valida campo imagem

	if(isset($_FILES['imagem']) && $_FILES['imagem']['size'] > 0):	
		$nomeimg = $_FILES['imagem']['name'];
		$ext_aceitas = array('jpg','jpeg','png');//array com as extensões permitidas
		$array_extensao = explode('.',$_FILES['imagem']['name']);//pegar a extensão
		$extensao = strtolower(end($array_extensao));

		//validar se a extensão é válida
		if(array_search($extensao, $ext_aceitas) === false):
			$retorno = array('status'=>'0', 'mensagem'=>'Extensão inválida - são permitidas (jpg/jpeg/png)');
			echo json_encode($retorno);
			exit();
		endif;

		$pega_nome_console = $console->consoleById($console_id);//busca o nome do console pelo ID passado
		if(!empty($pega_nome_console)):
			$dir = $pega_nome_console[0]->nome_console;//se okay, essa será a pasta destino da imagem				
		endif;

		//fazer upload da imagem
		if(is_uploaded_file($_FILES['imagem']['tmp_name'])):
			$dir = str_replace(' ', '', $dir);//retirar espaço entre as palavras
			//verifica se diretório existe, senão cria
			if(!file_exists('..\game/imagens/'.$dir)){					
				mkdir('..\game/imagens/'.$dir, 0700);					
			}

			//gerar nome aleatório e único para a imagem
			$nomeAleatorio = md5(uniqid(time())). strchr($nomeimg,".");

		endif;
	endif;//fim valida upload imagem

	if(empty($genero)){
		$retorno = array('status'=>'0', 'mensagem'=>'Selecione o(s) gênero(s) do jogo');
		echo json_encode($retorno);
		exit();
	}

	if(!$descricao):
		$retorno = array('status'=>'0', 'mensagem'=>'Insira uma breve descrição do seu jogo');
		echo json_encode($retorno);
		exit();
	endif;

	/*$qtnGenero = count($genero);
	for($i=0; $i<=$qtnGenero, $i++) {
		$jogocategoria->setJogoID(23);
		$jogocategoria->setCategoriaID($genero[$i]);

		if($jogocategoria->insert()){
			$retorno = array('status'=>'0', 'mensagem'=>'Falha ao inserir gênero'.$genero[$key]);
			echo json_encode($retorno);
			exit();
		}
	}*/
	
	/*ENVIAR IMAGEM PARA A PASTA DESTINO*/
	if(empty($img_id)):
		if(!move_uploaded_file($_FILES['imagem']['tmp_name'], '..\game/imagens/'.$dir.'/'.$nomeAleatorio)){
			$retorno = array('status'=>'0', 'mensagem'=>'Houve um erro ao fazer o upload');
			echo json_encode($retorno);
			exit();
		}
		/*SALVAR A IMAGEM NO BD*/
		$image->setIdConsole($console_id);
		$image->setNome($nome_jogo);
		$image->setImagem($nomeAleatorio);

		if(!$image->insert()){
			$retorno = array('status'=>'0', 'mensagem'=>'Ocorreu um erro ao fazer o upload');
			echo json_encode($retorno);
			exit();
		}
		/*Retorna o ID da imagem salva e atribui no var @img_id*/
		$image->setImagem($nomeAleatorio);
		if($dados = $image->findPhoto()):
			foreach ($dados as $key => $value) {
				$img_id = $value->id_img;
				/*$retorno = array('status'=>'0', 'mensagem'=>'Encontrou id->'.$img_id);
				echo json_encode($retorno);*/				
			}
		endif;
	endif;

	//INSERIR OS DADOS NO BANCO DE DADOS		
	//SETAR TODOS OS CAMPOS
	$jogo->setNome($nome_jogo);
	$jogo->setImagem($img_id);
	$jogo->setIdCons($console_id);
	$jogo->setIdGamer($idUser);
	//$jogo->setJogoT($jogoDesejado);
	//$jogo->setIdJogoT($idJogoDesejado);
	$jogo->setData(date('Y-m-d'));
	$jogo->setDescricao($descricao);
	$jogo->setInfoExtra($infoExtra);

	$sql = $jogo->insert();

	if(empty($sql)){
		$retorno = array('status'=>'0', 'mensagem'=>'Houve um erro ao cadastrar o jogo! Tente novamente');
		echo json_encode($retorno);
		exit();
	}else{
		
		$lastinserted = (int)$sql;//garantir que valor seja inteiro
		$qtnGenero = count($genero);

		for($i=0; $i<$qtnGenero; $i++) {
			//echo $genero[$i];
			$jogocategoria->setJogoID($lastinserted);
			$jogocategoria->setCategoriaID($genero[$i]);

			$jogocategoria->insert();

		}
		$retorno = array('status'=>'1', 'mensagem'=>'Jogo salvo com sucesso');
		echo json_encode($retorno);
	}	
?>