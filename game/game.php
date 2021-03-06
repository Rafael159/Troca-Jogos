<?php
	spl_autoload_register(function($classe) {
		require(dirname(dirname(__FILE__)).'/classes/'.$classe.'.class.php');        
    });
    //@BD::conn();//conexão com o banco de dados	
    
    $jogos = new Jogos(); //chama a classe Jogos
    $console = new Consoles(); //chama a classe Consoles 
    $usuarios = new Usuarios();      
    $generoJogo = new JogoCategoria();
    $genero = new Generos();

    session_start(); 
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="Troque seus jogos antigos por jogos que ainda não teve"/>
		<meta name="description" content="Troque jogos - divirta-se sem gastar mais"/>
		<meta name="description" content="Jogos únicos + informações"/>
		<meta name="keywords" content="Troca,Jogo,Games,Jogadores"/>
		<title>RG - Porque o jogo não pode parar</title>
		<!--CHAMADA CSS-->
		<link rel="stylesheet" type="text/css" href="css/games.css"/>
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<link rel="stylesheet" type="text/css" href="css/header.css" />
		<link rel="stylesheet" type="text/css" href="../css/estilo.css" />
		<link rel="stylesheet" type="text/css" href="../css/fonts.css" />

		<link rel="stylesheet" type="text/css" href="../css/style-footer.css"/>
		<link rel="shortcut icon" type="image/x-icon" href="../favicon.ico">
		<link rel="stylesheet" type="text/css" href="../font-awesome/css/font-awesome.css"/>

		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	</head>
