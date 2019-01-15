<?php
	$generos = new Generos();
	$consoles = new Consoles();
?>
<!--SIDEBAR-->		
<div class="left_sidebar">
	<ul class="filtro-plataforma"> 
		<span class="titulo_filtro">PLATAFORMA</span>
		<?php	
			foreach ($consoles->listarTodos() as $conso) :
		?>
		<li class="controle">
			<label class="item <?php echo (isset($cnsl) AND ($cnsl == $conso->nome_console)) ? 'filtro-actived' : ''?>" for="<?php echo str_replace(' ','',$conso->nome_console)?>">
				<div class="checkbox <?php echo str_replace(' ','',$conso->nome_console)?>">
					<section class="categoria">
						<input type="checkbox" name="console[]" value="<?php echo $conso->id_console?>" autocomplete="off" class="filterConsole content" id="<?php echo str_replace(' ','',$conso->nome_console)?>" <?php echo (isset($cnsl) AND ($cnsl == $conso->nome_console)) ? 'checked="checked"' : ''?>>
					</section>
					<span class="filter_name"><?php echo $conso->nome_console?></span>
				</div>
			</label>
		</li>
		<?php
			endforeach;
		?>	
	</ul>
	<?php
		function tirarAcentos($string){
			$valor = str_replace('ç', 'c', $string);
		    return preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$valor);
		}
	?>
	<ul class="filtro-genero"> 
		<span class="titulo_filtro">GÊNERO</span>
		<?php 
			foreach ($generos->findAll() as $chave => $info):
		?>
		<li class="controle">
			<?php 
				$genero_sem_acento = strtolower(tirarAcentos($info->nome));
			?>
			<label class="item" for="<?php echo $genero_sem_acento?>">
				<div class="checkbox <?php echo $genero_sem_acento?>">
					<section class="genero">
						<i class="fa fa-futbol-o" aria-hidden="true"></i>
						<input type="checkbox" name="genre[]" value="<?php echo $info->id?>" autocomplete="off" class="filterGenre content" id="<?php echo $genero_sem_acento?>"/>							
					</section>
					<span class="filter_name"><?php echo $info->nome?></span>
				</div>
			</label>
	    <?php endforeach; ?>
	</ul>
	<!--FIM DO FILTRO DE JOGOS-->
	<!--<ul class="genero">
		<span class="titulo_filtro">GÊNERO</span>
		<?php 
			foreach ($generos->findAll() as $chave => $info):
		?>
		<li class="genero-opcao acao">			      
	      <label for="acao" id="<?php echo $info->id?>"><?php echo $info->nome?></label>
	    </li>
	    <?php endforeach; ?>
	</ul>-->
	<!-- INÍCIO FILTRO POR GÊNERO
	<ul class="filtro-ano">
		<span class="titulo_filtro">GÊNERO</span>				
		<li class="controle">
			<label class="item ano_1"><div class="ano"><span id=""></span></div>Ação</label>
		</li>	
		<li class="controle">
			<label class="item ano_2"><div class="ano"><span id=""></span></div>Luta</label>
		</li>
		<li class="controle">
			<label class="item ano_3"><div class="ano"><span id=""></span></div>Corrida</label>
		</li>
		<li class="controle">
			<label class="item ano"><div class="ano"><span id=""></span></div>RPG</label>
		</li>			
	</ul>	 -->
	<!--FIM DO FILTRO DO ANO-->
	
</div>