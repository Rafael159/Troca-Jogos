<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="description" content="Troque seus jogos antigos por jogos que ainda não teve"/>
		<meta name="description" content="Troque jogos - divirta-se sem gastar mais"/>
		<meta name="keywords" content="Troca,Jogo,Games,Jogadores"/>

		<!--CHAMADA CSS-->
		<link rel="stylesheet" type="text/css" href="css/estilo.css"/>   
		<link rel="stylesheet" type="text/css" href="css/style-footer.css"/>
		<link rel="stylesheet" type="text/css" href="css/fonts.css"/>
		<title>TJ - Troque jogos com outros jogadores</title>
	</head>
	<body class="center">
		<?php
			session_start();
			function __autoload($classe){
       			 require('classes/'.$classe.'.class.php'); /*chama a classe automaticamente*/
   			}
    		@BD::conn();//conexão com o banco de dados
    		$categoria = new Consoles();
    		$jogos = new Jogos();
		?>
		<div class="main_box">
			<div class="content">
				<?php include_once 'require/topo.php';?> <!--chama o topo do site-->
			<div class="conteudo">
				<section class="secao"> 
					<h3>Procure jogos para trocar</h3> 
					<h4>Economize dinheiro trocando jogos com outros jogadores</h4> 
				</section>
				<form class="box_pesquisa" action="pesquisa.php" method="GET">
					<div class="input_container">
						<input type="text" name="pesquisa" id="pesquisa" onkeyup="autoCompletar(this)" autocomplete="off" class="pesquisa"/>				
						<ul id="lista_jogos"></ul>
						<input type="submit" value="Pesquisar" class="btn-enviar"/>
					</div>
				</form><br/>
			</div>
			
			<main class="main">
				<div class="clearfix">
				<!--<div id="box-jogos-destaque">
					<div id="games-top" class="destaque_games">
						<a href="teste.php">
							<figure class="quadro-maior"><div class="sombraImg"></div><img src="imagens/background.jpg" alt="Game" width="470px" height="300px"/>
								<figcaption>
									<h3>Assassin's Creed</h3><h4>R$ 120,00</h4>
							    </figcaption>
							</figure>
						</a>
						<a href="teste.php">
							<figure class="quadro-menor"><div class="sombraImg"></div><img src="imagens/jogo2.jpg" alt="Game" width="250px" height="300px"/>
								<figcaption>
									<h3>Assassin's Creed - Brotherhood IV...</h3><h4>R$ 320,00</h4>
							    </figcaption>
							</figure>
						</a>
						<a href="teste.php">
							<figure class="quadro-maior"><div class="sombraImg"></div><img src="imagens/sonic.jpg" alt="Game" width="470px" height="300px"/>
								<figcaption>
									<h3>Assassin's Creed</h3><h4>R$ 200,00</h4>
							    </figcaption>
							</figure>
						</a>
					</div>
					<div id="games-bottom" class="destaque_games">								
						<a href="teste.php">
							<figure class="quadro-menor"><div class="sombraImg"></div><img src="imagens/pes.jpg" alt="Game" width="250px" height="300px">
								<figcaption>
									<h3>Assassin's Creed</h3><h4>R$ 320,00</h4>
							    </figcaption>
							</figure>
						</a>
						<a href="teste.php">
							<figure class="quadro-maior"><div class="sombraImg"></div><img src="imagens/tiro.jpg" alt="Game" width="470px" height="300px">
								<figcaption>
									<h3>Assassin's Creed</h3><h4>R$ 320,00</h4>
							    </figcaption>
							</figure>
						</a>						
						<a href="teste.php">	
							<figure class="quadro-maior"><div class="sombraImg"></div><img src="imagens/juiced.jpg" alt="Game" width="470px" height="300px">
								<figcaption>
									<h3>Assassin's Creed</h3><h4>R$ 420,00</h4>
							    </figcaption>
							</figure>
						</a>	
					</div>
				</div>
			</div>-->
				<!--menu galeria de jogos em estoque-->
				<span id="titulo-galeria"><h4>GALERIA DE JOGOS POR CATEGORIA</h4></span>
				<!--enviar o id do console e retorno os jogos referentes ao mesmo-->
				
				<div class="galeria">
					<ul class="box-galeria-jogos">			
						<div class="arrow"></div>
						<?php								
							foreach($categoria->listarTodos() as $valor):
						?>
 						<li name="" value="<?php echo $valor->id_console?>" class="link"><?php echo strtoupper($valor->nome_console)?></li>		 							
						<?php endforeach; ?>
					</ul>
				   
				   <div id="galeria">
			  		<!--
					* 	essa div recebe o resultado dos jogos de cada console
					* 	ao clicar no nome do console será retornado o jogos referente ao console 
					*   os jogos de PS4 já ficarão visíveis	
				  	-->					  	
					</div><!--id galeria-->
				</div><!--class galeria-->
				<div class="clearfix">
				<!--últimos cadastrados-->
					<div id="sidebar-left">
						<h5>Últimos <b>10</b> jogos cadastrados</h5>
						<span id="prevId" class="flexa"><a href="javascript:void(0);"><img src="imagens/icones/icon-seta.png"></a></span> 
						<span id="nextBtn" class="flexa"><a href="javascript:void(0);"><img src="imagens/icones/icon-seta.png"></a></span>
						<div id="slider">
							<ul>
								<?php
									$sql = "SELECT * FROM `jogos` as j,`console` as c, `imagens` as i WHERE j.id_console = c.id_console AND j.img_jogo = i.id_img ORDER BY j.id DESC LIMIT 10";
									
									foreach($jogos->consulta($sql) as $jogo=> $valor):		
								?>
								<a href='game/game.php?codigo=<?php echo $valor->id;?>'><li><img src="game/imagens/<?php echo str_replace(' ','',$valor->nome_console).'/'.$valor->imagem;?>"><span class="inf-ultimos-jogos"><?php echo substr($valor->n_jogo,0,12).' - '.substr(strtoupper($valor->nome_console),0,6).'...'?></span></li></a>
								<?php endforeach;?>
							</ul>							
						</div>
					</div><!--sidebar-->
				</div>
				<div class="clearfix">
					<div id="info-funcional">
						<header><h3>Como funciona?</h3></header>
						<ul id="passo-a-passo">
							<li class="passos">
								<div class="img-passos" id="img-cadastrar"></div>
								<h4 id="first-title">Cadastrar</h4>
								<span class="topo-info">
									<p>Cadastre-se no site</p> 
									<p>Cadastre os seus jogos</p>
								</span>
							</li>
							<li class="passos">
								<div class="img-passos" id="img-pesquisar"></div>
								<h4 id="second-title">Pesquisar</h4>
								<span class="topo-info">
									<p>Procure os jogos que interessam<p>
									<p>Entre em contato com 
									o dono<p>
									<p>Marque um ponto de encontro para a troca<p>
								</span>
							</li>							
							<li class="passos">
								<div class="img-passos" id="img-concluir"></div>
								<h4 id="third-title">Concluir</h4>
								<span class="topo-info">										
									<p>Pegue seu novo jogo</p> 
									<p>Divirta-se <b>Muito +</b></p>
								</span>
							</li>							
						</ul>
					</div><!-- final do id info-funcional-->
				</div>				
			</main>											
		</div><!--content-->	
	</div><!--principal-->
	<?php
		require 'footer.php';
	?>		
    <!--CHAMADA JAVASCRIPT-->		
	<script src="js/jquery.js"></script>
	<script src="js/jquery.validate.js"></script>
	<script src="js/events.js"></script><!--referente ao autocomplete do campo pesquisa-->
	<script src="js/funcoes.js"></script>
	<script src="js/validacao.js"></script>
	<script src="js/animation.js"></script><!--animação dos últimos jogos cadastrados-->
	<script src="js/global.js"></script>
	<script>
		$(document).ready(function(){
        	$('#lista_jogos').slideUp();
		});
	</script>
	</body>
</html>