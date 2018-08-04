<?php
	function __autoload($classe){
		require ('..\classes/'.$classe.'.class.php');
	}
	
	$imagem  = new Imagens;

	$id = $_POST['id'];
	$sql = "SELECT * FROM `console` as c, `imagens` as i WHERE c.id_console = i.id_console AND i.id_img = $id ORDER BY i.id_img";

	foreach ($imagem->consulta($sql) as $img) {
		$caminho = '../game/imagens/'.str_replace(' ', '', $img->nome_console).'/'.$img->imagem;
	}
			
	if(!$imagem->delete('id_img',$id)){
		
	}else{
		echo "Imagem excluida com sucesso!";
		unlink($caminho);
	}
?>