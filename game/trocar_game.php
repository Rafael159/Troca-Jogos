<?php
	header('Content-Type: text/html; charset=utf-8');
	spl_autoload_register(function($classe) {
		require(dirname(dirname(__FILE__)).'/classes/'.$classe.'.class.php');        
    });
    @BD::conn();//conexão com o banco de dados	
    
    $jogo = new Jogos(); //chama a classe Jogos 
    $user = new Usuarios();

    session_start();
    if($_SESSION AND isset($_SESSION['emailTJ'])){
    	$email = $_SESSION['emailTJ'];
    	$idUser = $_SESSION['id_user'];
    }else{
    	header("Location:..\index.php");
	};
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="description" content="Troque seus jogos antigos por jogos que ainda não teve"/>
		<meta name="description" content="Troque jogos - divirta-se sem gastar mais"/>
		<meta name="description" content="O lugar certo pra trocar jogos">
		<meta name="description" content="Trocar jogos">
		<meta name="keywords" content="Troca,Jogo,Games,Jogadores"/>

		<title>RG - Porque o jogo não pode parar</title>

		<!--CHAMADA CSS-->
		<link rel="stylesheet" type="text/css" href="css/games.css"/>
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<link rel="stylesheet" type="text/css" href="css/header.css"/>
		<link rel="stylesheet" type="text/css" href="../css/estilo.css" />
		<link rel="stylesheet" type="text/css" href="../css/fonts.css"/>
		<link rel="stylesheet" type="text/css" href="../css/style-footer.css"/>
		
		<link rel="stylesheet" type="text/css" href="../font-awesome/css/font-awesome.css"/>

		<!--CSS BOOTSTRAP-->
		<!-- <link rel="stylesheet" href="..\bootstrap/css/bootstrap.min.css"/>
		<link rel="stylesheet" href="..\bootstrap/css/bootstrap-theme.css"/> -->

		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

		<link rel="shortcut icon" type="image/x-icon" href="../favicon.ico">
		<script>
		(adsbygoogle = window.adsbygoogle || []).push({
			google_ad_client: "ca-pub-6141840476591418",
			enable_page_level_ads: true
		});
		</script>
	</head>