<body class="center">
	<div class="container-fluid nopadding">
		<div class="content">	
			<?php include_once('header.php'); ?>	

			<div class="row">
			<!--CHAMADA DO HEADER-->
			<?php	
				if(isset($_GET['codigo']) && $_GET['codigo'] != ""){
					$idJogo = $_GET['codigo'];//id do jogo
					if(isset($_SESSION['emailTJ']) AND $_SESSION['emailTJ'] != ""){
						$email = $_SESSION["emailTJ"];
					
						$linha = "SELECT id_user FROM usuarios WHERE emailTJ = '$email'";
						foreach ($usuarios->consulta($linha) as $key):
							$idLogado = $key->id_user;//id do usuário logado
						endforeach;	
					}			
				//buscar o jogo selecionado
				$sql = "SELECT * FROM `jogos` as j,`console` as c, `imagens` as i WHERE j.id = $idJogo AND j.id_console = c.id_console AND j.img_jogo = i.id_img";
				foreach ($jogos->consulta($sql) as $jogo => $valor):
					$_data=$usuarios->getNameByID($valor->id_gamer);//nome do dono do jogo
			?>
					
			<div id="conteudo-jogos">
				<div class="row nopadding">
					<div class="col-lg-4 col-md-5 col-sm-12 col-xs-12">
						<div class="left-jogo">				
							<img src="imagens/<?php echo str_replace(' ', '', strtolower($valor->nome_console))?>/<?php echo $valor->imagem?>" alt="<?php echo $valor->n_jogo?>" class="img_jogo"/>
							<?php
								if(isset($idLogado) AND $idLogado == $valor->id_gamer){
							?>		
								<div class="btn-botao btnTroca" style="opacity:0.6">Quero trocar</div>
								<span id="msgErro">Esse jogo já é seu</span>
							<?php
							}
								else if(isset($email) AND $email != ""){
							?>
							<div class="btn-botao btnTroca"><a href="trocar_game.php?id=<?php echo $valor->id?>">Quero trocar</a></div>
							<?php
								}else{
							?>
							<div class="btn-botao btnTroca" id="btnTrocaLogar"><a href="..\login/logar.php">Quero trocar</a></div>
							<?php
								}
							?>
							<!--<div class="btn-botao btnShare"><a href="#">Compartilhar para ajudar</a></div>-->
						</div>
					</div>
					<div class="col-lg-8 col-md-7 col-sm-12 col-xs-12">
						<div class="right-jogo">
						<span class="nome-jogo"><?php echo strtoupper($valor->n_jogo)?> - <?php echo strtoupper($valor->nome_console)?></h4></span>
							<fieldset>					
								<label>Dono do jogo : <span class="owner-name"><?php echo (isset($_data[0]) && $_data[0]) ? $_data[0] : ''?></span></label>					
							</fieldset>
							<fieldset>
								<legend>DESCRIÇÃO DO JOGO</legend>
								<label>				
									“<?php echo $valor->descricao; ?>”
								</label>
							</fieldset>				
							<fieldset>
								<legend>INDICADO PARA QUEM GOSTA DE:</legend>
								<label>
									<ul id="genre">
										<?php
											$array_generos = explode(",", $valor->generos);
																			
											foreach($array_generos as $key => $value):									
												$genero->setId($value);
												$genero->findGenreByID();
										?>
											<li class="genreGame"><?php echo $genero->getNome(); ?></li>
										<?php endforeach; ?>
									</ul>
								</label>
							</fieldset>
							<fieldset>
								<legend>INFORMAÇÕES ADICIONAIS</legend>
								<label>
									<?php echo $valor->informacao?>
								</label>
							</fieldset>
							<fieldset><label><a href="../feed.php?codigo=<?php echo $valor->id_gamer?>">Ver mais jogos</a></label></fieldset>
						</div>
					</div>
				</div>	
			</div>
			<?php
				endforeach;
				}else{
					echo '<script>location.href="../index.php";</script>';
				}
			?>
			</div>
		</div>
		<div class="row nopadding d-none d-lg-block">
			<div id="bottom_box">
				<div class="main">
					<span><h5>JOGOS RECOMENDADOS</h5></span>
					<div id="mi-slider" class="mi-slider">		
						<!--passar por todos os consoles cadastrados-->
					<?php					
						foreach ($console->findAll() as $chave => $consoles) :
							$id = $consoles->id_console;
							$nome = str_replace(' ','',$consoles->nome_console);
					?>		
						<ul>
							<!--Dentro de cada console, verificar os jogos disponíveis-->
							<?php 
								//$sql = "SELECT * FROM `jogos` as j, `imagens` as i WHERE j.id_console = $id AND j.img_jogo = i.id_img LIMIT 4";
								$games = $jogos->listarJogos(array('status'=>'Ativo', 'idconsole'=>$id, 'limite'=>'4', 'order'=>'ORDER BY j.id DESC'));
								
								$qntGames = count($games);								
								if($qntGames > 0): //se tiver jogo cadastrado para o console, mostre
									foreach ($games as $chave => $jogo) :
							?>
								<li><a href="game.php?codigo=<?php echo $jogo->id?>"><img src="imagens/<?php echo strtolower($nome)?>/<?php echo $jogo->imagem?>" alt="<?php echo $jogo->n_jogo?>"><h4><?php echo $jogo->n_jogo?></h4></a></li>								
							<?php 
									endforeach;
								else: //senão, mostrar imagem padrão
									if(isset($_SESSION['emailTJ'])):
							?>							
								<li><a href="../users/dashboard.php?secao=jogos"><img src="imagens/sem_jogo.jpg" alt=""><h4>Nenhum jogo cadastrado</h4></a></li>
									<?php else:?>
								<li><a href="..\login/logar.php"><img src="imagens/sem_jogo.jpg" alt=""><h4>Nenhum jogo cadastrado</h4></a></li>
							<?php
									endif;
								endif;
							?>
						</ul>
					<?php
						endforeach;
					?>					
						<nav>
							<?php
								foreach ($console->findAll() as $chave => $consoles) :
							?>
								<a href="#"><?php echo strtoupper($consoles->nome_console)?></a><!--todos os consoles cadastrados-->
							<?php  endforeach; ?>
						</nav>
					</div>
				</div>
			</div>
		</div>
		<?php
			include_once ('footer.php');
		?>
	</div>
	<!--CHAMADA JAVASCRIPT-->		
	<script type="text/javascript" src="js/jquery.js"></script><!--chama o arquivo principal do jquery-->
	<script src="js/modernizr.custom.63321.js"></script>
	<script src="js/jquery.catslider.js"></script>
	<script type="text/javascript" src="../js/funcoes.js"></script>
	<script type="text/javascript" src="js/script.js"></script>	

	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script>
		$(function() {
			$( '#mi-slider' ).catslider();
		});
	</script>
</body>
</html>
