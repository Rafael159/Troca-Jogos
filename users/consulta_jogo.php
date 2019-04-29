<?php
	function __autoload($classe){
		require ('..\classes/'.$classe.'.class.php');
	}
	
	$jogo = new Jogos;
	$generos = new Generos();
	$console = new Consoles;
	$jogocatego = new JogoCategoria();
	session_start();
	$tipouser = Usuarios::getUsuario('tipousuario');
	
	if(isset($_POST['idJ'])){
		$id = $_POST['idJ'];
	}
?>
<div id="boxGame" class="row">
	<?php
		$jogo->setID($id);
		
		foreach ($jogo->listaJogoById() as $game => $dados) {						
	?>
	<?php if($dados->status == 'Inativo'):?>
		<div class="col-lg-12">
			<label class="alert alert-warning">Esse jogo está inativo. Você <strong>não</strong> poderá trocá-lo / editá-lo ou excluí-lo enquanto ele fizer parte de um processo de troca</label>
		</div>
	<?php endif; ?>
	<div class="col-lg-4">
		<img src="../game/imagens/<?php echo str_replace(' ','',$dados->nome_console)?>/<?php echo $dados->imagem?>" class="img_jogo"/>
		<small class="news">Em breve você poderá atualizar a IMAGEM e o CONSOLE :)</small>
	</div>
	<div class="col-lg-8">
		<div id="form" class="form">
			<form name="update_jogo" id="update_jogo">
				<input type="hidden" value="<?php echo $dados->id?>" id="idJogo" name="idJogo"/>
				<input type="hidden" value="<?php echo $dados->img_jogo?>" name="img_update" id="img_update"/>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">						
					<label for="nomeJogo"><i class="fa fa-user fa-lg" aria-hidden="true"></i> Nome</label>
					<input type="text" value="<?php echo $dados->n_jogo?>" name="nomeJogo" id="nomeJogo" class="form-control"/>					
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<label for="console">Console</label>												
					<select name="console" id="update_console" class="form-control" required>						
						<?php							
						    $allConsoles = $console->listarTodos();
						    foreach ($allConsoles as $chave => $c):
						?>
						<option value="<?php echo $c->id_console?>" <?php echo $c->id_console == $dados->id_console ? 'selected' : '';?> disabled> <?php echo $c->nome_console?></option>
						<?php endforeach;?>				
					</select>
				</div>

				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<label>Gênero(s) do seu jogo</label><br/>
					<?php	
						$all_checks = explode(",", $dados->generos);
						$result = $generos->findAll();//buscar todos gêneros

						//if(!empty($result)):														
							foreach ($result as $chave => $genre):	
								//print_r($genre);
								$idGenero = $genre->id;	//separar o ID									
					?>
						<div class="btn-group" data-toggle="buttons">
							<label class="btn btn-primary checkbox-genre">
								<input type="checkbox" name="upgenero[]" value="<?php echo $genre->id;?>" autocomplete="off"  <?php echo in_array((int)$idGenero, $all_checks) ?' checked="checked"':'';?>><?php echo $genre->nome?>
							</label>
						</div>						
				    <?php				    			
				    		endforeach;//final do foreach GÊNEROS
				    	//endif;
				    ?>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">					
					<label for="nomeJogo"><i class="fa fa-edit fa-lg" aria-hidden="true"></i> Descrição</label>
					<textarea name="descricaoJogo" id="descricaoJogo" class="form-control" style="resize:none"><?php echo $dados->descricao?></textarea>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<label for="nomeJogo"><i class="fa fa-info fa-lg" aria-hidden="true"></i> Observação</label>
					<textarea name="infoJogo" id="infoJogo" class="form-control" style="resize:none" placeholder="Algo sobre o produto. Ex - 2 anos de uso; capa riscada"><?php echo $dados->informacao?></textarea>
				</div><br/>

				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div id='msg_update'></div><!--recebe as mensagens de erro-->
				</div>
				
				<?php if($tipouser == 0): ?>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<?php if($dados->status == 'Ativo'):?>
						<div id="btn_group">
							<button id="btnAtualiza" class="btn btn-warning" type="submit">Atualizar</button>						
							<a href="#" class="btn btn-danger" id="buttonApagar">Apagar</a>
						</div>
					<?php endif; ?>
					<div id="confirm-delete">
					    <div class="box-dialog">
					        <div class="box-content">					           
					            <div class="box-header">
					                <h4>Tem certeza que deseja apagar esse jogo?</h4>
					            </div>
					            <div class="box-footer" id="box_deleta">
					                <button type="button" id="btnCancelaDelete" class="btn btn-danger">Não</button>
					                <a id="btnDeleta" class="btn btn-success" type="submit" name="<?php echo $dados->id?>">Sim</a>
					            </div>
					        </div>
					    </div>
					</div>
				</div>	
				<?php endif; ?>
			</form>			
		</div>
	</div>
	<?php } ?>
</div>
<?php if($tipouser == 0): ?>
	<script src="js/update_game.js"></script>
<?php endif; ?>