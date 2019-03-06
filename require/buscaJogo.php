<?php
	function __autoload($classe){
		require('..\classes/'.$classe.'.class.php');
	}
	@BD::conn();//conexão com o banco de dados
	$console = new Consoles();
	$jogos = new Jogos();
	
	$way = (isset($_POST['op']) ? $_POST['op'] : 'crescente');
	$cod = (isset($_POST['cod']) ? $_POST['cod'] : '');
	$consoles = $console->listarCategorias($cod);
	
	foreach ($consoles as $key => $cns) {
		$cons = $cns->nome_console;
	}

	if($way == 'crescente'){		
		$games = $jogos->listarJogos(array('status'=>'Ativo', 'idconsole'=>$cod, 'order'=>'ORDER BY j.n_jogo')); 
	}else{
		$games = $jogos->listarJogos(array('status'=>'Ativo', 'idconsole'=>$cod, 'order'=>'ORDER BY j.n_jogo DESC'));		
	}
	 
	$qtd = $jogos->contarJogos(array('status'=>'Ativo', 'idconsole'=>$cod));
    echo '<label id="info"><span id="nomeConsole">'.strtoupper($cons).'</span><span id="qtdJogo">'.$qtd.'</span> <b>jogo(s) encontrado(s)</b></label><input type="hidden" value="'.$cod.' "id="cod"/>';
    if($qtd != 0){
        foreach($games as $valor): ?>
			<div class="each-game" id="game">
				<a href="game/game.php?id=<?php echo $valor->id?>&&console=<?php echo $cod;?>">
				<img src="game/imagens/<?php echo str_replace(' ','',$valor->nome_console)?>/<?php echo $valor->imagem?>" alt="<?php echo strtoupper($valor->n_jogo)?>"/>
				<span class="nome-jogo"><?php echo strtoupper($valor->n_jogo)?></span>
				</a>
          	</div>
      <?php
        endforeach;
	}else{
		echo "<span id='notFound'>Nada encontrado para ".strtoupper($cons)."</span>";                    
	}        
?>