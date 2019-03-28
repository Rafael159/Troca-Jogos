<!--
	*****SITE TROCA JOGOS						********
	*****Programador : RAFAEL ALVES CARDOSO     ********
	*****DATA: 06/03/2015                       ********
-->
<?php
  function __autoload($classe){
      require('classes/'.$classe.'.class.php');
  }
  @BD::conn();//conexão com o banco de dados
  $console = new Consoles();
  $jogos = new Jogos();

  $cons = ((isset($_GET['nome_console']) AND !empty($_GET['nome_console'])) ? $_GET['nome_console'] : 'Jogos');
  
?>
<!DOCTYPE HTML>
<html>
  <head>
  	<meta charset="UTF-8">
	<meta name="description" content="Todos os jogos por console"/>
    <meta name="description" content="Console e seus jogos"/>
    <meta name="description" content="Trocar jogos">
    <meta name="keywords" content="troca,jogo,games,consoles"/>
    <link rel="stylesheet" type="text/css" href="css/console.css"/>
    <link rel="stylesheet" type="text/css" href="css/header.css"/>
    <link rel="stylesheet" type="text/css" href="css/fonts.css" />
    <link rel="stylesheet" type="text/css" href="css/style-footer.css"/>

    <title>Restart Games - Tudo sobre <?php echo strtoupper($cons)?></title> 
  	</head>
  	<body>
    	<?php require 'require/header.php';?>
     
    	<div id="main-menu">
			<nav class="nav">
				<ul>
					<?php 
					foreach($console->listarTodos() as $value):
					?>
					<li id="<?php echo str_replace(' ', '', $value->nome_console)?>"><a href="console.php?codigo=<?php echo $value->id_console?>&nome_console=<?php echo $value->nome_console?>" class="link"><?php echo $value->nome_console?></a></li>
					<?php endforeach;?>
				</ul> 
			</nav>
		</div>  
		<div id="boxConsole">
			<div id="select">
				<select name="selecao" id="selecao">           
					<option value="crescente">Crescente (A-Z)</option>
					<option value="decrescente">Decrescente (Z-A)</option>
				</select> 
			</div>
			<?php
				$idConsole = ((isset($_GET['codigo']) AND !empty($_GET['codigo'])) ? $_GET['codigo'] : '');
			?>
			<input type="hidden" value="<?php echo $idConsole; ?>" id="cod"/>
			<div id="boxGame">          
			<?php
				if($idConsole){
					$qtd = Jogos::contarJogosHelper(array('status'=>'Ativo', 'idconsole'=>$idConsole));             
					echo '<label id="info"><span id="nomeConsole">'.strtoupper($cons).'</span><span id="qtdJogo">'.$qtd.'</span> <b>jogo(s) encontrado(s)</b></label>';

					if($qtd != 0){
						foreach($jogos->listarJogos(array('status'=>'Ativo', 'idconsole'=>$idConsole)) as $valor):
			?>          
				<div class="each-game" id="game">
					<a href="game/game.php?codigo=<?php echo $valor->id?>&&console=<?php echo $idConsole;?>">
					<img src="game/imagens/<?php echo str_replace(' ','',$valor->nome_console)?>/<?php echo $valor->imagem?>" alt="<?php substr($valor->n_jogo, 0, 12)?>"/>
					<span class="nome-jogo"><?php echo strtoupper(substr($valor->n_jogo, 0, 16)).'...';?></span>
					</a>
				</div>
				<?php endforeach;
					}else{
						echo "<span id='notFound'>Nada encontrado para ".strtoupper($cons)."</span>";                    
					}
				}else{ header('Location:index.php'); }
				?>
			</div>
		</div>
      <?php 
        require('footer.php');
      ?>
		<script type="text/javascript" src="js/jquery.js"></script>  
		<script type="text/javascript" src="js/console.js"></script>		
		<script type="text/javascript" src="js/events.js"></script>
  </body>
</html>