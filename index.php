<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="description" content="Restart Games - Porque o jogo não pode parar"/>
		<meta name="description" content="Troque seus jogos antigos por jogos que ainda não teve"/>
		<meta name="description" content="Troque jogos - divirta-se sem gastar mais"/>
		<meta name="keywords" content="Restart,Games,Troca,Jogo,Jogadores,Jogos"/>

		<!--CSS BOOTSTRAP-->
		<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css"/>
    	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-theme.css"/>
		
		<!--CHAMADA CSS-->
		<link rel="stylesheet" type="text/css" href="css/estilo.css"/>   
		<link rel="stylesheet" type="text/css" href="css/style-footer.css"/>
		<link rel="stylesheet" type="text/css" href="css/fonts.css"/>

		<link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.css"/>
		<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
		<title>Restart Games - Porque o jogo não pode parar</title>
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
			
			$user = Usuarios::getUsuario();
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
				<?php
					$queries = array('status'=>'Ativo', 'limite'=>'6', 'order'=>'ORDER BY id DESC');
					if($user){
						$idconsole = $user->console;
						$queries['idconsole'] = $idconsole;
					}

					$jogoAll = $jogos->listarJogos($queries);
					if(count($jogoAll) > 0):
				?>
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div id="lastgamesBox">
								<label class="last-records">Últimos jogos cadastrados que podem te interessar</label>
								<?php foreach($jogoAll as $jogo=> $valor): ?>
									<div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
										<div class="single-game">
											<a href='game/game.php?codigo=<?php echo $valor->id;?>'><img src="game/imagens/<?php echo str_replace(' ','',$valor->nome_console).'/'.$valor->imagem;?>" class="img-game"></a>
											
											<span class="name-game"><b><?php echo substr($valor->n_jogo,0,15).'...'?></b></span>
										</div>
									</div>
								<?php endforeach; ?>
							<?php //endif; ?>
							</div>
						</div>
					</div>
				<?php endif;?>				
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

				<div class="row">
					<ul id="devices">
						<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
							<li class="device">
								<span class="for_device">Computador</span>
								<img src="imagens/icones/version_computer.jpg" alt="Disponível para computador" class="img-device img-responsive">
							</li>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
							<li class="device soon">
								<span class="for_device">Breve: Mobile</span>
								<img src="imagens/icones/version_computer.jpg" alt="Disponível para mobile" class="img-device img-responsive">
							</li>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">						
							<li class="device soon">
								<span class="for_device">Breve: Tablet</span>
								<img src="imagens/icones/version_computer.jpg" alt="Disponível para tablet" class="img-device img-responsive">
							</li>
						</div>						
					</ul>
				</div>
			</main>	
			<div class="advertising">
				
			</div>
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
	<script src="js/global.js"></script>
	
	<!-- <script src="js/adblocks.js" type="text/javascript"></script>
	<script type="text/javascript">
	
		if(document.getElementById('drall_team_PRS_JS__random')){
		alert('Bloqueando anúncio: Não');
		} else {
		alert('Bloqueando anúncio: Sim');
		}
	</script> -->

	<!-- <script src="js/animation.js"></script>animação dos últimos jogos cadastrados -->
	<!-- <script>
		$(document).ready(function(){
			$('#lista_jogos').slideUp();
			alert(jQuery('.advertising').height());
			jQuery(document).ready(function() {
				if (jQuery('.advertising').height() == 0) {
					// AdBlock active
					alert('ANÚNCIO DESATIVADO');
				}else{
					alert('ANÚNCIO ATIVO');
				}
			});
		});
	</script> -->
	
	</body>
</html>