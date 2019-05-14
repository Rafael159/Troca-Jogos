<?php
	spl_autoload_register(function($classe) {
		require ('..\classes/'.$classe.'.class.php');
	});
	
	$imagem  = new Imagens();

	$id = $_POST['id'];
	$sql = "SELECT * FROM `console` as c, `imagens` as i WHERE c.id_console = i.id_console AND i.id_img = $id";

	foreach ($imagem->consulta($sql) as $img) {
		$caminho = '../game/imagens/'.str_replace(' ', '', $img->nome_console).'/'.$img->imagem;
	}

	$imagem->setIdImagem($id);		
	if($imagem->delete()){
		unlink($caminho);
		echo json_encode(array('status'=>'sucesso'));
		die();		
	}else{
		echo json_encode(array('status'=>'erro'));
		die();
	}
?>