<?php
	session_start();

	$id = (isset($_POST['id'])) ? $_POST['id'] : 1;
	require_once '../classes/BD.class.php';		

	$query = "SELECT * FROM `console` WHERE id_console = $id ";
	$result =  @BD::conn()->prepare($query);
	$result->execute();

	foreach($result->fetchAll() as $console):	
		$conso = $console->nome_console;	
		$idConso = $console->id_console;
	 endforeach; 
?>	
	<span id="resultado-links">
		<div class="quadro-galeria" id="<?php echo str_replace(' ', '', $conso)?>">
			<ul class="galeria-principal">
				<?php
					$sql = "SELECT * FROM `jogos` as j,`imagens` as i WHERE j.id_console = $id AND i.id_img = j.img_jogo LIMIT 5";
					$stmt =  @BD::conn()->prepare($sql);
					$stmt->execute();
					if($stmt->rowCount() == 0){
						if(isset($_SESSION['emailTJ'])){
							echo "<span class='msgFalha'>Hmmm! Nenhum jogo encontrado para esse console. Seja o primeiro a cadastrar  <a href='users/dashboard.php?secao=jogos'><button id='btn-register'>Cadastrar jogo</button></a></span>";
						}else{
							echo "<span class='msgFalha'>Hmmm! Nenhum jogo encontrado para esse console. Seja o primeiro a cadastrar <button id='btn-enter' onclick=overlayer('#box-login')>Entrar</button></span>";						
						}
					}else{											
						foreach($stmt->fetchAll() as $valor):
				?>
				<li class="vitrine">
					<a href="game/game.php?codigo=<?php echo $valor->id ?>"><img src="game/imagens/<?php echo str_replace(' ', '', $conso).'/'.$valor->imagem?>"/></a>
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
				<?php
					endforeach;
				}
				?>
			</ul>
		</div>
	</span>