<?php
	  function __autoload($classe){
      		require('..\classes/'.$classe.'.class.php');
  	  }
	  @BD::conn();//conexão com o banco de dados
	  $console = new Consoles();
	  $jogos = new Jogos();
	 	
	  $way = (isset($_POST['op']) ? $_POST['op'] : 'crescente');
	  $cod = (isset($_POST['cod']) ? $_POST['cod'] : '');

	  foreach ($console->listarCategorias($cod) as $key => $cns) {
	  	 $cons = $cns->nome_console;
	  }


	  if($way == 'crescente'){	  	
	  		$sql = "SELECT * FROM `jogos` as j, `console` as c, `imagens` as i WHERE c.id_console = $cod AND c.id_console = j.id_console AND j.img_jogo = i.id_img AND j.status = 1 ORDER BY j.n_jogo";
	  }else{
	  		$sql = "SELECT * FROM `jogos` as j, `console` as c, `imagens` as i WHERE c.id_console = $cod AND c.id_console = j.id_console AND j.img_jogo = i.id_img AND j.status = 1 ORDER BY j.n_jogo DESC";	  	
	  }
	 
      $qtd = count($jogos->consulta($sql));
      echo '<label id="info"><span id="nomeConsole">'.strtoupper($cons).'</span><span id="qtdJogo">'.$qtd.'</span> <b>jogo(s) encontrado(s)</b></label><input type="hidden" value="'.$cod.' "id="cod"/>';
      if($qtd != 0){
        foreach($jogos->consulta($sql) as $valor): 
?>
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