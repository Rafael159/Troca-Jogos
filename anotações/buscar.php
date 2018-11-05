<?php
	header("Content-Type: text/html;  charset=ISO-8859-1",true);
	function __autoload($classe){
		require('classes/'.$classe.'.class.php');
	}

	$jogos = new Jogos();
	$usuario = new Usuarios();
	$console = new Categorias();

	$pesq = strip_tags($_GET['pesquisa']);
    $jogo = $jogos->listarJogo(array('jogo'=>$pesq)); 

    $contarProdutos = count($jogo);
    if($contarProdutos != 0){?>
    
	<span id='num_jogos' style='display=none'><?php $contarProdutos;?></span>
    <?php    		
    foreach($jogo as $exibeJogo): // buscar informações do jogo

    	foreach($console->listarCategorias($exibeJogo->id_console) as $conso): //buscar nome do console referente ao jogo
			$nomeConsole = $conso->nome_console;															
		endforeach;
    	$user = $usuario->find($exibeJogo->id_gamer); //buscar informações do dono do jogo
    ?>
<div class="contorno">
	<figure id="console" nome="<?php echo strtoupper($nomeConsole)?>" <a href="#"><img src="imagens/<?php echo str_replace(' ','',$nomeConsole)?>/<?php echo $exibeJogo->img_jogo;?>" alt="<?php echo strtoupper($exibeJogo->n_jogo) ?>"/></a></figure>
	<!--<div class="imagem-troca"><img src="imagens/ps3/<?php $jogos ?>" alt="RESIDENT EVIL 6"/></div>-->
	<div class="info-gamer">
		<ul>
			<li><?php echo strtoupper($exibeJogo->n_jogo) ?></li>
			<li>Desde: <?php echo date("d/m/Y", strtotime($exibeJogo->data));?></li>  
			<li><a href="usuario.php?id='<?php echo $user->id;?>'" class="usuario"><?php echo $user->nomeUser;?></a></li>
			<li><?php echo $user->cidade ." / ". $user->estado?></li>
		</ul>
	</div>
</div><!--class contorno-->
<?php
	endforeach;
}else{
    	
	?>
		<span id="exclama"><img src='imagens/icones/exclama.png'/>Hmm! Nada encontrado para o termo escolhido, mas selecionamos outros produtos que possa gostar</span>
		<?php
		foreach($jogos->findAll() as $key=> $valor):
			foreach($console->listarCategorias($valor->id_console) as $conso):
					$nomeConsole = $conso->nome_console;															
				endforeach;
			$user = $usuario->find($valor->id_gamer);
	?> 

		<div class="contorno">
			<figure id="console" nome="<?php echo strtoupper($nomeConsole);?>"><a href="#"><img src="imagens/<?php echo $nomeConsole?>/<?php echo $valor->img_jogo?>" alt="<?php echo strtoupper($valor->n_jogo)?>"/></a></figure>
			<!--<div class="imagem-troca"><img src="imagens/ps3/gta5.jpg" alt="RESIDENT EVIL 6"/></div>-->
			<div class="info-gamer">
				<ul>
					<li><?php echo substr($valor->n_jogo,0,23);?></li>
					<li>Desde: <?php echo date("d/m/Y",strtotime($valor->data));?></li>
					<li><a href="usuario.php?id='<?php echo $user->id;?>'" class="usuario"><?php echo $user->nomeUser;?></a></li>
					<li><?php echo $user->cidade ." / ". $user->estado?></li>
				</ul>
			</div>
		</div><!--class contorno-->				
	<?php
	endforeach;
	}/*fecha o While dos jogos gerais*/
?>	