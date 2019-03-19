<!--
	*****Página de jogos pesquisados 			********
	*****Programador : RAFAEL ALVES CARDOSO     ********
	*****DATA: 27/07/2015                       ********
-->

<?php
	header("Content-Type: text/html;  charset=UTF-8",true);
	function __autoload($classe){
        require('classes/'.$classe.'.class.php');
    }
    @BD::conn();

    $jogos = new Jogos();
    $usuario = new Usuarios();
	$console = new Consoles();
	$key = ( isset($_GET['pesquisa']) AND !empty($_GET['pesquisa'])) ? $_GET['pesquisa'] : '';
	
	
	$pos = strpos($key, '-');//posição do "-"
	
	if($pos){
		$cnsl = trim(substr(strrchr($key, '-'), 1));
		$key = trim(substr($key, 0, $pos));//retira o nome do console
	}
	
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="description" content="Troque seus jogos antigos por jogos que ainda não teve"/>
		<meta name="description" content="Troque jogos - divirta-se sem gastar mais"/>
		<meta name="keywords" content="Troca,Jogo,Games,Jogadores,Console, Diversão"/>
		<title>RG - Pesquise jogos para trocar</title>
		<!--CHAMADAS CSS-->
		<link rel="stylesheet" type="text/css" href="css/pesquisa.css">
		<link rel="stylesheet" type="text/css" href="css/estilo.css"/>
		<link rel="stylesheet" type="text/css" href="css/style-footer.css"/>
		<link rel="stylesheet" type="text/css" href="css/fonts.css"/>
		<link rel="stylesheet" type="text/css" href="css/header.css"/><!--estilo topo-->
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
		
	</head>
<body class="center">
	<?php include_once('require/header.php'); ?>
	<div id="principal">
		<!--CHAMADA DO HEADER-->		
		<?php require ('require/sidebar_filtros.php');?> <!--chama o sidebar com os filtros para a pesquisa-->	

		<!--BOX RESULTADOS DA PESQUISA-->
		<div id="box-resultados">	
			<label id="progress"><img src="imagens/icones/progresso.gif"/></label>
		<?php		
			if($key){	
				if(isset($cnsl)){
					$grupoJogos = $jogos->listarJogos(array('status'=>'Ativo', 'order'=>'ORDER BY id DESC', 'jogo'=>$key, 'console'=>$cnsl));
				}else{
					$grupoJogos = $jogos->listarJogos(array('status'=>'Ativo', 'order'=>'ORDER BY id DESC', 'jogo'=>$key));
			}
				$qtd = count($grupoJogos);
				if($qtd != 0){
					foreach($grupoJogos as $valor):
		?>
			<div class="contorno">				
				<figure id="console" nome="<?php echo strtoupper($valor->nome_console)?>"><a href="game/game.php?codigo=<?php echo $valor->id;?>&&console=<?php echo $valor->id_console;?>"> <img src="game/imagens/<?php echo str_replace(' ', '',$valor->nome_console)?>/<?php echo $valor->imagem?>" alt="<?php echo strtoupper($valor->n_jogo)?>"/></a></figure>
				<div class="info-gamer">
					<ul>
						<li>
							<?php
								$num = strlen($valor->n_jogo);
								if($num >15){
									echo trim(substr($valor->n_jogo,0,15)).'...';
								}else{
									echo strtoupper($valor->n_jogo);
								}
							?>
						</li>
						<li><?php echo strtoupper($valor->nome_console)?></li>
						<li><a href="feed.php?codigo=<?php echo $valor->id_user?>" class="usuario"><?php echo $valor->nomeUser;?></a></li>
						<li><?php echo substr($valor->cidade,0,10) ." / ". $valor->estado?></li>
					</ul>
				</div>
			</div>
		<?php
			endforeach;
			}else{
				echo "<span class='alert-vazio'><p>OPS! Nenhum jogo encontrado :( </p><p>Tente outra pesquisa... </p></span>";
			}
			}else{
			foreach($jogos->listarJogos(array('status'=>'Ativo', 'order'=>"ORDER BY id DESC")) as $key=> $valor):
		?> 
			<div class="contorno">				
				<figure id="console" nome="<?php echo strtoupper($valor->nome_console)?>"><a href="game/game.php?codigo=<?php echo $valor->id;?>&&console=<?php echo $valor->id_console;?>"><img src="game/imagens/<?php echo str_replace(' ', '', $valor->nome_console)?>/<?php echo $valor->imagem?>" alt="<?php echo strtoupper($valor->n_jogo)?>"/></a></figure>
				<div class="info-gamer">
					<ul>
						<li>
							<?php
								$num = strlen($valor->n_jogo);
								if($num >15){
									echo substr($valor->n_jogo,0,15).'...';
								}else{
									echo strtoupper($valor->n_jogo);
								}
							?>
						</li>
						<li><?php echo strtoupper($valor->nome_console)?></li>						
						<li><a href="feed.php?codigo=<?php echo $valor->id_user?>" class="usuario"><?php echo substr($valor->nomeUser, 0,20)?></a></li>
						<li><?php echo $valor->cidade ." / ". $valor->estado?></li>
					</ul>
				</div>
			</div>
		<?php		
		endforeach;//fecha o While dos jogos gerais
		}?>
		</div>
		<?php
		require 'footer.php';
	?>
	</div>
	
	<!--CHAMADA JAVASCRIPT-->		
	<script src="js/jquery.js"></script>
	<script src="js/global.js"></script>
	<script src="js/funcoes.js"></script>
	<script type="text/javascript" src="js/events.js"></script>
</body>
</html>