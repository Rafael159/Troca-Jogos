<?php
	header("Content-Type: text/html;  charset=UTF-8",true);
	
	function __autoload($classe){
       	require('classes/'.$classe.'.class.php'); /*chama a classe automaticamente*/
   			 }
	@BD::conn();//conexão com o banco de dados

	$usuario = new Usuarios();
	$console = new Consoles();
	$jogos = new Jogos();

	/*SETAR VARIÁVEIS*/
	$consoles = (isset($_POST['console']) ? $_POST['console'] : '');
	$generos  = (isset($_POST['genre']) ? $_POST['genre'] : '');
	$pesquisa = (isset($_POST['pesquisa']) ? $_POST['pesquisa'] : '');

	if(!isset($where)){
		$where = array();//criar array com os dados da pesquisa
	}
	
	if(!empty($pesquisa)){
		$pos = strripos($pesquisa, '-');//encontrar separador
		//caso exista
		if($pos){
			$pesquisa = trim(substr($pesquisa, 0, $pos));//remover o nome do console
			$where[] = "UPPER(j.n_jogo) LIKE UPPER('%".$pesquisa."%')";
		}else{
			$where[] = "UPPER(j.n_jogo) LIKE UPPER('%".$pesquisa."%')";
		}		
	}

	if(!empty($consoles)):		
		$listaConsole = implode(" OR j.id_console = ", $consoles);
		$where[] = "(j.id_console = ".$listaConsole.")";
	endif;
	
	if(!empty($generos)):
		$listaGeneros = implode(" OR jc.categoria_id = ", $generos);
		$where[] = "(jc.categoria_id = ".$listaGeneros.")";
	endif;

	/*criar QUERY para pesquisa os jogos*/
	$sql  = "SELECT j.id, j.n_jogo, j.img_jogo, j.id_console, j.id_gamer, j.jogoTroca, j.idJogoTroca, j.data,
				j.descricao, j.informacao, j.status, c.nome_console, i.id_img, i.nome, i.imagem, u.id_user,
				u.nomeUser, u.celular, u.telefone, u.rua, u.numero, u.cidade, u.estado, u.complemento, u.console FROM ((((`jogos` as j INNER JOIN `console` as c ON j.id_console = c.id_console)"; 
	$sql .= "INNER JOIN `imagens` as i ON j.img_jogo = i.id_img)"; 
	$sql .= "INNER JOIN `jogocategoria` as jc ON j.id = jc.jogo_id)";
	$sql .= "INNER JOIN `usuarios` as u on j.id_gamer = u.id_user)";
	
	/*se existir filtro*/
	if(sizeof($where)){
		$sql .= ' WHERE '.implode( ' AND ',$where );//add filtros na QUERY	
	}	
	$sql.= ' GROUP BY jc.jogo_id';
	
		
	$arrayJogo = $jogos->consulta($sql);
		
	$contarProdutos = count($arrayJogo);//contar quantos jogos retornaram na consulta
    	if($contarProdutos > 0):    
	?>
    <div class="pesquisando"><span> Sua pesquisa retornou </span><span id="qnt_game"><?php echo ($contarProdutos>1) ? $contarProdutos.' jogos' : $contarProdutos.' jogo'?></span></div>
 
    <?php    	
    	foreach($arrayJogo as $exibeJogo): // buscar informações do jogo
    ?>
<div class="contorno">
	<figure id="console" nome="<?php echo strtoupper($exibeJogo->nome_console)?>" ><a href="game/game.php?codigo=<?php echo $exibeJogo->id;?>&&console=<?php echo $exibeJogo->id_console;?>"> <img src="game/imagens/<?php echo str_replace(' ','',$exibeJogo->nome_console)?>/<?php echo $exibeJogo->imagem;?>" alt="<?php echo strtoupper($exibeJogo->n_jogo) ?>"/></a></figure>
	<!--<div class="imagem-troca"><img src="imagens/ps3/<?php $jogos ?>" alt="RESIDENT EVIL 6"/></div>-->
	<div class="info-gamer">
		<ul>			
			<li>Jogo: 
				<?php
					$num = strlen($exibeJogo->n_jogo);
					if($num >15){
						echo substr($exibeJogo->n_jogo,0,15);
					}else{
						echo strtoupper($exibeJogo->n_jogo);
					}
				?>
			</li>
			<li>Console: <?php echo strtoupper($exibeJogo->nome_console)?></li>
			<li><a href="feed.php?codigo=<?php echo $exibeJogo->id_user?>" class="usuario"><?php echo $exibeJogo->nomeUser;?></a></li>
			<li>Local: <?php echo substr($exibeJogo->cidade,0,10) ." / ". $exibeJogo->estado?></li>
		</ul>
	</div><!--class info-gamer-->
</div><!--class contorno-->
<?php
	endforeach;
else:
	//caso o filtro não obtenha nenhum jogo, então mostrar outros os jogos para o cliente
	?>
	<span id="exclama"><img src='imagens/icones/exclama.png'/>Hmm! Nada encontrado para o termo escolhido, mas selecionamos outros produtos que possa gostar</span>
	<?php
	$sql = "SELECT * FROM `console` as c, `imagens` as i, `jogos` as j, `usuarios` as u WHERE c.id_console = j.id_console AND j.img_jogo = i.id_img AND j.id_gamer = u.id_user AND j.status = 1 ORDER BY j.id";

	foreach($jogos->listaTodosJogos() as $key=> $valor):
	?> 
		<div class="contorno">
			<figure id="console" nome="<?php echo strtoupper($valor->nome_console);?>"><a href="game/game.php?codigo=<?php echo $valor->id;?>&&console=<?php echo $valor->id_console;?>"><img src="game/imagens/<?php echo str_replace(' ', '',$valor->nome_console)?>/<?php echo $valor->imagem?>" alt="<?php echo strtoupper($valor->n_jogo)?>"/></a></figure>
			<!--<div class="imagem-troca"><img src="imagens/ps3/gta5.jpg" alt="RESIDENT EVIL 6"/></div>-->
			<div class="info-gamer">
				<ul>
					<li>Jogo: 
						<?php
					$num = strlen($valor->n_jogo);
					if($num >15){
						echo substr($valor->n_jogo,0,15);
					}else{
						echo strtoupper($valor->n_jogo);
					}
				?>
					</li>
					<li>Console: <?php echo strtoupper($valor->nome_console)?></li>
					<li><a href="feed.php?codigo=<?php echo $valor->id_user?>" class="usuario"><?php echo $valor->nomeUser;?></a></li>
					<li>Local: <?php echo substr($valor->cidade,0,10) ." / ". $valor->estado?></li>
				</ul>
			</div>
		</div><!--class contorno-->				
	<?php
	endforeach;
endif;/*fecha o While dos jogos gerais*/
?>