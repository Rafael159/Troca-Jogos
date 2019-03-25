<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="description" content="Restart Games - Porque o jogo não pode parar"/>
		<meta name="description" content="Troque seus jogos antigos por jogos que ainda não teve"/>
		<meta name="description" content="Troque jogos - divirta-se sem gastar mais"/>
		<meta name="keywords" content="Restart,Games,Troca,Jogo,Jogadores,Jogos"/>

		<!--CHAMADA CSS-->
				<!--CSS BOOTSTRAP-->
		<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css"/>
    	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-theme.css"/>

		<link rel="stylesheet" type="text/css" href="css/estilo.css"/>   
		<link rel="stylesheet" type="text/css" href="css/style-footer.css"/>
		<link rel="stylesheet" type="text/css" href="css/fonts.css"/>

		<link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.css"/>

		<title>RG - Porque o jogo não pode parar</title>
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
				<?php include_once 'require/topo.php'; ?> <!--chama o topo do site-->
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
				<!--menu galeria de jogos em estoque-->
				<!-- <span id="titulo-galeria"><h4>GALERIA DE JOGOS POR CATEGORIA</h4></span> -->
				<!--enviar o id do console e retorno os jogos referentes ao mesmo-->
				<div class="row nopadding">
					<!-- <div class="galeria"> -->
						<div class="col-lg-2 col-md-3 col-sm-4 nopadding">
							<div class="galeria">
								<ul class="box-galeria-jogos">			
									<div class="arrow"></div>
									<?php								
										foreach($categoria->listarTodos() as $valor):
									?>
									<li name="" value="<?php echo $valor->id_console?>" class="link"><?php echo strtoupper($valor->nome_console)?></li>		 							
									<?php endforeach; ?>
								</ul>
							</div>
						</div>
						<div class="col-lg-10 col-md-9 col-sm-8 nopadding">
							<div class="galeria">
								<div id="galeria">
								</div><!--id galeria-->
							</div>
						</div>
					<!-- </div> -->
				</div>
				
				<!--últimos cadastrados-->
					<?php
						$jogoAll = $jogos->listarJogos(array('status'=>'Ativo', 'limite'=>'10'));
						if(count($jogoAll) > 0):
					?>
					<div class="row">
						<div class="col-lg-4 col-lg-offset-8">
							<div id="sidebar-left">
								<h5>Últimos <b>10</b> jogos cadastrados</h5>
								<span id="prevId" class="flecha"><a href="javascript:void(0);"><img src="imagens/icones/icon-seta.png"></a></span> 
								<span id="nextBtn" class="flecha"><a href="javascript:void(0);"><img src="imagens/icones/icon-seta.png"></a></span>
								<div id="slider">
									<ul>
										<?php									
											foreach($jogoAll as $jogo=> $valor):		
										?>
										<a href='game/game.php?codigo=<?php echo $valor->id;?>'><li><img src="game/imagens/<?php echo str_replace(' ','',$valor->nome_console).'/'.$valor->imagem;?>"><span class="inf-ultimos-jogos"><?php echo substr($valor->n_jogo,0,12).' - '.substr(strtoupper($valor->nome_console),0,6).'...'?></span></li></a>
										<?php endforeach;?>
									</ul>							
								</div>
							</div><!--sidebar-->
						</div>
					</div>
					<?php endif; ?>
				</div>
				<div class="row">
					<div class="content">
						<div id="info-funcional">
							<header><h3>Como funciona a Restart Games?</h3></header>
							<ul id="passo-a-passo">
								<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
									<li class="passos">
										<!-- <div class="img-passos" id="img-cadastrar"></div> -->
										<h4 id="first-title">Cadastrar <i class="fa fa-user-plus fa-2x" aria-hidden="true"></i></h4>
										<span class="topo-info">
											<p><i class="fa fa-check" style="color:#0f8a8b"></i> Cadastre-se no site</p> 
											<p><i class="fa fa-check" style="color:#0f8a8b"></i> Cadastre seus jogos</p>
										</span>
									</li>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
									<li class="passos">
										<!-- <div class="img-passos" id="img-pesquisar"></div> -->
										<h4 id="second-title">Pesquisar <i class="fa fa-search fa-2x" aria-hidden="true"></i></h4>
										<span class="topo-info">
											<p><i class="fa fa-check" style="color:#8c0d0d"></i> Procure os jogos que interessam<p>
											<p><i class="fa fa-check" style="color:#8c0d0d"></i> Entre em contato com 
											o dono<p>
											<p><i class="fa fa-check" style="color:#8c0d0d"></i> Marque um ponto de encontro para a troca<p>
										</span>
									</li>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">						
									<li class="passos">
										<!-- <div class="img-passos" id="img-concluir"></div> -->
										<h4 id="third-title">Concluir <i class="fa fa-refresh fa-2x" aria-hidden="true"></i></h4>
										<span class="topo-info">										
											<p><i class="fa fa-check" style="color:#0b95ca"></i> Faça a troca</p> 
											<p><i class="fa fa-check" style="color:#0b95ca"></i> Pegue seu novo jogo</p> 
											<p><i class="fa fa-check" style="color:#0b95ca"></i> Divirta-se <b>muito +</b></p>
										</span>
									</li>
								</div>						
							</ul>
						</div><!-- final do id info-funcional-->
					</div>
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
	<script src="js/events.js"></script><!--referente ao autocomplete do campo pesquisa -->
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