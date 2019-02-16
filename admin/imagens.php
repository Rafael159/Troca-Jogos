<?php
	function __autoload($classe){
		require ('..\classes/'.$classe.'.class.php');
	}
	$console = new Consoles();
	$imagem  = new Imagens();

	//define( 'PATH_ROOT', dirname(__FILE__) );
?>
<title>Imagens</title>

<div class="overlay"></div><!---->
<div id="msg">
	<div align="center">
		<header></header>
		<span></span><br><br>
		<button class="submit-btn btn-positivo" id="confirmar-btn">Confirmar</button>
	</div>
</div>
<div id="conteudo">
	<header>
		<h3 class="content-title">Gerenciamento das imagens</h3>
		<!-- <span>
			<img src="images/config.png" alt="Configuração" id="btn-config"/>
		</span>
		<div id='box-config'>
			<ul>
				<li><img src="images/add_img.png" alt="Add Imagem" id="btn-add-img"/></li>
				<li><img src="images/add_img.png" alt="Add Imagem"/></li>
			</ul>
		</div> -->
	</header>
	<span id="btn-add-img"><i class="fa fa-plus-square fa-3x"></i><br/><strong>Add imagem</strong></span>

	<nav class="mn-console">
		<ul>
			<?php
				foreach($console->listarTodos() as $valor):										
			?>
			<li class="each-console" id="<?php echo $valor->id_console?>"><a href="#"><?php echo strtoupper($valor->nome_console);?></a></li>
			<?php endforeach; ?>
		</ul>
	</nav>
	<div class="box_imagens">
		<?php
			//$sql = "SELECT * FROM `console` as c, `imagens` as i WHERE c.id_console = i.id_console ORDER BY i.id_img";
			$imagens = $imagem->getImage(array('order'=>'ORDER BY id_img DESC'));
			$qnt = count($imagens);	
			if($qnt == 0):
				echo "<span id='msg-none'>NENHUMA IMAGEM CADASTRADA</span>";
			else:
				foreach($imagens as $img => $valor):								
		?>
		<div class="each-img">
			<img src="../game/imagens/<?php echo str_replace(' ', '', $valor->nome_console) ?>/<?php echo $valor->imagem?>" alt="<?php echo $valor->nome?>">
			<div class="box-opcao">
				<span><input type="text" value="<?php echo $valor->nome?>" class="nm_jogo"/></span>
				<ul id="<?php echo $valor->id_img;?>">
					<li><i class="fa fa-trash fa-2x icon-deletar" style="color:red"></i>
						<!-- <img src="images/deletar.png" alt="Deletar" class="icon-deletar"> -->
					</li>
					<li><i class="fa fa-edit fa-2x icon-editar" style="color:green"></i>
						<!-- <img src="images/editar.png" alt="Editar" class="icon-editar"> -->
					</li>
				</ul>
			</div>
		</div>
		<?php 
			endforeach;
		endif;
		?>
	</div>
</div>
<div class="alert-overlay"></div>
<div id="box_confirmacao">
	<header class="alert-title">Deletar Imagem</header>
	<p><span class="alert-msg">Imagem será deletado do banco. Tem certeza que deseja continuar?</span></p>
	<button class="alert-btn" id="alert-confirma" name="confirma">Confirmar</button>
	<button class="alert-btn" id="alert-cancela" name="cancela">Cancelar</button>
	<input type="hidden" value="" id="recuperaId">
</div>
<!--CHAMADA JS-->
<script src="js/funcoes.js"></script>