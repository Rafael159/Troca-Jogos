<!--
	*****Página de jogos pesquisados 					   ********
	*****Programador : RAFAEL ALVES CARDOSO    			   ********
	*****DATA: 25/04/2016                       	       ********
	*****Função: Página que mostrará jogos individualmente ********
-->
<?php
	function __autoload($classe){
        require('..\classes/'.$classe.'.class.php');
    }
    @BD::conn();//conexão com o banco de dados	
    
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
		<meta name="description" content="Troque seus jogos antigos por jogos que ainda não teve"/>
		<meta name="description" content="Troque jogos - divirta-se sem gastar mais"/>
		<meta name="description" content="Jogos únicos + informações"/>
		<meta name="keywords" content="Troca,Jogo,Games,Jogadores"/>
		
		<!--CHAMADA CSS-->
		<link rel="stylesheet" type="text/css" href="css/games.css"/>
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<link rel="stylesheet" type="text/css" href="css/header.css" />
		<link rel="stylesheet" type="text/css" href="../css/fonts.css" />

		<link rel="stylesheet" type="text/css" href="../css/style-footer.css"/>
	</head>
<body class="center">
	<div class="content">	
	<?php include_once('header.php'); ?>	

		<div class="clearfix">
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
				<div class="btn-botao btnShare"><a href="#">Compartilhar para ajudar</a></div>
			</div>
			<div class="right-jogo">
			<span class="nome-jogo"><?php echo strtoupper($valor->n_jogo)?> - <?php echo strtoupper($valor->nome_console)?></h4></span>
				<fieldset>					
					<label>Dono do jogo : <span class="owner-name"><?php echo (isset($_data[0]) && $_data[0]) ? $_data[0] : ''?></span></label>					
				</fieldset>
				<fieldset>
					<legend>DESCRIÇÃO DO JOGO</legend>
					<label>				
						“<?php echo $valor->descricao?>”
					</label>
				</fieldset>				
				<fieldset>
					<legend>INDICADO PARA QUEM GOSTA DE:</legend>
					<label>
						<ul id="genre">
							<?php 
								$generoJogo->setJogoID($idJogo);//setar id do jogo

								$result = $generoJogo->findAllByID();
								
								foreach($result as $value):
									$genero->setId($value->categoria_id);
									$genero->findGenreByID();
							?>
								<li class="genreGame"><?php echo $genero->getNome()?></li>
							<?php endforeach;?>															
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
		<?php
			endforeach;
			}else{
				echo '<script>location.href="../index.php";</script>';
			}
		?>
	</div>
</div>
	<div id="bottom_box">
		<div class="main">
			<span><h5>JOGOS RECOMENDADOS</h5></span>
			<div id="mi-slider" class="mi-slider">		
				<!--passar por todos os consoles cadastrados-->
			<?php					
				foreach ($console->findAll() as $chave => $consoles) {
					$id = $consoles->id_console;
					$nome = str_replace(' ','',$consoles->nome_console);
			?>		
				<ul>
					<!--Dentro de cada console, verificar os jogos disponíveis-->
					<?php 
						$sql = "SELECT * FROM `jogos` as j, `imagens` as i WHERE j.id_console = $id AND j.img_jogo = i.id_img LIMIT 4";

						$numero_jogo = count($console->consulta($sql));
						
						if($numero_jogo != 0){ //se tiver jogo cadastrado para o console, mostre
							foreach ($console->consulta($sql) as $chave => $jogo) {
					?>
						<li><a href="game.php?codigo=<?php echo $jogo->id?>"><img src="imagens/<?php echo strtolower($nome)?>/<?php echo $jogo->imagem?>" alt="<?php echo $jogo->n_jogo?>"><h4><?php echo $jogo->n_jogo?></h4></a></li>
						
					<?php 
							}
						}else{ //senão, mostre imagem padrão
							if(isset($_SESSION['emailTJ'])){
					?>							
						<li><a href="../users/dashboard.php?secao=jogos"><img src="imagens/sem_jogo.jpg" alt=""><h4>Nenhum jogo cadastrado</h4></a></li>

					<?php }else{?>
						<li><a href="..\login/logar.php"><img src="imagens/sem_jogo.jpg" alt=""><h4>Nenhum jogo cadastrado</h4></a></li>
					<?php
						}
					}
				 ?>
				</ul>
			<?php
				}
			?>					
				<nav>
				<?php 

					foreach ($console->findAll() as $chave => $consoles) {
				?>
					<a href="#"><?php echo strtoupper($consoles->nome_console)?></a><!--todos os consoles cadastrados-->
				<?php  } ?>
				</nav>
			</div>
		</div>
	</div>
	<?php
		include_once ('footer.php');
	?>
	<!--CHAMADA JAVASCRIPT-->		
	<script type="text/javascript" src="js/jquery.js"></script><!--chama o arquivo principal do jquery-->
	<script src="js/modernizr.custom.63321.js"></script>
	<script src="js/jquery.catslider.js"></script>
	<script type="text/javascript" src="../js/funcoes.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
	<script>
		$(function() {
			$( '#mi-slider' ).catslider();
		});
	</script>
</body>
</html>