<body>
	<input type="hidden" name="idUserDois" value='<?php echo $idUser ?>' id="idUserDois"/>
	<div class="content">
		<?php include_once('header.php'); ?>

		<div class="clearfix">			
			
		</div>	
		<div class='container-fluid nopadding'>
			<div class="d-flex justify-content-center">
				<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12 d-flex justify-content-center nopadding'>
					<div class="main_jogo_selecionado">							
						<div class="row nopadding">
							<div id="box_jogo">
								<form name="frm_trocas" id="frm_trocas" method="POST">
									<div class="row nopadding">
										<div class="col-lg col-md col-sm-12 col-xs-12">
											<!--JOGO QUE QUERO RECEBER NA TROCA-->
											<div class="jgTroca jgNovo">
											<span class="header-dono">JOGO DESEJADO</span>
											<?php						
												$idJogo = (isset($_GET['id']) AND $_GET['id'] !== '') ? $_GET['id'] : '';//id do jogo

												if($idJogo):
												//buscar o jogo selecionado					
												$jogo->setId($idJogo);
												foreach ($jogo->listaJogoById() as $chave => $valor):
											?>	
											<input type="hidden" name='idUserUm' value="<?php echo $valor->id_user ?>" id="idUserUm"/>
											<input type="hidden" name='idJogo' value="<?php echo $idJogo ?>" id="idJogo"/>	
											<!--<input type="hidden" name='idUser' value="<?php echo $valor->id_user ?>" id="idUser"/>-->
											<img src="imagens/<?php echo str_replace(' ', '', $valor->nome_console)?>/<?php echo $valor->imagem?>" alt="<?php echo $valor->n_jogo?>" class="img-responsive"/>
											<label><?php echo strtoupper($valor->n_jogo)?> - <?php echo strtoupper($valor->nome_console)?></label>
											<?php 
											endforeach;
												else: ?>
													<a href="../pesquisa.php"><img src="imagens/padrao_sem_jogo.jpg" alt="Add o jogo que deseja" class="img-responsive"/></a>
													<label>
														<p>JOGO</p>
													</label>
												<?php
												endif;
											?>
											</div>
										</div>
										<div class="col-lg col-md col-sm-12 col-xs-12">
											<!--JOGO QUE DAREI NA TROCA-->
											<div class="jgTroca jgVelho">	
												<span class="header-dono">MEU JOGO</span>
												<?php 
													if(isset($_GET['id_troca']) AND $_GET['id_troca'] != ''){
														$idTroca = $_GET['id_troca'];

														//buscar o jogo selecionado												
														$meujogo = $jogo->listarJogos(array('id'=>$idTroca));
														foreach ($meujogo as $meuJogo => $valor):
												?>	
												<input type="hidden" name='idTroca' value="<?php echo $idTroca ?>" id="idTroca"/>				
												<img src="imagens/<?php echo str_replace(' ', '', $valor->nome_console)?>/<?php echo $valor->imagem?>" alt="<?php echo $valor->n_jogo?>" class="img-responsive"/>
												<label><?php echo strtoupper($valor->n_jogo)?> - <?php echo strtoupper($valor->nome_console)?></label>
												<?php 
													endforeach;
													}else{
														$idTroca = null;
												?>
												<input type="hidden" value="<?php echo $idTroca ?>" id="idTroca"/>
												<img src="imagens/padrao_sem_jogo.jpg" alt="Add seu jogo" class="img-responsive"/>
												<label>
													<?php						
														echo (isset($_GET['id_jogo'])) ? $_GET['id_jogo'] : "Seu Jogo";
													}
													?>
												</label>
											</div>
										</div>
									</div>
									<div class="row nopadding">
										<div id='fieldTroca'>
											<div class='col-lg-12'>
												<div class="row">
													<span id='fieldTitle'>Como considera essa troca?</span>
													<div class="col-lg col-md avalia-metodo">
														<label for='maisVale'><input type="radio" name="optradio" value='0' class='btn-opcao' id='maisVale'>Meu jogo vale <b>MAIS</b></label>
													</div>
													<div class="col-lg col-md avalia-metodo">
														<label for='igualVale'><input type="radio" name="optradio" value='1' class='btn-opcao' id='igualVale' checked>Equilibrado</label>
													</div>
													<div class="col-lg col-md avalia-metodo">
														<label for='menosVale'><input type="radio" name="optradio" value='2' class='btn-opcao' id='menosVale'>Meu jogo vale <b>MENOS</b></label>
													</div>
												</div>																		
											</div>	  
											<div class='col-lg-12' id="quadroOpcao">
												<div>
													<label class="titulOpcao">VALOR DE RETORNO: R$</label><input type="text" name="valor" class="form-control" id="txtValor" value="0" placeholder="Valor máximo - R$99,99"/>
													<button type="button" data-target='#infoTroca' data-toggle="modal" class="btn btn-link">Entenda o valor</button>   
												</div>
											</div>
										</div><br/>
										<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
											<label for="mensagem" class="titlemsg">Mensagem</label>
											<textarea class="form-control" name="mensagem" id="mensagem" placeholder="Deixe sua mensagem..."></textarea>   
										</div>	
										<div class='col-lg-12'>					 
											<div class="btn-group">
												<a id="btnCancelar" class="btnTroca btn btn-danger" href='../pesquisa.php'>Cancelar <i class="fa fa-remove"></i></a>
												<button type="button" id="btnConfirmar" class="btnTroca btn btn-success">Confirmar <i class="fa fa-check"></i></button>
											</div>
										</div>
									</div>
								</form>				 	
							</div>
						</div>
					</div><!--main_jogo_selecionado-->
				</div>
			</div>
		</div>

		<div class="overlay"></div>
	<div id="msg">
		<div>
			<header>Mensagem</header>
			<span></span><br/><br/>
		</div>
	</div>

	 <!--Modal Tela Pagamento-->
    <div class="modal fade" id="infoTroca" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="title_modal">POR QUE INFORMAR UM VALOR NA TROCA?</h4>
                </div>
                <div class="modal-body">
                	<label class="lbl_info">
                		<p>A Restart Games acredita que todo jogo, independente se é usado ou não, tem valores diferentes. Pensando assim, acreditamos que você tem o <b>direito</b> de 
                		pedir algum valor como retorno ou oferecer um valor em dinheiro na hora da troca</p>
                		<p>Há 3 possíveis situações:</p>

                		<div class="alert alert-warning">
						  <strong>EQUILIBRADOS!</strong> Uma troca (Jogo) por (Jogo). Ambos os jogos têm o mesmo valor
						</div>
                		<div class="alert alert-success">
						  <strong>VALE MAIS!</strong> (Jogo) por (Jogo <strong>+</strong> Dinheiro). O usuário troca o seu jogo e recebe um jogo + algum valor(R$)
						</div>
                		<div class="alert alert-danger">
						  <strong>VALE MENOS!</strong> (Jogo <strong>+</strong> Dinheiro) por (Jogo). O usuário oferece seu jogo + algum valor(R$) e recebe apenas o jogo
						</div>						            		
                	</label>
                	<label class="lbl_info">
                		<p>A Restart Games não é responsável pelos valores informados, sendo de inteira responsabilidade do proprietário do jogo</p>
                		<p>Todo valor pode ser discutidos entre os jogadores. Assim, nenhum valor é definitivo, podendo ser acordado um novo valor entre os jogadores</p>
                	</label>
                </div>
            </div>
        </div>
    </div>
	<!--AQUI MOSTRARÁ OS JOGOS QUE O USUÁRIO POSSUI-->
	<div id="box_meu_jogo">
		<div class="row nopadding">
			<div class="col-lg-12">
				<span id="topo"><h4>Escolha seu jogo</h4><img src="..\users/img/pop-botao-fecha.png" alt="Fechar" id="close_pop_up"/></span>
				<section class="section">
					<div class="row">
					<?php			
						$num_game = Jogos::contarJogosHelper(array('id_gamer'=>$idUser, 'status'=>'Ativo'));
						
						if($num_game > 0):
							$meusjogos = $jogo->listarJogos(array('id_gamer'=>$idUser, 'status'=>'Ativo'));
							foreach ($meusjogos as $chave => $result):
					?>	
					<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
						<div class="mygames">
							<a href="trocar_game.php?id=<?php echo $_GET['id']?>&id_troca=<?php echo $result->id?>"><img src="imagens/<?php echo strtolower(str_replace(' ','',$result->nome_console))?>/<?php echo $result->imagem?>"/></a>
							<span class="infoGame"><p><?php echo $result->n_jogo?></p><p><?php echo $result->nome_console?></p></span>
						</div>
					</div>
					<?php
						endforeach;
						else:
							echo "<span class='alert-vazio'><p>OPS! Nenhum jogo encontrado :( </p><p><a href='../users/dashboard.php?secao=jogos'>Cadastre agora</a></p></span>";
						endif;
					?>
					</div>
				</section>
			</div>
		</div>
	</div>		
	<?php
		include_once ('footer.php');
	?>
	</div>

	<!--CHAMADA JAVASCRIPT-->		
	<script src="js/jquery.js"></script><!--chama o arquivo principal do jquery-->
	<script src="js/jquery.mask.min.js"></script>
	<script src="../js/funcoes.js"></script>
	<script src="../js/mascara.js"></script>
	<script src="js/script.js"></script>
	<script src="js/troca.js"></script>
	<script src="js/modernizr.custom.63321.js"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

	<!--JS BOOTSTRAP-->
	<script src="..\bootstrap/js/bootstrap.min.js"></script>
</body>
</html>