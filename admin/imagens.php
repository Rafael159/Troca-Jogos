<?php
	function __autoload($classe){
		require ('..\classes/'.$classe.'.class.php');
	}
	$console = new Consoles;
	$imagem  = new Imagens;
?>
<!Doctype html>
<html>
	<head>		
		<!--CHAMADA CSS-->
		<link type="text/css" href="css/imagens.css" rel="stylesheet"/>
		<!--CHAMADA JS-->
		<script src="js/funcoes.js"></script>
		<title>Imagens</title>
	</head>
	<body>
	<div class="overlay"></div><!---->
	<div id="msg">
		<div align="center">
			<header></header>
			<span></span></br></br>
			<button class="submit-btn btn-positivo" id="confirmar-btn">Confirmar</button>
		</div>
	</div>
	<div id="conteudo">
		<header>
			<h3>Gerenciamento das imagens</h3>
			<span>
				<img src="images/config.png" alt="Configuração" id="btn-config"/>
			</span>
			<div id='box-config'>
				<ul>
					<li><img src="images/add_img.png" alt="Add Imagem" id="btn-add-img"/></li>
					<li><img src="images/add_img.png" alt="Add Imagem"/></li>
				</ul>
			</div>
		</header>
		<nav class="mn-console">
			<ul>
				<?php
					foreach($console->listarTodos() as $valor):										
				?>
				<li class="each-console" id="<?php echo $valor->id_console?>"><a href="#"><?php echo strtoupper($valor->nome_console);?></a></li>
				<?php
					endforeach;
				?>
			</ul>
		</nav>
		<div class="box_imagens">
			<?php
				$sql = "SELECT * FROM `console` as c, `imagens` as i WHERE c.id_console = i.id_console ORDER BY i.id_img";
				$qnt = count($imagem->consulta($sql));	
				if($qnt == 0){
					echo "<span id='msg-none'>NENHUMA IMAGEM CADASTRADA</span>";
				}else{
					foreach($imagem::getImage() as $img=> $valor):								
			?>
			<div class="each-img">
				<img src="../game/imagens/<?php echo str_replace(' ', '', $valor->nome_console) ?>/<?php echo $valor->imagem?>" alt="<?php echo $valor->nome?>">
				<div class="box-opcao">
					<span><input type="text" value="<?php echo $valor->nome?>" class="nm_jogo"/></span>
					<ul id="<?php echo $valor->id_img;?>">
						<li><img src="images/deletar.png" alt="Deletar" class="icon-deletar"></li>
						<li><img src="images/editar.png" alt="Editar" class="icon-editar"></li>
					</ul>
				</div>
			</div>
			<?php 
				endforeach;
			}
			?>
		</div>
	</div>
	<div class="alert-overlay"></div>
	<div id="box_confirmacao">
		<header class="alert-title">Deletar Imagem</header>
		<p><span class="alert-msg">Imagem será deletado do banco. Tem certeza que deseja continuar?</span></p>
		<button class="alert-btn" id="alert-confirma" name="confirma">Confirmar</button>
		<button class="alert-btn" id="alert-cancela" name="cancela">Cancelar</button>
		<input type="hidden" value="" id="recuperaId"></input>
	</div>
	</body>
</html>