<?php

function __autoload($classe){
    require('../classes/'.$classe.'.class.php');
}
@BD::conn();//conexão com o banco de dados
$console = new Consoles();

//flag que indica se há erro ou não
$data['erro'] = null;
$data['sucesso'] = false;

if(is_array($_FILES)) {

	$data['jogo'] = $_POST['nome-jogo'];
	$data['console'] = $_POST['console'];

	$id = $data['console'];

	foreach ($console->listarCategorias($id) as $cons) {
		$data['nomeconsole'] = str_replace(' ', '',$cons->nome_console);
	}

	if(is_uploaded_file($_FILES['image_file']['tmp_name'])) {

		//recuperando informações do arquivo
		$temp = $_FILES['image_file']['tmp_name'];
		$nome = $_FILES['image_file']['name'];

		//configuração
		$extensoes = array('.jpg', '.png');
		$caminho = "../game/imagens/".$data['nomeconsole'];

		//se o diretório do arquivo não existe, então crie o diretório
		if (!file_exists($caminho)){
			mkdir("$caminho", 0700);
		}

		if(!in_array(strtolower(strrchr($nome, ".")), $extensoes)){
			$data['erro'] = 'Extensão não permitida'; 
		}
		//se não houver erro
		if(!$data['erro']){

			//gerar nome aleatório e único para a imagem
			$nomeAleatorio = md5(uniqid(time())). strchr($nome,".");
			//movendo arquivo para o servidor
			if(move_uploaded_file($temp, "$caminho/$nomeAleatorio")){
				$data['nome'] = "$caminho/$nomeAleatorio";
				$data['nomeAleatorio'] = "$nomeAleatorio";
				}else{
					$data['erro'] = 'Não foi possível anexar o arquivo';
				}
			$data['sucesso'] = true;
		}
	}
	echo json_encode($data);
}else{
	echo $data['erro'] = "Falha";
}

?>