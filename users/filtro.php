<?php
	spl_autoload_register(function($classe) {
		require(dirname(dirname(__FILE__)).'/classes/'.$classe.'.class.php');
	});

	$imagem  = new Imagens();
	if(isset($_POST['jogo'])){ $jogo = $_POST['jogo']; }
	if(isset($_POST['id'])){ $id = $_POST['id']; }

	$sql = "SELECT * FROM `console` as c, `imagens` as i WHERE i.nome LIKE '$jogo%' AND c.id_console = i.id_console AND i.id_console = $id ORDER BY i.id_img";
	
	$qnt = count($imagem->consulta($sql));	
	if($qnt == 0){
		$dados['qnt'] = 0;//nenhum jogo encontrado
	}else{
		
		$dados = $imagem->consulta($sql);
		//print_r($rst);
		/*$dados['id_img'] = $rst->id_img;
		$dados['nome_console'] = $rst->nome_console;
		$dados['imagem'] = $rst->imagem;
		$dados['nome'] = $rst->nome;*/
		//$dados = $rst;		
	}
	if(!empty($dados)){
		echo json_encode($dados);//retorna valor em JSON
	}else{
		$dados['mensagem'] = 'Ocorreu algum erro';
		echo json_encode($dados);
	}
?>
