<!DOCTYPE HTML>
<html lang="pt-br">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="Restart Games - Porque o jogo não pode parar"/>
		<meta name="description" content="Troque seus jogos antigos por jogos que ainda não teve"/>
		<meta name="description" content="Troque jogos - divirta-se sem gastar mais"/>
		<meta name="keywords" content="Restart,Games,Troca,Jogo,Jogadores,Jogos"/>

		<!--CSS BOOTSTRAP-->
		<!-- <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css"/>
    	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-theme.css"/> -->
		
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		
		<!--CHAMADA CSS-->
		<link rel="stylesheet" type="text/css" href="css/estilo.css"/>   
		<link rel="stylesheet" type="text/css" href="css/style-footer.css"/>
		<link rel="stylesheet" type="text/css" href="css/fonts.css"/>

		<link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.css"/>
		<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
		<title>Restart Games - Porque o jogo não pode parar</title>
		<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		<script>
		(adsbygoogle = window.adsbygoogle || []).push({
			google_ad_client: "ca-pub-6141840476591418",
			enable_page_level_ads: true
		});
		</script>
	</head>
	<body class="center">	
		<?php			
			session_start();
			
			spl_autoload_register(function($classe) {
       			require(dirname(__FILE__).'/classes/'.$classe.'.class.php'); /*chama a classe automaticamente*/
			});
			@BD::conn();//conexão com o banco de dados
			
    		$categoria = new Consoles();
			$jogos = new Jogos();
			
			$user = Usuarios::getUsuario();
		?>
		<div class="container-fluid">
			
			<div class="conteudo">
				<?php include_once 'require/topo.php'; ?> <!--chama o topo do site-->

			<div class="row">
				<div class="col-lg-12">
					<div class="search-box">
						<section class="secao">
							<h3>Procure jogos para trocar</h3> 
							<h4>Economize dinheiro trocando jogos com outros jogadores</h4> 
						</section>
						<form class="box_pesquisa" action="pesquisa.php" method="GET">
							<div class="form-group">
								<div class="input_container">
									<div class="control-group">
										<input type="text" name="pesquisa" id="pesquisa" onkeyup="autoCompletar(this)" autocomplete="off" class="pesquisa form-control"/>				
										<input type="submit" value="Pesquisar" class="btn-enviar"/>								
									</div>
									<ul id="lista_jogos"></ul>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			
				<main class="main">				
					<!--menu galeria de jogos em estoque-->

					<div class="row nopadding">
						<!-- <div class="gallery"> -->
							<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 nopadding">
								<div class="galeria">
									<ul class="box-galeria-jogos">			
										<div class="arrow"></div>
										<?php
											foreach($categoria->listarTodos() as $valor):
										?>
										<li value="<?php echo $valor->id_console?>" class="link"><?php echo strtoupper($valor->nome_console)?></li>		 							
										<?php endforeach; ?>
									</ul>
								</div>
							</div>
							<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12 nopadding">
								<div class="galeria">
									<div id="galeria">
									</div>
								</div>
							</div>
						</div>
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
						<section id="lastgamesBox">
							<h5 class="section-title h1">Últimos jogos cadastrados</h5>
							<div class="row">
								<?php foreach($jogoAll as $jogo=> $valor): ?>						
									<div class="col-xs-12 col-sm-6 col-md-3 col-lg-2">
										<div class="card">
											<div class="card-body text-center">
												<div class="single-game">
													<p><a href='game/game.php?codigo=<?php echo $valor->id;?>'><img src="game/imagens/<?php echo str_replace(' ','',$valor->nome_console).'/'.$valor->imagem;?>" class="img-game img-fluid"></a></p>													
													<h5 class="card-title"><?php echo substr($valor->n_jogo,0,15).'...'?></h5>													
													<a href="game/game.php?codigo=<?php echo $valor->id;?>" class="btn btn-primary btn-md">Conferir <i class="fa fa-eye"></i></a>
												</div>
											</div>
										</div>
									</div>	
								<?php endforeach; ?>						
							</div>
						</section>
					<?php endif;?>				
					<div class="content">
						<div id="info-funcional">
							<header><h3>Como funciona a Restart Games?</h3></header>
							<ul id="passo-a-passo">
								<div class="row">
									<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
										<li class="passos">
											<!-- <div class="img-passos" id="img-cadastrar"></div> -->
											<h4 id="first-title">Cadastrar <i class="fa fa-user-plus" aria-hidden="true"></i></h4>
											<span class="topo-info">
												<p><i class="fa fa-check" style="color:#0f8a8b"></i> Cadastre-se no site</p> 
												<p><i class="fa fa-check" style="color:#0f8a8b"></i> Cadastre seus jogos</p>
											</span>
										</li>
									</div>
									<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
										<li class="passos">
											<!-- <div class="img-passos" id="img-pesquisar"></div> -->
											<h4 id="second-title">Pesquisar <i class="fa fa-search" aria-hidden="true"></i></h4>
											<span class="topo-info">
												<p><i class="fa fa-check" style="color:#8c0d0d"></i> Procure os jogos que interessam<p>
												<p><i class="fa fa-check" style="color:#8c0d0d"></i> Entre em contato com 
												o dono<p>
												<p><i class="fa fa-check" style="color:#8c0d0d"></i> Marque um ponto de encontro para a troca<p>
											</span>
										</li>
									</div>
									<div class="col-xs-12 col-sm-6 col-md-4 col-lg-46">						
										<li class="passos">
											<!-- <div class="img-passos" id="img-concluir"></div> -->
											<h4 id="third-title">Concluir <i class="fa fa-refresh" aria-hidden="true"></i></h4>
											<span class="topo-info">										
												<p><i class="fa fa-check" style="color:#0b95ca"></i> Faça a troca</p> 
												<p><i class="fa fa-check" style="color:#0b95ca"></i> Pegue seu novo jogo</p> 
												<p><i class="fa fa-check" style="color:#0b95ca"></i> Divirta-se <b>muito +</b></p>
											</span>
										</li>
									</div>						
								</div>						
							</ul>
						</div><!-- final do id info-funcional-->
					</div>
						<div id="devices">
							<div class="row">
								<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
									<div class="device">
										<span class="for_device">Computador</span>
										<img src="imagens/icones/version_computer.jpg" alt="Disponível para computador" class="img-device img-responsive">
									</div>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
									<div class="device soon">
										<span class="for_device">Breve: Mobile</span>
										<img src="imagens/icones/version_mobile.jpg" alt="Disponível para mobile" class="img-device img-responsive">
									</div>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">						
									<div class="device soon">
										<span class="for_device">Breve: Tablet</span>
										<img src="imagens/icones/version_tablet.jpg" alt="Disponível para tablet" class="img-device img-responsive">
									</div>
								</div>						
							</div>
						</div>
					</main>				
				</div>
			</div>
			<?php
				require 'footer.php';
			?>
		</div>
	
    <!--CHAMADA JAVASCRIPT-->		
	<script src="js/jquery.js"></script>
	<script src="js/jquery.validate.js"></script>
	<script src="js/events.js"></script><!--referente ao autocomplete do campo pesquisa -->
	<script src="js/funcoes.js"></script>
	<script src="js/validacao.js"></script>
	<script src="js/global.js"></script>

	<!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	
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