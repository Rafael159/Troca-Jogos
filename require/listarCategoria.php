<?php
	spl_autoload_register(function($classe) {
	    require('../classes/'.$classe.'.class.php');
	});
	$consoles = new Consoles();
	$jogos = new Jogos();
	session_start();

	$id = (isset($_POST['id'])) ? $_POST['id'] : 1;

	$grupoconsoles = $consoles->consoleById($id);
	foreach($grupoconsoles as $console):	
		$conso = $console->nome_console;	
		$idConso = $console->id_console;
	 endforeach; 
?>	
	<span id="resultado-links">
		<div class="quadro-galeria" id="<?php echo str_replace(' ', '', $conso)?>">
			<ul class="galeria-principal">
				<?php
					$games = $jogos->listarJogos(array('idconsole'=>$id, 'status'=>'Ativo', 'limite'=>'5'));

					if(Jogos::contarJogosHelper(array('idconsole'=>$id, 'status'=>'Ativo', 'limite'=>'5')) == 0){
						if(isset($_SESSION['emailTJ'])){
							echo "<span class='msgFalha'>Hmmm! Nenhum jogo encontrado para esse console. Seja o primeiro a cadastrar  <a href='users/dashboard.php?secao=jogos'><button id='btn-register'>Cadastrar jogo</button></a></span>";
						}else{
							echo "<span class='msgFalha'>Hmmm! Nenhum jogo encontrado para esse console. Seja o primeiro a cadastrar <button id='btn-enter' onclick=overlayer('#box-login')>Entrar</button></span>";						
						}
					}else{											
						foreach($games as $valor):
				?>
			<div class="col-lg-3 col-md-4 col-sm-6 col-xs-6">
				<li class="vitrine">
					<a href="game/game.php?codigo=<?php echo $valor->id ?>"><img src="game/imagens/<?php echo str_replace(' ', '', $conso).'/'.$valor->imagem?>" class="img-responsive"/></a>
					<span class="infogame">
						<?php
							$num = strlen($valor->n_jogo);
							if($num >=22){
								echo substr($valor->n_jogo,0,22).'...';
							}else{
								echo $valor->n_jogo;
							}
						?>
					</span>
				</li>
			</div>
				<?php
					endforeach;
				}
				?>
			</ul>
		</div>
	</span>