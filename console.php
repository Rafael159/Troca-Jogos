<!--
	*****SITE Restart Games						********
	*****Programador : RAFAEL ALVES CARDOSO     ********
	*****DATA: 06/03/2015                       ********
-->
<?php
  spl_autoload_register(function($classe) {
		require(dirname((__FILE__)).'/classes/'.$classe.'.class.php');
  });
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
		<meta name="description" content="Trocar jogos"/>
		<meta name="keywords" content="troca,jogo,games,consoles"/>
		<link rel="stylesheet" type="text/css" href="css/console.css"/>
		<link rel="stylesheet" type="text/css" href="css/header.css"/>
		<link rel="stylesheet" type="text/css" href="css/fonts.css" />
		<link rel="stylesheet" type="text/css" href="css/style-footer.css"/>
		<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
		<link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.css"/>
		  
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">		

		<title>Restart Games - Tudo sobre <?php echo strtoupper($cons)?></title>
		<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		<script>
		(adsbygoogle = window.adsbygoogle || []).push({
			google_ad_client: "ca-pub-6141840476591418",
			enable_page_level_ads: true
		});
		</script>
	</head>
  	<body>
	  <?php require 'require/header.php';?>
		<div class="container">
			<div class="row nopadding">
				<div class="col-lg-11 col-md-12 col-sm-12 col-xs-12">
					<div id="main-menu">
						<nav class="nav">
							<ul class="navbar-menu"> 
								<?php 
								foreach($console->listarTodos() as $value):
								?>
									<li id="<?php echo str_replace(' ', '', $value->nome_console)?>" ><a href="console.php?codigo=<?php echo $value->id_console?>&nome_console=<?php echo $value->nome_console?>" class="nav-link link"><?php echo $value->nome_console?></a></li>									
								<?php endforeach;?>
							</ul> 
						</nav>
					</div>
					<div id="boxConsole">
						<div class="row nopadding">
							<div class="d-flex ml-auto">
								<div id="select">
									<select name="selecao" id="selecao" class="">           
										<option value="crescente">Crescente (A-Z)</option>
										<option value="decrescente">Decrescente (Z-A)</option>
									</select> 
								</div>
							</div>
							
							<?php
								$idConsole = ((isset($_GET['codigo']) AND !empty($_GET['codigo'])) ? $_GET['codigo'] : '');
							?>
							<input type="hidden" value="<?php echo $idConsole; ?>" id="cod"/>
						</div>
						<div id="boxGame">   
							<div class="row nopadding">
								<?php
									if($idConsole):
										$qtd = Jogos::contarJogosHelper(array('status'=>'Ativo', 'idconsole'=>$idConsole));             
										echo '<label id="info"><span id="nomeConsole">'.strtoupper($cons).' - </span><span id="qtdJogo">'.$qtd.'</span> <b>jogo(s) encontrado(s)</b></label>';

										if($qtd != 0):
											foreach($jogos->listarJogos(array('status'=>'Ativo', 'idconsole'=>$idConsole)) as $valor):
								?>    
								<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">								
									<div class="each-game" id="game">
										<a href="game/game.php?codigo=<?php echo $valor->id?>&&console=<?php echo $idConsole;?>">
										<img src="game/imagens/<?php echo str_replace(' ','',$valor->nome_console)?>/<?php echo $valor->imagem?>" alt="<?php substr($valor->n_jogo, 0, 12)?>"/>
										<span class="nome-jogo"><?php echo strtoupper(substr($valor->n_jogo, 0, 16)).'...';?></span>
										</a>
									</div>
								</div>							
								<?php endforeach;
									else:
										echo "<span id='notFound'>Nada encontrado para ".strtoupper($cons)."</span>";                    
									endif;
								else: header('Location:index.php'); endif;
								?>
							</div>
						</div><!-- fim .row -->
					</div>
				</div>
			</div>  
		</div>

		<?php 
        	require('footer.php');
	  	?>

		<script type="text/javascript" src="js/jquery.js"></script> 
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
		
		<script type="text/javascript" src="js/console.js"></script>		
		<script src="js/global.js"></script>
		<script type="text/javascript" src="js/events.js"></script>
  </body>
</html>