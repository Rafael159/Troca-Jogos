<?php
	function __autoload($classe){
		require ('..\classes/'.$classe.'.class.php');
	}
	$console = new Consoles;
?>

<link href="css/style.css" rel="stylesheet" type="text/css">

<div class="overlay"></div><!--SOMBRA DE FUNDO-->
	<div id="msg">
		<div align="center">
			<header></header>
			<span></span><br><br>
			<button class="submit-btn btn-positivo" id="confirmar-btn">Confirmar</button>
		</div>
	</div>

	<div class="box_cad_img">
		<!--PARTE 1 - ESCOLHA DO CONSOLE-->
		<div class="section" id="box_console">		
			<div class="boxcontainer" align="center">
				<h3>Cadastrar imagem para qual console?</h3>
				<div class="galeria">
					<nav>
						<ul class="box-galeria-jogos">			
							<div class="arrow"></div>
							<?php								
								foreach($console->listarTodos() as $valor):										
							?>
								<li name="<?php echo strtoupper($valor->nome_console)?>" value="<?php echo $valor->id_console?>" class="link"><?php echo strtoupper($valor->nome_console)?></li>		 							
							<?php endforeach; ?>
						</ul>
				</nav>
				<button class="submit-btn btn_negar">Cancelar</button>
				<button class="submit-btn btn-positivo" id="console-btn">Confirmar</button>
				</div>
			</div>
		</div>
		<!--PARTE 2 - ESCOLHA DA NOME DA IMAGEM ( A QUAL JOGO PERTENCE ) -->
		<div class="section" id="box_nome">
			<div class="boxcontainer" align="center">
				<h3>Informe o nome do jogo dessa imagem</h3>
				<form action="#" method="post">
					<input name="nome-jogo" type="text" id="txt-jogo"/>		                
				</form>
				<button class="submit-btn btn_negar">Cancelar</button>
				<button class="submit-btn btn_voltar" id="voltar-btn_um">Voltar</button>
				<input type="button" value="Confirmar" class="submit-btn btn-positivo" id="nome-jogo-btn" />	
			</div>
		</div>
		<!--PARTE 3 - ESCOLHA IMAGEM -->
		<div class="section" id="box_imagem">		
			<div class="boxcontainer" align="center">
				<h3>Escolha a imagem que deseja cadastrar</h3>
				<form action="#" method="post" enctype="multipart/form-data" id="upload_form">
					<input name="image_file" type="file" id="arquivo" />
					<input type="hidden" id="id-console" name="console"/>
					<input type="hidden" id="nome-imagem" name="imagem"/>
					<input type="hidden" id="nome-jogo" name="nome-jogo"/>

					<div id="output"></div>  
					<img src="images/ajax-loader.gif" id="loading-img" style="display:none;" alt="Please Wait"/>		        
				</form>
				<span>Extensões permitidas(.jpg, .jpeg, .png)</span><br>
				<button class="submit-btn btn_negar">Cancelar</button>
				<button class="submit-btn btn_voltar" id="voltar-btn_dois">Voltar</button>     
				<input type="button" value="Cadastrar" class="submit-btn btn-positivo" id="imagem-btn" />   
			</div>		
		</div>
	</div>

<script src="js/jquery-1.10.2.min.js"></script>
<script src="js/funcoes.js"></script>
