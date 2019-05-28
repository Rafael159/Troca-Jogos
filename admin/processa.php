<?php
spl_autoload_register(function($classe) {
	require(dirname(dirname((__FILE__))).'/classes/'.$classe.'.class.php');
});
@BD::conn();//conexão com o banco de dados
$console = new Consoles();

//flag que indica se há erro ou não
$data['erro'] = null;
$data['sucesso'] = false;

if(is_array($_FILES)) {
	
	//recupera informações
	$id = $_POST['console'];
	$imagem = $_FILES['image_file'];
	$temp = $_FILES['image_file']['tmp_name'];
	$nome = $_FILES['image_file']['name'];//nome original

	foreach ($console->listarCategorias($id) as $cons) {
		$data['nomeconsole'] = str_replace(' ', '',$cons->nome_console);
	}
	//configuração
	$largura = 195;
	$extensoes = array('.jpg', '.png');
	$caminho = "../game/imagens/".$data['nomeconsole'];
	$ext = strtolower(strrchr($nome, "."));
		
	if(is_uploaded_file($_FILES['image_file']['tmp_name'])) {
		
		if(!in_array(strtolower(strrchr($nome, ".")), $extensoes)){
			$data['erro'] = 'Extensão não permitida';
		}

		if(!isset($data['erro'])){
			//se o diretório do arquivo não existe, então crie o diretório
			if (!file_exists($caminho)){
				mkdir("$caminho", 0700); 
			}

			$name = md5(uniqid(rand(),true));//nome criado a partir de chave única
		
			if ($imagem['type']=="image/jpeg"){
				$img = imagecreatefromjpeg($imagem['tmp_name']);
			}else if ($imagem['type']=="image/png"){
				$img = imagecreatefromjpeg($imagem['tmp_name']);
			}
			$x   = imagesx($img);
			$y   = imagesy($img);
			$altura = ($largura * $y)/$x;
			
			$nova = imagecreatetruecolor($largura, $altura);
			imagecopyresampled($nova, $img, 0, 0, 0, 0, $largura, $altura, $x, $y);
			
			session_start();
			if ($imagem['type']=="image/jpeg"){
				$local="$caminho/$name".".jpg";
				imagejpeg($nova, $local);
			}else if ($imagem['type']=="image/gif"){
				$local="$caminho/$name".".gif";
				imagejpeg($nova, $local);
			}else if ($imagem['type']=="image/png"){
				$local="$caminho/$name".".png";
				imagejpeg($nova, $local);
			}
			
			imagedestroy($img);
			imagedestroy($nova);
			$name = $name.$ext;

			$data['nome'] = "$local";
			$data['nomeAleatorio'] = "$name";
			$data['sucesso'] = true;
		}
	}else{
		$data['erro'] = 'Não foi possível anexar o arquivo';
	}
}else{
	$data['erro'] = "Arquivo incompatível. Por favor verifique";
}

echo json_encode($data);
die();
?>