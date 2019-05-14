<?php
	spl_autoload_register(function($classe) {
	 	require('classes/'.$classe.'.class.php'); /*chama a classe automaticamente*/
 	});
	$keyword = (isset($_POST['keyword']) ? strtolower($_POST['keyword']) : '');

	$jogo = new Jogos();
	$jogo->setNome($keyword);
	$lista = $jogo->listarJogos(array('status'=>'Ativo', 'jogo'=>$keyword));

	$retorno = array();
	foreach ($lista as $rs) {
		//colocar em negrito o que foi digitado
		$nome_jogos = str_replace($_POST['keyword'], '<b>'.$_POST['keyword'].'</b>', strtolower($rs->n_jogo));
		$tmp = array('jogo'=>$rs->n_jogo, 'console'=>$rs->nome_console, 'consolesemEspaco'=>str_replace(' ', '', $rs->nome_console), 'imagem'=>$rs->imagem);

		array_push($retorno, $tmp);
	}
	echo json_encode($retorno);	
?>
